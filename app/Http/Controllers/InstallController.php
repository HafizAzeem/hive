<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Session;
use DB,Hash;
use App\Setting;
use App\User;
class InstallController extends Controller
{
    protected $info;
    protected $internet_connection = FALSE;
    private $core;
    public $data=[];
    
    public function __construct(){
        if($this->checkInternetConnection()) {
            $this->internet_connection = TRUE;
        }
    }
    public function index() {
        // Check PHP version
        if (phpversion() < "5.3") {
            $this->data['errors'][] = 'You are running PHP old version!';
        } else {
            $phpversion = phpversion();
            $this->data['success'][] = ' You are running PHP '.$phpversion;
        }
        // Check Mcrypt PHP exention
        if(!extension_loaded('mcrypt')) {
            $this->data['errors'][] = 'Mcriypt PHP exention unloaded!';
        } else {
            $this->data['success'][] = 'Mcriypt PHP exention loaded!';
        }
        // Check Mysql PHP exention
        if(!extension_loaded('mysql')) {
            $this->data['errors'][] = 'Mysql PHP exention unloaded!';
        } else {
            $this->data['success'][] = 'Mysql PHP exention loaded!';
        }
        // Check Mysql PHP exention
        if(!extension_loaded('mysqli')) {
            $this->data['errors'][] = 'Mysqli PHP exention unloaded!';
        } else {
            $this->data['success'][] = 'Mysqli PHP exention loaded!';
        }
        // Check MBString PHP exention
        if(!extension_loaded('mbstring')) {
            $this->data['errors'][] = 'MBString PHP exention unloaded!';
        } else {
            $this->data['success'][] = 'MBString PHP exention loaded!';
        }
       
        // Check CURL PHP exention
        if(!extension_loaded('curl')) {
            $this->data['errors'][] = 'CURL PHP exention unloaded!';
        } else {
            $this->data['success'][] = 'CURL PHP exention loaded!';
        }

        // Check Database Path
        $envFile = app()->environmentFilePath();
        if ($envFile) {
            $this->data['success'][] = 'Database file is loaded';
            @chmod($envFile, FILE_WRITE_MODE);
            if (is_writable($envFile) === FALSE) {
                $this->data['errors'][] = 'database file is unwritable';
            } else {
                $this->data['success'][] = 'Database file is writable';
            }

        } else {
            $this->data['errors'][] = 'Database file is unloaded';
        }
        
        if($this->internet_connection) {
            $this->data['success'][] = 'Internet connection OK';
        } else {
            $this->data['errors'][] = 'Internet connection problem!';
        }
        $pdo = DB::connection()->getPdo();
        if($pdo){
            $settings = getSettings();
            if(isset($settings['site_setup']) && $settings['site_setup']==1){
                //return redirect('admin');
            }
       }
        return view('install.checklist',$this->data);
    }

    public function databaseView() {
        $sessionData = Session::get('database_info');
        $this->data['database_info'] = ($sessionData) ? $sessionData : null;
        return view('install.database', $this->data);
    }
    public function databaseSave(Request $request) {
        Session::put('database_info', $request->all());
         $envData = [
            'DB_HOST'       => $request->host,
            'DB_DATABASE'   => $request->database,
            'DB_USERNAME'   => $request->username,
            'DB_PASSWORD'   => $request->password,
        ];
        if($this->setEnvironmentValue($envData)){
            return redirect()->route('set-siteconfig')->with(['success' => config('constants.FLASH_REC_ADD_1')]);
        } else {
            return redirect()->back()->with(['error' => config('constants.FLASH_DB_CONNECT_0')]);
        }
        
    }
    public function siteconfigView() {
        return view('install.site_config');
    }
    public function siteconfigSave(Request $request) {
        Session::put('site_info', $request->all());
        if($this->checkDatabaseConnection()){
            //save settings
            $res = null;
            $acceptCol = ['site_language', 'site_page_title', 'hotel_name', 'site_setup'];
            foreach($request->all() as $key => $value){ 
                if(in_array($key, $acceptCol)){
                   $res = Setting::updateOrCreate(['name'=>$key], ['name'=>$key, 'value'=>$value, 'updated_at'=>date('Y-m-d h:i:s')]);
                }
            }
            if($res) setSettings();

            //save user
            $userId = User::insertGetId(['role_id'=>2,'name'=>$request->name, 'email'=>$request->username, 'password'=>Hash::make($request->password)]);
            return redirect()->route('done')->with(['success' => config('constants.FLASH_REC_ADD_1')]);
        } else {
            return redirect()->route('set-database')->with(['error' => config('constants.FLASH_DB_CONNECT_0')]);
        }
    }

    public function doneView() {
        $sessionData = Session::get('site_info');
        $this->data['username'] = $sessionData['username'];
        $this->data['password'] = $sessionData['password'];
        return view('install.done', $this->data);
    }

    function checkInternetConnection($sCheckHost = 'www.google.com')  {
        return (bool) @fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
    }
    function checkDatabaseConnection() {
        ini_set('display_errors', 'Off');
        $connected = false;
        try {
            DB::connection()->getPdo();
            $connected = true;
        } catch (\Exception $e) {
            $connected = false;
        }
        return $connected;
    }
    function setEnvironmentValue($data){
        if(count($data) > 0){
            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);

            // Loop through given data
            foreach((array)$data as $key => $value){
                // Loop through .env-data
                foreach($env as $env_key => $env_value){
                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);
            return true;
        }
        return false;
    }
}
