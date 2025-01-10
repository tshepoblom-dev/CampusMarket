<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class WinnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_title = translate('Winner List');
        $user = Auth::user();

        $winners = Order::select('orders.*')
            ->join('products', 'products.id', '=', 'orders.product_id')

            ->when($user->role == 2, function ($q) use ($user) {
                return $q->where('products.author_id', $user->id);
            })
            ->when($request->search, function ($q) use ($request) {
                return $q->where('products.name', 'LIKE', '%' . $request->search . '%');
            })
            ->where('orders.type', 2)
            ->where('orders.win_status', 1)
            ->paginate(12);
        return view('backend.winner.index', compact('page_title', 'winners'));
    }
}
