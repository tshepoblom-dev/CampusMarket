<?php

namespace App\Http\Controllers\Auth;

use Str;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MerchantRegisterController extends Controller
{


    public function __construct()  {

        $this->middleware("pverify");
    }


    public function index(Request $request)
    {
        if (auth()->check()) {
            return back()->with('error', translate('Not Allowed'));
        }
        $title = translate('Become a Merchant');
        $templateId = get_setting('theme_id') ?? 1;
        return view('frontend.template-' . $templateId . '.auth.merchant_register', compact('title'));
    }

    public function register(Request $request)
    {

        if (get_setting('google_recapcha_check') == 1) {
            $recaptcha_response = $request->input('g-recaptcha-response');
            if (empty($recaptcha_response)) {
                return redirect()->back()->with('g-recaptcha-response', 'Please Check Recaptcha');
            }
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'shop_name' => 'required|max:255|unique:stores,name',
            'password' => 'required|confirmed|min:8',
            'terms_policy' => 'required',
            'g-recaptcha-response' => function ($attribute, $value, $fail) {
                $secretKey = get_setting('recaptcha_secret');
                $response = $value;
                $userIP = $_SERVER['REMOTE_ADDR'];
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$userIP";
                $response = Http::asForm()->post($url);
                $response = json_decode($response);
                if (!$response->success) {
                    Session::flash('g-recaptcha-response', 'Please Check Recaptcha');
                    $fail($attribute . "Google Recaptcha Failed");
                }
            }
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $merchant = new User;

        $users = User::where('role', 2)->orderBy('id', 'desc')->pluck('custom_id')->first();
        if ($users) {
            $numbers = substr($users, 2);
            $merchant_id = 'MC' . str_pad(($numbers +  1), 4, '0', STR_PAD_LEFT);
            $merchant->custom_id = $merchant_id;
        } else {
            $merchant->custom_id = 'MC0001';
        }
        $token = Str::random(32);
        $merchant->fname = $request->first_name;
        $merchant->lname = $request->last_name;
        $merchant->email = $request->email;
        $merchant->username = $request->username;
        $merchant->password = Hash::make($request->password);
        $merchant->role = 2;
        $merchant->verify_token = $token;
        if ($merchant->save()) {
            $user_id = $merchant->id;

            $shop = new Store;
            $shop->name = $request->shop_name;
            $slug = Str::slug($request->shop_name, '-');
            $shop->slug = $slug;
            $shop->author_id = $user_id;
            $shop->save();
        }

        auth()->login($merchant);

        if ($merchant->email != null) {
            if (get_setting('merchant_email_verification') != 1) {
                $merchant->email_verified_at = date('Y-m-d H:m:s');
                $merchant->save();
                return redirect()->route('backend.dashboard')->with('success', translate('Registration successful'));
            } else {
                try {
                    $templates = EmailTemplate::where('slug', 'verification_email')->first();

                    if ($templates) {
                        $subject = $templates->subject;
                        $body = $templates->body;
                        $emailTo = $merchant->email;
                        $emailToName = $merchant->fname ? $merchant->fname . ' ' . $merchant->lname : $merchant->username;

                        $shortcodes['company_name'] = get_setting('company_name') ?? 'Bidout';
                        $shortcodes['customer_fname'] = $merchant->fname ?? '';
                        $shortcodes['customer_lname'] = $merchant->lname ?? '';
                        $shortcodes['customer_full_name'] = $merchant->fname ? $merchant->fname . ' ' . $merchant->lname : $merchant->username;
                        $shortcodes['customer_username'] = $merchant->username ?? '';
                        $shortcodes['customer_email'] = $merchant->email ?? '';
                        $shortcodes['verify_btn'] = '<p><a href="' . route('verification.verify', $merchant->verify_token) . '">Email Verify</a></p>';

                        foreach ($shortcodes as $key => $parameter) {
                            $body = str_replace('[' . $key . ']', $parameter, $body);
                        }
                        if ($emailTo) {
                            Mail::send('backend.email_template.email_body', ['body' => $body], function ($message) use ($emailTo, $emailToName, $subject) {
                                $message->to($emailTo, $emailToName);
                                $message->subject($subject);
                            });
                        }
                    }
                    return redirect()->route('verification.notice')->with('success', translate('Registration successful. Please verify your email'));
                } catch (\Throwable $th) {

                    // dd($th->getMessage());
                    $merchant->delete();
                    return redirect()->route('merchant.register.show')->with('error', translate('Registration failed. Please try again later.'));
                }
            }
        }

        return redirect()->route('backend.dashboard')->with('success', translate("Registration successful"));
    }
}
