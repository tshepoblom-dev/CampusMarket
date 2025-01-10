<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecificationTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['specification_id','label', 'value', 'lang'];

    public function product_specification(){
      return $this->belongsTo(ProductSpecification::class);
    }
}
