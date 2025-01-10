<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PayfastController;
use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\Product;
use App\Models\Currency;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','pverify']);
    }
    /**
     * customer_payment
     *
     * @param  mixed $request
     * @return Response
     */
    public static function customer_payment(Request $request)
    {

        try {
            if ($request->payment_method == null) {
                return redirect()->back()->with('error', translate('Select Payment Method.'));
            }

            if ($request->payment_method == 'stripe') {
                if ($request->total_amount < (get_payment_method('stripe_conversion') / 2)) {
                    return redirect()->back()->with('error', translate('Total Amout is low for stripe payment'));
                }
            }

            if ($request->type == 2 || $request->type == 3) {
                $userSingle = Auth::user();
                /** Validation */
                $validator = Validator::make($request->all(), [
                    'billing_first_name' => 'required|max:255',
                    'billing_last_name' => 'required|max:255',
                    'billing_address' => 'required|max:255',
                    'billing_country_id' => 'required|max:255',
                    'billing_state_id' => 'required|max:255',
                    'billing_city_id' => 'required|max:255',
                    'billing_post_code' => 'required|max:255',
                    'billing_phone' => 'required|max:255',
                    'billing_email' => 'required|max:255',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                if ($userSingle->address == null) {
                    $userSingle->address = $request->billing_address;
                }
                if ($userSingle->country_id == null) {
                    $userSingle->country_id = $request->billing_country_id;
                }
                if ($userSingle->state_id == null) {
                    $userSingle->state_id = $request->billing_state_id;
                }
                if ($userSingle->city_id == null) {
                    $userSingle->city_id = $request->billing_city_id;
                }
                if ($userSingle->zip_code == null) {
                    $userSingle->zip_code = $request->billing_post_code;
                }
                if ($userSingle->phone == null) {
                    $userSingle->phone = $request->billing_phone;
                }
                $userSingle->update();
            }

            if ($request->payment_method == 'paypal') {
                $result = (new PaypalController)->submit($request);
                if (isset($result['status'])) {
                    return redirect()->back()->with('error', $result['message']);
                }
            } elseif($request->payment_method == 'payfast'){
                try{
                    $result = (new PayfastController)->submit($request);

                /*    $wallets = Wallet::where('payer_id', $result['id'])->first();
                    $orders = $wallets->wallets;
                    if ($request->type == 1) {
                        Auth::user()->increment('wallet_balance', $request->amount);
                        email_send('deposit', Auth::user()->email);

                        return redirect()->back()->with('success', translate('Deposit successfully! Your Transaction ID is:') . $result->id);
                    } elseif ($request->type == 2) {
                        email_send('bidding_customer', Auth::user()->email);
                        return redirect()->route('thank_you')->with(['success' => translate('Bid successfully! Your Transaction ID is:') . $result->id, 'orders' => $orders]);
                    } elseif ($request->type == 3) {
                        email_send('order_mail', Auth::user()->email);

                        return redirect()->route('thank_you')->with(['success' => translate('Order successfully! Your Transaction ID is:') . $result->id, 'orders' => $orders]);
                    } elseif ($request->type == 7) {
                        $orders = Order::findOrFail($request->order_id);
                        $orders->payment_status = 3;
                        $orders->update();
                        email_send('final_payment', Auth::user()->email);

                        return redirect()->route('customer.bid')->with('success', translate('Final Payment successfully! Your Transaction ID is:') . $result->id);
                    }*/
                } catch (\Throwable $th) {

                    //throw $th;
                    return redirect()->back()->with('error', $th->getMessage());
                }
            } elseif ($request->payment_method == 'stripe') {

                try {

                    $result = (new StripeController)->submit($request);
                    // if (isset($result['status'])) {
                    //     return redirect()->back()->with('error', $result['message']);
                    // }

                    $wallets = Wallet::where('payer_id', $result['id'])->first();
                    $orders = $wallets->wallets;
                    if ($request->type == 1) {
                        Auth::user()->increment('wallet_balance', $request->amount);
                        email_send('deposit', Auth::user()->email);

                        return redirect()->back()->with('success', translate('Deposit successfully! Your Transaction ID is:') . $result->id);
                    } elseif ($request->type == 2) {
                        email_send('bidding_customer', Auth::user()->email);
                        return redirect()->route('thank_you')->with(['success' => translate('Bid successfully! Your Transaction ID is:') . $result->id, 'orders' => $orders]);
                    } elseif ($request->type == 3) {
                        email_send('order_mail', Auth::user()->email);

                        return redirect()->route('thank_you')->with(['success' => translate('Order successfully! Your Transaction ID is:') . $result->id, 'orders' => $orders]);
                    } elseif ($request->type == 7) {
                        $orders = Order::findOrFail($request->order_id);
                        $orders->payment_status = 3;
                        $orders->update();
                        email_send('final_payment', Auth::user()->email);

                        return redirect()->route('customer.bid')->with('success', translate('Final Payment successfully! Your Transaction ID is:') . $result->id);
                    }
                } catch (\Throwable $th) {

                    //throw $th;
                    return redirect()->back()->with('error', $th->getMessage());
                }
            } elseif ($request->payment_method == 'razorpay') {

                $response = (new RazorpayController)->submit($request);
                if (isset($response['status'])) {
                    return redirect()->back()->with('error', $response['message']);
                } else {
                    $templateId = get_setting('theme_id') ?? 1;
                    $title = 'RazorPay Payment';
                    return view('frontend.template-' . $templateId . '.razorpay', compact('title', 'response'));
                }
            } elseif ($request->payment_method == 'wallet')
            {
                $product = Product::where('id', $request->product_id)->first();
                $total_amount = floatval(str_replace(',', '', $request->total_amount));
                $amount = floatval(str_replace(',', '', $request->amount));

                if (Auth::user()->wallet_balance >= $total_amount) {
                    $currency = Currency::findOrFail(get_setting('default_currency'));
                    $receiptId = Str::random(20);

                    if ($request->type == 2 || $request->type == 3) {
                        $orders = new Order;
                        $orders->order_number = random_number();
                        $orders->product_id = $product->id;
                        $orders->user_id = Auth::user()->id;
                        $orders->type = $request->type;
                        $orders->bid_amount = $request->bid_price;
                        $orders->amount = $amount;
                        $orders->tax_amount = $request->tax_amount;
                        $orders->quantity = $request->quantity;
                        $orders->billing_first_name = $request->billing_first_name;
                        $orders->billing_last_name = $request->billing_last_name;
                        $orders->billing_address = $request->billing_address;
                        $orders->billing_country_id = $request->billing_country_id;
                        $orders->billing_state_id = $request->billing_state_id;
                        $orders->billing_city_id = $request->billing_city_id;
                        $orders->billing_post_code = $request->billing_post_code;
                        $orders->billing_phone = $request->billing_phone;
                        $orders->billing_email = $request->billing_email;
                        $orders->shipping_first_name = $request->shipping_first_name;
                        $orders->shipping_last_name = $request->shipping_last_name;
                        $orders->shipping_address = $request->shipping_address;
                        $orders->shipping_country_id = $request->shipping_country_id ? $request->shipping_country_id  :null;
                        $orders->shipping_state_id =$request->shipping_state_id ?$request->shipping_state_id : null;
                        $orders->shipping_city_id =$request->shipping_city_id ? $request->shipping_city_id :null;
                        $orders->shipping_post_code = $request->shipping_post_code;
                        $orders->shipping_phone =$request->shipping_phone;
                        $orders->shipping_email =$request->shipping_email;
                        $orders->message = $request->message;
                        $orders->merchant_id = $product->author_id;
                        if ($request->type == 2 && $amount > 0) {
                            $orders->payment_status = 1;
                        } elseif ($request->type == 2 && $amount == 0) {
                            $orders->payment_status = 2;
                        } elseif ($request->type == 3) {
                            $orders->payment_status = 3;
                        }
                        $orders->save();
                    }

                    $payment = new Wallet;
                    $payment->transaction_id = $receiptId;
                    $payment->user_id = Auth::user()->id;
                    if ($request->type == 2 || $request->type == 3) {
                        $payment->order_id = $orders->id ?? null;
                    } elseif ($request->type == 7) {
                        $payment->order_id = $request->order_id ?? null;
                    }
                    $payment->payer_id = $receiptId;
                    $payment->payer_email = $request->billing_email ?? Auth::user()->email;
                    $payment->type = $request->type;
                    $payment->gateway_amount = $total_amount;
                    if ($request->type == 2 || $request->type == 3 || $request->type == 7) {
                        $products = Product::findOrFail($request->product_id);
                        $admin_commission_rate = $products->users->admin_commission ?? get_setting('merchant_commission');
                        $payment_rate = 100 - ($admin_commission_rate ?? 0);

                        $merchant_amount = ($amount / 100) * $payment_rate;
                        $admin_commission = $amount - $merchant_amount;
                        $payment->merchant_amount = $merchant_amount;
                        $payment->admin_commission_rate = ($admin_commission_rate ?? 0);
                        $payment->admin_commission = $admin_commission;

                        Auth::user()->decrement('wallet_balance', $total_amount);
                        if ($request->type == 3 || $request->type == 7) {
                            if ($products->users->role == 2) {
                                User::findOrFail($products->author_id)->increment('wallet_balance', (int)$merchant_amount);
                            }
                            $admin = User::where('role', 4)->orderBy('id', 'asc')->first();
                            $admin->increment('wallet_balance', (int)$admin_commission);
                        }
                    }
                    if ($request->type == 1) {
                        $payment->payment_details = 'Deposit to Wallet';
                    } elseif ($request->type == 2) {
                        $payment->payment_details = 'Bid Initial Payment';
                    } elseif ($request->type == 3) {
                        $products = Product::findOrFail($request->product_id);
                        $payment->payment_details = 'Purchase - ' . $products->name;
                    } elseif ($request->type == 4) {
                        $payment->payment_details = 'Withdraw from Wallet';
                    } elseif ($request->type == 7) {
                        $payment->payment_details = 'Bid Final Payment';
                    }
                    $payment->amount = $amount;
                    $payment->tax_amount = $request->tax_amount;
                    $payment->total_amount = $total_amount;
                    $payment->payment_method = 'wallet';
                    $payment->currency = $currency->code ?? 'ZAR';
                    $payment->status = 2;
                    $payment->save();
                    if ($request->type == 2) {
                        email_send('bidding_customer', Auth::user()->email);
                        return redirect()->route('thank_you')->with(['success' => translate('Bid successfully! Your Transaction ID is:') . $receiptId, 'orders' => $orders]);
                    } elseif ($request->type == 3) {
                        Product::findOrFail($request->product_id)->decrement('quantity', $request->quantity);
                        email_send('order_mail', Auth::user()->email);
                        return redirect()->route('thank_you')->with(['success' => translate('Order successfully! Your Transaction ID is:') . $receiptId, 'orders' => $orders]);
                    } elseif ($request->type == 7) {
                        $orders = Order::findOrFail($request->order_id);
                        $orders->payment_status = 3;
                        $orders->update();
                        email_send('final_payment', Auth::user()->email);
                        return redirect()->route('customer.bid')->with('success', translate('Final Payment successfully! Your Transaction ID is:') . $receiptId);
                    }
                } else {
                    return redirect()->back()->with('error', translate('Your Balance not sufficient. Please deposit.'));
                }
            }
        } catch (\Throwable $th) {

            // dd($th->getMessage());
            return redirect()->back()->with('error', translate('!Something Wrong'));
        }
    }
}
