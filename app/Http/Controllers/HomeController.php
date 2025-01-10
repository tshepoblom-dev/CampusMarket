<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Page;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Wallet;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Location;
use App\Models\BlogComment;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\ProductReview;
use App\Models\WidgetContent;
use App\Models\ProductGallery;
use DrewM\MailChimp\MailChimp;
use Illuminate\Support\Facades\DB;
use App\Models\ProductSpecification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{



    /** Show the application Home.
     *
     * @return View
     */
    public function index(Request $request)
    {

        $lang = $request->lang;
        $slug = 'home';
        $templateId = get_setting('theme_id') ?? 1;

        $singlePageData = Page::with(['widgetContents' => function ($query) {
            $query->where('status', 1);
        }])->where('page_slug', '=', $slug)->first();

        if ($singlePageData) {
            $activeWidgets = $singlePageData->widgetContents;
            $title = $singlePageData->meta_title ?? $singlePageData->page_name ?? get_setting('meta_title');
            $meta_description = $singlePageData->meta_description ?? get_setting('meta_description');
            $meta_keyward = $singlePageData->meta_keyward ? implode(', ', $singlePageData->meta_keyward) : get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';

            return view('frontend.index', ['activeWidgets' => $activeWidgets, 'templateId' => $templateId, 'params' => $slug, 'title' => $title, 'meta_description' => $meta_description, 'meta_keyward' => $meta_keyward, 'meta_image' => $meta_image, 'lang' => $lang]);
        } else {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }


    /**
     * loadPagesContent
     *
     * @param  mixed $request
     * @param  string $slug
     * @return View
     */
    public function loadPagesContent(Request $request, $slug)
    {

        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        if ($slug == 'signup') {
            if (Auth::id()) {
                return redirect()->to('customer/dashboard');
            }
        }

        if ($slug) {
            $singlePageData = Page::where('page_slug', $slug)->first();
            if ($singlePageData) {
                $activeWidgets = $singlePageData->widgetContents;
                $is_bread_crumb = $singlePageData?->is_bread_crumb;
                $title = $singlePageData->getTranslation('meta_title') ?? $singlePageData->getTranslation('page_name') ?? get_setting('meta_title');
                $meta_description = $singlePageData->getTranslation('meta_description') ?? get_setting('meta_description');


                $meta_keyward = $singlePageData->getTranslation('meta_keyward') ? implode(', ', $singlePageData->meta_keyward) : get_setting('meta_keyward');
                $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';

                if ($request->ajax()) {

                    if (isset($request->widget_name)) {
                        if ($request->widget_name == 'all-product') {
                            $widgetItem = getWidgetContent($singlePageData->id, 'all-product');
                            return $this->productSearch($request, $widgetItem->widget_content['display_per_page'], $templateId, $lang);
                        }
                    }
                }

                return view('frontend.index', ['activeWidgets' => $activeWidgets, 'templateId' => $templateId, 'params' => $slug, 'title' => $title, 'meta_description' => $meta_description, 'meta_keyward' => $meta_keyward, 'meta_image' => $meta_image, 'lang' => $lang, 'is_bread_crumb' => $is_bread_crumb]);
            } else {
                return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
            }
        }
    }


    /**
     * live_auctions
     *
     * @param  mixed $request
     * @return View
     */
    public function live_auctions(Request $request)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {

            // return Product::where('status',1)->get();
            $title = translate('Products');
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';

            $currentDateTime = now();

            $highest_price = Product::where('status', 1)->max('sale_price');

            $options = [];
            $category = [];
            $keyword = '';
            if (isset($request->product_type)) {
                $options['sale_type'] = $request->product_type;
            }
            if (isset($request->categories)) {
                $category = $request->categories;
            }
            if (isset($request->keyword)) {
                $keyword = $request->keyword;
            }

            $live_auctions = Product::query();

            $live_auctions->when($category, function ($q) use ($category) {
                return $q->whereIn('category_id', explode(',', $category));
            });

            if (!empty($keyword)) {
                $live_auctions->when(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('short_desc', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('long_desc', 'LIKE', '%' . $keyword . '%');
                });
            }



            $products = $live_auctions->whereHas('categories', function ($query) {
                $query->where('status', 1);
            })->where($options)
                ->when('sale_type' == 1, function ($q) use ($currentDateTime) {
                    return $q->where('start_date', '<=', $currentDateTime)->where('end_date', '>=', $currentDateTime);
                })
                ->where('status', 1)
                ->latest()
                ->paginate(12);

            if ($request->ajax()) {

                $data = view('frontend.template-' . $templateId . '.partials.filter-products', compact('live_auctions', 'lang'))->render();

                return response()->json(['status' => true, 'products' => $data, 'total' => $products->total(), 'first_item' => $products->firstItem(),  'last_item' => $products->lastItem()]);
            }

            return view('frontend.template-' . $templateId . '.live-auction-page', compact('title', 'products', 'lang', 'meta_description', 'meta_keyward', 'meta_image', 'highest_price', 'templateId'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }


    /**
     * auction_category
     *
     * @param  mixed $request
     * @param  string $slug
     * @return View
     */
    public function auction_category(Request $request, $slug)
    {


        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            $auction_category = Category::where('slug', $slug)->where('status', 1)->first();
            $title = $auction_category->getTranslation('name', $lang);
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';
            $fun_facts = WidgetContent::where('widget_slug', 'fun-facts')->latest()->first();
            if ($fun_facts) {
                $funFactsDataItem = $fun_facts->widget_content;
            } else {
                $funFactsDataItem = '';
            }
            $currentDateTime = now();
            $live_auctions = Product::where('category_id', $auction_category->id)->where('status', 1)->latest()->paginate(12);

            // dd($live_auctions);
            return view('frontend.template-' . $templateId . '.category_page', compact('auction_category', 'title', 'meta_description', 'meta_keyward', 'meta_image', 'live_auctions', 'lang', 'funFactsDataItem'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }


    /**
     * auction_details
     *
     * @param  mixed $request
     * @param  string $slug
     * @return View
     */
    public function auction_details(Request $request, $slug)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            $auction_details = Product::whereHas('categories', function ($query) {
                $query->where('status', 1);
            })->where('slug', $slug)->where('status', 1)->first();
            $bidHistories = Order::where('product_id', $auction_details->id)->where('type', 2)->latest('bid_amount')->get();
            $title = $auction_details->meta_title ?? $auction_details->name;
            $meta_description = $auction_details->meta_description ?? $auction_details->short_desc ?? get_setting('meta_description');
            $meta_keyward = $auction_details->meta_keyward ? implode(', ', $auction_details->meta_keyward) : get_setting('meta_keyward');
            $meta_image = $auction_details->features_image ? url('uploads/products/features/' . $auction_details->features_image) : url('assets/logo/' . get_setting('header_logo'));
            $img_galleries = ProductGallery::where('product_id', $auction_details->id)->get();
            $specifications = ProductSpecification::where('product_id', $auction_details->id)->get();
            $currentDateTime = now();
            $live_auctions = Product::where('id', '!=', $auction_details->id)->where('status', 1)->where('start_date', '<=', $currentDateTime)->where('end_date', '>=', $currentDateTime)->latest()->take(2)->get();
            $fun_facts = WidgetContent::where('widget_slug', 'fun-facts')->latest()->first();
            if ($fun_facts) {
                $funFactsDataItem = $fun_facts->widget_content;
            } else {
                $funFactsDataItem = '';
            }
            $randomBlog = Blog::where('status', 1)->inRandomOrder()->first();
            if (Auth::check()) {
                $orders_confirm = Order::where('status', '<>', 4)->where('product_id', $auction_details->id)->where('user_id', Auth::user()->id)->first();
                $review_confirm = ProductReview::where('product_id', $auction_details->id)->where('user_id', Auth::user()->id)->first();
                if ($orders_confirm && $review_confirm) {
                    $reviewAllow = 2;
                } else {
                    $reviewAllow = 0;
                }
            } else {
                $reviewAllow = 2;
            }
            $product_reviews = ProductReview::where('product_id', $auction_details->id)->where('status', 1)->whereNull('reply_id')->latest()->get();

            return view('frontend.template-' . $templateId . '.live-auction-details', compact('auction_details', 'title', 'meta_description', 'meta_keyward', 'meta_image', 'img_galleries', 'specifications', 'live_auctions', 'lang', 'funFactsDataItem', 'bidHistories', 'randomBlog', 'reviewAllow', 'product_reviews','templateId'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }


    /**
     * shop_details
     *
     * @param  mixed $request
     * @param  string $slug
     * @return View
     */
    public function shop_details(Request $request, $slug)
    {

        try {

            $templateId = get_setting('theme_id') ?? 1;
            $lang = $request->lang;

            $options = [];

            if (isset($request->filter_by)) {
                $options['type'] = $request->filter_by;
            }

            $shop_details = Store::where('slug', $slug)->firstOrFail();
            $title = $shop_details->name;
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = $shop_details->logo ? url('uploads/shop/' . $shop_details->logo) : url('assets/logo/' . get_setting('header_logo'));

            $currentDateTime = now();

            $products = Product::query();
            if (!empty($options['type'])) {

                if ($options['type'] != "all") {
                    $products->when(function ($query) use ($options, $currentDateTime) {
                        if ($options['type'] == 1 || $options['type'] == 2) {
                            $query->where('sale_type', $options['type']);
                        } else if($options['type'] == 3){
                            $query->where('start_date', '>=', $currentDateTime);
                        }
                    });
                }
            }
            $products = $products->where('status', 1)->whereHas('categories', function ($query) {
                $query->where('status', 1);
            })
                ->where('author_id', $shop_details->author_id)
                ->when('sale_type' == 1, function ($q) use ($currentDateTime) {
                    return $q->where('start_date', '<=', $currentDateTime)->where('end_date', '>=', $currentDateTime);
                })
                ->latest()
                ->paginate(12);

            if ($request->ajax()) {
                $data = view('frontend.template-' . $templateId . '.partials.filter-products', compact('products', 'lang'))->render();

                return response()->json(['status' => true, 'products' => $data, 'total' => $products->count(), 'first_item' => $products->firstItem(),  'last_item' => $products->lastItem()]);
            }

            return view('frontend.template-' . $templateId . '.shop-details', compact('shop_details', 'title', 'meta_description', 'meta_keyward', 'meta_image', 'lang', 'products', 'templateId'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }


    /**
     * blogs
     *
     * @param  mixed $request
     * @return View
     */
    public function blogs(Request $request)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            if (isset($request->search)) {
                $title = translate('Search') . ': ' . $request->search;
                $blogs = Blog::where('status', 1)->where('title', 'like', '%' . $request->search . '%')->orWhere('description', 'like', '%' . $request->search . '%')->latest()->paginate(9);
            } else {
                $title = translate('Blogs');
                $blogs = Blog::where('status', 1)->latest()->paginate(9);
            }
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';

            return view('frontend.template-' . $templateId . '.blog-page', compact('title', 'meta_description', 'meta_keyward', 'meta_image', 'blogs', 'lang','templateId'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }


    /**
     * blog_category
     *
     * @param  mixed $request
     * @param  string $slug
     * @return View
     */
    public function blog_category(Request $request, $slug)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            $blog_category = BlogCategory::where('slug', $slug)->first();
            $title = $blog_category->getTranslation('name', $lang);
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';
            $blogs = Blog::where('status', 1)->where('category_id', $blog_category->id)->latest()->paginate(9);

            return view('frontend.template-' . $templateId . '.blog-page', compact('title', 'meta_description', 'meta_keyward', 'meta_image', 'blogs', 'lang','templateId'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }


    /**
     * blog_tag
     *
     * @param  mixed $request
     * @param  View $tag
     * @return void
     */
    public function blog_tag(Request $request, $tag)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $title = $tag;
        $lang = $request->lang;
        try {
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';

            $blogs = Blog::whereRaw("find_in_set('" . $tag . "',tags)")->where('status', 1)->latest()->paginate(12);

            return view('frontend.template-' . $templateId . '.blog-page', compact('title', 'meta_description', 'meta_keyward', 'meta_image', 'blogs', 'lang','templateId'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }


    /**
     * blog_details
     *
     * @param  mixed $request
     * @param  string $slug
     * @return View
     */
    public function blog_details(Request $request, $slug)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            $blog_details = Blog::where('slug', $slug)->first();
            $title = $blog_details->meta_title ?? $blog_details->title;
            $desc = strip_tags($blog_details->description);
            $meta_description = $blog_details->meta_description ?? Str::words($desc, 50, ' (...)') ?? get_setting('meta_description');
            $meta_keyward = $blog_details->meta_keyward ? implode(', ', $blog_details->meta_keyward) : get_setting('meta_keyward');
            $meta_image = $blog_details->image ? url('uploads/blog/' . $blog_details->image) : url('assets/logo/' . get_setting('header_logo'));
            $recentBlogs = Blog::where('status', 1)->latest()->take(5)->get();
            $categories = BlogCategory::where('status', 1)->inRandomOrder()->take(5)->get();
            $comments = BlogComment::where('blog_id', $blog_details->id)->where('parent_id', 0)->latest()->get();

            $randomBlog = Blog::where('status', 1)->inRandomOrder()->first();

            return view('frontend.template-' . $templateId . '.blog-details', compact('blog_details', 'title', 'meta_description', 'meta_keyward', 'meta_image', 'lang', 'recentBlogs', 'categories', 'comments', 'randomBlog','templateId'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }

    /**
     * blog_comment
     *
     * @param  mixed $request
     * @return Response
     */
    public function blog_comment(Request $request)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $comments = new BlogComment;
        if (Auth::guest()) {
            $comments->user_name = $request->user_name;
            $comments->user_email = $request->user_email;
        } else {
            $comments->user_id = Auth::user()->id;
        }
        $comments->blog_id = $request->blog_id;
        $comments->comment = $request->comment;
        if (isset($request->parent_id)) {
            $comments->parent_id = $request->parent_id;
        }
        $comments->save();
        if (isset($request->parent_id)) {
            return redirect()->back()->with('success', translate('Your reply save successfully'));
        } else {
            return redirect()->back()->with('success', translate('Your comment save successfully'));
        }
    }


    /**
     * dashboard
     *
     * @param  mixed $request
     * @return View
     */
    public function dashboard(Request $request)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            $title = translate('Dashboard');
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';
            $bidding = Order::where('type', 2)->where('user_id', Auth::user()->id)->count();
            $purchases = Order::where('type', 3)->where('user_id', Auth::user()->id)->count();
            $deposits = Wallet::where('user_id', Auth::user()->id)->where('type', 1)->sum('amount');
            $wins = Order::where('type', 2)->where('user_id', Auth::user()->id)->whereIn('status', [2, 4])->count();

            return view('frontend.template-' . $templateId . '.customer.dashboard', compact('title', 'meta_description', 'meta_keyward', 'meta_image', 'bidding', 'purchases', 'deposits', 'wins'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }

    /**
     * customer_profile
     *
     * @param  mixed $request
     * @return View
     */
    public function customer_profile(Request $request)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            $title = translate('Profile');
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';
            $customerSingle = User::where('id', Auth::user()->id)->first();
            $countries = Location::where('country_id', null)->where('state_id', null)->get();

            return view('frontend.template-' . $templateId . '.customer.profile', compact('title', 'meta_description', 'meta_keyward', 'meta_image', 'customerSingle', 'countries'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }

    /**
     * customer_bid
     *
     * @param  mixed $request
     * @return View
     */
    public function customer_bid(Request $request)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            $title = translate('Bidding History');
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';
            if ($request->all()) {
                $bidding = Order::where('type', 2)->where('user_id', Auth::user()->id)->latest()->take($request->filter)->paginate($request->filter);
            } else {
                $bidding = Order::where('type', 2)->where('user_id', Auth::user()->id)->latest()->paginate(10);
            }

            return view('frontend.template-' . $templateId . '.customer.bid', compact('title', 'meta_image', 'meta_description', 'meta_keyward', 'bidding'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }

    /**
     * order_details
     *
     * @param  mixed $request
     * @param  int $id
     * @return View
     */
    public function order_details(Request $request, $id)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            $bidSingle = Order::with('wallets')->where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
            $title = $bidSingle->type == 2 ? translate('Bid Details') : translate('Order Details');
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';
            $review_confirm = ProductReview::where('product_id', $bidSingle->products->id)->where('user_id', Auth::user()->id)->count();

            return view('frontend.template-' . $templateId . '.customer.order-details', compact('title', 'meta_image', 'meta_description', 'meta_keyward', 'bidSingle', 'lang', 'review_confirm'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }

    /**
     * customer_purchase
     *
     * @param  mixed $request
     * @return View
     */
    public function customer_purchase(Request $request)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            $title = translate('Order History');
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';
            if ($request->all()) {
                $purchases = Order::where('type', 3)->where('user_id', Auth::user()->id)->latest()->take($request->filter)->paginate($request->filter);
            } else {
                $purchases = Order::where('type', 3)->where('user_id', Auth::user()->id)->latest()->paginate(10);
            }

            return view('frontend.template-' . $templateId . '.customer.purchase', compact('title', 'meta_image', 'meta_description', 'meta_keyward', 'purchases'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }

    /**
     * customer_deposit
     *
     * @param  mixed $request
     * @return View
     */
    public function customer_deposit(Request $request)
    {

        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            $title = translate('Deposits');
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';
            if (isset($request->search)) {
                $deposits = Wallet::where('user_id', Auth::user()->id)->where('type', 1)->latest()->paginate($request->search);
            } else {
                $deposits = Wallet::where('user_id', Auth::user()->id)->where('type', 1)->latest()->paginate(10);
            }
            $payment_methods = PaymentMethod::where('status', 1)->where('id', '<>', 1)->get();

            return view('frontend.template-' . $templateId . '.customer.deposit', compact('title', 'meta_image', 'meta_description', 'meta_keyward', 'deposits', 'payment_methods'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }

    /**
     * customer_transaction
     *
     * @param  mixed $request
     * @return View
     */
    public function customer_transaction(Request $request)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            $title = translate('Transactions');
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';
            if (isset($request->search)) {
                $transactions = Wallet::where('user_id', Auth::user()->id)->latest()->paginate($request->search);
            } else {
                $transactions = Wallet::where('user_id', Auth::user()->id)->latest()->paginate(10);
            }

            return view('frontend.template-' . $templateId . '.customer.transaction', compact('title', 'meta_image', 'meta_description', 'meta_keyward', 'transactions'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }

    /**
     * customer_update
     *
     * @param  mixed $request
     * @param  int $id
     * @return Response
     */
    public function customer_update(Request $request, $id)
    {
        $customers = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email,' . $customers->id,
            'contact_number' => 'nullable|max:255|unique:users,phone,' . $customers->id,
            'address' => 'nullable|max:255',
            'country_id' => 'nullable|max:255',
            'state_id' => 'nullable|max:255',
            'city_id' => 'nullable|max:255',
            'zip_code' => 'nullable|max:255',
            'password' => 'nullable|confirmed|min:8',
            'image' => 'nullable|image',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /** image upload */
        $image = $request->file('image');
        if ($image != '') {
            if ($customers->image != null) {
                unlink(public_path('uploads/users/' . $customers->image));
            }
            $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/users'), $image_name);
            $customers->image = $image_name;
        }
        $customers->fname = $request->first_name;
        $customers->lname = $request->last_name;
        $customers->address = $request->address;
        $customers->email = $request->email;
        $customers->phone = $request->contact_number;
        $customers->country_id = $request->country_id;
        $customers->state_id = $request->state_id;
        $customers->city_id = $request->city_id;
        $customers->zip_code = $request->zip_code;
        if ($request->password) {
            $customers->password = Hash::make($request->password);
        }

        $customers->update();

        return redirect()->back()->with('success', translate('Your Profile has been updated successfully'));
    }


    /**
     * checkout_check
     *
     * @param  mixed $request
     * @return Response
     */
    public function checkout_check(Request $request)
    {
        $bid_null = Product::where('sale_type', 1)->where('id', $request->product_id)->where('min_deposit', 0)->first();
        $currency = Currency::findOrFail(get_setting('default_currency'));
        $user = Auth::user();
        if ($bid_null) {
            DB::beginTransaction();
            try {
                $receiptId = Str::random(20);
                $orders = new Order;
                $orders->order_number = random_number();
                $orders->product_id = $request->product_id;
                $orders->user_id = $user->id;
                $orders->type = 2;
                $orders->bid_amount = $request->price;
                $orders->amount = 0;
                $orders->tax_amount = 0;
                $orders->quantity = $request->quantity;
                $orders->billing_first_name = $user->fname;
                $orders->billing_last_name = $user->lname;
                $orders->billing_address = $user->address;
                $orders->billing_country_id = $user->country_id? $user->country_id  : null;
                $orders->billing_state_id = $user->state_id ?? 0;
                $orders->billing_city_id = $user->city_id ?? 0;
                $orders->billing_post_code = $user->zip_code;
                $orders->billing_phone = $user->phone;
                $orders->billing_email = $user->email;
                $orders->shipping_first_name = '';
                $orders->shipping_last_name = '';
                $orders->shipping_address = '';
                $orders->shipping_country_id = null;
                $orders->shipping_state_id = null;
                $orders->shipping_city_id = null;
                $orders->shipping_post_code = '';
                $orders->shipping_phone = null;
                $orders->shipping_email = null;
                $orders->message = null;
                $orders->merchant_id = $bid_null->author_id;
                $orders->save();
                email_send('order_mail', Auth::user()->email);
                DB::commit();

                return redirect()->route('thank_you')->with(['success' => translate('Order successfully! Your Order ID is:') . $receiptId, 'orders' => $orders]);
            } catch (\Exception $e) {
                DB::rollback();
            }
        }

        $templateId = get_setting('theme_id') ?? 1;
        if (isset($request->price) && isset($request->product_id)) {
            $customer_cart = [
                'quantity' => $request->quantity ?? 1,
                'price' => $request->price ?? 0,
                'product_id' => $request->product_id,
            ];

            Session::put('customer_cart', $customer_cart);

            return redirect()->route('live.auction.checkout');
        } else {
            return view('frontend.errors.index', ['templateId' => $templateId]);
        }
    }


    /**
     * checkout
     *
     * @param  mixed $request
     * @return View
     */
    public function checkout(Request $request)
    {



        // dd(Session::get('customer_cart'));
        $templateId = get_setting('theme_id') ?? 1;
        $customer_cart = Session::get('customer_cart');


        $lang = $request->lang;
        if (isset($customer_cart['price'], $customer_cart['product_id'])) {

            if(is_numeric((int)$customer_cart['price']) && is_numeric($customer_cart['product_id'])){
                $singleProduct = Product::findOrFail($customer_cart['product_id']);
                $price= abs($customer_cart['price']) ;
                $quantity= abs($customer_cart['quantity']) ;

                if( $singleProduct->sale_type==1){
                    if(highest_bid($customer_cart['product_id']) !==0){
                        if($price <= highest_bid($customer_cart['product_id'])  ){
                            return redirect()->back()->with('error', 'Bidding Price should be greater than Current Bid Price');
                         }
                    }else if( $price <= $singleProduct->min_bid_price ){
                        return redirect()->back()->with('error', 'Bidding Price should be greater than  Bidding Price');
                    }

                }

                 $loginUser = Auth::user();
                 $countries = Location::where('country_id', null)->where('state_id', null)->get();
                 $title = translate('Checkout');
                 $meta_description = get_setting('meta_description');
                 $meta_keyward = get_setting('meta_keyward');
                 $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';
                 $payment_methods = PaymentMethod::where('status', 1)->get();

                 return view('frontend.template-' . $templateId . '.checkout', compact('title', 'meta_image', 'meta_description', 'meta_keyward', 'loginUser', 'singleProduct', 'price', 'quantity', 'countries', 'lang', 'payment_methods'));

            }else{

               return redirect()->back()->with('error', 'Wrong');
            }

        } else {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }
    /**
     * thank_you
     *
     * @param  mixed $request
     * @return View
     */
    public function thank_you(Request $request)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        $title = translate('Thank You');
        $meta_description = get_setting('meta_description');
        $meta_keyward = get_setting('meta_keyward');
        $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';
        if (Session::has('orders')) {
            $orderSingle = Session::get('orders');

            return view('frontend.template-' . $templateId . '.thankyou', compact('title', 'meta_image', 'meta_description', 'meta_keyward', 'lang', 'orderSingle','templateId'));
        } else
         {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }
    public function cancelled(Request $request)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        $title = translate('Payment Cancelled');
        $meta_description = get_setting('meta_description');
        $meta_keyward = get_setting('meta_keyward');
        $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';

        return view('frontend.template-' . $templateId . '.cancelled', compact('title', 'meta_image', 'meta_description', 'meta_keyward', 'lang', 'templateId'));
    }

    public function success(Request $request)
    {
        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        $title = translate('Payment Successful');
        $meta_description = get_setting('meta_description');
        $meta_keyward = get_setting('meta_keyward');
        $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';

        if (Session::has('orders')) {
            $orderSingle = Session::get('orders');

            return view('frontend.template-' . $templateId . '.success', compact('title', 'meta_image', 'meta_description', 'meta_keyward', 'lang', 'orderSingle', 'templateId'));
        } else {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }


    /** Send message to admin for contact.
     *
     * contact_store
     *
     * @param  mixed $request
     */
    public function contact_store(Request $request)
    {
        if (get_setting('google_recapcha_check') == 1) {
            $recaptcha_response = $request->input('g-recaptcha-response');
            if (empty($recaptcha_response)) {
                return redirect()->back()->with('g-recaptcha-response', 'Please Check Recaptcha');
            }
        }

        /** Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'nullable|max:255',
            'subject' => 'required|max:255',
            'message' => 'required',
            'g-recaptcha-response' => function ($attribute, $value, $fail) {
                $secretKey = get_setting('recaptcha_secret');
                $response = $value;
                $userIP = $_SERVER['REMOTE_ADDR'];
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$userIP";
                $response = Http::asForm()->post($url);
                $response = json_decode($response);
                if (!$response->success) {
                    Session::flash('g-recaptcha-response', 'Please Check Recaptcha');
                    $fail($attribute . 'Google Recaptcha Failed');
                }
            },
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $contacts = new Contact;
        $contacts->name = $request->name;
        $contacts->email = $request->email;
        $contacts->phone = $request->phone;
        $contacts->subject = $request->subject;
        $contacts->message = $request->message;
        $contacts->save();

        return redirect()->back()->with('success', translate('Your Message has been Sent Successfully'));
    }


    /**
     * newsletter_subscribe
     *
     * @param  mixed $request
     * @return Response
     */
    public function newsletter_subscribe(Request $request)
    {

        try {


            if($request->email == ""){
                return redirect()->back()->with('success', translate('Enter Your Email'));
            }


            $api_key = get_setting('MAILCHIMP_API_KEY');
            $list_id = get_setting('MAILCHIMP_LIST_ID');

            $MailChimp = new MailChimp($api_key);

            $result = $MailChimp->post("lists/$list_id/members", [
                'email_address' => $request->email,
                'status' => 'subscribed',
            ]);

            if ($MailChimp->success()) {
                return redirect()->back()->with('success', translate('Thanks For Subscribe'));
            } else {
                return redirect()->back()->with('error', $MailChimp->getLastError());
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',  translate('Credentials Wrong!'));
        }
    }


    /** Show the application customer search.
     * search
     *
     * @param  mixed $request
     * @return Response
     */
    public function search(Request $request)
    {

        $templateId = get_setting('theme_id') ?? 1;
        $lang = $request->lang;
        try {
            $title = translate('Search') . ': ' . $request->search;
            $meta_description = get_setting('meta_description');
            $meta_keyward = get_setting('meta_keyward');
            $meta_image = get_setting('header_logo') ? url('assets/logo/' . get_setting('header_logo')) : '';
            $live_auctions = Product::whereHas('categories', function ($query) {
                $query->where('status', 1);
            })->select('products.*')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->where('products.status', 1)
                ->where('categories.status', 1)
                ->where('products.name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('categories.name', 'LIKE', '%' . $request->search . '%')
                ->paginate(12);

            return view('frontend.template-' . $templateId . '.search-page', compact('title', 'meta_image', 'meta_description', 'meta_keyward', 'live_auctions', 'lang','templateId'));
        } catch (\Throwable $th) {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }


    /**
     * shop_name_available_check
     *
     * @param  mixed $request
     * @return Response
     */
    public function shop_name_available_check(Request $request)
    {

        if ($request->get('shop_name')) {
            $shop_name = $request->get('shop_name');
            $data = Store::where('name', $shop_name)
                ->count();

            return $data;
        }
    }


    /** product review submit from customer.
     *
     * review_submit
     *
     * @param  mixed $request
     * @param  int $id
     */
    public function review_submit(Request $request, $id)
    {
        $lang = $request->lang;
        $templateId = get_setting('theme_id') ?? 1;
        $customer = Auth::user();
        $product = Product::findOrFail($id);
        $order = Order::where('product_id', $product->id)->where('user_id', $customer->id)->first();
        if ($order) {
            /** Validation */
            $validator = Validator::make($request->all(), [
                'rate' => 'required|max:255',
                'review' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $ProductReview = new ProductReview;
            $ProductReview->rate = $request->rate;
            $ProductReview->product_id = $product->id;
            $ProductReview->user_id = $customer->id;
            $ProductReview->comments = $request->review;
            $ProductReview->save();

            return redirect()->back()->with('success', translate('Your Rating and Review submit successfully'));
        } else {
            return view('frontend.errors.index', ['templateId' => $templateId, 'lang' => $lang]);
        }
    }

    /**
     * productSearch
     *
     * @param  mixed  $request
     * @param  int  $item
     * @param  string  $lang
     * @param  int  $templateId
     * @return Response
     */
    public function productSearch($request, $item, $templateId, $lang)
    {

        $options = [];
        $category = [];
        $keyword = '';

        // return response()->json($request->all());

        $currentDateTime = now();

        if (isset($request->categories)) {
            $category = $request->categories;
        }
        if (isset($request->product_type)) {
            $options['type'] = $request->product_type;
        }
        if (isset($request->keyword)) {
            $keyword = $request->keyword;
        }

        $products = Product::query();

        if (!empty($category)) {
            $products->when($category, function ($q) use ($category) {
                $q->whereIn('category_id', explode(',', $category));
            });
        }

        if (!empty($keyword)) {
            $products->when(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('short_desc', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('long_desc', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (!empty($options['type'])) {
            $products->when(function ($query) use ($options, $currentDateTime) {
                if ($options['type'] == 1) {
                    $query->where('sale_type', 1, function ($q) use ($currentDateTime) {
                        $q->where('start_date', '<=', $currentDateTime)
                            ->where('end_date', '>=', $currentDateTime);
                    });
                } elseif ($options['type'] == 2) {
                    $query->where('sale_type', $options['type']);
                }
                elseif ($options['type'] == 3) {
                    $query->where('start_date', '>=', $currentDateTime);
                }

            });
        }
        if (!empty($request->min_value) && !empty($request->max_value)) {
            if ($request->product_type != null) {
                $products->when($request->product_type == 1, function ($q) use ($request) {
                    $q->whereBetween('min_bid_price', [$request->min_value,  $request->max_value]);
                });
                $products->when($request->product_type == 2, function ($q) use ($request) {
                    $q->whereBetween('price', [$request->min_value, $request->max_value]);
                });
            }
        }

        if (empty($request->product_type)) {
            $products->where(function ($query) use ($request) {
                $query->whereBetween('min_bid_price', [$request->min_value,  $request->max_value]);
                $query->OrWhereBetween('price', [$request->min_value,  $request->max_value]);
            });
        }

        $products = $products->whereHas('categories', function ($query) {
            $query->where('status', 1);
        })->where('status', 1)->when('sale_type' == 1, function ($q) use ($currentDateTime) {
            return $q->where('start_date', '<=', $currentDateTime)->where('end_date', '>=', $currentDateTime);
        })->paginate($item ? $item : 9);

        if ($request->ajax()) {
            $data = view('frontend.template-' . $templateId . '.partials.filter-products', compact('products', 'lang'))->render();

            return response()->json(['status' => true, 'products' => $data, 'total' => $products->count(), 'first_item' => $products->firstItem(),  'last_item' => $products->lastItem()]);
        }
    }
}
