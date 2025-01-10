<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'tags', 'lang', 'blog_id'];

    public function blog(){
    	return $this->belongsTo(Blog::class);
    } 
}
