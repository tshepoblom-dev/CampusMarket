<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users(){
    	return $this->belongsTo(User::class, 'user_id');
    } 

    public function payments(){
    	return $this->belongsTo(MerchantPaymentInfo::class, 'payment_method');
    } 

    public function locations(){
    	return $this->belongsTo(Location::class);
    } 

    public function wallets()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

}
