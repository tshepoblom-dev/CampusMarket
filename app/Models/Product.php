<?php

namespace App\Models;

use App;
use Mews\Purifier\Casts\CleanHtml;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'meta_keyward' => 'array',
        'short_desc'            => CleanHtml::class,
        'long_desc'            => CleanHtml::class,
    ];

    protected $with = ['product_translations'];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $product_translations = $this->product_translations->where('lang', $lang)->first();
        return $product_translations != null ? $product_translations->$field : $this->$field;
    }

    public function product_translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'author_id');
    }

    public function bids()
    {
        return $this->hasMany(Order::class,'product_id')->where('type',2)->latest();
    }

    public function bid_winners()
    {
        return $this->hasMany(Order::class,'product_id')->where('type',2)->whereIn('status',[2,4,6,8])->latest();
    }


    public function direct_sales()
    {
        return $this->hasMany(Order::class,'product_id')->where('type',3)->latest();
    }

    /**
     * This functions provides widget wise content Product
     */
    public static function getLiveAuctionsProduct($limit,$orderBy){

        $currentDateTime = now();
        $liveAuctions = Product::where('status',1)->where('start_date', '<=', $currentDateTime)->where('end_date', '>=', $currentDateTime)->orderBy('id',$orderBy)->take($limit)->get();
        return $liveAuctions;
    }

    /**
     * This functions provides widget wise content Upcoming
     */
    public static function getUpComingAuctionsProduct($limit,$orderBy){
        $currentDateTime = now();
        $upComingAuctionsData = Product::where('status',1)->where('start_date', '>=', $currentDateTime)->orderBy('id',$orderBy)->take($limit)->get();
        return $upComingAuctionsData;
    }


}
