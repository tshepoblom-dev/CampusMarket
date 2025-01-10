<?php

use Carbon\Carbon;
use App\Models\Blog;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Translation;
use Illuminate\Support\Str;
use App\Models\EmailTemplate;
use App\Models\PaymentMethod;
use App\Models\ProductReview;
use App\Models\WidgetContent;
use App\Models\PurchaseVerify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

//highlights the selected navigation on frontend
if (!function_exists('default_language')) {
    function default_language()
    {
        return get_setting('DEFAULT_LANGUAGE', 'en');
    }
}

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset('public/' . $path, $secure);
    }
}

/**
 * translate
 *
 * @param  mixed $key
 * @param  mixed $lang
 * @param  mixed $addslashes
 * @return Response
 */


if (!function_exists('translate')) {

    function translate($key, $lang = null, $addslashes = false)
    {
        if (alreadyInstalled() !== false) {
            if ($lang == null) {
                $lang = App::getLocale();
            }

            $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($key)));

            $translations_default = Cache::rememberForever('translations-' . get_setting('DEFAULT_LANGUAGE', 'en'), function () {
                return Translation::where('lang', get_setting('DEFAULT_LANGUAGE', 'en'))->pluck('lang_value', 'lang_key')->toArray();
            });

            if (!isset($translations_default[$lang_key])) {
                $translation_def = new Translation;
                $translation_def->lang = get_setting('DEFAULT_LANGUAGE', 'en');
                $translation_def->lang_key = $lang_key;
                $translation_def->lang_value = $key;
                $translation_def->save();
                Cache::forget('translations-' . get_setting('DEFAULT_LANGUAGE', 'en'));
            }

            $translation_locale = Cache::rememberForever('translations-' . $lang, function () use ($lang) {
                return Translation::where('lang', $lang)->pluck('lang_value', 'lang_key')->toArray();
            });

            //Check for session lang
            if (isset($translation_locale[$lang_key])) {
                return $addslashes ? addslashes($translation_locale[$lang_key]) : $translation_locale[$lang_key];
            } elseif (isset($translations_default[$lang_key])) {
                return $translations_default[$lang_key];
            } else {
                return $key;
            }
        }
    }
}



/**
 * Generate a setting path for the application.
 */
if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {

        if (alreadyInstalled() !== false) {
            $setting = Setting::where('type', $key)->first();

            return $setting == null ? $default : $setting->value;
        }

        return null;
    }
}

/**
 * send to a email for the application.
 */
