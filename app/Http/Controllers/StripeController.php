<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Stripe;

class StripeController extends Controller
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

            $amount = floatval(str_replace(',', '', $request->amount));
            $total_amount = floatval(str_replace(',', '', $request->total_amount));
            $tax_amount = floatval(str_replace(',', '', $request->tax_amount));


            $product = Product::where('id', $request->product_id)->first();

            $currency = get_setting('default_currency');
            $token = $request->stripeToken;
            Stripe\Stripe::setApiKey(get_payment_method('stripe_secret'));

            $main_amount = ($total_amount / (get_payment_method('stripe_conversion') ?? 1));

            $main_amount= ($main_amount * 100);

            if ($request->type == 1 || $request->type == 7) {
                $response = Stripe\Charge::create([
                    'amount' => $main_amount,
                    'currency' => 'USD',
                    'source' => $request->stripeToken,
                ]);
            } elseif ($request->type == 2 || $request->type == 3) {

                $customer = Stripe\Customer::create([

                    'address' => [
                        'line1' => $request->billing_address,
                        'postal_code' => $request->billing_post_code,
                        'city' => Location::where('id', $request->billing_city_id)->pluck('name')->first(),
                        'state' => Location::where('id', $request->billing_state_id)->pluck('name')->first(),
                        'country' => Location::where('id', $request->billing_country_id)->pluck('name')->first(),
                    ],
                    'email' => $request->billing_email,
                    'name' => $request->billing_first_name . ' ' . $request->billing_last_name,
                    'source' => $request->stripeToken,
                ]);

                $response = Stripe\Charge::create([
                    'amount' =>$main_amount,
                    'currency' => 'USD',
                    'customer' => $customer->id,
                    'shipping' => [
                        'name' => $request->billing_first_name . ' ' . $request->billing_last_name,
                        'address' => [
                            'line1' => $request->shipping_address ?? $request->billing_address,
                            'postal_code' => $request->shipping_post_code ?? $request->billing_post_code,
                            'city' => Location::where('id', $request->shipping_city_id)->pluck('name')->first() ?? Location::where('id', $request->billing_city_id)->pluck('name')->first(),
                            'state' => Location::where('id', $request->shipping_state_id)->pluck('name')->first() ?? Location::where('id', $request->billing_state_id)->pluck('name')->first(),
                            'country' => Location::where('id', $request->shipping_country_id)->pluck('name')->first() ?? Location::where('id', $request->billing_country_id)->pluck('name')->first(),
                        ],

                    ],

                ]);
            }

            if ($request->type == 2 || $request->type == 3) {
                $orders = new Order;
                $orders->order_number = random_number();
                $orders->product_id = $product->id;
                $orders->user_id = Auth::user()->id;
                $orders->type = $request->type;
                $orders->bid_amount = $request->bid_price;
                $orders->amount = $amount;
                $orders->tax_amount = $tax_amount;
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
                $orders->shipping_phone = $request->shipping_phone;
                $orders->shipping_email = $request->shipping_email;
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

                if ($request->type == 3) {
                    Product::findOrFail($request->product_id)->decrement('quantity', $request->quantity);
                }
            }

            $payment = new Wallet;
            $payment->transaction_id = $response->id;
            $payment->user_id = Auth::user()->id;
            if ($request->type == 2 || $request->type == 3) {
                $payment->order_id = $orders->id ?? null;
            } elseif ($request->type == 7) {
                $payment->order_id = $request->order_id ?? null;
            }
            $payment->payer_id = $response->id;
            $payment->payer_email = $request->billing_email ?? Auth::user()->email;
            $payment->type = $request->type;
            $payment->gateway_amount = $response->amount / 100;
            if ($request->type == 2 || $request->type == 3 || $request->type == 7) {
                $products = Product::findOrFail($request->product_id);
                $admin_commission_rate = $products->users->admin_commission ?? get_setting('merchant_commission');
                $payment_rate = 100 - ($admin_commission_rate ?? 0);
                $merchant_amount = ($amount / 100) * $payment_rate;
                $payment->merchant_amount = $merchant_amount;
                $payment->admin_commission_rate = ($admin_commission_rate ?? 0);
                $admin_commission = $amount - $merchant_amount;
                $payment->admin_commission = $admin_commission;

                // Auth::user()->decrement('wallet_balance', $total_amount);
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
            $payment->tax_amount = $tax_amount;
            $payment->total_amount = $total_amount;
            $payment->payment_method = 'stripe';
            $payment->currency = $response->currency;
            $payment->status = 2;
            $payment->save();
            return $response;
        } catch (\Throwable $th) {
            return ['status' => false , 'message' => $th->getMessage()];
        }
    }
}
