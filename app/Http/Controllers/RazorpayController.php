<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\Wallet;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class RazorpayController extends Controller
{
    /**
     * submit
     *
     * @param  mixed $request
     * @return Response
     */
    public function submit($request)
    {

        try {

            $product = Product::where('id', $request->product_id)->first();

            $customer_info = [
                'billing_first_name' => $request->billing_first_name ?? Auth::user()->fname,
                'billing_last_name' => $request->billing_last_name ?? Auth::user()->lname,
                'billing_address' => $request->billing_address ?? Auth::user()->address,
                'billing_country_id' => $request->billing_country_id ?? '',
                'billing_state_id' => $request->billing_state_id ?? '',
                'billing_city_id' => $request->billing_city_id ?? '',
                'billing_post_code' => $request->billing_post_code ?? '',
                'billing_phone' => $request->billing_phone ?? Auth::user()->phone,
                'billing_email' => $request->billing_email ?? Auth::user()->email,
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
                'merchant_id' => $product->author_id ?? '',
                'product_id' => $product->id ?? '',
                'bid_amount' => $request->bid_price ?? 0,
                'amount' => $request->amount ?? 0,
                'tax_amount' => $request->tax_amount ?? 0,
                'total_amount' => $request->total_amount ?? 0,
                'type' => $request->type ?? 1,
                'currency' => 'INR',
                'current_url' => $request->current_url,
                'quantity' => $request->quantity ?? 1,
                'order_id' => $request->order_id ?? '',
            ];

            Session::put('customer_info', $customer_info);

            $receiptId = Str::random(20);
            // Create an object of razorpay
            $api = new Api(get_payment_method('razorpay_key'), get_payment_method('razorpay_secret'));
            $main_amount = ($request->total_amount / (get_payment_method('razorpay_conversion') ?? 1));

            $main_amount = (int) $main_amount;
            $main_amount =  ($main_amount*100);

            $order = $api->order->create([
                'receipt' => $receiptId,
                'amount' => $main_amount,
                'currency' => 'INR',
            ]);

            $response = [
                'orderId' => $order['id'],
                'razorpayId' => get_payment_method('razorpay_key'),
                'amount' =>$main_amount,
                'name' => ($request->billing_first_name . ' ' . $request->billing_last_name) ?? (Auth::user()->fname . ' ' . Auth::user()->lname),
                'currency' => 'INR',
                'email' => $request->billing_email ?? Auth::user()->email,
                'contactNumber' => $request->billing_phone ?? Auth::user()->phone,
                'address' => $request->billing_address ?? Auth::user()->address,
                'description' => 'Testing description',
            ];

            return $response;
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => 'Something Wrong'];
        }
    }

    /**
     * success
     *
     * @param  mixed $request
     * @return Response
     */
    public function success(Request $request)
    {
        try {

            $customer_info = Session::get('customer_info');
            if ($customer_info['type'] == 2 || $customer_info['type'] == 3) {
                $orders = new Order;
                $orders->order_number = random_number();
                $orders->product_id = $customer_info['product_id'];
                $orders->user_id = Auth::user()->id;
                $orders->type = $customer_info['type'];
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
                if ($customer_info['type'] == 2 && $customer_info['amount'] > 0) {
                    $orders->payment_status = 1;
                } elseif ($customer_info['type'] == 2 && $customer_info['amount'] == 0) {
                    $orders->payment_status = 2;
                } elseif ($customer_info['type'] == 3) {
                    $orders->payment_status = 3;
                }
                $orders->save();
            }

            $payment = new Wallet;
            $payment->transaction_id = $request->rzp_paymentid;
            $payment->user_id = Auth::user()->id;
            if ($request->type == 2 || $request->type == 3) {
                $payment->order_id = $orders->id ?? null;
            } elseif ($request->type == 7) {
                $payment->order_id = $customer_info['order_id'] ?? null;
            }
            $payment->payer_id = $request->rzp_orderid;
            $payment->payer_email = $customer_info['billing_email'];
            $payment->type = $customer_info['type'];
            $payment->gateway_amount = ($customer_info['total_amount'] / (get_payment_method('razorpay_conversion') ?? 1));

            if ($customer_info['type'] == 2 || $customer_info['type'] == 3 || $customer_info['type'] == 7) {
                $products = Product::findOrFail($customer_info['product_id']);
                $admin_commission_rate = $products->users->admin_commission ?? get_setting('merchant_commission');
                $payment_rate = 100 - ($admin_commission_rate ?? 0);
                $merchant_amount = $customer_info['amount'] / 100 * $payment_rate;
                $payment->merchant_amount = $merchant_amount;
                $payment->admin_commission_rate = ($admin_commission_rate ?? 0);
                $admin_commission = $customer_info['amount'] - $merchant_amount;
                $payment->admin_commission = $admin_commission;
                if ($customer_info['type'] == 3 || $customer_info['type'] == 7) {
                    if ($products->users->role == 2) {
                        User::findOrFail($products->author_id)->increment('wallet_balance', (int)$merchant_amount);
                    }
                    $admin = User::where('role', 4)->orderBy('id', 'asc')->first();
                    $admin->increment('wallet_balance', (int)$admin_commission);
                }
            }
            if ($customer_info['type'] == 1) {
                $payment->payment_details = 'Deposit to Wallet';
            } elseif ($customer_info['type'] == 2) {
                $payment->payment_details = 'Bid Initial Payment';
            } elseif ($customer_info['type'] == 3) {
                $products = Product::findOrFail($customer_info['product_id']);
                $payment->payment_details = 'Purchase - ' . $products->name;
            } elseif ($customer_info['type'] == 4) {
                $payment->payment_details = 'Withdraw from Wallet';
            } elseif ($customer_info['type'] == 7) {
                $payment->payment_details = 'Bid Final Payment';
            }

            $payment->amount = $customer_info['amount'];
            $payment->tax_amount = $customer_info['tax_amount'];
            $payment->total_amount = $customer_info['total_amount'];
            $payment->payment_method = 'razorpay';
            $payment->currency = $customer_info['currency'];
            $payment->status = 2;
            $payment->save();

            if ($customer_info['type'] == 1) {
                Auth::user()->increment('wallet_balance', $customer_info['amount']);
                email_send('deposit', Auth::user()->email);
                return redirect($customer_info['current_url'])->with('success', translate('Deposit successfully! Your Transaction ID is:') . $request->rzp_paymentid);
            } elseif ($customer_info['type'] == 2) {
                email_send('bidding_customer', Auth::user()->email);
                Session::forget($customer_info);
                return redirect()->route('thank_you')->with(['success' => translate('Bid successfully! Your Transaction ID is:') . $request->rzp_paymentid, 'orders' => $orders]);
            } elseif ($customer_info['type'] == 3) {
                Product::findOrFail($customer_info['product_id'])->decrement('quantity', $customer_info['quantity']);
                email_send('order_mail', Auth::user()->email);
                Session::forget($customer_info);
                return redirect()->route('thank_you')->with(['success' => translate('Order successfully! Your Transaction ID is:') . $request->rzp_paymentid, 'orders' => $orders]);
            } elseif ($customer_info['type'] == 7) {
                $orders = Order::findOrFail($customer_info['order_id']);
                $orders->payment_status = 3;
                $orders->update();
                email_send('final_payment', Auth::user()->email);
                return redirect()->route('customer.bid')->with('success', translate('Final Payment successfully! Your Transaction ID is:') . $request->rzp_paymentid);
            }
        } catch (\Throwable $th) {
            //throw $th;
            $templateId = get_setting('theme_id') ?? 1;
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => 'en']);

        }
    }

    /**
     * error
     *
     * @return Response
     */
    public function error()
    {
        return redirect('checkout')->with('error', translate('Payment not Complete!'));
    }

}
