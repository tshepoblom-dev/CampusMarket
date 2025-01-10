<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\Currency;

class PaymentMethodController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'admin','pverify']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $page_title = translate('Payment Methods');
        $payment_methods = PaymentMethod::paginate(10);
        $default_currency = Currency::findOrFail(get_setting('default_currency'));

        return view('backend.payment_methods.index', compact('page_title', 'payment_methods', 'default_currency'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $payment_methods  = PaymentMethod::where($where)->first();

        return Response()->json($payment_methods);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $method_id = $request->method_id;
        $methods = PaymentMethod::findOrFail($method_id);

        /** Features image upload */
        $logo_image = $request->file('logo');
        if ($logo_image != '') {
            if ($methods->logo != null) {
                unlink(public_path('uploads/payment_methods/' . $methods->logo));
            }
            $logo_image_name = pathinfo($logo_image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $logo_image->getClientOriginalExtension();
            $logo_image->move(public_path('uploads/payment_methods'), $logo_image_name);
            $methods->logo = $logo_image_name;
        }
        if (isset($request->mode)) {
            $methods->mode = $request->mode;
        } else {
            $methods->mode = 1;
        }
        $methods->key = $request->method_key;
        $methods->secret = $request->method_secret;
        $methods->conversion_currency_id = $request->conversion_currency_id;
        $methods->conversion_currency_rate = $request->conversion_currency_rate;
        $methods->update();


        return redirect()->back()->with('success', 'Payment Method updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }


    /**
     * Change Category status.
     */

    public function changeStatus()
    {
        $status = $_POST['status'];
        $methodId = $_POST['methodId'];

        if ($status && $methodId) {
            $method = PaymentMethod::findOrFail($methodId);
            if ($status == 1) {
                $method->status = 2;
                $message = translate('Payment Method Inactive');
            } else {
                $method->status = 1;
                $message = translate('Payment Method Active');
            }
            if ($method->update()) {
                $response = array('output' => 'success', 'statusId' => $method->status, 'metId' => $method->id, 'message' => $message, 'active' => translate('Active'), 'inactive' => translate('Inactive'));
                return response()->json($response);
            }
        }
    }
}
