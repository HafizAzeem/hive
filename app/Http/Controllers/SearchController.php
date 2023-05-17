<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Auth,DB,Hash;
use App\User,App\Customer,App\Role;
use App\Room,App\RoomType;
use App\Amenities;
use App\FoodCategory,App\FoodItem;
use App\ExpenseCategory,App\Expense;
use App\Product,App\StockHistory;
use App\Reservation;
use App\Order,App\OrderItem,App\OrderHistory;
use App\Setting;
use App\PersonList;
use App\MediaFile;
use App\Permission;
use Mail;
use App\Mail\InvoiceEmail;
use Illuminate\Support\Str;
use App\UserLog;
use Excel;
use App\Http\Controllers\ExcelExport;
use Session;
use Validator;

use Carbon\Carbon;
use App\Paytm\PaytmChecksum;
use GuzzleHttp\Client;
use App\MealPlan;
use App\PackageMaster;
use App\DatePriceRange;
use App\PaymentMode;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        private $core;
     public function __construct()
    {
        $this->core=app(\App\Http\Controllers\CoreController::class);
        $this->middleware('auth');
    }
    
    
    public function index()
    {
        return view('backend.search');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
      public function newcheckin(Request $request, $mobile) {
          
          
       $this->data['data_row']=[];

        $this->data['roomtypes_list']=RoomType::select('id','title','is_base_price','base_price')->whereStatus(1)->whereIsDeleted(0)->orderBy('title','ASC')->pluck('title','id');
        $this->data['customer_list']=[];//getCustomerList();
        $this->data['getmid'] = Setting::where('name', 'mid')->select('value')->first();
        $this->data['corporates']=DB::table('corporates')->pluck('name');
        $this->data['tas']=DB::table('tas')->pluck('name');
        $this->data['ota']=DB::table('ota')->select('id','name')->get();
        $this->data['package_list']=PackageMaster::select('id','title', 'package_price', 'room_type_id')->whereStatus(1)->orderBy('id','DESC')->get();
        $this->data['mealplan_list']=MealPlan::select('id', 'name')->whereStatus(1)->orderBy('id','ASC')->pluck('name', 'id');
        $this->data['payment_mode_list']=PaymentMode::select('id', 'payment_mode')->whereStatus(1)->orderBy('id','ASC')->pluck('payment_mode', 'id');
        $this->data['arrivals_id'] = $request->id;
        $this->data['mobile'] = $mobile;
        return view('backend/rooms/newcheckin',$this->data);
    }
    
    public function newexistscheckin(Request $request) {
          
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://dashboard.f9hotels.com/api/getCustomerById',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('id'=>$request->id),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
      
        $c=json_decode($response);
        $this->data['data_row']=$c->customer;
        $this->data['booking']=$c->booking;
        
        $usermob = $this->data['data_row']->mobile;
        $useremail = $this->data['data_row']->email;
        $this->data['data_row_personal'] = Customer::where('mobile',$usermob)->orWhere('email',$useremail)->first();
        // print_r($this->data['data_row_personal']);
        
        $this->data['roomtypes_list']=RoomType::select('id','title','is_base_price','base_price')->whereStatus(1)->whereIsDeleted(0)->orderBy('title','ASC')->pluck('title','id');
        $this->data['customer_list']=[];//getCustomerList();
        $this->data['getmid'] = Setting::where('name', 'mid')->select('value')->first();
        $this->data['corporates']=DB::table('corporates')->pluck('name');
        $this->data['tas']=DB::table('tas')->pluck('name');
        //$this->data['ota']=DB::table('ota')->pluck('name');
        $this->data['ota']=DB::table('ota')->select('id','name')->get();
        $this->data['package_list']=PackageMaster::select('id','title', 'package_price', 'room_type_id')->whereStatus(1)->orderBy('id','DESC')->get();
        $this->data['mealplan_list']=MealPlan::select('id', 'name')->whereStatus(1)->orderBy('id','ASC')->pluck('name', 'id');
        $this->data['payment_mode_list']=PaymentMode::select('id', 'payment_mode')->whereStatus(1)->orderBy('id','ASC')->pluck('payment_mode', 'id');
        $this->data['arrivals_id'] = $request->id;
       
      
        
        return view('backend/rooms/newcheckin',$this->data);
    }
    
    public function myotaalldata(Request $request){
        $id = $request->id;
        //$selctoption = PaymentMode::where('otarelation',$id)->get();
        $selctoption = PaymentMode::whereIn('otarelation', [$id,1000, 2000, 3000, 4000])->get();
        return $selctoption;
    }
    
    // public function myotaalldata2(Request $request){
    //     $id2 = $request->id;
    //     $selctoption2 = PaymentMode::whereIn('otarelation', [$id2,1000, 2000, 3000, 4000])->get();
    //     return $selctoption2;
    // }
    
    public function myotaalldata3(Request $request){
        $id3 = $request->id;
        // $selctoption3 = PaymentMode::where('status', 1)->get();
        $selctoption3 = PaymentMode::whereIn('otarelation', [1000, 2000, 3000, 4000])->get();
        return $selctoption3;
    }
    
    
    public function mobotpnewchekin(Request $request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $mobile = $request->mobile;
        $otp = $request->otp;
        $fieldsnew = array(
            "variables_values" => $otp,
            "route" => "otp",
            "numbers" => $mobile,
        );
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($fieldsnew),
          CURLOPT_HTTPHEADER => array(
            "authorization: ndP9f2cztvZrow6QS0GHOI8jsmxaFplg7RyDB1VqMeXNK34LkYqxCSzR6w8hgbrk4QDlp91aiYcAjVoT",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));
        
        $response = json_decode(curl_exec($curl));
        // return $response;
        
        $customerData = [
            "mobile" => $request->mobile,
            "otp" => $request->otp
        ];
        
        $customerId = Customer::updateOrCreate(['mobile'=>$request->mobile],$customerData);
        
        if($customerId){
            return $customerId;
        }else{
            return $response;
        }
        
        // if($response->request_id != ""){
        //     $res = new Customer;
        //     $res->mobile = $mobile;
        //     $res->otp = $otp;
        //     $res->save();
        //     return $response->request_id;
        // }else{
        //     return $response;
        // }
        $err = curl_error($curl);
        curl_close($curl);
        // return $response->status_code;
    }
    
    public function verifyotpchekin(Request $request){
        $userotp = $request->enterotp;
        $usermob = $request->mobileno;
        // return $usermob;
        $data = Customer::where('mobile',$usermob)->where('otp',$userotp)->first();
        if($userotp == $data->otp){
            Customer::where('mobile', $usermob)->where('otp',$userotp)->update(['verifystatus'=> 1]);
            return true;
        }else{
            return false;
        }
    }
    
    public function skipotpcheckin(Request $request){
        $enterreason = $request->enterreason;
        $usermob = $request->mobileno;
        // return $usermob;
        
        $dataskip = Customer::where('mobile', $usermob)->update(['skipreason'=> $enterreason]);
        if($dataskip){
            return true;
        }else{
            return false;
        }
    }
    
     public function savecheckin(Request $request) {
           
        $data = $request->all();
        
        
        date_default_timezone_set('Asia/Kolkata');

        if($request->room_qty){
            $room_qty= $request->room_qty;
        }
        else{
            $room_qty=1;
        }
        $getmid = Setting::where('name', 'mid')->select('value')->first();
        $mid=$getmid->value+1;

        if(isset($request->document_upload)){
            $documentPath = $request->document_upload->store('public/files');
           
        }else{
            $documentPath = $request->document_id ?? '';
        }
   

        if($request->id>0){
            if($this->core->checkWebPortal()==0){
                return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
            }
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        }
        else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        
        $starttime=date('Y-m-d H:i:s',strtotime("12:00:00"));
        $starttime=date('H:i:s',strtotime($starttime));
        $endtime=date('Y-m-d H:i:s',strtotime("06:00:00"));
        $endtime=date('H:i:s',strtotime($endtime));
        $time = date("H:i:s");

        if($starttime > $time && $endtime > $time)
        {
            $todayDate=date('Y-m-d');
            $date=date('Y-m-d',strtotime($todayDate.'-1 days'));
            $datetime = $date ." ". $time;
            $checkoutdatatime=date('Y-m-d',strtotime($date.'+ '.$request->duration_of_stay.' days'));
            $paymentdate = $date;
            
        }else
        {
            $date=$request->check_in_date;
            $todayDate = Carbon::now();
            $datetime = $date ." ". $time;
            $checkoutdatatime=$todayDate->addDays($request->duration_of_stay); 
            $paymentdate=date('Y-m-d');
        }
        
        Carbon::useStrictMode(false);
        $to_date = Carbon::parse($checkoutdatatime);
        $from_date = Carbon::parse($datetime);
        $room = $request->per_room_price;
        $booking = $request->booking_payment;
        $reservationData = [];
        $customerData = [];

        if($request->referred_by_name == "F9" || $request->referred_by_name == "Management")
        {
            $spl = str_split($request->name);
            $Booking_id = $spl[0].$spl[1].rand(0000,9999);  
            
                //wallet
                
                 $email = $request->email;
                 $total_amount = $request->total_amount;
            //   print_r($total_amount);die;
        $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://demo.f9hotels.com/api/wallet_account',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('email' => $email,'amount' => $total_amount),
    ));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
        //end wallet
        }
        else
        {
            $Booking_id = "";
        }
        
        $dateOfBirth = dateConvert($request->age, 'Y-m-d');
        $years = Carbon::parse($dateOfBirth)->age;
        $custName = $request->name;
        $customerData = [
        "Booking_id" => $request->Booking_id ?? $Booking_id,
        "and_number" => $mid,
        "name" => $request->name,
        "father_name" => $request->father_name,
        "email" => $request->email,
        "mobile" => $request->mobile,
        "address" => $request->Address,
        "nationality" => $request->nationality,
        "country" => $request->country,
        "state" => $request->state,
        "city" => $request->city,
        "gender" => $request->gender,
        "dob" => dateConvert($request->age, 'Y-m-d'),
        "age" => $years,
        "password" => Hash::make($request->mobile),
        "document" =>   $documentPath,
       ];
        $customerId = Customer::updateOrCreate(['mobile'=>$request->mobile],$customerData);
      
        $hit['mobile']=$request->mobile;
        $hit['name']=$request->name;
        $hit['email']=$request->email;
        $hit['address']=$request->Address;
        $hit['dob']=dateConvert($request->age, 'Y-m-d');
      

        if($room == 'NaN')
        {
            $perroom = 0.00;
        }else
        {
            $perroom =  $room;
        }
        $room_count = count($request->room_num);
        if($request->ta)
        {
            $referred_by = $request->ta;
        }
        else if($request->ota)
        {
            $referred_by = $request->ota;
        }
        else if($request->corporate)
        {
            $referred_by = $request->corporate;
        }
        else{
            $referred_by = '';
        }
        if($room_count == 1)
        {
           
            $reservationData = [
                 "customer_id" => $customerId->id,
                 "booking_payment" => $booking,
                 'total_amount'=>$request->total_amount,
                 "room_qty" => $room_qty,
                 "unique_id"=>uniqid(),
                 "per_room_price" => $request->booking_payment,
                 "guest_type" => $request->guest_type,
                 "check_in" => $datetime,
                 "infant" => $request->infant,
                 "user_checkout" => $checkoutdatatime,
                 "duration_of_stay" => $request->duration_of_stay,
                 "Booking_Reason" => $request->Booking_Reason,
                 "room_type_id" => $request->room_type_id,
                 "room_num" => ($request->room_num) ? join(',',$request->room_num) : null,
                 "adult" => $request->adult,
                 "kids" => $request->kids,
                 "booked_by" => $request->booked_by,
                 "vehicle_number" => $request->vehicle_number,
                 "reason_visit_stay" => $request->reason_visit_stay,
                 "advance_payment" => $request->advance_payment,
                 "idcard_type" => $request->idcard_type,
                 "idcard_no" => $request->idcard_no,
                 "idcard_image" => $documentPath,
                 "payment_mode" =>$request->payment_mode,
                 "meal_plan" => $request->meal_plan,
                 "corporates" => $request->corporate,
                 "tas" => $request->ta,
                 "ota" => $request->ota,
                 "referred_by_name" => $request->referred_by_name,
                 "referred_by" => $referred_by,
                 "remark_amount" => $request->remark_amount,
                 "remark" => $request->remark,
                 "package_id" => $request->package_id,
                 "checkin_type" => 'single',
                 "Employee_Check_In_name" => Auth::user()->id,
                 'mid'=>$mid
                 
             ];
            if(!$request->id){
                $reservationData["created_at_checkin"] = $datetime;
            }
            $res = Reservation::updateOrCreate(['id'=>$request->id],$reservationData);
                $paytmParams["body"] = array(
                "clientId"             => "8e5a3jsp0hh7",
                "clientSecret"        => "xsW3fI3q45",
            );
                Setting::where('name', 'mid')->update(['value'=>$mid]);
           
                $history['payment']=$request->advance_payment ?? 0;
                $history['mode']=$request->payment_mode;
                $history['payment_date']=$paymentdate;
                $history['reservations_id']=$res->id;
                $history['remark']='Advance';
                DB::table("payment_history")->insert($history);
                //print_r($request->payment);die;
                
                 if($request->payment != null){
                    foreach($request->payment as $key => $value){
                         if($value > 0){
                            $r_id = $res->id;
                            $value1 = $value;
                            $today = $paymentdate;
                            $mode = $request->mode[$key];
                            $remark = $request->payment_remark[$key];
                            DB::table("payment_history")->insert(['reservations_id' => $r_id, 'payment' => $value1, 'payment_date' => $today, 'mode' => $mode,  'remark' => $remark]);
                         }
                    }
                 } 
                // 
            
                $hit['checkin']=$datetime;
                $hit['checkout']=$checkoutdatatime;
                $hit['payment']=$booking;
                $hit['adult']=$request->adult;
                $se=Setting::where('name','hotel_name')->first();
                $hit['hotel']=$se->value;
                $hit['room_number']=($request->room_num) ? join(',',$request->room_num) : null;
                $hit['nights']=$request->duration_of_stay;
                $hit['invoice_number']=$reservationData['unique_id'];
                $re=centralDataInsert($hit);
                $re1=centralDataInsertf9($hit);
                
                // dd($re);
        }
        elseif($room_count > 1)
        {
            $unique_id=uniqid();
          foreach($request->room_num as $rm_num)
          {
            // echo $customerId;die();
            $reservationData = [
                "customer_id" => $customerId->id,
                'unique_id'=>$unique_id,
                 "booking_payment" => $booking/$room_count,
                 'total_amount'=>$request->total_amount,
                 "per_room_price" => $request->booking_payment,
                 "room_qty" => $room_qty/$room_count,//$request->room_qty,
                 "guest_type" => $request->guest_type,
                 "check_in" => $datetime,
                 "Booking_Reason" => $request->Booking_Reason,
                 "user_checkout" => $checkoutdatatime,
                 "duration_of_stay" => $request->duration_of_stay,
                 "room_type_id" => $request->room_type_id,
                 "room_num" => $rm_num,
                 "adult" => $request->adult,
                 "infant" => $request->infant,
                 "kids" => $request->kids,
                 "booked_by" => $request->booked_by,
                 "vehicle_number" => $request->vehicle_number,
                 "reason_visit_stay" => $request->reason_visit_stay,
                 "advance_payment" => $request->advance_payment,
                 "sec_advance_payment" => $request->sec_advance_payment,
                 "sec_payment_mode" => $request->sec_payment_mode,
                 "idcard_type" => $request->idcard_type,
                 "idcard_no" => $request->idcard_no,
                 "idcard_image" => $documentPath,
                 "payment_mode" =>$request->payment_mode,
                 "meal_plan" => $request->meal_plan,
                 "corporates" => $request->corporate,
                 "tas" => $request->ta,
                 "ota" => $request->ota,
                 "referred_by_name" => $request->referred_by_name,
                 "referred_by" => $referred_by,
                 "remark_amount" => $request->remark_amount,
                 "remark" => $request->remark,
                 "package_id" => $request->package_id,
                 "checkin_type" => 'multiple',
                 "Employee_Check_In_name" => Auth::user()->id,
                 'mid'=>$mid
            ];
            if(!$request->id){
                $reservationData["created_at_checkin"] = $datetime;
            }
            $res = Reservation::updateOrCreate(['id'=>$request->id],$reservationData);
                    $paytmParams["body"] = array(
                "clientId"             => "8e5a3jsp0hh7",
                "clientSecret"        => "xsW3fI3q45",
            );
            Setting::where('name', 'mid')->update(['value'=>$mid]);
            
            $history['payment']=$request->advance_payment/$room_count ?? 0;
            $history['mode']=$request->payment_mode;
            $history['payment_date']=$paymentdate;
            $history['reservations_id']=$res->id;
            $history['remark']='Advance';
            
            DB::table("payment_history")->insert($history);
            
            if($request->payment != null){
                foreach($request->payment as $key => $value){
                     if($value > 0){
                        $r_id = $res->id;
                        $value1 = $value/$room_count;
                        $today = $paymentdate;
                        $mode = $request->mode[$key];
                        $remark = $request->payment_remark[$key];
                        DB::table("payment_history")->insert(['reservations_id' => $r_id, 'payment' => $value1, 'payment_date' => $today, 'mode' => $mode,  'remark' => $remark]);
                    }
                }
            } 
                 
            $hit['checkin']=$datetime;
            $hit['checkout']=$checkoutdatatime;
            $hit['payment']=$booking;
            $hit['adult']=$request->adult;
            $se=Setting::where('name','hotel_name')->first();
            $hit['hotel']=$se->value;
            $hit['room_number']=($request->room_num) ? join(',',$request->room_num) : null;
            $hit['nights']=$request->duration_of_stay;
            $hit['invoice_number']=$reservationData['unique_id'];
            $re=centralDataInsert($hit);
            $re1=centralDataInsertf9($hit);
        
          }
        }
        if($room_count !=1)
        {
            $idd = $res->id -1;
        }
        else
        {
            $idd = $res->id;
        }
        if($idd){

        $img = $request->id_cardno;
        for($c=0; $c < count($img); $c++){
        
        $img = $request->id_cardno;
        
        $folderPath = "public/uploads/id_cards/";
        
        $image_parts = explode(";base64,", $img[$c]);
        $image_type_aux = explode("image/", $image_parts[0] ?? '');
        $image_type = $image_type_aux[1] ?? '';
        
        $image_base64 = base64_decode($image_parts[1] ?? '');
        $fileName = uniqid() . '.png';
        
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);
        $idImages = [];
        
        $idImages[] = ['tbl_id'=>$res->id, 'file'=>$fileName];
                //}
                if(count($idImages)>0){
                    MediaFile::insert($idImages);
                }
            }

        $img = $request->id_cardno;
        $folderPath = "public/uploads/id_cards/";
        $image_parts = explode(";base64,", $img[0] ?? '');
        $image_type_aux = explode("image/", $image_parts[0] ?? '');
        $image_type = $image_type_aux[1] ?? '';
        $image_base64 = base64_decode($image_parts[1] ?? '');
        $fileNameFront = uniqid() . '.png';
        $file = $folderPath . $fileNameFront;
        file_put_contents($file, $image_base64);
        
        
        
        $folderPath = "public/uploads/id_cards/";
        $image_parts = explode(";base64,", $img[1] ?? '');
        $image_type_aux = explode("image/", $image_parts[0] ?? '');
        $image_type = $image_type_aux[1] ?? '';
        $image_base64 = base64_decode($image_parts[1] ?? '');
        $fileNameBack = uniqid() . '.png';
        $back = $folderPath . $fileNameBack;
        file_put_contents($back, $image_base64);

        $mediaData=array(
        'tbl_id'=>$res->id,
        'file'=>$fileNameFront,
        'cnic_back'=>$fileNameBack,
        
        );

        DB::table('media_files')->InsertGetId($mediaData);
        if(isset($request->persons_info['name'])){
    
            $personReqData = $request->persons_info;
    
            $personsData = [];
            
            foreach($personReqData['name'] as $k=>$val){
               
                if (!empty($personReqData['age'][$k]) && !empty($personReqData['gender'][$k]) )
                {
                    if(isset($request->document_upload) && !empty($personReqData['document_upload1'][$k]) ){
                        $documentPath = $personReqData['document_upload1'][$k]->store('public/files');
                    }else{
                        $documentPath = '';
                    }
    
                    if($val!=''){
                    $temp_id = session()->get('temp_id');
                    $image= DB::table('guest_cnic_images')->where('is_fetch',$temp_id)->orderBy('id', 'DESC')->first();
    
                    if(!isset($image->front) == 1)
                    {
                        $front = "";
                    }
                    else{
                        $front = $image->front;
                    }
    
                    if(!isset($image->back) == 1)
                    {
                        $back = "";
                    }
                    else
                    {
                        $back = $image->back;
                    }
    
    
    
    
                    $person_dateOfBirth = dateConvert($personReqData['age'][$k], 'Y-m-d');
                        $person_years = Carbon::parse($person_dateOfBirth)->age;
                    $personsData[] = [
                            'reservation_id'=>$idd,
                            'name'=>$val,
                            'gender'=>$personReqData['gender'][$k],
                            'age'=>$person_years,
                            'idcard_type'=>$personReqData['idcard_type'][$k],
                            'document'=>$documentPath,
                            'idcard_no'=>$personReqData['idcard_no'][$k],
                            'cnic_front'=>$front,
                            'cnic_back'=>$back,
                            'dob' => dateConvert($personReqData['age'][$k], 'Y-m-d'),
                        ];
    
                    //  $delete= DB::table('guest_cnic_images')->where('id',$image->id)->delete();
                    }
                }
            }
    
            if(count($personsData)>0){
                PersonList::insert($personsData);
            }
    
        }

    if(!$request->id && $request->mobile){
        $this->core->sendSms(1,$request->mobile,["name" => $custName]);
    }
                $starttime=date('Y-m-d H:i:s',strtotime("12:00:00"));
                $starttime=date('H:i:s',strtotime($starttime));
                $endtime=date('Y-m-d H:i:s',strtotime("06:00:00"));
                $endtime=date('H:i:s',strtotime($endtime));
                $time = date("H:i:s");
                $today_checkin_timenew = date('Y-m-d');
                if($starttime > $time && $endtime > $time)
                {
                    $today_checkin_timenew = date('Y-m-d',strtotime($today_checkin_timenew.'-1 days'));
                }else{
                    $today_checkin_timenew = $today_checkin_timenew;
                }
                
                $controoms = DB::select("SELECT COUNT(*) as noOfContinue FROM reservations WHERE check_out IS NULL and is_deleted='0' and status='1' and room_num != '' and date(check_in) != '$today_checkin_timenew'");
                $noofrooms = $controoms[0]->noOfContinue;
                $controoms_new = DB::select("SELECT COUNT(*) as noOfContinuetodaycheckout FROM reservations WHERE date(check_out) = '$today_checkin_timenew' and is_deleted='0' and status='1' and room_num != '' and date(check_in) != '$today_checkin_timenew'");
                $noofrooms_new = $controoms_new[0]->noOfContinuetodaycheckout;
                $today_room_count_query =  DB::select("SELECT * FROM reservations WHERE DATE(`created_at_checkin`) = '$today_checkin_timenew'");
                $today_room_count_add = count($today_room_count_query);
                $noofrooms = $noofrooms + $noofrooms_new + $today_room_count_add;
                DB::delete("DELETE FROM continue_rooms WHERE DATE(created_at) = DATE('$today_checkin_timenew') ");
                $today_checkin_timenew = date("$today_checkin_timenew H:i:s");
                DB::insert("INSERT INTO continue_rooms(no_of_rooms,created_at)VALUES($noofrooms,'$today_checkin_timenew')"); 
        
                // $controoms = DB::select("SELECT COUNT(*) as noOfContinue FROM reservations WHERE check_out IS NULL and is_deleted='0' and status='1' and room_num != '' and date(check_in) != '$today_checkin_timenew'");
                // $noofrooms = $controoms[0]->noOfContinue;
                // $today_room_count_query =  DB::select("SELECT * FROM reservations WHERE DATE(`created_at_checkin`) = '$today_checkin_timenew'");
                // $today_room_count_add = count($today_room_count_query);
                // $noofrooms = $noofrooms + $today_room_count_add;
                // DB::delete("DELETE FROM continue_rooms WHERE DATE(created_at) = DATE('$today_checkin_timenew') ");
                // DB::insert("INSERT INTO continue_rooms(no_of_rooms)VALUES($noofrooms)");   
    
    //   $now = date('Y-m-d');
    //   $controoms = DB::select("SELECT COUNT(*) as noOfContinue FROM reservations WHERE check_out IS NULL and is_deleted='0' and status='1' and room_num != ''");
    //   $noofrooms = $controoms[0]->noOfContinue;
    //   DB::delete("DELETE FROM continue_rooms WHERE DATE(created_at) = DATE('$now') ");
    //   DB::insert("INSERT INTO continue_rooms(no_of_rooms)VALUES($noofrooms)");
      
      
        //new code
      $detail=  DB::table('hotels_room_light')->select('light_on')->where('room_no',$request->room_num)->first();
    //   print_r($detail->light_on);die;
    
// https://maker.ifttt.com/trigger/NG121_608_MS_ON/with/key/cCCBs5uLNQJDGkDH-65yXr
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://maker.ifttt.com/trigger/{{$detail->light_on}}/with/key/cCCBs5uLNQJDGkDH-65yXr',
//   CURLOPT_URL => 'https://maker.ifttt.com/trigger/NG121_608_MS_ON/with/key/cCCBs5uLNQJDGkDH-65yXr',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
));

$response = curl_exec($curl);

curl_close($curl);


        //end new code
        
         //wallet
        $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://demo.f9hotels.com/api/wallet_account',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('email' => 'ravi.srivastav@corewebconnections.com','amount' => '1200'),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
        //end wallet
      
      
    return redirect('admin/search')->with(['success' => $success]);
   //return redirect()->back()->with(['success' => $success]);
}
return redirect()->back()->with(['error' => $error]);
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
