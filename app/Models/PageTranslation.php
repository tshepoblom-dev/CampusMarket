<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{
    use HasFactory;


    protected $guarded=['id'];

    protected $casts = [
        'meta_keyward' => 'array',
    ];

}
