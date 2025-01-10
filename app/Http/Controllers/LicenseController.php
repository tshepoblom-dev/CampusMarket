<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\PurchaseVerify;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LicenseController extends Controller
{
    //


    /**
     * index
     *
     * @return View
     */
    public function index()
    {
        Artisan::call('optimize:clear');
        return view("backend.license-verify.index");
    }


    /**
     * licenseVerifyForm
     *
     * @param  mixed $request
     * @return view
     */
    public function licenseVerifyForm(Request $request)  {
        Artisan::call('optimize:clear');
        return view("backend.license-verify.verify-index");
    }


     /**
      * themeUpdate
      *
      * @param  mixed $request
      *
      */
     public function themeUpdate(Request $request){


        try {

            $validator = Validator::make($request->all(), [
                'purchase_code' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $client = new Client();
            $res = $client->request('POST', 'https://www.license.egenslab.com/api/admin/license-update', [
                'form_params' => [
                    'purchase_code' => $request->purchase_code,
                    'host_url' => $request->getHost(),
                ]
            ]);

            $response = $res->getBody();
            $obj = json_decode($response, true);

            if ($obj['status'] == true) {

                Session::forget('updateContent');

                 Session::put('updateContent', $obj['content']);
                return redirect()->back()->with('success', $obj['result']);
            }

            return redirect()->back()->with('error', $obj['result']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error',  translate('501!'));
        }
    }

    /**
     * verifyUpdate
     *
     * @param  mixed $request
     *
     */
    public function verifyUpdate(Request $request){


        try {

            $validator = Validator::make($request->all(), [
                'purchase_code' => 'required',
                'email' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $client = new Client();
            $res = $client->request('POST', 'https://www.license.egenslab.com/api/admin/verify-envato-purchase', [
                'form_params' => [
                    'purchase_code' => $request->purchase_code,
                    'email' =>$request->email,
                    'script_name' => 'Bidout - Multivendor Auction & Bidding Platform',
                    'host_url' => $request->getHost(),
                ]
            ]);

            $response = $res->getBody();
            $obj = json_decode($response, true);

            if ($obj['status'] == true) {

                PurchaseVerify::create([
                    'purchase_code'=>$request->purchase_code
                ]);
                $filePath = base_path('config/app.php');
                $currentContent = file_get_contents($filePath);
                $keyToModify = "'app_verify' => false,";

                $newValue = "    'app_verify' => true,";
                $updatedContent = str_replace($keyToModify, $newValue, $currentContent);
                file_put_contents($filePath, $updatedContent);
                // return $response;
                return redirect()->back()->with('success', $obj['result']);

            }


            return redirect()->back()->with('error', $obj['result']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error',  translate('501!'));
        }
    }

    /**
     * purcahaseRemove
     *
     * @param  mixed $request
     *
     */
    public function purcahaseRemove(Request $request){


        try {






            $validator = Validator::make($request->all(), [
                'purchase_code' => 'required',

            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $client = new Client();
            $res = $client->request('POST', 'https://www.license.egenslab.com/api/admin/license-remove', [
                'form_params' => [
                    'purchase_code' => $request->purchase_code,
                    'host_url' => $request->getHost(),
                ]
            ]);

            $response = $res->getBody();
            $obj = json_decode($response, true);

            if ($obj['status'] == true) {

                $purchaseVerify= PurchaseVerify::truncate();


                $filePath = base_path('config/app.php');
                $currentContent = file_get_contents($filePath);
                $keyToModify = "'app_verify' => true,";

                $newValue = "    'app_verify' => false,";
                $updatedContent = str_replace($keyToModify, $newValue, $currentContent);
                file_put_contents($filePath, $updatedContent);

                return redirect()->back()->with('success', $obj['result']);
            }

            return redirect()->back()->with('error', $obj['result']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }
}
