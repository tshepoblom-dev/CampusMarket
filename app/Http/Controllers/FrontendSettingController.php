<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Config;
use Illuminate\Support\Facades\Artisan;

class FrontendSettingController extends Controller
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
        $page_title = translate('Frontend Settings');
        $frontend_setting = Setting::all();
        return view('backend.frontend_setting.index', compact('frontend_setting', 'page_title'));
    }
    /**
     * Store a newly created value.
     */
    public function store(Request $request)
    {

        if (!isset($request['hide_footer_bottom'])) {
            $exists = Setting::where(['type' => 'hide_footer_bottom'])->first();
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

        if (!isset($request['show_preloader'])) {
            $exists = Setting::where(['type' => 'show_preloader'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            } else {
                $new_data = new Setting;
                $new_data->type = 'show_preloader';
                $new_data->value = 0;
                $new_data->save();
            }
        }
        if (!isset($request['footer_mailchimp_status'])) {
            $exists = Setting::where(['type' => 'footer_mailchimp_status'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }
        if (!isset($request['footer1_status'])) {
            $exists = Setting::where(['type' => 'footer1_status'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }

        if (!isset($request['footer2_status'])) {
            $exists = Setting::where(['type' => 'footer2_status'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }
        if (!isset($request['footer3_status'])) {
            $exists = Setting::where(['type' => 'footer3_status'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }
        if (!isset($request['footer4_status'])) {
            $exists = Setting::where(['type' => 'footer4_status'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            }
        }


        if (!isset($request['show_preloader'])) {
            $exists = Setting::where(['type' => 'show_preloader'])->first();
            if ($exists) {
                $exists->value = 0;
                $exists->update();
            } else {
                $new_data = new Setting;
                $new_data->type = 'show_preloader';
                $new_data->value = 0;
                $new_data->save();
            }
        }





        // dd($request->all());
        foreach ($request->except('_token') as $key => $value) {
            $frontend_setting = Setting::firstOrNew(['type' => $key]);

            if ($key == 'header_logo') {
                $header_logo = $request->file('header_logo');
                if ($header_logo != '') {
                    if (get_setting('header_logo') != null) {
                        if (file_exists(public_path('assets/logo/' . get_setting('header_logo')))) {
                            unlink(public_path('assets/logo/' . get_setting('header_logo')));
                        }
                    }
                    $header_logo_name = pathinfo($header_logo->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $header_logo->getClientOriginalExtension();
                    $header_logo->move(public_path('assets/logo'), $header_logo_name);
                    $frontend_setting->value = $header_logo_name;
                }
            } elseif ($key == 'footer_logo') {
                $footer_logo = $request->file('footer_logo');
                if ($footer_logo != '') {
                    if (get_setting('footer_logo') != null) {
                        if (file_exists(public_path('assets/logo/' . get_setting('footer_logo')))) {
                            unlink(public_path('assets/logo/' . get_setting('footer_logo')));
                        }
                    }
                    $footer_logo_name = pathinfo($footer_logo->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $footer_logo->getClientOriginalExtension();
                    $footer_logo->move(public_path('assets/logo'), $footer_logo_name);
                    $frontend_setting->value = $footer_logo_name;
                }
            } elseif ($key == 'front_favicon') {
                $front_favicon = $request->file('front_favicon');
                if ($front_favicon != '') {
                    if (get_setting('front_favicon') != null) {
                        if (file_exists(public_path('assets/logo/' . get_setting('front_favicon')))) {
                            unlink(public_path('assets/logo/' . get_setting('front_favicon')));
                        }
                    }
                    $front_favicon_name = pathinfo($front_favicon->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $front_favicon->getClientOriginalExtension();
                    $front_favicon->move(public_path('assets/logo'), $front_favicon_name);
                    $frontend_setting->value = $front_favicon_name;
                }
            } elseif ($key == 'payment_method_img') {
                $payment_method_img = $request->file('payment_method_img');
                if ($payment_method_img != '') {
                    if (get_setting('payment_method_img') != null) {
                        if (file_exists(public_path('assets/logo/' . get_setting('payment_method_img')))) {
                            unlink(public_path('assets/logo/' . get_setting('payment_method_img')));
                        }
                    }
                    $payment_method_img_name = pathinfo($payment_method_img->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $payment_method_img->getClientOriginalExtension();
                    $payment_method_img->move(public_path('assets/logo'), $payment_method_img_name);
                    $frontend_setting->value = $payment_method_img_name;
                }
            } elseif ($key == 'breadcamp_img') {
                $breadcamp_img = $request->file('breadcamp_img');
                if ($breadcamp_img != '') {
                    if (get_setting('breadcamp_img') != null) {
                        if (file_exists(public_path('assets/logo/' . get_setting('breadcamp_img')))) {
                            unlink(public_path('assets/logo/' . get_setting('breadcamp_img')));
                        }
                    }
                    $breadcamp_img_name = pathinfo($breadcamp_img->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $breadcamp_img->getClientOriginalExtension();
                    $breadcamp_img->move(public_path('assets/logo'), $breadcamp_img_name);
                    $frontend_setting->value = $breadcamp_img_name;
                }
            } elseif ($key == 'meta_keyward') {
                $frontend_setting->value = implode(',', $value);
            } elseif ($key == 'meta_img') {

                $meta_img = $request->file('meta_img');
                if ($meta_img != '') {
                    if (get_setting('meta_img') != null) {
                        if (file_exists(public_path('assets/logo/' . get_setting('meta_img')))) {
                            unlink(public_path('assets/logo/' . get_setting('meta_img')));
                        }
                    }
                    $meta_img_name = pathinfo($meta_img->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $meta_img->getClientOriginalExtension();
                    $meta_img->move(public_path('assets/logo'), $meta_img_name);
                    $frontend_setting->value = $meta_img_name;
                }
            } else {
                $frontend_setting->value = $value;
            }

            $frontend_setting->save();
        }

        Artisan::call('cache:clear');
        return redirect()->back()->with('success', 'Frontend settings saved successfully.');
    }
}
