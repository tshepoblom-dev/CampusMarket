<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;

class DepositController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','pverify']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_title = translate('Deposit List');
        if (isset($request->search)) {
            $deposits = Wallet::where('user_id', 'LIKE', '%' . $request->search . '%')
                ->orWhere('payment_method', 'LIKE', '%' . $request->search . '%')
                ->orWhere('transaction_id', 'LIKE', '%' . $request->search . '%')
                ->orWhere('currency', 'LIKE', '%' . $request->search . '%')
                ->orWhere('amount', 'LIKE', '%' . $request->search . '%')
                ->latest()
                ->paginate(10);
        } else {
            $deposits = Wallet::where('type', 1)->latest()->paginate(10);
        }
        return view('backend.deposits.index', compact('page_title', 'deposits'));
    }
}
