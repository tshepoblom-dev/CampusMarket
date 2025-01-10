<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App;

class ProductSpecification extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['product_specification_translations'];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $product_specification_translations = $this->product_specification_translations->where('lang', $lang)->first();
        return $product_specification_translations != null ? $product_specification_translations->$field : $this->$field;
    }

    public function product_specification_translations()
    {
        return $this->hasMany(ProductSpecificationTranslation::class, 'specification_id');
    }
}
