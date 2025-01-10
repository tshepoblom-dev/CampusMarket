<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\ProductGallery;
use App\Models\ProductTranslation;
use Mews\Purifier\Facades\Purifier;
use App\Models\ProductSpecification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use Symfony\Component\Console\Input\Input;
use App\Models\ProductSpecificationTranslation;


class ProductController extends Controller
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
        $user = Auth::user();
        $lang = $request->lang;
        $page_title = translate('All Products');
        if ($user->role == 2) {
            if ($request->search) {
                $products = Product::where('author_id', $user->id)->where('name', 'LIKE', '%' . $request->search . '%')->orWhere('sale_price', $request->search)->latest()->paginate(10);
            } else {
                $products = Product::where('author_id', $user->id)->latest()->paginate(10);
            }
            $user_sale_products = Product::where('sale_type', 2)->where('author_id', $user->id)->pluck('id');
            $user_bidding_products = Product::where('sale_type', 1)->where('author_id', $user->id)->pluck('id');
            $user_all_products = Product::where('author_id', $user->id)->pluck('id');

            $data['total_products'] = $user_all_products->count();
            $data['total_auction_products'] =  $user_bidding_products->count()  ;
            $data['total_direct_products'] =$user_sale_products->count();
        } else {
            if ($request->search) {
                $products = Product::where('name', 'LIKE', '%' . $request->search . '%')->orWhere('sale_price', $request->search)->latest()->paginate(10);
            } else {
                $products = Product::latest()->paginate(10);
            }
            $data['total_products'] = $this->getProduct()->count();
            $data['total_auction_products'] = $this->getProductByType($status = 1)->count();
            $data['total_direct_products'] = $this->getProductByType($status = 2)->count();
        }
        return view('backend.products.index', compact('page_title', 'products', 'lang', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = translate('Create Product');
        $categories = Category::where('status', 1)->orderBy('name', 'asc')->get();
        $authors = User::where('role', 2)->orderBy('username', 'asc')->get();
        return view('backend.products.create', compact('categories', 'authors', 'page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)


    {


        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:products,name',
            'sku' => 'required|max:255|unique:products,sku',
            'short_desc' => 'required',
            'long_desc' => 'required',
            'label' => 'nullable',
            'value' => 'nullable',
            'features_image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp',
            'image' => 'nullable',
            'category_id' => 'required|max:255',
            'quantity' => 'required|max:255',
            'sale_type' => 'required|max:255',
            'schedule_type' => 'required|max:255',
            'min_deposit' => 'nullable|max:255',
            'min_deposit_type' => 'nullable|max:255',
            'price' => 'nullable|max:255',
            'sale_price' => 'nullable|max:255',
            'min_bid_price' => 'nullable|max:255',
            'start_date' => 'nullable|max:255',
            'end_date' => 'nullable|max:255',
            'status' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $products = new Product;



        if($request->hasFile('features_image')){
            $features_image = $request->file('features_image');
            if ($features_image != '') {
                $features_image_name = pathinfo($features_image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $features_image->getClientOriginalExtension();
                $features_image->move(public_path('uploads/products/features'), $features_image_name);
                $products->features_image = $features_image_name;
            }
        }

        $products->name = $request->name;
        $products->sku = $request->sku;
        $products->meta_title = $request->meta_title;
        $products->meta_keyward = $request->meta_keyward;
        $products->meta_description =  str_replace('script' , '', prelaceScript(html_entity_decode($request->meta_description)))    ;

        $products->short_desc = str_replace('script' , '', prelaceScript(html_entity_decode($request->short_desc)))  ;



        $products->long_desc = Purifier::clean($request->long_desc)   ;

        $products->category_id = $request->category_id;
        $products->quantity = $request->quantity;
        $products->sale_type = $request->sale_type;
        $products->schedule_type = $request->schedule_type;
        $products->min_deposit = $request->min_deposit;
        $products->min_deposit_type = $request->min_deposit_type;
        $products->price = $request->price;
        $products->sale_price = $request->sale_price;
        $products->min_bid_price = $request->min_bid_price;
        if ($request->sale_type == 1 && $request->schedule_type == 1 && $request->start_date) {
            $products->start_date = date('Y-m-d H:i:s', strtotime($request->start_date));
        } elseif ($request->sale_type == 1 && $request->schedule_type == 2) {
            $products->start_date = date('Y-m-d H:i:s', strtotime(now()));
        }
        if ($request->sale_type == 1 && $request->end_date) {
            $products->end_date = date('Y-m-d H:i:s', strtotime($request->end_date));
        }
        if ($user->role == 2) {
            $products->author_id = $user->id;
            if ($request->status == 1) {
                $products->status = 3;
            } else {
                $products->status = $request->status;
            }
        } elseif ($user->role == 3 || $user->role == 4) {
            $products->author_id = $request->author_id;
            $products->status = $request->status;
        }

        $products->enable_seo = $request->enable_seo == "on" ? 1 : null;

        $slug = Str::slug($request->name, '-');
        $same_slug_count = Product::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;

        $products->slug = $slug;
        $products->save();;
        $this->productGallery($request, $products->id, $features_image);
        $this->specifications($request->specifications, $products->id);
        return redirect()->route('products.list')->with('success', translate('Product saved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $page_title = translate('Product Details');
        $lang = $request->lang;
        $productSingle = Product::with('bids')->where('id', $id)->first();
        return view('backend.products.details', compact('page_title', 'productSingle', 'lang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $page_title = translate('Edit Product');
        $lang = $request->lang;
        $productSingle = Product::findOrFail($id);
        $categories = Category::where('status', 1)->orderBy('name', 'asc')->get();
        $authors = User::where('role', 2)->orderBy('username', 'asc')->get();
        $specifications = ProductSpecification::where('product_id', $id)->get();
        $galleries = ProductGallery::where('product_id', $id)->get();
        return view('backend.products.edit', compact('categories', 'authors', 'page_title', 'productSingle', 'lang', 'specifications', 'galleries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:products,name,'.$id,
            'sku' => 'required|max:255|unique:products,sku,'.$id,
            'short_desc' => 'required',
            'long_desc' => 'required',
            'label' => 'nullable',
            'value' => 'nullable',
            'image' => 'nullable',
            'category_id' => 'required|max:255',
            'quantity' => 'required|max:255',
            'sale_type' => 'required|max:255',
            'schedule_type' => 'required|max:255',
            'min_deposit' => 'nullable|max:255',
            'min_deposit_type' => 'nullable|max:255',
            'price' => 'nullable|max:255',
            'sale_price' => 'nullable|max:255',
            'min_bid_price' => 'nullable|max:255',
            'start_date' => 'nullable|max:255',
            'end_date' => 'nullable|max:255',
        ]);



        if( $request->hasFile('features_image')){
            $validator = Validator::make($request->all(), [
                'features_image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp',
            ]);

        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $products = Product::findOrFail($id);

        if ($request->lang == get_setting("DEFAULT_LANGUAGE", "en")) {
            $products->name = $request->name;
            $short_desc= prelaceScript(html_entity_decode($request->short_desc));
            $long_desc= prelaceScript(html_entity_decode($request->long_desc));
            $products->short_desc = str_replace('script' , '', $short_desc)  ;
            $products->long_desc = str_replace('script' , '', $long_desc) ;
        }
        /** Features image upload */
        $features_image = $request->file('features_image');
        if ($features_image != '') {
            if ($products->features_image != null) {
                unlink(public_path('uploads/products/features/' . $products->features_image));
            }
            $features_image_name = pathinfo($features_image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $features_image->getClientOriginalExtension();
            $features_image->move(public_path('uploads/products/features'), $features_image_name);
            $products->features_image = $features_image_name;
        }
        $products->sku = $request->sku;
        $products->meta_title = $request->meta_title;
        $products->meta_keyward = $request->meta_keyward;

        $meta_description= prelaceScript(html_entity_decode($request->meta_description));
        $meta_description =  str_replace('script' , '', $meta_description)   ;
        $products->meta_description =  $meta_description ;
        $products->category_id = $request->category_id;
        $products->quantity = $request->quantity;
        $products->sale_type = $request->sale_type;
        $products->min_deposit = $request->min_deposit;
        $products->min_deposit_type = $request->min_deposit_type;
        $products->price = $request->price;
        $products->sale_price = $request->sale_price;
        $products->min_bid_price = $request->min_bid_price;
        $products->schedule_type = $request->schedule_type;
        if ($request->sale_type == 1 && $request->schedule_type == 1 && $request->start_date) {
            $products->start_date = date('Y-m-d H:i:s', strtotime($request->start_date));
        } elseif ($request->sale_type == 1 && $request->schedule_type == 2) {
            $products->start_date = date('Y-m-d H:i:s', strtotime(now()));
        }
        if ($request->sale_type == 1 && $request->end_date) {
            $products->end_date = date('Y-m-d H:i:s', strtotime($request->end_date));
        }
        if ($user->role == 2) {
            if (isset($request->status)) {
                if ($request->status == 1) {
                    $products->status = 3;
                } else {
                    $products->status = $request->status;
                }
            } else {
                $products->status = 1;
            }
        } elseif ($user->role == 3 || $user->role == 4) {
            if (isset($request->status)) {
                $products->status = $request->status;
            } else {
                $products->status = 1;
            }
        }
        $products->enable_seo = $request->enable_seo == "on" ? 1 : null;
        $slug = Str::slug($request->name, '-');
        $same_slug_count = Product::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;

        $products->slug = $slug;

        if ($products->update()) {


            $product_translation = ProductTranslation::firstOrNew(['lang' => $request->lang, 'product_id' => $products->id]);
            $product_translation->name = $request->name;

            $short_desc= prelaceScript(html_entity_decode($request->short_desc));
            $long_desc= prelaceScript(html_entity_decode($request->long_desc));

            $product_translation->short_desc = str_replace('script' , '', $short_desc) ;
            $product_translation->long_desc = str_replace('script' , '', $long_desc) ;

            $product_translation->save();
            $product_id = $products->id;

            if ($request->lang == get_setting("DEFAULT_LANGUAGE", "en")) {
                $this->specifications($request->specifications, $product_id);
            } else {

                $this->specificationsTranslate($request->specifications, $request->lang);

            }

            if ($request->hasFile('image')) {
                $allowedfileExtension=['jpeg','png','jpg','gif','svg','webp'];
                foreach ($request->file('image') as $image) {
                    $extension = $image->getClientOriginalExtension();
                    $check=in_array($extension,$allowedfileExtension);
                    if($check){
                        $product_gallery = new ProductGallery;
                        $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('uploads/products/gallery'), $image_name);
                        $product_gallery->image = $image_name;
                        $product_gallery->product_id = $product_id;
                        $product_gallery->save();
                    }

                }
            }
        }
        return redirect()->route('products.list')->with('success', translate('Product updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $products = Product::findOrFail($id);
        if ($products->features_image != null) {
            unlink(public_path('uploads/products/features/' . $products->features_image));
        }
        $product_gallery = ProductGallery::where('product_id', $id)->get();
        if ($product_gallery != null) {
            foreach ($product_gallery as $pgallery) {
                unlink(public_path('uploads/products/gallery/' . $pgallery->image));
            }
        }
        $products->delete();
        return back()->with('success', translate('Product deleted successfully'));
    }

    /**
     * Pending product approved.
     */
    public function approve(Request $request, $id)
    {
        $products = Product::findOrFail($id);
        $products->status = 1;
        $products->update();

        return back()->with('success', translate('Product approved successfully'));
    }

    /**
     * Gallery image remove.
     */

    public function gallery_remove()
    {
        $dataId = $_POST['dataId'];

        if ($dataId) {
            $gallery = ProductGallery::findOrFail($dataId);
            if ($gallery->image != null) {
                unlink(public_path('uploads/products/gallery/' . $gallery->image));
            }
            $message = translate('Gallery Image Deleted');

            if ($gallery->delete()) {
                $response = array('output' => 'success', 'dataId' => $dataId, 'message' => $message);
                return response()->json($response);
            }
        }
    }

    /**
     * Specification remove.
     */
    public function specification_remove()
    {
        $dataId = $_POST['dataId'];

        if ($dataId) {
            $specification = ProductSpecification::findOrFail($dataId);
            $message = translate('Specification Deleted');

            if ($specification->delete()) {
                $response = array('output' => 'success', 'dataId' => $dataId, 'message' => $message);
                return response()->json($response);
            }
        }
    }


    /**
     * winner
     *
     * @param  mixed $id
     * @return void
     */
    public function winner($id)
    {

        // dd($id);
        $order = Order::with('users')->where('id', $id)->first();
        if ($order->win_status == 1) {
            $message = translate("Already Winner");
        } else {
            $order->win_status = 1;
            $order->status = 2;
            email_send('bid_winner', $order->users->email);
            $order->update();
            $message =  translate('Winner updated successfully');
        }

        return back()->with('success', $message);
    }

    /**
     * closed
     *
     * @param  mixed $id
     * @return void
     */
    public function closed($id)


    {


        $currency = get_setting('default_currency');
        $products = Product::findOrFail($id);
        $has_winner = Order::where('product_id', $products->id)->where('win_status', 1)->first();
        if ($has_winner) {
            $products->status = 5;
            $orders = Order::where('product_id', $products->id)->get();

            if ($orders) {
                foreach ($orders as $order) {
                    if ($order->status == 1) {
                        $wallets = Wallet::where('order_id', $order->id)->first();
                        $wallets->type = 6;
                        $wallets->payment_details = 'Bidding Refund';
                        $wallets->status = 3;
                        if ($wallets->update()) {
                            $order->status = 7;
                            $order->update();
                            User::findOrFail($order->user_id)->increment('wallet_balance', $order->amount);
                        }
                    } elseif ($order->win_status == 1) {
                        if ($products->users->role == 2) {
                            $wallets = Wallet::where('order_id', $order->id)->first();
                            $wallets->payment_details = 'Bid winning';
                            $wallets->status = 2;
                            if ($wallets->update()) {
                                User::findOrFail($products->author_id)->increment('wallet_balance', (int)$wallets->merchant_amount);
                            }
                        }
                        $admin = User::where('role', 4)->orderBy('id', 'asc')->first();
                        $admin->increment('wallet_balance', (int)$wallets->admin_commission);
                    }
                }
            }

            $products->update();
            return back()->with('success', translate('Bid Closed successfully'));
        } else {
            return back()->with('error', translate('Please confirm your winner'));
        }
    }

    /**
     * Change Product status.
     */

    public function changeStatus()
    {
        $currency = get_setting('default_currency');
        $status         = $_POST['status'];
        $productId     = $_POST['productId'];

        if ($status && $productId) {
            $products = Product::findOrFail($productId);
            if ($status == 1) {
                $products->status = 4;
                $message = translate('Product Inactive');
            } elseif ($products->sale_type == 1 && $status == 5) {
                $message = translate('Bid Already Closed');
            } else {
                $products->status = 1;
                $message = translate('Product Active');
            }
        }
        if ($products->update()) {
            $response = array('output' => 'success', 'statusId' => $products->status, 'proId' => $products->id, 'message' => $message);
            return response()->json($response);
        }
    }


    /**
     * Change Product status.
     */

    public function changeStatusClosed()
    {
        $currency = get_setting('default_currency');
        $status         = $_POST['status'];
        $productId     = $_POST['productId'];

        if ($status && $productId) {
            $products = Product::findOrFail($productId);
            if ($status == 1) {
                $products->status = 4;
                if ($products->sale_type == 1) {
                    $orders = Order::where('product_id', $productId)->get();
                    if ($orders) {
                        foreach ($orders as $order) {
                            if ($order->status == 1) {
                                $wallets = new Wallet;
                                $wallets->user_id = $order->user_id;
                                $wallets->payer_id = get_setting('company_name');
                                $wallets->payer_email = get_setting('email_address');
                                $wallets->type = 7;
                                $wallets->amount = $order->amount;
                                $wallets->total_amount = $order->amount;
                                $wallets->payment_method = 'Bidding Refund';
                                $wallets->currency = $currency->currencies->code ?? 'USD';
                                $wallets->payment_details = 'Bidding Refund';
                                $wallets->status = 2;
                                if ($wallets->save()) {
                                    $order->status = 3;
                                    $order->update();
                                    User::findOrFail($order->user_id)->increment('wallet_balance', $order->amount);
                                }
                            } elseif ($order->status == 2) {
                                if ($products->users->role == 2) {
                                    $wallets = new Wallet;
                                    $wallets->user_id = $products->author_id;
                                    $wallets->payer_id = get_setting('company_name');
                                    $wallets->payer_email = get_setting('email_address');
                                    $wallets->type = 6;
                                    $payment_rate =  100 - ($products->users->admin_commission ?? get_setting('merchant_commission'));
                                    $amount = $order->amount / 100 * $payment_rate;
                                    $wallets->amount = $amount;
                                    $wallets->total_amount = $order->amount;
                                    $admin_commission_rate = $products->users->admin_commission ?? get_setting('merchant_commission');
                                    $wallets->admin_commission_rate = $admin_commission_rate;
                                    $wallets->admin_commission = $order->amount / 100 * $admin_commission_rate;
                                    $wallets->payment_method = 'Bidding Initial Payment';
                                    $wallets->currency = $currency->currencies->code ?? 'USD';
                                    $wallets->payment_details = 'Bidding Initial Payment';
                                    $wallets->status = 2;
                                    if ($wallets->save()) {
                                        User::findOrFail($products->author_id)->increment('wallet_balance', $amount);
                                    }
                                }
                            }
                        }
                    }

                    $message = translate('Bid Closed');
                } else {
                    $message = translate('Product Inactive');
                }
            } else {
                if ($products->sale_type == 1) {
                    $message = translate('Bid Already Closed');
                } else {
                    $products->status = 1;
                    $message = translate('Product Active');
                }
            }
            if ($products->update()) {
                $response = array('output' => 'success', 'statusId' => $products->status, 'proId' => $products->id, 'message' => $message);
                return response()->json($response);
            }
        }
    }

    /**
     * Show the product review.
     */
    public function review(Request $request, $id)
    {
        $lang = $request->lang;
        $products = Product::findOrFail($id);
        $page_title = translate('Product Review') . ': ' . $products->getTranslation('name', $lang);
        $productReviews = ProductReview::where('product_id', $id)->whereNull('reply_id')->whereNotNull('rate')->latest()->paginate(10);
        return view('backend.products.reviews', compact('productReviews', 'page_title', 'lang'));
    }

    /**
     * Show the product review.
     */
    public function review_reply(Request $request)
    {
        $reply = new ProductReview;
        $reply->product_id = $request->product_id;
        $reply->reply_id = $request->review_id;
        $reply->comments = $request->reply_message;
        $reply->user_id = Auth::user()->id;
        $reply->save();

        return back()->with('success', translate('Reply successfully'));
    }

    /**
     * Change Product Review status.
     */

    public function changeReviewStatus(Request $request)
    {
        $status         = $_POST['status'];
        $reviewId     = $_POST['reviewId'];

        if ($status && $reviewId) {
            $productReview = ProductReview::findOrFail($reviewId);
            if ($status == 1) {
                $productReview->status = 2;
                $message = translate('Product Review Inactive');
            } else {
                $productReview->status = 1;
                $message = translate('Product Review Active');
            }
        }
        if ($productReview->update()) {
            $response = array('output' => 'success', 'statusId' => $productReview->status, 'revId' => $productReview->id, 'message' => $message);
            return response()->json($response);
        }
    }

    /**
     * getProductByType
     *
     * @param  int $type
     * @return Response
     */

    public function getProductByType($type)
    {
        return Product::where('sale_type', $type)->get();
    }


    /**
     * getProduct
     *
     * @return Response
     */
    public function getProduct()
    {
        return Product::get();
    }




    /**
     * specifications
     *
     * @param  mixed $specifications
     * @param  int $productId
     * @return Response
     */
    public function specifications($specifications, $productId)
    {
        ProductSpecification::where('product_id', $productId)->delete();

        if (is_array($specifications)) {
            foreach ($specifications  as $specification) {
                if (isset($specification['label']) && isset($specification['value'])) {
                    $productSpecification = new ProductSpecification();
                    $productSpecification->label = $specification['label'];
                    $productSpecification->value = $specification['value'];
                    $productSpecification->product_id = $productId;
                    $productSpecification->save();
                }
            }
        }
    }


    /**
     * specificationsTranslate
     *
     * @param  mixed $specifications
     * @param  int $productId
     * @param  string $lang
     * @return Response
     */
    public function specificationsTranslate($specifications, $lang)
    {
        if (is_array($specifications)) {
            foreach ($specifications  as $specification) {
                if (isset($specification['label']) && isset($specification['value']) && isset($specification['specification_id'])) {
                    if ($productSpecification = ProductSpecificationTranslation::where('specification_id', $specification['specification_id'])->where('lang', $lang)->first()) {
                        $productSpecification->label = $specification['label'];
                        $productSpecification->value = $specification['value'];
                        $productSpecification->update();
                    } else {
                        $productSpecification = new ProductSpecificationTranslation();
                        $productSpecification->label = $specification['label'];
                        $productSpecification->value = $specification['value'];
                        $productSpecification->specification_id = $specification['specification_id'];
                        $productSpecification->lang = $lang;
                        $productSpecification->save();
                    }
                }
            }
        }
    }



    /**
     * productGallery
     *
     * @param  mixed $request
     * @param  int $product_id
     * @param  mixed $features_image
     * @return Response
     */
    public function productGallery($request, $product_id, $features_image)
    {
        if ($request->file('image')) {

            $allowedfileExtension=['jpeg','png','jpg','gif','svg','webp'];
            foreach ($request->file('image') as $image) {
                $extension = $image->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                if($check){
                    $product_gallery = new ProductGallery;
                    $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $features_image->getClientOriginalExtension();
                    $image->move(public_path('uploads/products/gallery'), $image_name);
                    $product_gallery->image = $image_name;
                    $product_gallery->product_id = $product_id;
                    $product_gallery->save();
                }
            }
        }
    }
}
