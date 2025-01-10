<?php

namespace App\Models;

use Mews\Purifier\Casts\CleanHtml;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $casts = [
        'body'  => CleanHtml::class,
    ];

}
