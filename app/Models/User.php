<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'custom_id',
        'fname',
        'lname',
        'username',
        'phone',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'image',
        'role',
        'status',
        'email',
        'password',
        'admin_commission',
        'verify_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function countries(){
    	return $this->belongsTo(Location::class, 'country_id');
    }

    public function states(){
    	return $this->belongsTo(Location::class, 'state_id');
    }

    public function cities(){
    	return $this->belongsTo(Location::class, 'city_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'author_id');
    }

    public function transactions()
    {
        return $this->hasMany(Wallet::class, 'user_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function bid_wins()
    {
        return $this->hasMany(Order::class, 'user_id')->where('status',2)->orWhere('status',4);
    }

    public function shop()
    {
        return $this->hasOne(Store::class, 'author_id');
    }

    public function activeProducts()
    {
        return $this->hasMany(Product::class, 'author_id')->where('status',1);
    }
}
