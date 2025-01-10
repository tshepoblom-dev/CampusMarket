<?php

namespace App\Models;

use App;
use Mews\Purifier\Casts\CleanHtml;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $with = ['category_translations'];
    protected $casts = [
        'name'            => CleanHtml::class,
        'image'            => CleanHtml::class,
    ];

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $category_translation = $this->category_translations->where('lang', $lang)->first();
        return $category_translation != null ? $category_translation->$field : $this->$field;
    }

    public function category_translations(){
    	return $this->hasMany(CategoryTranslation::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * This functions provides widget wise content category
    */
    public static function getAllCategory($limit,$orderBy){
        $category = Category::orderBy('id',''.$orderBy.'')->take($limit)->get();
        return $category;
    }


    public function actionProducts()
    {
        return $this->hasMany(Product::class)->where('status',1);
    }
}
