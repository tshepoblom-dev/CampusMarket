<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{

    public function index()
    {
        if(auth()->check()){
            return back()->with('error',translate('Not Allowed'));
        }
        $page_title = translate('Admin & Merchant Login');
        return view('auth.admin_login',compact('page_title'));
    }

    public function login(Request $request)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'login' => 'required|max:255',
            'password' => 'required|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }



        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if ( auth()->attempt(array($fieldType => $request->login, 'password' => $request->password)))
        {
            return redirect()->route('backend.dashboard');
        }else{
            return redirect()->route('admin.login.show')
                ->with('error',translate('These credentials do not match our records'));
        }
    }

}
