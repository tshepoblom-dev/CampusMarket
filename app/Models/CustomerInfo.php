<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInfo extends Model
{
    use HasFactory;
     // Define the table name
     protected $table = 'customer_info';

     // Define the primary key (optional, if it's not 'id')
     protected $primaryKey = 'id';

     // If the primary key is not auto-incrementing, disable it
     public $incrementing = true;

     // Specify the data type for the primary key if necessary
     protected $keyType = 'int';

     // Disable timestamps if the table doesn't have 'created_at' and 'updated_at' columns
     public $timestamps = true;

     // Specify the fillable attributes
     protected $fillable = [
         'transaction_guid',
         'billing_first_name',
         'billing_last_name',
         'billing_address',
         'billing_country_id',
         'billing_state_id',
         'billing_city_id',
         'billing_post_code',
         'billing_phone',
         'billing_email',
         'shipping_first_name',
         'shipping_last_name',
         'shipping_address',
         'shipping_country_id',
         'shipping_state_id',
         'shipping_city_id',
         'shipping_post_code',
         'shipping_phone',
         'shipping_email',
         'message',
         'product_id',
         'merchant_id',
         'bid_amount',
         'amount',
         'tax_amount',
         'total_amount',
         'type',
         'currency',
         'current_url',
         'quantity',
         'order_id',
         'customer_id',
     ];

     // Relationships if necessary (e.g., a customer might have many orders)
     public function product()
     {
         return $this->belongsTo(Product::class, 'product_id', 'id');
     }

     public function merchant()
     {
         return $this->belongsTo(User::class, 'merchant_id', 'id');
     }
     public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'id');
     }
}
