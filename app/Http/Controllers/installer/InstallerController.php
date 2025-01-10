<?php
namespace App\Http\Controllers\installer;

use  Config;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\PurchaseVerify;
use App\Classes\DatabaseManager;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Classes\EnvironmentManager;
use App\Classes\PermissionsChecker;
use App\Classes\FinalInstallManager;
use App\Classes\RequirementsChecker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Classes\InstalledFileManager;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InstallerController extends Controller
{


    /* Minimum PHP Version Supported (Override is in installer.php config file).
    *
    * @var _minPhpVersion
    */

   private $databaseManager;
   protected $requirements;
   protected $permissions;
   protected $environmentManager;



   public function __construct(DatabaseManager $databaseManager, RequirementsChecker $checker, PermissionsChecker $pchecker,EnvironmentManager $environmentManager)
   {

       $this->databaseManager = $databaseManager;
       $this->requirements=$checker;
       $this->permissions = $pchecker;
       $this->environmentManager = $environmentManager;
   }

   /**
    * installContent
    *
    * @return view
    */
   public function installContent(){

        $phpSupportInfo = $this->requirements->checkPHPversion(config('installer.core.minPhpVersion'));
        $requirements = $this->requirements->check(config('installer.requirements'));
        $permissions = $this->permissions->check(config('installer.permissions'));
        return view('installer.index', compact('phpSupportInfo', 'requirements','permissions'));
   }

    /**
     * requirement
     *
     * @param  mixed $request
     * @return view
     */
    public function requirement(Request $request){
         if($request->ajax()) {
            $phpSupportInfo = $this->requirements->checkPHPversion(config('installer.core.minPhpVersion'));
            $requirements = $this->requirements->check(config('installer.requirements'));
            if( isset($requirements['errors'])  || isset($phpSupportInfo['supported'] ) !== true){
                return response()->json(['status'=>false , 'message'=>'Please make sure Server Requirements']);
            }else{
                return response()->json(['status'=>true]);
            }
         }
         return redirect(404);
    }

    /**
     * permission
     *
     * @param  mixed $request
     * @return Response
     */
    public function permission(Request $request){
         if($request->ajax()){
            $permissions = $this->permissions->check(config('installer.permissions'));
            // $view= view('installer.permission', compact('permissions'))->render();
            if(isset($permissions['errors']) ==true ){
                return response()->json(['status'=>false ,  'message'=>'Please make sure folder Permissions']);
            }else{
                return response()->json(['status'=>true]);
            }

         }
         return redirect(404);
    }

    /**
     * environment
     *
     * @param  mixed $request
     * @return void
     */
    public function environment(Request $request){
          if($request->ajax()){
            $validator= Validator::make($request->all(),[
                'app_name'=>'required',
                'app_debug'=>'required',
                'environment'=>'required',
                'app_log_level'=>'required',
                'app_url'=>'required',
             ]);

             if($validator->fails()){
                return response()->json(['status'=>false , 'errors'=>$validator->errors()]);
             }
            Session::put('environment' ,  $request->all());
            return response()->json(['status'=>true]);
          }
          return redirect(404);

    }

    /**
     * database
     *
     * @param  mixed $request
     * @return Response
     */
    public function database(Request $request){

        $request->merge(Session::get('environment'));
        try{

            $rules = config('installer.environment.form.rules');
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response()->json(['status'=>false , 'errors'=>$validator->errors()]);
             }
            if (! $this->checkDatabaseConnection($request)) {
                return response()->json(['status'=>false , 'message'=>"Could not connect to the database."]);
            }
            $results = $this->environmentManager->saveFileWizard($request);
            return response()->json(['status'=>true , 'message'=>"d", 'url' => route('install.import-demo')]);

        }catch (\Exception $e) {
            return dd($e->getMessage());
        }

    }

    /**
     * importDemo
     *
     * @return View
     */
    public function importDemo(){
        return view('installer.index');
    }


    /**
     * imported
     *
     * @param  mixed $redirect
     * @return Redirect
     */
    public function imported(Redirector $redirect){

        try {
            if( Request()->demo_import=="on"){
                $this->databaseManager->migrateTable();
                $sql = File::get(public_path('demo.sql'));
                 DB::connection()->getPdo()->exec($sql);

            }else{
                $this->databaseManager->migrateAndSeed();
            }

            return $redirect->route('install.final');

        } catch (\Throwable $th) {
            // dd( $th->getMessage());
            return $redirect->route('install.final');
        }
    }


    /**
     * finish
     *
     * @param  mixed $fileManager
     * @param  mixed $finalInstall
     * @param  mixed $environment
     *
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        PurchaseVerify::create(['purchase_code'=> File::get(storage_path('app/public/file.txt'))]);
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();
        $setting=Setting::where('type', 'company_name')->first();
        $setting->value=env('APP_NAME');
        $setting->update();

        return view('installer.index', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }


    /**
     * checkDatabaseConnection
     *
     * @param  mixed $request
     * @return
     */
    private function checkDatabaseConnection(Request $request)
    {
        $connection = $request->input('database_connection');

        $settings = config("database.connections.$connection");

        config([
            'database' => [
                'default' => $connection,
                'connections' => [
                    $connection => array_merge($settings, [
                        'driver' => $connection,
                        'host' => $request->input('database_hostname'),
                        'port' => $request->input('database_port'),
                        'database' => $request->input('database_name'),
                        'username' => $request->input('database_username'),
                        'password' => $request->input('database_password'),
                    ]),
                ],
            ],
        ]);

        DB::purge();

        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * If application is already installed.
     *
     * @return
     */
    public function alreadyInstalled()
    {
        return file_exists(storage_path('installed'));
    }


    /**
     * purchaseCode
     *
     * @param  mixed $request
     *
     */
    public function purchaseCode(Request $request){

          try{
              $validator= Validator::make($request->all(),[
                'purchase_code'=>'required',
                'email'=>'required',
               ]);

               if($validator->fails()){
                   return response()->json(['status'=>false , 'errors'=>$validator->errors()]);
                }
                $client = new Client();
                $res = $client->request('POST', 'https://www.license.egenslab.com/api/admin/verify-envato-purchase', [
                    'form_params' => [
                        'purchase_code' => $request->purchase_code,
                        'email' => $request->email,
                        'script_name' => 'Bidout - Multivendor Auction & Bidding Platform',
                        'host_url' => $request->getHost(),
                    ]
                ]);
            $response= $res->getBody();
            $obj= json_decode($response, true);


            Storage::disk('local')->put('public/file.txt', $request->purchase_code);


            if($obj['status'] == true){
                $filePath = base_path('config/app.php');

                $currentContent = file_get_contents($filePath);
                $keyToModify = "'app_verify' => false,";

                $newValue = "    'app_verify' => true,";
                $updatedContent = str_replace($keyToModify, $newValue, $currentContent);
                file_put_contents($filePath, $updatedContent);
                return $response;
            }

            return response()->json(['status'=>$obj['status'] , 'message'=>$obj['result']]);

          }
          catch(\Exception $e){
            return response()->json(['status'=>false , 'message'=> $e->getMessage()]);
          }
    }


}