if (!function_exists('email_send')) {
    function email_send($template, $emailTo = null)
    {
        $templates = EmailTemplate::where('slug', $template)->first();
        if ($templates) {
            $user = Auth::user();
            $subject = $templates->subject;
            $body = $templates->body;
            $emailToName = $user->fname ? $user->fname . ' ' . $user->lname : $user->username;

            $shortcodes['company_name'] = get_setting('company_name') ?? 'Bidout';
            if ($user->role == 1) {
                $shortcodes['customer_fname'] = $user->fname ?? '';
                $shortcodes['customer_lname'] = $user->lname ?? '';
                $shortcodes['customer_full_name'] = $user->fname ? $user->fname . ' ' . $user->lname : $user->username;
                $shortcodes['customer_username'] = $user->username ?? '';
                $shortcodes['customer_email'] = $user->email ?? '';
                $shortcodes['customer_phone'] = $user->phone ?? '';
                $shortcodes['customer_address'] = $user->address ?? '';
                $shortcodes['customer_country'] = $user->countries->name ?? '';
                $shortcodes['customer_state'] = $user->states->name ?? '';
                $shortcodes['customer_city'] = $user->cities->name ?? '';
                $shortcodes['customer_zip_code'] = $user->zip_code ?? '';
            } else if ($user->role == 2) {
                $shortcodes['merchant_fname'] = $user->fname ?? '';
                $shortcodes['merchant_lname'] = $user->lname ?? '';
                $shortcodes['merchant_full_name'] = $user->fname ? $user->fname . ' ' . $user->lname : $user->username;
                $shortcodes['merchant_username'] = $user->username ?? '';
                $shortcodes['merchant_email'] = $user->email ?? '';
                $shortcodes['merchant_phone'] = $user->phone ?? '';
                $shortcodes['merchant_address'] = $user->address ?? '';
                $shortcodes['merchant_country'] = $user->countries->name ?? '';
                $shortcodes['merchant_state'] = $user->states->name ?? '';
                $shortcodes['merchant_city'] = $user->cities->name ?? '';
                $shortcodes['merchant_zip_code'] = $user->zip_code ?? '';
            }
            foreach ($shortcodes as $key => $parameter) {
                $body = str_replace('[' . $key . ']', $parameter, $body);
            }
            if ($emailTo) {
                try {
                    Mail::send('backend.email_template.email_body', ['body' => $body], function ($message) use ($emailTo, $emailToName, $subject) {
                        $message->to($emailTo, $emailToName);
                        $message->subject($subject);
                        // $message->attachData($pdf->output(), $clients["company_name"].".pdf");
                    });

                    return 'success';
                } catch (\Throwable $th) {
                    //throw $th;
                }
            } else {
                return redirect()->back()->with('error', translate('User Email not found'));
            }
        } else {
            return redirect()->back()->with('error', translate('Email Template not found'));
        }
    }
}
/**
 * Generate a setting path for the application.
 */
if (!function_exists('currency_symbol')) {
    function currency_symbol($currency_id = null)
    {
        $currency = $currency_id ?? get_setting('default_currency');

        if ($currency) {
            $default_currency = Currency::findOrFail($currency);
            $symbol = $default_currency?->symbol;

            return $symbol;
        }

        return false;
    }
}

/**
 * Generate a setting path for the application.
 */
if (!function_exists('wallet_balance')) {
    function wallet_balance($user_id)
    {
        $wallet_balance = User::where('id', $user_id)->pluck('wallet_balance')->first();

        return $wallet_balance ?? 0;
    }
}

/**
 * Generate a setting path for the application.
 */
if (!function_exists('highest_bid')) {
    function highest_bid($product_id)
    {
        $bid_amount = Order::where('product_id', $product_id)->latest()->pluck('bid_amount')->first();
        return $bid_amount ?? 0;
    }
}

/**
 * Generate a payment method path for the application.
 */
if (!function_exists('get_payment_method')) {
    function get_payment_method($key)
    {
        $method = explode('_', $key);
        $payment_method = PaymentMethod::where('method_name', $method[0])->first();
        if ($payment_method) {
            if ($method[1] == 'mode') {
                return $payment_method->mode == 2 ? false : true;
            } elseif ($method[1] == 'key') {
                return $payment_method->key;
            } elseif ($method[1] == 'secret') {
                return $payment_method->secret;
            } elseif ($method[1] == 'conversion') {
                return $payment_method->conversion_currency_rate;
            }
        } else {
            return null;
        }
    }
}

/**
 * alreadyInstalled
 *
 * @return response
 */
if (!function_exists('alreadyInstalled')) {

    function alreadyInstalled()
    {
        return file_exists(storage_path('installed'));
    }
}

/**
 * dateFormat
 *
 * @param  mixed  $date
 * @return Response
 */
if (!function_exists('dateFormat')) {
    function dateFormat($date)
    {
        if ($date !== '') {
            $parse = Carbon::parse($date);

            return $parse->format(get_setting('date_format'));
        }

        return false;
    }
}

/**
 * paymentMethods
 *
 * @return Response
 */
if (!function_exists('paymentMethods')) {

    function paymentMethods()
    {
        return PaymentMethod::where('status', 1)->get();
    }
}

/** fileExists
 *
 *========= fileExists ==========
 *
 * @return Response
 */
