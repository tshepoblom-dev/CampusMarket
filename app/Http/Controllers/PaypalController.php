<?php

namespace App\Http\Controllers;

use App\Models\User;
use Omnipay\Omnipay;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class PaypalController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(get_payment_method('paypal_key'));
        $this->gateway->setSecret(get_payment_method('paypal_secret'));
        $this->gateway->setTestMode(get_payment_method('paypal_mode'));
        $this->middleware(['auth','pverify']);

    }



    /**
     * submit
     *
     * @param  mixed $request
     * @return Response
     */
    public function submit($request)
    {
        $product = Product::where('id', $request->product_id)->first();

        $amount = floatval(str_replace(',', '', $request->amount));
        $total_amount = floatval(str_replace(',', '', $request->total_amount));
        $tax_amount = floatval(str_replace(',', '', $request->tax_amount));

        $customer_info = [
            'billing_first_name' => $request->billing_first_name ?? '',
            'billing_last_name' => $request->billing_last_name ?? '',
            'billing_address' => $request->billing_address ?? '',
            'billing_country_id' => $request->billing_country_id ?? '',
            'billing_state_id' => $request->billing_state_id ?? '',
            'billing_city_id' => $request->billing_city_id ?? '',
            'billing_post_code' => $request->billing_post_code ?? '',
            'billing_phone' => $request->billing_phone ?? '',
            'billing_email' => $request->billing_email ?? '',
            'shipping_first_name' => $request->shipping_first_name ?? '',
            'shipping_last_name' => $request->shipping_last_name ?? '',
            'shipping_address' => $request->shipping_address ?? '',
            'shipping_country_id' =>  $request->shipping_country_id?  $request->shipping_country_id :null,
            'shipping_state_id' => $request->shipping_state_id ? $request->shipping_state_id:null,
            'shipping_city_id' => $request->shipping_city_id?$request->shipping_city_id:null,
            'shipping_post_code' => $request->shipping_post_code ?? '',
            'shipping_phone' => $request->shipping_phone ?? '',
            'shipping_email' => $request->shipping_email ?? '',
            'message' => $request->message ?? '',
            'product_id' => $product->id ?? '',
            'merchant_id' => $product->author_id ?? '',
            'bid_amount' => $request->bid_price ?? 0,
            'amount' => $amount ?? 0,
            'tax_amount' => $tax_amount ?? 0,
            'total_amount' => $total_amount ?? 0,
            'quantity' => $request->quantity ?? 1,
            'order_id' => $request->order_id ?? '',
        ];

        try {
            Session::put('customer_info', $customer_info);
            $main_amount = ($total_amount / (get_payment_method('paypal_conversion') ?? 1));
            $response = $this->gateway->purchase([
                'amount' => number_format($main_amount, 2),
                'currency' => 'USD',
                'returnUrl' => url('/customer/paypal/' . $request->type . '/success'),
                'cancelUrl' => url('/customer/paypal/cancel'),
            ])->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return ['status' => false, 'message' => $response->getMessage()];
            }
        } catch (\Throwable $th) {

            return ['status' => false, 'message' => $th->getMessage()];
        }
    }

    /**
     * success
     *
     * @param  mixed $request
     * @param  int $type
     * @return Response
     */
    public function success(Request $request, $type)
    {

        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase([
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ]);
            $response = $transaction->send();
            // dd($response);
            $customer_info = Session::get('customer_info');

            if ($response->isSuccessful()) {
                $arr = $response->getData();
                if ($type == 2 || $type == 3) {
                    $orders = new Order;
                    $orders->order_number = random_number();
                    $orders->product_id = $customer_info['product_id'];
                    $orders->user_id = Auth::user()->id;
                    $orders->type = $type;
                    $orders->bid_amount = $customer_info['bid_amount'];
                    $orders->amount = $customer_info['amount'];
                    $orders->tax_amount = $customer_info['tax_amount'];
                    $orders->quantity = $customer_info['quantity'];
                    $orders->billing_first_name = $customer_info['billing_first_name'];
                    $orders->billing_last_name = $customer_info['billing_last_name'];
                    $orders->billing_address = $customer_info['billing_address'];
                    $orders->billing_country_id = $customer_info['billing_country_id'];
                    $orders->billing_state_id = $customer_info['billing_state_id'];
                    $orders->billing_city_id = $customer_info['billing_city_id'];
                    $orders->billing_post_code = $customer_info['billing_post_code'];
                    $orders->billing_phone = $customer_info['billing_phone'];
                    $orders->billing_email = $customer_info['billing_email'];
                    $orders->shipping_first_name = $customer_info['shipping_first_name'];
                    $orders->shipping_last_name = $customer_info['shipping_last_name'];
                    $orders->shipping_address = $customer_info['shipping_address'];
                    $orders->shipping_country_id = $customer_info['shipping_country_id'];
                    $orders->shipping_state_id = $customer_info['shipping_state_id'];
                    $orders->shipping_city_id = $customer_info['shipping_city_id'];
                    $orders->shipping_post_code = $customer_info['shipping_post_code'];
                    $orders->shipping_phone = $customer_info['shipping_phone'];
                    $orders->shipping_email = $customer_info['shipping_email'];
                    $orders->message = $customer_info['message'];
                    $orders->merchant_id = $customer_info['merchant_id'];

                    if ($type == 2 && $customer_info['amount'] > 0) {
                        $orders->payment_status = 1;
                    } elseif ($type == 2 && $customer_info['amount'] == 0) {
                        $orders->payment_status = 2;
                    } elseif ($type == 3) {
                        $orders->payment_status = 3;
                    }
                    $orders->save();
                }
                $payment = new Wallet;
                $payment->transaction_id = $arr['id'];
                $payment->user_id = Auth::user()->id;
                if ($request->type == 2 || $request->type == 3) {
                    $payment->order_id = $orders->id ?? null;
                } elseif ($request->type == 7) {
                    $payment->order_id = $customer_info['order_id'] ?? null;
                }
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['email'];
                $payment->gateway_amount = $arr['transactions'][0]['amount']['total'];
                $payment->type = $type;
                if ($type == 2 || $type == 3 || $type == 7) {
                    $products = Product::findOrFail($customer_info['product_id']);
                    $admin_commission_rate = $products->users->admin_commission ?? get_setting('merchant_commission');
                    $payment_rate = 100 - ($admin_commission_rate ?? 0);
                    $merchant_amount = $customer_info['amount'] / 100 * $payment_rate;
                    $payment->merchant_amount = $merchant_amount;
                    $payment->admin_commission_rate = ($admin_commission_rate ?? 0);
                    $admin_commission = $customer_info['amount'] - $merchant_amount;
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
                    $products = Product::findOrFail($customer_info['product_id']);
                    $payment->payment_details = 'Purchase - ' . $products->name;
                } elseif ($type == 4) {
                    $payment->payment_details = 'Withdraw from Wallet';
                } elseif ($type == 7) {
                    $payment->payment_details = 'Bid Final Payment';
                }
                $payment->amount = $customer_info['amount'];
                $payment->tax_amount = $customer_info['tax_amount'];
                $payment->total_amount = $customer_info['total_amount'];
                $payment->payment_method = 'paypal';
                $payment->currency = $arr['transactions'][0]['amount']['currency'];
                $payment->status = 2;
                $payment->save();
                if ($type == 1) {
                    Auth::user()->increment('wallet_balance', $customer_info['amount']);
                    email_send('deposit', Auth::user()->email);
                    Session::forget($customer_info);
                    return redirect()->route('customer.deposit')->with('success', translate('Deposit successfully! Your Transaction ID is:') . $arr['id']);
                } elseif ($type == 2) {
                    email_send('bidding_customer', Auth::user()->email);
                    Session::forget($customer_info);
                    return redirect()->route('thank_you')->with(['success' => translate('Bid successfully! Your Transaction ID is:') . $arr['id'], 'orders' => $orders]);
                } elseif ($type == 3) {
                    Product::findOrFail($customer_info['product_id'])->decrement('quantity', $customer_info['quantity']);
                    email_send('order_mail', Auth::user()->email);
                    Session::forget($customer_info);
                    return redirect()->route('thank_you')->with(['success' => translate('Order successfully! Your Transaction ID is:') . $arr['id'], 'orders' => $orders]);
                } elseif ($type == 7) {
                    $orders = Order::findOrFail($customer_info['order_id']);
                    $orders->payment_status = 3;
                    $orders->update();
                    email_send('final_payment', Auth::user()->email);
                    Session::forget($customer_info);
                    return redirect()->route('customer.bid')->with('success', translate('Final Payment successfully! Your Transaction ID is:') . $arr['id']);
                }
            } else {
                return redirect()->back()->with('error', $response->getMessage());
            }
        } else {
            return redirect()->back()->with('error', translate('Your Transection is declined'));
        }
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















}
