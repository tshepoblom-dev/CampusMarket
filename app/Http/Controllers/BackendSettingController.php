<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Setting;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Mail;

class BackendSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin','pverify']);
    }

    /**
     * Display backend setting.
     */
    public function index()
    {
        $page_title = translate('Backend Settings');
        $currencies = Currency::where('status', 1)->get();
        $backend_setting = Setting::all();

        return view('backend.backend_setting.index', compact('currencies', 'backend_setting', 'page_title'));
    }

    /**
     * Store a newly created value.
     */
    public function store(Request $request)
    {
        if (!isset($request['paypal_sandbox_mode'])) {
            $exists = Setting::where(['type' => 'paypal_sandbox_mode'])->first();
            if ($exists) {
                $exists->value = $request['paypal_sandbox_mode'];
                $exists->update();
            } else {
                $new_data = new Setting;
                $new_data->type = 'paypal_sandbox_mode';
                $new_data->value = 0;
                $new_data->save();
            }
        }
        if (!isset($request['tawk_enabled'])) {
            $exists = Setting::where(['type' => 'tawk_enabled'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }

        if (!isset($request['google_recapcha_check'])) {
            $exists = Setting::where(['type' => 'google_recapcha_check'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }
        if (!isset($request['gdpr_cookie_enabled'])) {
            $exists = Setting::where(['type' => 'gdpr_cookie_enabled'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }

        if (!isset($request['paypal_status'])) {
            $exists = Setting::where(['type' => 'paypal_status'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }
        if (!isset($request['stripe_status'])) {
            $exists = Setting::where(['type' => 'stripe_status'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }
        if (!isset($request['razorpay_status'])) {
            $exists = Setting::where(['type' => 'razorpay_status'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }

        if (!isset($request['merchant_email_verification'])) {
            $exists = Setting::where(['type' => 'merchant_email_verification'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }

        if (!isset($request['customer_email_verification'])) {
            $exists = Setting::where(['type' => 'customer_email_verification'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }

        foreach ($request->except('_token') as $key => $value) {
            $backend_setting = Setting::firstOrNew(['type' => $key]);
            if ($key == 'started_date') {
                $backend_setting->value = date('d-m-Y', strtotime($value));
            } elseif ($key == 'invoice_logo') {
                $invoice_logo = $request->file('invoice_logo');
                if ($invoice_logo != '') {
                    if (get_setting('invoice_logo') != null) {
                        if (file_exists(public_path('assets/logo/' . get_setting('invoice_logo')))) {
                            unlink(public_path('assets/logo/' . get_setting('invoice_logo')));
                        }
                    }
                    $invoice_name = pathinfo($invoice_logo->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $invoice_logo->getClientOriginalExtension();
                    $invoice_logo->move(public_path('assets/logo'), $invoice_name);
                    $backend_setting->value = $invoice_name;
                }
            } elseif ($key == 'PAYPAL_CLIENT_ID' || $key == 'PAYPAL_CLIENT_SECRET' || $key == 'STRIPE_KEY' || $key == 'STRIPE_SECRET' || $key == 'RAZOR_KEY' || $key == 'RAZOR_SECRET') {
                $backend_setting->value = $value;
            } elseif ($key == 'company_name') {
                $this->overWriteEnvFile('APP_NAME', $value);
                $backend_setting->value = $value;
            } else {
                $backend_setting->value =  $value;
            }

            $backend_setting->save();

            if ($key == 'DEFAULT_LANGUAGE') {
                $request->session()->put('locale', $request->locale);
                return redirect()->back()->with('success', 'Default Language Updated successfully');
            }
        }

        return redirect()->back()->with('success', 'Backend settings saved successfully');
    }

    /**
     * sendTestMail
     *
     * @param  mixed $request
     * @return Response
     */
    public function sendTestMail(Request $request)
    {
        try {
            if ($request) {
                $mailTo = $request->email;
                $content= htmlspecialchars(prelaceScript(html_entity_decode($request->message)));
                Mail::send('mail.test', ['content' => $content], function ($message) use ($mailTo) {
                    $message->to($mailTo)
                        ->subject('Test Email From Bidout')
                        ->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                });

                return redirect()->back()->with('success', 'Test Mail Sent Successfully');
            } else {
                return redirect()->back()->with('error', 'Input your email');
            }
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return redirect()->back()->with('error', 'Credential Wrong!');
        }
    }

    /**
     * overWrite the Env File values.
     *
     * @param  string type
     * @param  string value
     * @return \Illuminate\Http\Response
     */
    public function overWriteEnvFile($type, $val)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"' . trim($val) . '"';
            if (is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0) {
                file_put_contents($path, str_replace(
                    $type . '="' . env($type) . '"',
                    $type . '=' . $val,
                    file_get_contents($path)
                ));
            } else {
                file_put_contents($path, file_get_contents($path) . "\r\n" . $type . '=' . $val);
            }
        }
    }

    /**
     * cacheClear
     *
     * @return Response
     */
    public function cacheClear()
    {
        Artisan::call('optimize:clear');
        return redirect()->back()->with('success', 'Cache Clear Successfully');
    }
}
