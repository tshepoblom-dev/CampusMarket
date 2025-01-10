<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\MerchantPaymentInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_title = translate('Withdraw List');
        $user = Auth::user();
        if ($user->role == 2) {
            if (isset($request->search)) {
                $withdraws = Wallet::where('user_id', $user->id)
                    ->orWhere('payment_method', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('transaction_id', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('currency', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('amount', 'LIKE', '%' . $request->search . '%')
                    ->latest()
                    ->paginate(10);
            } else {
                $withdraws = Wallet::where('user_id', $user->id)->where('type', 4)->latest()->paginate(10);
            }
            $data['total_withdraw'] = Wallet::where('type', 4)->where('user_id', $user->id)->where('status', 2)->sum('amount');
            $data['pending_withdraw'] = Wallet::where('type', 4)->where('user_id', $user->id)->where('status', 1)->sum('amount');
            $data['pending_withdraw_request'] = Wallet::where('type', 4)->where('user_id', $user->id)->where('status', 1)->count();
            $data['paid_withdraw_request'] = Wallet::where('type', 4)->where('user_id', $user->id)->where('status', 2)->count();
        } else {
            if (isset($request->search)) {
                $withdraws = Wallet::where('user_id', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('payment_method', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('transaction_id', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('currency', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('amount', 'LIKE', '%' . $request->search . '%')
                    ->latest()
                    ->paginate(10);
            } else {
                $withdraws = Wallet::where('type', 4)->latest()->paginate(10);
            }
            $data['total_withdraw'] = Wallet::where('type', 4)->where('status', 2)->sum('amount');
            $data['pending_withdraw'] = Wallet::where('type', 4)->where('status', 1)->sum('amount');
            $data['pending_withdraw_request'] = Wallet::where('type', 4)->where('status', 1)->count();
            $data['paid_withdraw_request'] = Wallet::where('type', 4)->where('status', 2)->count();
        }

        return view('backend.withdraw.index', compact('page_title', 'withdraws', 'data'));
    }

    /**
     * add new withdraw from author.
     */
    public function withdraw_new()
    {
        $page_title = translate('Withdraw Request');
        $payment_methods = MerchantPaymentInfo::where('user_id', Auth::user()->id)->get();
        return view('backend.withdraw.request', compact('page_title', 'payment_methods'));
    }
    /**
     * withdraw request from author.
     */
    public function withdraw_request(Request $request)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'amount' => 'required|max:255',
            'payment_method' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $withdraws = Wallet::where('type', 4)->orderBy('id', 'desc')->pluck('transaction_id')->first();
        $currency = get_setting('default_currency');
        $wallets = new Wallet;
        if ($withdraws) {
            $numbers = substr($withdraws, 2);
            $transaction_id = 'WD' . str_pad(($numbers +  1), 5, '0', STR_PAD_LEFT);
            $wallets->transaction_id = $transaction_id;
        } else {
            $wallets->transaction_id = 'WD00001';
        }

        $wallets->user_id = Auth::user()->id;
        $wallets->payment_method = $request->payment_method;
        $wallets->amount = $request->amount;
        $wallets->currency = $currency->currencies->code ?? 'USD';
        $wallets->type = 4;
        $wallets->save();

        return redirect()->route('withdraw.list')->with('success', translate('Withdraw request send successfully'));
    }

    /**
     * withdraw request details from author.
     */
    public function details($id)
    {
        $user = Auth::user();
        if ($user->role == 2) {
            return redirect()->route('withdraw.list')->with('error', translate('This page not supported'));
        } else {
            $page_title = translate('Withdraw Request');
            $withdraw = Wallet::findOrFail($id);
            return view('backend.withdraw.details', compact('page_title', 'withdraw'));
        }
    }

    /**
     * withdraw request approved or cancel by Admin
     */
    public function status(Request $request, $id)
    {
        $withdraw = Wallet::findOrFail($id);
        if ($request->status == 1) {
            $withdraw->status = 2;
        } else {
            $withdraw->status = 3;
        }
        if ($withdraw->update()) {
            User::where('id', $withdraw->user_id)->decrement('wallet_balance', $withdraw->amount);
        }
        email_send('withdraw', $withdraw->users->email);

        return redirect()->route('withdraw.list')->with('success', translate('Withdraw status changed successfully!'));
    }
}