if (!function_exists('fileExists')) {

    function fileExists($folder, $fileName)
    {

        if (!empty($fileName)) {

            $filePath = public_path($folder . '/' . $fileName);

            if (File::exists($filePath)) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }
}

/** fileExists
 *
 *========= fileExists ==========
 *
 * @return Response
 */
if (!function_exists('categoryProducts')) {

    function categoryProducts()
    {
        return Category::withCount('actionProducts')->where('status', 1)->get();
    }
}

if (!function_exists('latestBidingProducts')) {

    function latestBidingProducts($limit, $perItem = null)
    {
        return Product::with('bids')->withCount('bids')->whereHas('categories', function ($query) {
            $query->where('status', 1);
        })->where('sale_type', 1)
            ->orderBy('bids_count', 'desc')
            ->take($limit)
            ->where('status', 1)
            ->get();
    }
}

/**blog post
 *
 *========= blog ==========
 * @return Response
 */

if (!function_exists('blog')) {

    function blog($limit = null, $perPage = null, $sortedBy = 'DESC')
    {
        $blog = Blog::with('users')->where('status', 1)
            ->orderBy('id', $sortedBy)
            ->select('id', 'title', 'slug', 'image', 'description', 'created_at', 'user_id')
            // ->authorName()
            ->withCount('comments');
        if (isset($limit) || isset($perPage)) {
            return $limit ? $blog->limit($limit)->get() : $blog->paginate($perPage);
        } else {
            return $blog->get();
        }
    }
}

/**merchants
 *
 *========= merchants List ==========
 * @return Response
 */

if (!function_exists('merchants')) {

    function merchants($limit = null, $perPage = null, $sortedBy = 'DESC')
    {
        $merchants = User::with('shop')
            ->withCount('activeProducts')
            ->where(['role' => 2,  'status' => 1])
            ->orderBy('id', $sortedBy);
        if (isset($limit) || isset($perPage)) {
            return $limit ? $merchants->limit($limit)->get() : $merchants->paginate($perPage);
        } else {
            return $merchants->get();
        }
    }
}

/**products
 *
 *========= products List ==========
 * @return Response
 */

if (!function_exists('products')) {

    function products(?array $options, $limit = null, $perPage = null, $sortedBy = 'DESC')
    {

        $products = Product::query();
        $currentDateTime = now();
        $products = $products->whereHas('categories', function ($query) {
            $query->where('status', 1);
        })->where('status', 1)->orderBy('id', $sortedBy)->when('sale_type' == 1, function ($q) use ($currentDateTime) {
            return $q->where('start_date', '<=', $currentDateTime)->where('end_date', '>=', $currentDateTime);
        });

        if (!empty($options['type'])) {
            $products->when(function ($query) use ($options, $currentDateTime) {
                if ($options['type'] == 1) {
                    $query->where('start_date', '<=', $currentDateTime)->where('end_date', '>=', $currentDateTime)->where('sale_type', $options['type']);
                }
                $query->where('sale_type', $options['type']);
            });
        }

        if (isset($limit) || isset($perPage)) {
            return $limit ? $products->limit($limit)->get() : $products->paginate($perPage);
        } else {
            return $products->get();
        }
    }
}

/**
 * getWidgetContent
 *
 * @param  mixed  $pageId
 * @param  mixed  $widgetName
 * @return Response
 */
if (!function_exists('getWidgetContent')) {

    function getWidgetContent($pageId, $widgetName)
    {
        return WidgetContent::where(['page_id' => $pageId, 'widget_slug' => $widgetName])->first();
    }
}

/**
 * highestPrice
 *
 * @return Response
 */
if (!function_exists('highestPrice')) {

    function highestPrice()
    {
        return Product::where('status', 1)->sum('sale_price');
    }
}


/**
 * active_language
 *
 * @return Response
 */

if (!function_exists('active_language')) {

    function active_language()
    {
        $locale = "";
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            $locale =  'en';
        }
        return  $locale;
    }
}

