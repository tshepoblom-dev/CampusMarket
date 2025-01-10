<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use PDF;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'pverify']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $page_title = translate('All Orders');
        $lang = $request->lang;

        if ($user->role == 2) {
            if ($request->search) {
                $orders = Order::select('orders.*')
                    ->join('products', 'products.id', '=', 'orders.product_id')
                    ->where('orders.type', 3)
                    ->where('products.author_id', $user->id)
                    ->where('products.name', 'LIKE', '%' . $request->search . '%')
                    ->latest('orders.created_at')->paginate(10);
            } else {
                $orders = Order::select('orders.*')
                    ->join('products', 'products.id', '=', 'orders.product_id')
                    ->where('orders.type', 3)
                    ->where('products.author_id', $user->id)
                    ->latest('orders.created_at')->paginate(10);
            }
            $user_sale_products = Product::where('sale_type', 2)->where('author_id', $user->id)->pluck('id');
            $user_bidding_products = Product::where('sale_type', 1)->where('author_id', $user->id)->pluck('id');
            $user_all_products = Product::where('author_id', $user->id)->pluck('id');
            $data['total_sale_amount'] =  $this->salesSubByStatus($type = 3, $status = 3, $author = $user->id);
            $data['total_orders'] = $this->allOrder($user->id)->count();
            $data['total_processing_orders'] = $this->getOrderByStatus($status = 1, $user->id)->count();
            $data['total_completed_orders'] = $this->getOrderByStatus($status = 4, $user->id)->count();
            $data['total_deliverd_orders'] = $this->getOrderByStatus($status = 6, $user->id)->count();
        } else {
            if ($request->search) {
                $orders = Order::select('orders.*')
                    ->join('products', 'products.id', '=', 'orders.product_id')
                    ->where('orders.type', 3)
                    ->where('products.name', 'LIKE', '%' . $request->search . '%')
                    ->latest('orders.created_at')->paginate(10);
            } else {
                $orders = Order::where('type', 3)->latest()->paginate(10);
            }
            $data['total_sale_amount'] =  $this->salesSubByStatus($type = 3, $status = 3, $userType = null);
            $data['total_orders'] = $this->allOrder()->count();
            $data['total_processing_orders'] = $this->getOrderByStatus($status = 1)->count();
            $data['total_completed_orders'] = $this->getOrderByStatus($status = 4)->count();
            $data['total_deliverd_orders'] = $this->getOrderByStatus($status = 6)->count();
        }

        return view('backend.orders.index', compact('page_title', 'orders', 'lang', 'data'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $page_title = translate('Invoice');
        $lang = $request->lang;
        $order = Order::with('merchant')->where('id', $id)->first();
        $order->increment('view', 1);
        return view('backend.orders.details', compact('page_title', 'order', 'lang'));
    }

    /**
     * Display a listing of the Bidding.
     */
    public function bidding(Request $request)
    {
        $user = Auth::user();
        $page_title = translate('All Bidding');
        $lang = $request->lang;

        if ($user->role == 2) {
            if ($request->search) {
                $bidding = Order::select('orders.*')
                    ->join('products', 'products.id', '=', 'orders.product_id')
                    ->where('orders.type', 2)
                    // ->where('orders.win_status', 0)
                    ->where('orders.merchant_id', $user->id)
                    ->where('products.name', 'LIKE', '%' . $request->search . '%')
                    ->latest('orders.created_at')->paginate(10);
            } else {
                $bidding = Order::select('orders.*')
                    ->join('products', 'products.id', '=', 'orders.product_id')
                    ->where('orders.type', 2)
                    // ->where('orders.win_status', 0)
                    ->where('orders.merchant_id', $user->id)
                    ->latest('orders.created_at')->paginate(10);
            }
            $user_all_products = Product::where('author_id', $user->id)->pluck('id');
            $data['total_bidder'] =  Order::where('type', 2)->where('merchant_id', Auth::user()->id)->count();
            $data['total_bidding_amount'] = Order::where('type', 2)->where('payment_status', 3)->where('merchant_id', Auth::user()->id)->sum('bid_amount');
            $data['total_winner'] =  Order::where('type', 2)->where('win_status', 1)->where('merchant_id', Auth::user()->id)->count();
            $data['live_auction'] = Product::where('sale_type', 1)->where('status', 1)->where('author_id', $user->id)->count();
            $data['closed_bids'] = Product::where('sale_type', 1)->where('status', 5)->where('author_id', $user->id)->count();
        } else {
            if ($request->search) {
                $bidding = Order::select('orders.*')
                    ->join('products', 'products.id', '=', 'orders.product_id')
                    ->where('orders.type', 2)
                    ->where('products.name', 'LIKE', '%' . $request->search . '%')
                    ->whereNotIn('status', [2, 4, 6, 8])
                    ->latest('orders.created_at')->paginate(10);
            } else {
                $bidding = Order::where('type', 2)->latest()->paginate(10);
            }
            $data['total_bidder'] =  Order::where('type', 2)->count();
            $data['total_bidding_amount'] = Order::where('type', 2)->where('payment_status', 3)->sum('bid_amount');
            $data['total_winner'] =  Order::where('type', 2)->where('win_status', 1)->count();
            $data['live_auction'] = Product::where('sale_type', 1)->where('status', 1)->count();
            $data['closed_bids'] = Product::where('sale_type', 1)->where('status', 5)->count();
        }
        return view('backend.orders.bidding', compact('page_title', 'bidding', 'lang', 'data'));
    }

    /**
     * Change order Status.
     */
    public function changeStatus(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->status = $request->status_id;
        $order->update();
        return redirect()->back()->with('success', translate('Order status changed successfully!'));
    }


    /**
     * pdf_download_invoice
     *
     * @param  mixed $request
     * @param  int $id
     * @return Response
     */
    public function pdf_download_invoice(Request $request, $id)
    {
        $page_title = translate('Invoice');
        $lang = $request->lang;
        $orders = Order::findOrFail($id);
        $pdf = PDF::loadView('backend.orders.invoice_pdf', array('page_title' =>  $page_title, 'lang' => $lang, 'orders' => $orders))
            ->setPaper('a4', 'portrait');
        return $pdf->download('invoice' . $orders->id . '.pdf');
    }

    /**
     * getOrderByType
     *
     * @param  int $type
     * @param  array $merchantProduct
     * @return Response
     */
    public function getOrderByType($type, $merchantId = null)
    {

        $orders = Order::where('type', $type);
        if (!empty($merchantId)) {
            return $orders->where('merchant_id', $merchantId)->get();
        }
        return $orders->get();
    }

    /**
     * getOrderByStatus
     *
     * @param  int $status
     * @param  array $merchantProduct product Id
     * @return Response
     */
    public function getOrderByStatus($status, $merchantId = null)
    {

        $orders = Order::where('type', 3)->where('status', $status);
        if (!empty($merchantId)) {
            return $orders->where('merchant_id', $merchantId)->get();
        }
        return $orders->get();
    }
    /**
     * allOrder
     *
     * @param  array $merchantProduct product Id
     * @return Response
     */
    public function allOrder($merchantId = null)
    {
        if (!empty($merchantId)) {
            return Order::where('type', 3)->where('merchant_id', $merchantId)->get();
        }
        return Order::where('type', 3)->get();
    }

    /**
     * salesSubByStatus
     *
     * @param  int $type
     * @param  int $status
     * @param  int $author
     * @return Response
     */
    public function salesSubByStatus($type = null, $status = null, $author = null)
    {
        $order =  Order::where('type', $type)->where('payment_status', $status);
        if (!empty($author)) {
            return $order->where('merchant_id', $author)->sum('amount');
        }
        return $order->sum('amount');
    }
}
