<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
use Excel;
use Intervention\Image\ImageManagerStatic as Image;
use App\AlertTemplate;
class CoreController extends Controller {   
    
    function checkWebPortal(){
        return config('constants.WEB_PORTAL');
    }

    function fileUpload($file,$path,$original_name=0,$resize=0){
        $filename='';
        $full_path='public/'.$path;
        File::isDirectory($full_path) or File::makeDirectory($full_path, 0777, true, true);
        if($file!=''){
            if($original_name==1){
                $filename=$file->getClientOriginalName();                
            } else {
                $filename=md5($file->getClientOriginalName()).'_'.time().'.'.$file->getClientOriginalExtension();    
            }
            if($resize==1){
                switch($path){
                    case "uploads/_img":
                        $file->move($full_path, $filename);
                        break;
                    default:
                        $file->move($full_path, $filename);
                        break;
                }
            } else {
               $file->move($full_path, $filename); 
            }
        }       
        return $filename;   
    }

    function resizeImage($file,$path,$filename,$w,$h){
        $image_resize = Image::make($file->getRealPath());              
        $image_resize->resize($w, $h);
        $image_resize->save(public_path($path.'/'.$filename));
    }
    function unlinkImg($img,$path) {
        if($img !=null || $img !='')
        {
            $path='public/'.$path.'/';
            $image_path = app()->basePath($path.$img);
            if(File::exists($image_path)) 
                unlink($image_path);
        }       
    }

    function sendSms($templateId,$mobile,$data=null) {
        $settings = getSettings();
        if(isset($settings['sms_api_active']) && $settings['sms_api_active']==1){
            if(!isset($settings['sms_sender_id']) || !isset($settings['sms_api_key']) || !isset($settings['sms_api_url']) || !isset($settings['sms_api_username'])){
                return false;
            }
            $senderId = @$settings['sms_sender_id'];
            $apiKey = @$settings['sms_api_key'];
            $apiUrl = @$settings['sms_api_url'];
            $apiUsername = @$settings['sms_api_username'];

            $templateData = AlertTemplate::whereId($templateId)->first();
            $name = '';
            if(isset($data['name'])){
                if($data['name']!=''){
                    $name = $data['name'];
                }
            }
            $smsTxt = str_replace(['##NAME##'], [$name] , $templateData->template);   
            $message = urlencode($smsTxt);

            $send_url = $apiUrl."?username=".$apiUsername."&message=" .$message. "&sendername=" .$senderId. "&smstype=TRANS&numbers=" .$mobile. "&apikey=".$apiKey;
            $send_url = trim($send_url);
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $send_url
            ));
            $result=curl_exec ($ch);
            curl_close ($ch);
            return true;
        }
        return false;
   }
}