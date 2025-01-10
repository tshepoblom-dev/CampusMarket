<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Wallet;
use App\Models\Product;
use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MerchantPaymentInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    /**
     * Show the application admin dashboard.
     */
    public function index()
    {
        $user       = Auth::user();
        $page_title = translate('Dashboard');
        if ($user->role == 2) {
            $user_sale_products    = Product::where('sale_type', 2)->where('author_id', $user->id)->pluck('id');
            $user_bidding_products = Product::where('sale_type', 1)->where('author_id', $user->id)->pluck('id');
            $user_all_products     = Product::where('author_id', $user->id)->pluck('id');
            $user_customers        = Order::where('product_id', array($user_all_products))->groupBy('user_id')->pluck('user_id');

            $total_sales = Order::where('type', 3)->where('status', 4)->whereIn('product_id', $user_sale_products)->sum('quantity');

            $total_bids = Order::where('type', 2)->where('product_id', array($user_bidding_products))->count();

            $data['total_amount']       = $this->walletMultiTypeByStatus($type = array(2, 3, 7), $status = 2, $author = $user->id);
            $data['total_sale_amounts'] = Order::where('type', 3)->where('payment_status', 3)->where('product_id', array($user_sale_products))->sum('amount');
            $data['total_bid_amounts']  = Order::where('type', 2)->where('payment_status', 3)->where('product_id', array($user_sale_products))->sum('amount');
            $data['total_withdraw']     = $this->walletSubByStatus($type = 4, $status = 2, $userId = $user->id);


            $data['depositReports']   = $this->transitionReport($status = 2, $type = 1);
            $data['widthdrawReports'] = $this->transitionReport($status = 2, $type = 4);

            $productSettingReport = $this->productSellingReport();

            $data['purchaseOrderReports'] = $this->orderTypeSales($user_sale_products, $orderType = 3, $orderStatus = 4);
            $data['bidOrderReports']      = $this->orderTypeSales($user_bidding_products, $orderType = 2, $orderStatus = 2);
            $data['orderSummeries']       = $this->orderSummeryReport($user_all_products);
        } else {

            $total_amount = Order::where('payment_status', 4)->sum('amount');
            $total_sales = Order::where('type', 3)->where('status', 4)->sum('quantity');
            $total_bids  = Order::where('type', 2)->count();

            $data['total_amount']       = $this->walletMultiTypeByStatus($type = array(2, 3, 7), $status = 2, $author = null);
            $data['total_tax']          = $this->taxMultiTypeByStatus($type = array(2, 3, 7), $status = 2, $userType = null);
            $data['total_sale_amounts'] = Order::where('type', 3)->where('payment_status', 3)->sum('amount');
            $data['total_bid_amounts']  = Order::where('type', 2)->where('payment_status', 3)->sum('amount');
            $data['total_profits']      = Wallet::where('status', 2)->sum('admin_commission');
            $data['depositReports']     = $this->transitionReport($status = 2, $type = 1);
            $data['widthdrawReports']   = $this->transitionReport($status = 2, $type = 4);

            $productSettingReport = $this->productSellingReport();

            $data['purchaseOrderReports'] = $this->orderTypeSales(null, $orderType = 3, $orderStatus = 4);
            $data['bidOrderReports']      = $this->orderTypeSales(null, $orderType = 2, $orderStatus = 2);
            $data['orderSummeries']       = $this->orderSummeryReport(null);
            $data['customers']            = $this->userSummeryReport($type = 1, $status = 1);
            $data['merchants']            = $this->userSummeryReport($type = 2, $status = 1);
        }
        return view('backend.dashboard.index', compact('page_title', 'total_sales', 'total_bids', 'productSettingReport', 'data'));
    }


    /**
     * profile
     *
     * @return view
     */
    public function profile()
    {
        $userSingle = Auth::user();
        if ($userSingle->role == 2) {
            $page_title = translate('Merchant Profile');
        } else {
            $page_title = translate('Admin Profile');
        }
        $merchant_payment = MerchantPaymentInfo::where('user_id', $userSingle->id)->get();
        $countries        = Location::where('country_id', null)->where('state_id', null)->get();
        return view('backend.dashboard.profile', compact('page_title', 'userSingle', 'countries', 'merchant_payment'));
    }


    /**
     * profile_update
     *
     * @param  mixed $request
     * @param  int   $id
     * @return Response
     */
    public function profile_update(Request $request, $id)
    {
        $users = User::findOrFail($id);

        /** Validation */
        $validator = Validator::make(
            $request->all(),
            [
                'fname'      => 'required|max:255',
                'lname'      => 'required|max:255',
                'email'      => 'required|max:255|unique:users,email,' . $users->id,
                'phone'      => 'required|max:255|unique:users,phone,' . $users->id,
                'username'   => 'required|max:255|unique:users,username,' . $users->id,
                'address'    => 'required|max:255',
                'country_id' => 'required|max:255',
                'state_id'   => 'required|max:255',
                'city_id'    => 'required|max:255',
                'zip_code'   => 'required|max:255',
                'image'      => 'nullable|image',
            ]
        );

        if ($request->password) {
            $validator = Validator::make($request->all(), [
                'password'   => 'required|confirmed|min:8',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /** image upload */
        $image = $request->file('image');
        if ($image != '') {
            if ($users->image != null) {
                unlink(public_path('uploads/users/' . $users->image));
            }
            $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/users'), $image_name);
            $users->image = $image_name;
        }
        $users->fname      = $request->fname;
        $users->lname      = $request->lname;
        $users->address    = $request->address;
        $users->username   = $request->username;
        $users->email      = $request->email;
        $users->phone      = $request->phone;
        $users->country_id = $request->country_id;
        $users->state_id   = $request->state_id;
        $users->city_id    = $request->city_id;
        $users->zip_code   = $request->zip_code;

        if ($request->password) {
            $users->password = Hash::make($request->password);
        }
        $users->update();


        if ($users->role == 2) {
            $this->merchantPaymentInfo($request, $id);
        }


        return redirect()->back()->with('success', translate('Your profile has been updated successfully'));
    }


    /**
     * shop
     *
     * @return view
     */
    public function shop()
    {
        $userSingle = Auth::user();
        $shopSingle = Store::where('author_id', $userSingle->id)->first();
        $page_title = translate('My Shop');
        $countries  = Location::where('country_id', null)->where('state_id', null)->get();
        return view('backend.dashboard.shop', compact('page_title', 'shopSingle', 'countries'));
    }


    /**
     * shop_update
     *
     * @param  mixed $request
     * @return Response
     */
    public function shop_update(Request $request)
    {
        $shop      = $request->shop_id ? Store::findOrFail($request->shop_id) : new Store();
        $validator = Validator::make(
            $request->all(),
            array(
                'name'           => isset($request->shop_id) ? 'required|max:255|unique:stores,name,' . $shop->id : 'required|max:255|unique:stores,name',
                'shop_email'     => 'nullable|max:255',
                'shop_phone'     => 'nullable|max:255',
                'shop_address'   => 'nullable|max:255',
                'shop_logo'      => 'nullable',
                'cover_img'      => 'nullable',
                'facebook_link'  => 'nullable|max:255',
                'twitter_link'   => 'nullable|max:255',
                'linkedin_link'  => 'nullable|max:255',
                'instagram_link' => 'nullable|max:255',
                'pinterest_link' => 'nullable|max:255',
                'youtube_link'   => 'nullable|max:255',
            )
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /** Shop Logo upload */
        $shop_logo = $request->file('shop_logo');
        if ($shop_logo != '') {
            if ($shop->logo != null) {
                unlink(public_path('uploads/shop/' . $shop->logo));
            }
            $shop_logo_name = pathinfo($shop_logo->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $shop_logo->getClientOriginalExtension();
            $shop_logo->move(public_path('uploads/shop'), $shop_logo_name);
            $shop->logo = $shop_logo_name;
        }
        /** Shop Cover Image upload */
        $cover_img = $request->file('cover_img');
        if ($cover_img != '') {
            if ($shop->cover_img != null) {
                unlink(public_path('uploads/shop/' . $shop->cover_img));
            }
            $cover_img_name = pathinfo($cover_img->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $cover_img->getClientOriginalExtension();
            $cover_img->move(public_path('uploads/shop'), $cover_img_name);
            $shop->cover_img = $cover_img_name;
        }
        $shop->name      = $request->name;
        $shop->slug      = Str::slug($request->name);
        $shop->author_id = Auth::user()->id;
        $shop->email     = $request->shop_email;
        $shop->phone     = $request->shop_phone;
        $shop->address   = $request->shop_address;
        $shop->facebook  = $request->facebook_link;
        $shop->twitter   = $request->twitter_link;
        $shop->linkedin  = $request->linkedin_link;
        $shop->instagram = $request->instagram_link;
        $shop->pinterest = $request->pinterest_link;
        $shop->youtube   = $request->youtube_link;
        $shop->save();

        return redirect()->back()->with('success', translate('Your shop has been updated successfully'));
    }


    /**
     * transaction
     *
     * @return View
     */
    public function transaction()
    {
        $page_title = translate('Transactions');
        $user       = Auth::user();
        if ($user->role == 2) {
            $transactions = Wallet::where('user_id', $user->id)->latest()->paginate(10);
        } else {
            $transactions = Wallet::latest()->paginate(10);
        }
        return view('backend.dashboard.transaction', compact('page_title', 'transactions'));
    }




    /**
     * depositMonthlyReport
     *
     * @param  mixed $status
     * @return Response
     */
    public function transitionReport($status, $type)
    {
        return Wallet::select(
            DB::raw('SUM(amount) as total_amount'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as monthsYears")
        )
            ->where('status', $status)
            ->where('type', $type)
            ->groupBy('monthsYears')
            ->get();
    }


    /**
     * depositMonthlyReport
     *
     * @param  mixed $status
     * @return Response
     */
    public function productSellingReport()
    {
        return Product::select(
            DB::raw('count(*) as total'),
            DB::raw("DATE_FORMAT(created_at,'%d %M %Y') as monthsYears")
        )
            ->where('sale_type', 2)
            ->groupBy('monthsYears')
            ->get();
    }

    /**
     * depositMonthlyReport
     *
     * @param  mixed $status
     * @return Response
     */
    public function productSellingAmountReport()
    {
        return Product::select(
            DB::raw('count(*) as total'),
            DB::raw("DATE_FORMAT(created_at,'%d %M %Y') as monthsYears")
        )
            ->where('sale_type', 2)
            ->groupBy('monthsYears')
            ->get();
    }

    /**
     * orderTypeSales
     *
     * @param  mixed $product
     * @param  int   $orderType
     * @param  int   $orderStatus
     * @return Response
     */

    public function orderTypeSales($product = null, $orderType, $orderStatus)
    {

        $order = Order::select(
            DB::raw('SUM(quantity) as quantity'),
            DB::raw('SUM(amount) as amount'),
            DB::raw("DATE_FORMAT(created_at,'%d %M %Y') as monthsYears")
        )
            ->where('type', $orderType)
            ->where('status', $orderStatus);
        if (!empty($product)) {
            return $order->whereIn('product_id', $product)
                ->groupBy('monthsYears')
                ->get();
        } else {
            return $order
                ->groupBy('monthsYears')
                ->get();
        }
    }

    /**
     * orderSummeryReport
     *
     * @param  Object $product
     * @return Response
     */
    public function orderSummeryReport($product = null)
    {

        $order = Order::select(
            DB::raw('SUM(quantity) as quantity'),
            DB::raw("DATE_FORMAT(created_at,'%d %M %Y') as monthsYears")
        );

        if (!empty($product)) {
            return $order->whereIn('product_id', $product)
                ->groupBy('monthsYears')
                ->get();
        } else {
            return $order
                ->groupBy('monthsYears')
                ->get();
        }
    }

    /**
     * userSummeryReport
     *
     * @param  int $type
     * @param  int $status
     * @return Response
     */
    public function userSummeryReport($type = null, $status = null)
    {
        return User::select(
            DB::raw('COUNT(*) as total'),
            DB::raw("DATE_FORMAT(created_at,'%d %M %Y') as monthsYears")
        )
            ->where('role', $type)
            ->where('status', $status)
            ->groupBy('monthsYears')
            ->get();
    }

    /**
     * walletSubByStatus
     *
     * @param  int $type
     * @param  int $status
     * @param  int $userType
     * @return Response
     */
    public function walletSubByStatus($type = null, $status = null, $userType = null)
    {
        $wallet = Wallet::where('type', $type)->where('status', $status);
        if (!empty($userType)) {
            return $wallet->where('user_id', $userType)->sum('amount');
        }
        return $wallet->sum('amount');
    }

    /**
     * walletMultiTypeByStatus
     *
     * @param  int $type
     * @param  int $status
     * @param  int $author
     * @return Response
     */
    public function walletMultiTypeByStatus($type = null, $status = null, $author = null)
    {
        if (!empty($author)) {
            return Wallet::where('wallets.status', $status)->whereIn('wallets.type', $type)->join('orders', 'orders.id', '=', 'wallets.order_id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->where('products.author_id', $author)->sum('wallets.amount');
        } else {
            $wallet = Wallet::where('status', $status)->whereIn('type', $type);
            return $wallet->sum('amount');
        }
    }

    /**
     * taxMultiTypeByStatus
     *
     * @param  int $type
     * @param  int $status
     * @param  int $userType
     * @return Response
     */
    public function taxMultiTypeByStatus($type = null, $status = null, $userType = null)
    {
        $wallet = Wallet::where('status', $status)->whereIn('type', $type);
        if (!empty($userType)) {
            return $wallet->where('user_id', $userType)->sum('amount');
        }
        return $wallet->sum('tax_amount');
    }


    /**
     * merchantPaymentInfo
     *
     * @param  mixed $request
     * @param  int $id
     * @return response
     */
    protected function merchantPaymentInfo($request, $id)
    {
        $new_existing     = array_filter($request->merchant_payment_id);
        $existing_payment = MerchantPaymentInfo::where('user_id', $id)->pluck('id')->toArray();
        $remove_existing  = array_diff($existing_payment, $new_existing);
        MerchantPaymentInfo::where('id', $remove_existing)->delete();
        foreach ($request->merchant_payment_id as $key => $val) {
            if ($val != null) {
                $merchant_payment                        = MerchantPaymentInfo::findOrFail($val);
                $merchant_payment->payment_type          = $request->payment_type[$key];
                $merchant_payment->bank_name             = $request->bank_name[$key];
                $merchant_payment->branch_name           = $request->branch_name[$key];
                $merchant_payment->bank_ac_name          = $request->bank_ac_name[$key];
                $merchant_payment->bank_ac_number        = $request->bank_ac_number[$key];
                $merchant_payment->bank_routing_number   = $request->bank_routing_number[$key];
                $merchant_payment->mobile_banking_name   = $request->mobile_banking_name[$key];
                $merchant_payment->mobile_banking_number = $request->mobile_banking_number[$key];
                $merchant_payment->paypal_name           = $request->paypal_name[$key];
                $merchant_payment->paypal_username       = $request->paypal_username[$key];
                $merchant_payment->paypal_email          = $request->paypal_email[$key];
                $merchant_payment->paypal_mobile_number  = $request->paypal_mobile_number[$key];
                $merchant_payment->update();
            } elseif ($request->payment_type[$key]) {
                $merchant_payment               = new MerchantPaymentInfo();
                $merchant_payment->user_id      = $id;
                $merchant_payment->payment_type = $request->payment_type[$key];

                if ($request->payment_type[$key] == 1) {
                    $merchant_payment->bank_name           = $request->bank_name[$key];
                    $merchant_payment->branch_name         = $request->branch_name[$key];
                    $merchant_payment->bank_ac_name        = $request->bank_ac_name[$key];
                    $merchant_payment->bank_ac_number      = $request->bank_ac_number[$key];
                    $merchant_payment->bank_routing_number = $request->bank_routing_number[$key];
                } elseif ($request->payment_type[$key] == 2) {
                    $merchant_payment->mobile_banking_name   = $request->mobile_banking_name[$key];
                    $merchant_payment->mobile_banking_number = $request->mobile_banking_number[$key];
                } else {
                    $merchant_payment->paypal_name          = $request->paypal_name[$key];
                    $merchant_payment->paypal_username      = $request->paypal_username[$key];
                    $merchant_payment->paypal_email         = $request->paypal_email[$key];
                    $merchant_payment->paypal_mobile_number = $request->paypal_mobile_number[$key];
                }
                $merchant_payment->save();
            }
        }
    }
}
