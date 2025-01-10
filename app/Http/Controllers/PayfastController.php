<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\Product;
use App\Models\Currency;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\CustomerInfo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;


class PayfastController extends Controller{

    protected $merchant_id;
    protected $merchant_key;
    protected $passphrase;
    protected $test_mode;
    protected $order_session_key;

    public function __construct(){
        $this->merchant_id = get_payment_method('payfast_key');
        $this->merchant_key = get_payment_method('payfast_secret');
        $this->passphrase = "Teachmeapp2024";
        $this->test_mode = get_payment_method('payfast_mode');
    }
    function generateGUID():string {
        // Generate a random string of 16 bytes
        $data = openssl_random_pseudo_bytes(16);

        // Set version and variant for the GUID
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Set the 4 most significant bits to 0100 (version 4)
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Set the 2 most significant bits to 10 (variant)

        // Convert the byte array to hex and format it into a standard GUID string
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    function saveCustomerTransactionInfo($request, string $guid, string $userId){
        try{
            // Create a new instance of the CustomerInfo model to save temp data
            $customerInfo = new CustomerInfo();

            $product = Product::where('id', $request->product_id)->first();
            // Populate the model with the request data
            $customerInfo->transaction_guid = $guid;
            $customerInfo->customer_id = $userId;
            $customerInfo->billing_first_name = $request->billing_first_name ?? '';
            $customerInfo->billing_last_name = $request->billing_last_name ?? '';
            $customerInfo->billing_address = $request->billing_address ?? '';
            $customerInfo->billing_country_id = $request->billing_country_id ?? null;
            $customerInfo->billing_state_id = $request->billing_state_id ?? null;
            $customerInfo->billing_city_id = $request->billing_city_id ?? null;
            $customerInfo->billing_post_code = $request->billing_post_code ?? '';
            $customerInfo->billing_phone = $request->billing_phone ?? '';
            $customerInfo->billing_email = $request->billing_email ?? '';

            $customerInfo->shipping_first_name = $request->shipping_first_name == '' ? $request->billing_first_name : $request->shipping_first_name ?? '';
            $customerInfo->shipping_last_name = $request->shipping_last_name == '' ? $request->billing_last_name :  $request->shipping_last_name ?? '';
            $customerInfo->shipping_address = $request->shipping_address == '' ? $request->billing_address : $request->shipping_address ?? '';
            $customerInfo->shipping_country_id = $request->shipping_country_id == '' ? $request->billing_country_id : $request->shipping_country_id ?? null;
            $customerInfo->shipping_state_id = $request->shipping_state_id == '' ? $request->billing_state_id : $request->shipping_state_id ?? null;
            $customerInfo->shipping_city_id = $request->shipping_city_id == '' ? $request->billing_city_id : $request->shipping_city_id ?? null;
            $customerInfo->shipping_post_code = $request->shipping_post_code == '' ? $request->billing_post_code : $request->shipping_post_code ?? null;
            $customerInfo->shipping_phone = $request->shipping_phone == '' ? $request->billing_phone : $request->shipping_phone ?? '';
            $customerInfo->shipping_email = $request->shipping_email == '' ? $request->billing_email : $request->shipping_email ?? '';

            $customerInfo->message = $request->message ?? '';
            $customerInfo->product_id = $product->id ?? null;
            $customerInfo->merchant_id = $product->author_id ?? null;
            $customerInfo->bid_amount = $request->bid_price ?? 0;
            $customerInfo->amount = $request->amount ?? 0;
            $customerInfo->tax_amount = $request->tax_amount ?? 0;
            $customerInfo->total_amount = $request->total_amount ?? 0;
            $customerInfo->type = $request->type ?? 1;
            $customerInfo->currency = 'ZAR';
            $customerInfo->current_url = $request->current_url ?? URL::full();
            $customerInfo->quantity = $request->quantity ?? 1;
            $customerInfo->order_id = $request->order_id ?? '';

            // Save the data to the database
            $customerInfo->save();
        }catch(Exception $ex)
        {
            Log::error('Error saving customer info: ' . $ex->getMessage());
        }
    }
    public function submit($request){
        try{

            $product = Product::where('id', $request->product_id)->first();
            $guid = $this->generateGUID();
            $userId = Auth::user()->id ?? '';
            $this->saveCustomerTransactionInfo($request, $guid, $userId);
            $productname = $product->name ?? 'Campus Market';
            $data = [
                'merchant_id' => $this->test_mode ? '10011546' : $this->merchant_id,
                'merchant_key' => $this->test_mode ? 'ru0uwhy438i6k' : $this->merchant_key,
                'return_url' => url("/customer/payfast/success"),
                'cancel_url' => url("/customer/payfast/cancel"),
                'notify_url' => url("/customer/payfast/notify"),
                'm_payment_id' => $guid,
                'amount' => $request->total_amount,
                'item_name' => $productname,
            ];

            $updatedData = $this->convertToHttpsUrls($data);
            $signature = $this->generateSignature($updatedData, $this->passphrase);
            $updatedData['signature'] = $signature;

            // If in testing mode make use of either sandbox.payfast.co.za or www.payfast.co.za
            $pfHost = $this->test_mode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
            $url = 'https://' . $pfHost . '/eng/process';

            // Initialize cURL
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($updatedData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute cURL request
            $response = curl_exec($ch);

            // Check for errors
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                // Handle error
                echo 'Error: ' . $error_msg;
            }

            // Close cURL session
            curl_close($ch);

            // Process the response
            echo $response;
            }
            catch(Exception $ex){
                dd($ex);
            }
    }

    public function success(){
        try
        {
            $transaction_guid = Cache::get('transaction_guid');
            $pf_payment_id = Cache::get('pf_payment_id');
            $customer_info = CustomerInfo::where('transaction_guid', $transaction_guid)->first();
            $user = User::where('id', $customer_info->customer_id)->first();
            $orders = Order::find($customer_info->order_id);

            if ($customer_info->type == 1) {
                $user->increment('wallet_balance', $customer_info->amount);
                email_send('deposit', $user->email);
                return redirect($customer_info->current_url)->with('success', translate('Deposit successfully! Your Transaction ID is:') . $pf_payment_id);
            } elseif ($customer_info->type == 2) {
                email_send('bidding_customer', $user->email);
                return redirect()->route('thank_you')->with(['success' => translate('Bid successfully! Your Transaction ID is:') . $pf_payment_id, 'orders' => $orders]);
            } elseif ($customer_info->type == 3) {
                Product::findOrFail($customer_info->product_id)->decrement('quantity', $customer_info->quantity);
                email_send('order_mail', $user->email);
                return redirect()->route('thank_you')->with(['success' => translate('Order successfully! Your Transaction ID is:') . $pf_payment_id, 'orders' => $orders]);
            } elseif ($customer_info->type == 7) {
                $orders = Order::findOrFail($customer_info->order_id);
                $orders->payment_status = 3;
                $orders->update();
                email_send('final_payment', $user->email);
                return redirect()->route('customer.bid')->with('success', translate('Final Payment successfully! Your Transaction ID is:') . $pf_payment_id);
            }
        }
        catch(Exception $ex)
        {
            return redirect($customer_info->current_url)->with('success', translate('An error occured: ') . $ex->getMessage());
        }
    }

    /*
     $check1 = $this->pfValidSignature($pfData, $pfParamString);
            $check2 = $this->pfValidIP();
            $check3 = $this->pfValidPaymentData($cartTotal, $pfData);
            $check4 = $this->pfValidServerConfirmation($pfParamString, $pfHost);

            if($check1 && $check2 && $check3 && $check4) {
                // All checks have passed, the payment is successful
            } else {
                // Some checks have failed, check payment manually and log for investigation
            }
    */
    public function notify(Request $request)
    {
        Log::info('PayFast notify hit', ['data' => $request->all()]);
        try
        {
            $ITN_Payload = $request->all();
            //header( 'HTTP/1.0 200 OK' );
            //flush();
            if(isset($ITN_Payload['payment_status'])){
                switch($ITN_Payload['payment_status']){
                    case "COMPLETE":

                    $m_payment_id = $ITN_Payload["m_payment_id"];
                    $customer_info = CustomerInfo::where('transaction_guid', $m_payment_id)->first();
                    $customer_info->amount = $ITN_Payload['amount_net'];

                    Cache::put('transaction_guid', $m_payment_id);
                    Cache::put('pf_payment_id', $ITN_Payload['pf_payment_id']);

                    if ($customer_info->type == 2 || $customer_info->type == 3) {
                        $orders = new Order;
                        $orders->order_number = random_number();
                        $orders->product_id = $customer_info->product_id;
                        //$orders->user_id = Auth::user()->id;
                        $orders->user_id = $customer_info->customer_id;
                        $orders->type = $customer_info->type;
                        $orders->bid_amount = $customer_info->bid_amount;
                        $orders->amount = $customer_info->total_amount;
                        $orders->tax_amount = $customer_info->tax_amount;
                        $orders->quantity = $customer_info->quantity;
                        $orders->billing_first_name = $customer_info->billing_first_name;
                        $orders->billing_last_name = $customer_info->billing_last_name;
                        $orders->billing_address = $customer_info->billing_address;
                        $orders->billing_country_id = $customer_info->billing_country_id;
                        $orders->billing_state_id = $customer_info->billing_state_id;
                        $orders->billing_city_id = $customer_info->billing_city_id;
                        $orders->billing_post_code = $customer_info->billing_post_code;
                        $orders->billing_phone = $customer_info->billing_phone;
                        $orders->billing_email = $customer_info->billing_email;
                        $orders->shipping_first_name = $customer_info->shipping_first_name;
                        $orders->shipping_last_name = $customer_info->shipping_last_name;
                        $orders->shipping_address = $customer_info->shipping_address;
                        $orders->shipping_country_id = $customer_info->shipping_country_id;
                        $orders->shipping_state_id = $customer_info->shipping_state_id;
                        $orders->shipping_city_id = $customer_info->shipping_city_id;
                        $orders->shipping_post_code = $customer_info->shipping_post_code;
                        $orders->shipping_phone = $customer_info->shipping_phone;
                        $orders->shipping_email = $customer_info->shipping_email;
                        $orders->message = $customer_info->message;
                        $orders->merchant_id = $customer_info->merchant_id;

                        // Handling payment status
                        if ($customer_info->type == 2 && $customer_info->amount > 0) {
                            $orders->payment_status = 1;
                        } elseif ($customer_info->type == 2 && $customer_info->amount == 0) {
                            $orders->payment_status = 2;
                        } elseif ($customer_info->type == 3) {
                            $orders->payment_status = 3;
                        }

                        // Save the order
                        $orders->save();
                        $customer_info->order_id = $orders->id;
                    }
                $customer_info->update();

                $payment = new Wallet;
                $payment->transaction_id = $ITN_Payload['pf_payment_id'];
                //$payment->user_id = Auth::check() ? Auth::user()->id : null;

                if ($request->type == 2 || $request->type == 3) {
                    $payment->order_id = $orders->id ?? null;
                } elseif ($request->type == 7) {
                    $payment->order_id = $customer_info->order_id ?? null;
                }
                $payment->payer_id = $request->id;
                $payment->payer_email = $customer_info->billing_email;
                $payment->type = $customer_info->type;

                $type = $customer_info->type;
                if ($type == 2 || $type == 3 || $type == 7) {
                        $products = Product::findOrFail($customer_info->product_id);
                        $admin_commission_rate = $products->users->admin_commission ?? get_setting('merchant_commission');
                        $payment_rate = 100 - ($admin_commission_rate ?? 0);
                        $merchant_amount = $ITN_Payload['amount_net'] / 100 * $payment_rate;
                        $payment->merchant_amount = $merchant_amount;
                        $payment->admin_commission_rate = ($admin_commission_rate ?? 0);
                        $admin_commission = $ITN_Payload['amount_net'] - $merchant_amount;
                        $payment->admin_commission = $admin_commission;

                        if ($type == 3 || $type == 7) {
                            if ($products->users->role == 2) {
                                User::findOrFail($products->author_id)->increment('wallet_balance', (int)$merchant_amount);
                            }
                            $admin = User::where('role', 4)->orderBy('id', 'asc')->first();
                            $admin->increment('wallet_balance', (int)$admin_commission);
                        }
                    }
                    if ($type == 1) {
                        $payment->payment_details = 'Deposit to Wallet';
                    } elseif ($type == 2) {
                        $payment->payment_details = 'Bid Initial Payment';
                    } elseif ($type == 3) {
                        $products = Product::findOrFail($customer_info->product_id);
                        $payment->payment_details = 'Purchase - ' . $products->name;
                    } elseif ($type == 4) {
                        $payment->payment_details = 'Withdraw from Wallet';
                    } elseif ($type == 7) {
                        $payment->payment_details = 'Bid Final Payment';
                    }
                    $payment->amount = $ITN_Payload['amount_net'];
                    $payment->tax_amount = $customer_info->tax_amount;
                    $payment->gateway_amount = $ITN_Payload['amount_fee'];
                    $payment->total_amount = $ITN_Payload['amount_gross'];
                    $payment->payment_method = 'payfast';
                    $payment->currency = $customer_info->currency;
                    $payment->user_id = $customer_info->customer_id;
                    $payment->status = 2;
                    $payment->save();
/*
                    $customer_info = Session::get('customer_info');

                    if ($customer_info['type'] == 1) {
                        Auth::user()->increment('wallet_balance', $customer_info['amount']);
                        email_send('deposit', Auth::user()->email);
                        return redirect($customer_info['current_url'])->with('success', translate('Deposit successfully! Your Transaction ID is:') . $ITN_Payload['pf_payment_id']);
                    } elseif ($customer_info['type'] == 2) {
                        email_send('bidding_customer', Auth::user()->email);
                        Session::forget($customer_info);
                        return redirect()->route('thank_you')->with(['success' => translate('Bid successfully! Your Transaction ID is:') . $ITN_Payload['pf_payment_id'], 'orders' => $orders]);
                    } elseif ($customer_info['type'] == 3) {
                        Product::findOrFail($customer_info['product_id'])->decrement('quantity', $customer_info['quantity']);
                        email_send('order_mail', Auth::user()->email);
                        Session::forget($customer_info);
                        return redirect()->route('thank_you')->with(['success' => translate('Order successfully! Your Transaction ID is:') . $ITN_Payload['pf_payment_id'], 'orders' => $orders]);
                    } elseif ($customer_info['type'] == 7) {
                        $orders = Order::findOrFail($customer_info['order_id']);
                        $orders->payment_status = 3;
                        $orders->update();
                        email_send('final_payment', Auth::user()->email);
                        return redirect()->route('customer.bid')->with('success', translate('Final Payment successfully! Your Transaction ID is:') . $ITN_Payload['pf_payment_id']);
                    }
                    */

                return response()->json(['status' => 'success'], 200);
                break;
                case "CANCELLED":
                    default:
                    return redirect('checkout')->with('error', translate('Payment not Complete!'));
                    break;
                }
            }
        }
        catch(Exception $ex){
            dd($ex);
            return redirect('checkout')->with('error', translate($ex->getMessage()));
        }
    }
    public function cancel(){
            return redirect('checkout')->with('error', translate('Payment not Complete!'));
    }
     /**
     * error
     *
     * @return Response
     */
    public function error()
    {
        return redirect()->back()->with('error', translate('Payment not Complete!'));
    }
    function convertToHttpsUrls($data):array {
        foreach ($data as $key => $value) {
            // Check if the key contains 'url'
            if (strpos($key, 'url') !== false) {
                // Replace 'http' with 'https' in the value
                $data[$key] = str_replace('http:', 'https:', $value);
            }
        }
        return $data;
    }
    function generateSignature($data, $passPhrase = null) {
        $signatureString = '';
        foreach ($data as $key => $value) {
            if ($key !== 'signature') {
                $signatureString .= $key . '=' . urlencode($value) . '&';
            }
        }
        $signatureString = rtrim($signatureString, '&');
        return md5($signatureString . '&passphrase=' . $passPhrase);
    }
    public function notifyMethod($request)
    {
        // Tell Payfast that this page is reachable by triggering a header 200
        header( 'HTTP/1.0 200 OK' );
        flush();

        define( 'SANDBOX_MODE', true );
        $pfHost = SANDBOX_MODE ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
        // Posted variables from ITN
        $pfData = $_POST;

        // Strip any slashes in data
        foreach( $pfData as $key => $val ) {
            $pfData[$key] = stripslashes( $val );
        }
        $pfParamString ='';
        // Convert posted variables to a string
        foreach( $pfData as $key => $val ) {
            if( $key !== 'signature' ) {
                $pfParamString .= $key .'='. urlencode( $val ) .'&';
            } else {
                break;
            }
        }

        $pfParamString = substr( $pfParamString, 0, -1 );
    }
    function pfValidSignature( $pfData, $pfParamString, $pfPassphrase = null ) {
        // Calculate security signature
        if($pfPassphrase === null) {
            $tempParamString = $pfParamString;
        } else {
            $tempParamString = $pfParamString.'&passphrase='.urlencode( $pfPassphrase );
        }

        $signature = md5( $tempParamString );
        return ( $pfData['signature'] === $signature );
    }

    function pfValidIP() {
        // Variable initialization
        $validHosts = array(
            'www.payfast.co.za',
            'sandbox.payfast.co.za',
            'w1w.payfast.co.za',
            'w2w.payfast.co.za',
            );

        $validIps = [];

        foreach( $validHosts as $pfHostname ) {
            $ips = gethostbynamel( $pfHostname );

            if( $ips !== false )
                $validIps = array_merge( $validIps, $ips );
        }

        // Remove duplicates
        $validIps = array_unique( $validIps );
        $referrerIp = gethostbyname(parse_url($_SERVER['HTTP_REFERER'])['host']);
        if( in_array( $referrerIp, $validIps, true ) ) {
            return true;
        }
        return false;
    }

    function pfValidPaymentData( $cartTotal, $pfData ) {
        return !(abs((float)$cartTotal - (float)$pfData['amount_gross']) > 0.01);
    }

    function pfValidServerConfirmation( $pfParamString, $pfHost = 'sandbox.payfast.co.za', $pfProxy = null ) {
        // Use cURL (if available)
        if( in_array( 'curl', get_loaded_extensions(), true ) ) {
            // Variable initialization
            $url = 'https://'. $pfHost .'/eng/query/validate';

            // Create default cURL object
            $ch = curl_init();

            // Set cURL options - Use curl_setopt for greater PHP compatibility
            // Base settings
            curl_setopt( $ch, CURLOPT_USERAGENT, NULL );  // Set user agent
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );      // Return output as string rather than outputting it
            curl_setopt( $ch, CURLOPT_HEADER, false );             // Don't include header in output
            curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );

            // Standard settings
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $pfParamString );
            if( !empty( $pfProxy ) )
                curl_setopt( $ch, CURLOPT_PROXY, $pfProxy );

            // Execute cURL
            $response = curl_exec( $ch );
            curl_close( $ch );
            if ($response === 'VALID') {
                return true;
            }
        }
        return false;
    }
}