/**
 * random_number
 *
 * @return Response
 */

if (!function_exists('random_number')) {

    function random_number()
    {
        return  strtoupper(Str::random(7));
    }
}

/**
 * totalMerchantProduct
 *
 * @return Response
 */

if (!function_exists('totalMerchantProduct')) {

    function totalMerchantProduct($merchantId)
    {
        return Product::where('author_id', $merchantId)->whereHas('categories', function ($query) {
            $query->where('status', 1);
        })
            ->where('status', 1)
            ->count();
    }
}


/**
 * totalSaleMerchant
 *
 * @return Response
 */

if (!function_exists('totalSaleMerchant')) {

    function totalSaleMerchant($merchantId)
    {
        return Order::where('status', 4)
            ->where('merchant_id', $merchantId)
            ->count();
    }
}


/**
 * merchantViewRating
 *
 * @return Response
 */

if (!function_exists('merchantViewRating')) {

    function merchantViewRatings($merchantId)
    {
        $user_products_id = Product::whereHas('categories', function ($query) {
            $query->where('status', 1);
        })->where('author_id', $merchantId)
            ->where('status', 1)
            ->pluck('id')
            ->toArray();

        return ProductReview::whereNotNull('rate')
            ->whereNull('reply_id')
            ->whereIn('product_id', $user_products_id)
            ->get();
    }
}


/**
 * latestBidPrice
 *
 * @return Response
 */

if (!function_exists('latestBidPrice')) {

    function latestBidPrice($productId)
    {
        return Order::where('product_id', $productId)
            ->orderBy('bid_amount', 'desc')
            ->select('bid_amount')
            ->first();
    }
}

/**
 * strLimit
 *
 * @param  string $string
 * @param  int $limit
 * @return Response
 */
if (!function_exists('strLimit')) {

    function strLimit($string, $limit = 35)
    {
        return  Str::limit($string, $limit);
    }
}

/**
 * getUpComingAuctionsProduct
 *
 * @param  int $limit
 * @param  mixed $orderBy
 * @return Response
 */

if (!function_exists('getUpComingAuctionsProduct')) {


    function getUpComingAuctionsProduct($limit, $orderBy, $productType)
    {



        $currentDateTime = now();
        $products = Product::query();
        $currentDateTime = now();
        $products = $products->whereHas('categories', function ($query) {
            $query->where('status', 1);
        });
        if (!empty($productType)) {
            $products->when(function ($query) use ($productType, $currentDateTime) {
                if ($productType == 1) {
                    $query->where('start_date', '>=', $currentDateTime)->where('sale_type', $productType);
                }
                $query->where('start_date', '>=', $currentDateTime)->where('sale_type', $productType);
            });
        }
        return $products->where('status', 1)->orderBy('id', $orderBy)->take($limit)->get();
    }
}

/**
 * currentDate
 * @return Response
 */

if (!function_exists('currentDate')) {

    function currentDate()
    {
        return  Carbon::now();
    }
}

/**
 * currentDate
 * @return Response
 */

if (!function_exists('prelaceScript')) {

    function prelaceScript($descipt)
    {
        return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $descipt);
    }
}

/**
 * indexFile
 * @return Response
 */

if (!function_exists('indexFile')) {
    function indexFile()
    {
        if (File::exists(public_path('index.php'))) {
            return true;
        };
        return false;
    }
}

/**
 * selectedTheme
 *
 * @return Response
 */

if (!function_exists('selectedTheme')) {

    function selectedTheme()
    {
        return get_setting('theme_id') ?? 1;
    }
}

/**
 * selectedTheme
 *
 * @return Response
 */

if (!function_exists('purchaseCode')) {

    function purchaseCode()
    {
        return PurchaseVerify::select('purchase_code')->latest()->first();


    }
}
