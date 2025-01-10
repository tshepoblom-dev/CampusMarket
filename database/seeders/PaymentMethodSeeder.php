<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $paymentMethods=[
            [
            'method_name' => "wallet",
            'default_logo' => "wallet.png",
            'mode'=>1,
            'status'=>1,
            'logo' =>null,
            'created_at'=> now(),
            'updated_at'=> now(),

            ],
            [
                'method_name' => "paypal",
                'default_logo' => "paypal.png",
                'mode'=>1,
                'status'=>2,
                'logo' =>null,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'method_name' => "stripe",
                'default_logo' => "stripe.png",
                'mode'=>1,
                'status'=>2,
                'logo' =>null,
                'created_at'=> now(),
                'updated_at'=> now(),

            ],
            [
                'method_name' => "razorpay",
                'default_logo' => "razorpay.png",
                'mode'=>1,
                'status'=>2,
                'logo' =>null,
                'created_at'=> now(),
                'updated_at'=> now(),

            ],
            [
                'method_name' => "payfast",
                'default_logo' => "razorpay.png",
                'mode'=>1,
                'status'=>2,
                'logo' =>null,
                'created_at'=> now(),
                'updated_at'=> now(),

            ],
        ];

        if(PaymentMethod::count()==0){
            PaymentMethod::insert($paymentMethods);
          }

    }
}
