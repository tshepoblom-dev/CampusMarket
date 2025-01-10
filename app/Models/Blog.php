<?php

namespace App\Models;

use App;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Casts\CleanHtml;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'meta_keyward' => 'array',
        'description'            => CleanHtml::class,
    ];

    protected $with = ['blog_translations'];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $blog_translations = $this->blog_translations->where('lang', $lang)->first();

        return $blog_translations != null ? $blog_translations->$field : $this->$field;
    }

    public function blog_translations()
    {
        return $this->hasMany(BlogTranslation::class);
    }

    public function blog_categories()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * This functions provides widget wise content Blogs
     */
    public static function getBlogsList($limit, $orderBy)
    {
        $blogsList = Blog::orderBy('id', $orderBy)->take($limit)->get();

        return $blogsList;
    }

    /**
     * This functions provides widget wise content Recent News
     */
    public static function getrecentNewsBlog($limit, $orderBy)
    {
        $recent_news = Blog::orderBy('id', $orderBy)->take($limit)->get();

        return $recent_news;
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_id')->where('parent_id', 0);
    }

    public function scopeAuthorName($query)
    {
        return $query->addSelect([
            'author_name' => function ($query) {
                $query->select(DB::raw("CONCAT(users.fname,' ',users.lname) AS full_name")
                )->from('users')->whereColumn('blogs.user_id', 'users.id');
            },
        ]);
    }
}
