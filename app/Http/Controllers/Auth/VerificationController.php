<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use Str;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */



    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->middleware("pverify");

    }


     /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $templateId=get_setting('theme_id') ?? 1;
        $title = translate('Email Verification');
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : view('frontend.template-'.$templateId.'.auth.verify',compact('title'));
    }
    /**
     * Resend the email verification mail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */

    public function resend(Request $request)
    {
        $user = Auth::user();
        if($user->email != null){
            if($user->role == 1 && get_setting('customer_email_verification') != 1){
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
                return redirect()->route('customer.dashboard')->with('success',translate('Registration successful'));
            }elseif($user->role == 2 && get_setting('merchant_email_verification') != 1){
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
                return redirect()->route('backend.dashboard')->with('success',translate('Registration successful'));
            }else {
                try {
                    $token = Str::random(32);
                    $user->verify_token = $token;
                    $user->update();

                    $templates = EmailTemplate::where('slug','verification_email')->first();

                    if($templates){
                        $subject = $templates->subject;
                        $body = $templates->body;
                        $emailTo = $user->email;
                        $emailToName = $user->fname ? $user->fname.' '.$user->lname : $user->username;

                            $shortcodes['company_name'] = get_setting('company_name') ?? 'Bidout';
                            $shortcodes['customer_fname'] = $user->fname ?? '';
                            $shortcodes['customer_lname'] = $user->lname ?? '';
                            $shortcodes['customer_full_name'] = $user->fname ? $user->fname.' '.$user->lname : $user->username;
                            $shortcodes['customer_username'] = $user->username ?? '';
                            $shortcodes['customer_email'] = $user->email ?? '';
                            $shortcodes['verify_btn'] = '<p><a href="'.route('verification.verify',$token).'">Email Verify</a></p>';

                        foreach($shortcodes as $key=>$parameter)
                        {
                            $body = str_replace('['.$key.']', $parameter, $body);
                        }
                        if($emailTo){
                            Mail::send('backend.email_template.email_body', ['body' => $body], function($message)use($emailTo,$emailToName,$subject) {
                                $message->to($emailTo, $emailToName);
                                $message->subject($subject);
                            });
                        }
                    }
                    return redirect()->route('verification.notice')->with('success',translate('Registration successful. Please verify your email'));
                } catch (\Throwable $th) {
                    $user->delete();
                    return redirect()->route('register')->with('error',translate('Registration failed. Please try again later.'));
                }
            }
        }
    }

     /**
     * verify your email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function verify_email($token)
    {
        $user = User::where('verify_token',$token)->first();
        if($user){
            $user->email_verified_at = date('Y-m-d H:m:s');
            $user->verify_token = '';
            $user->update();
            if($user->role == 1){
                return redirect()->route('customer.dashboard')->with('success',translate('Email verification successful'));
            }elseif($user->role == 2){
                return redirect()->route('backend.dashboard')->with('success',translate('Email verification successful'));
            }
        }else{
            return redirect()->route('verification.notice')->with('error',translate('Your Token not match. Please try again'));
        }
    }
}
