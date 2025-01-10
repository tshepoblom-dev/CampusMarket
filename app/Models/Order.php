<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class, 'order_id');
    }

    public function billing_countries()
    {
        return $this->belongsTo(Location::class, 'billing_country_id');
    }

    public function billing_states()
    {
        return $this->belongsTo(Location::class, 'billing_state_id');
    }

    public function billing_cities()
    {
        return $this->belongsTo(Location::class, 'billing_city_id');
    }

    public function shipping_countries()
    {
        return $this->belongsTo(Location::class, 'shipping_country_id');
    }

    public function shipping_states()
    {
        return $this->belongsTo(Location::class, 'shipping_state_id');
    }

    public function shipping_cities()
    {
        return $this->belongsTo(Location::class, 'shipping_city_id');
    }


    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id', 'id');
    }
}
