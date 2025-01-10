<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','name', 'short_desc', 'long_desc', 'lang'];

    public function product(){
      return $this->belongsTo(Product::class);
    }
}
