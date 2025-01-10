<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $temples = [

            [
                'name' => 'Deposit - Customer',
                'slug' => 'deposit',
                'subject' => 'Deposit success',
                'body' => '<p style="text-align:center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871738470.png"><br><p>Dear [customer_full_name],</p><p>Congratulations, Your Deposit has been successfully!</p><p>Thank You</p><p>The [company_name] Team.</p><p><br></p><p></p><p></p><p></p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Direct Product Order - Customer',
                'slug' => 'order_mail',
                'subject' => 'Thank you for order',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871580300.png"><br><p>Dear [customer_full_name],</p><p>Congratulations, Your Order has been successfully send!</p><p>Thank You</p><p>The [company_name] Team.</p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Password Reset',
                'slug' => 'forgot_password',
                'subject' => 'Reset Your Account Password',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871581060.png"><br><p>Dear [customer_full_name],</p><p>To reset your password click here</p><p>Thank You</p><p>The [company_name] Team.</p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Email Verification',
                'slug' => 'verification_email',
                'subject' => 'Account Verification Email',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871581550.png"><br><p>Dear [customer_full_name],</p><p>To verify your email please click here.</p><p>[verify_btn]</p><p>Thank You</p><p>The [company_name] Team.</p><p></p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer Registration',
                'slug' => 'registration',
                'subject' => 'Thank you for registration',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871581870.png"><br><p>Dear [customer_full_name],</p><p>Congratulations, Your Account has been successfully created!</p><p>Thank You</p><p>The [company_name] Team.</p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Withdraw Approved - Merchant',
                'slug' => 'withdraw',
                'subject' => 'Withdraw success',
                'body' => '<p style="text-align:center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871757290.png"><br><p>Dear [customer_full_name],</p><p>Congratulations, Your Withdraw request has been successfully approved! Your payment will be sent to your payment account.&nbsp;</p><p>Please Check</p><p>Thank You</p><p>The [company_name] Team.</p><p><br></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bidding Winner - Customer',
                'slug' => 'bid_winner',
                'subject' => 'Thank you for Bid Winning',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871580300.png"><br><p>Dear [customer_full_name],</p><p>Congratulations!! You won the bid please confirm your final payment.</p><p>Thank You</p><p>The [company_name] Team.</p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bidding Final Payment - Customer',
                'slug' => 'final_payment',
                'subject' => 'Thank you for final payment',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871580300.png"><br><p>Dear [customer_full_name],</p><p>Congratulations!! Your payment is successful we will shift your product and deliver as soon as possible.</p><p>Thank You</p><p>The [company_name] Team.</p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Password Reset Confirmation',
                'slug' => 'password_reset_confirmation',
                'subject' => 'Thank you for Password Reset',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871580300.png"><br><p>Dear [customer_full_name],</p><p>Your password has been successfully reset. Now you can login in your account.</p><p>Thank You</p><p>The [company_name] Team.</p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Merchant Registration',
                'slug' => 'merchant_registration',
                'subject' => 'Thank you for Registration',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871580300.png"><br><p>Dear [customer_full_name],</p><p>Congratulations!! Your merchant registration is successful now you can list your product and sell to the customer.</p><p>Thank You</p><p>The [company_name] Team.</p><p></p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bidding - Customer',
                'slug' => 'bidding_customer',
                'subject' => 'Thank you for Bidding',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871580300.png"><br><p>Dear [customer_full_name],</p><p>Congratulations!! Your bidding is successfully placed. Stay connected for the updates.</p><p>Thank You</p><p>The [company_name] Team.</p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bidding Payment Refund - Customer',
                'slug' => 'bidding_payment_refund',
                'subject' => 'Thank you for Bidding & Bidding Payment Refund',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871580300.png"><br><p>Dear [customer_full_name],</p><p>Your partial bidding amount has been successfully refunded to your account wallet.&nbsp;</p><p>Thank You</p><p>The [company_name] Team.</p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Withdraw Rejected - Merchant',
                'slug' => 'Withdraw Rejected - Merchant',
                'subject' => 'Your Withdraw Rejected',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871580300.png"><br><p>Dear [customer_full_name],</p><p>Your withdrawal request has been rejected. Please contact the admin for the update.</p><p>Thank You</p><p>The [company_name] Team.</p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Withdraw Requested - Admin',
                'slug' => 'withdraw_requested',
                'subject' => 'Thank you for Withdraw Requested',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871580300.png"><br><p>Dear [customer_full_name],</p><p>Your withdrawal request has been placed. Will update you regarding this soon. Stay connected&nbsp;</p><p>Thank You</p><p>The [company_name] Team.</p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Support Ticket Reply - Merchant',
                'slug' => 'support_ticket_reply',
                'subject' => 'Thank you for the Support Ticket Reply',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871580300.png"><br><p>Dear [customer_full_name],</p><p>Your support ticket has been successfully submitted. Soon support member will response to your support.&nbsp;</p><p>Thank You</p><p>The [company_name] Team.</p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Support Ticket - Admin',
                'slug' => 'support_ticket',
                'subject' => 'Thank you for the Support Ticket',
                'body' => '<p style="text-align: center;"><img data-filename="favicon.ico" style="width: 22px;" src="/uploads/email/16871580300.png"><br><p>Dear [customer_full_name],</p><p>Your support ticket has been successfully submitted. Soon support member will response to your support.&nbsp;<br></p><p>Thank You</p><p>The [company_name] Team.</p><p></p><p></p></p>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        if(EmailTemplate::count()==0){
            EmailTemplate::insert($temples);
          }


    }
}
