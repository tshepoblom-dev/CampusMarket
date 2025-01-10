<?php

namespace App\Http\Controllers\Auth;

use Str;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    public function showRegistrationForm(Request $request)
    {
        $templateId=get_setting('theme_id') ?? 1;
        $title = translate('Sign Up');
        return view('frontend.template-'.$templateId.'.auth.register',compact('title'));
    }

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
          $this->middleware("pverify");
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $users = User::where('role',1)->orderBy('id','desc')->pluck('custom_id')->first();
        if($users){
            $numbers = substr($users, 2);
            $customer_id = 'C'.str_pad(($numbers +  1), 4, '0', STR_PAD_LEFT);
            $custom_id = $customer_id;
        }else{
            $custom_id = 'C0001';
        }

        // email_send('registration', $data['email']);
        $token = Str::random(32);

       $user = User::create([
            'fname' => $data['first_name'],
            'lname' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'custom_id' => $custom_id,
            'verify_token' => $token,
        ]);


            // return redirect()->route('verification.notice');
        return $user;
    }

    public function register(Request $request)
    {


        if (get_setting('google_recapcha_check') == 1) {
            $recaptcha_response = $request->input('g-recaptcha-response');
            if (empty($recaptcha_response)) {
                return redirect()->back()->with('g-recaptcha-response', 'Please Check Recaptcha');
            }
        }

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $this->guard()->login($user);

        if($user->email != null){
            if(get_setting('customer_email_verification') != 1){
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
                return redirect()->route('customer.dashboard')->with('success',translate('Registration successful'));
            }else {
                try {
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
                            $shortcodes['verify_btn'] = '<p><a href="'.route('verification.verify',$user->verify_token).'">Email Verify</a></p>';

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

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }


}
