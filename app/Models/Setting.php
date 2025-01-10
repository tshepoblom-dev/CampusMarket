<?php

namespace App\Models;

use Mews\Purifier\Casts\CleanHtml;
use Illuminate\Database\Eloquent\Model;

use Mews\Purifier\Casts\CleanHtmlInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function currencies(){
    	return $this->belongsTo(Currency::class, 'value');
    }

    protected $casts = [
        // 'type'            => CleanHtml::class, // cleans both when getting and setting the value
        'value'            => CleanHtml::class, // cleans both when getting and setting the value

    ];
}
