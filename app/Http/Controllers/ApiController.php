<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use DB;
use Carbon\Carbon;
use App\Customer,App\Role;
use App\Reservation;
use App\Room;
use Illuminate\Support\Facades\Hash;
class ApiController extends Controller
{
    //
    public function getCheckinDetails(Request $request)
    {
     $room_number=$request->room_number;
     
     $r=DB::table('reservations')->where('room_num',$room_number)->first();
     if($r)
     {
     $c=DB::table('customers')->where('id',$r->customer_id)->first();         
     $array['roomDetails']['roomId']=$r->room_num;
     $array['roomDetails']['roomNo']=$r->room_num;
     $array['roomDetails']['propertyCode']=1;
     $array['roomDetails']['checkInDate']=$r->check_in;
     $array['roomDetails']['checkOutDate']=$r->check_out;
     $array['roomDetails']['bookingId']=$r->unique_id;
     $array['roomDetails']['status']="CHECK_IN";
     $array['roomDetails']['noOfGuests']['total']=$r->adult ?? 0 + $r->kids ?? 0;
     $array['roomDetails']['noOfGuests']['Adults']=$r->adult ?? 0;
     $array['roomDetails']['noOfGuests']['Children']=$r->kids ?? 0;
     
     $array['roomDetails']['rateCode']='';
     $array['roomDetails']['remark']='';
     $array['roomDetails']['package']='';
     $array['roomDetails']['billingInstruction']='';
     $array['roomDetails']['onlineOrderPref']['payNow']=true;
     $array['roomDetails']['onlineOrderPref']['payAtCheckout']=false;
     
     $array['roomDetails']['guestDetails']['guestId']='';
     $array['roomDetails']['guestDetails']['firstName']=$c->name;
     $array['roomDetails']['guestDetails']['middleName']='';
     $array['roomDetails']['guestDetails']['lastName']='';
     $array['roomDetails']['guestDetails']['gender']=$c->gender;
     $array['roomDetails']['guestDetails']['email']=$c->email;
     $array['roomDetails']['guestDetails']['mobile']=$c->mobile;
     $array['roomDetails']['guestDetails']['nationality']='';
     $array['roomDetails']['guestDetails']['homeCountry']=''; 
     return response()->json(['data'=>$array,'status'=>true],200);
     }else
     {
         return response()->json(['data'=>[],'status'=>false],500);
     }
    }
    
    public function emailLogin(Request $request)
    {
        
        $email=$request->email;
        $password=$request->password;
         
        $user=User::where('email',$email)->first();
         
         if(!empty($user))
         {
             if(Hash::check($password,$user->password))
             {
             return response()->json(['message'=>'valid user','data'=>$user],200);
             }else
             {
               return response()->json(['message'=>'invalid user','data'=>[]],500);  
             }
         }else
         {
             return response()->json(['message'=>'invalid user','data'=>[]],500);
         }
        
    }
    
    
    
    
//     public function newchecking(Request $request)
//     {
//       $date=$request->check_in_date; 
//       $todayDate = Carbon::now();
// $checkoutdatatime=$todayDate->addDays($request->duration_of_stay);
// $time = date("H:i:s");
// $datetime = $date ." ". $time;
// Carbon::useStrictMode(false);
// $to_date = Carbon::parse($checkoutdatatime);
// $from_date = Carbon::parse($datetime);
// $room = $request->per_room_price;
// $booking = $request->booking_payment;
// if(isset($request->document_upload)){
//         $documentPath = $request->document_upload->store('public/files');
       
//     }else{
//         $documentPath = $request->document_id ?? '';
//     }
// if($request->customer_id){
//     $customer_id=$request->customer_id;
//     $custData = Customer::whereId($customer_id)->first();
//     $custName = $custData->name;
//     $customerId = $customer_id;
// }else
// {
//         $dateOfBirth = dateConvert($request->age, 'Y-m-d');
//         $years = Carbon::parse($dateOfBirth)->age;
//         $custName = $request->name;
//         $customerData = [
//         "Booking_id" => $request->name.rand(0000,9999),
//         "name" => $request->name,
//         "father_name" => $request->father_name,
//         "email" => $request->email,
//         "mobile" => $request->mobile,
//         "address" => $request->Address,
//         "nationality" => $request->nationality,
//         "country" => $request->country,
//         "state" => $request->state,
//         "city" => $request->city,
//         "gender" => $request->gender,
//         "dob" => dateConvert($request->age, 'Y-m-d'),
//         "age" => $years,
//         "password" => Hash::make($request->mobile),
//         "document" =>   $documentPath,
//       ];
//       $customerId = Customer::insertGetId($customerData);
// }


//       $reservationData = [
//         "customer_id" => $customerId,
//          "booking_payment" => $booking,
//          "room_qty" => 1,
//          "unique_id"=>uniqid(),
//          "per_room_price" => $request->booking_payment,
//          "guest_type" => $request->guest_type,
//          "check_in" => $datetime,
//          "infant" => $request->infant ?? 0,
//          "user_checkout" => $checkoutdatatime,
//          "duration_of_stay" => $request->duration_of_stay,
//          "Booking_Reason" => $request->Booking_Reason,
//          "room_type_id" => $request->room_type_id,
//          "room_num" => $request->room_num,
//          "adult" => $request->adult,
//          "kids" => $request->kids,
//          "booked_by" => $request->booked_by,
//          "vehicle_number" => $request->vehicle_number,
//          "reason_visit_stay" => $request->reason_visit_stay,
//          "advance_payment" => $request->advance_payment,
//          "idcard_type" => $request->idcard_type,
//          "idcard_no" => $request->idcard_no,
//          "idcard_image" => $documentPath,
//          "payment_mode" =>$request->payment_mode,
//          "meal_plan" => $request->meal_plan,
//          "corporates" => $request->corporate,
//          "tas" => $request->ta,
//          "ota" => $request->ota,
//          "referred_by_name" => $request->referred_by_name,
//          "referred_by" => '',
//          "remark_amount" => $request->remark_amount,
//          "remark" => $request->remark,
//          "package_id" => $request->package_id ?? '',
//          "checkin_type" => 'single',
//          "Employee_Check_In_name" => ''
         
//      ];
//      if(!$request->id){
//         $reservationData["created_at_checkin"] = date('Y-m-d H:i:s');
//     }
//     $res = Reservation::updateOrCreate(['id'=>$request->id],$reservationData);
//         $paytmParams["body"] = array(
//         "clientId"             => "8e5a3jsp0hh7",
//         "clientSecret"        => "xsW3fI3q45",
//     );
    
   
//         $history['payment']=$request->advance_payment ?? 0;
//         $history['mode']=$request->payment_mode;
//         $history['payment_date']=date('Y-m-d');
//         $history['reservations_id']=$res->id;
//     DB::table("payment_history")->insert($history);
//  return response()->json(['status'=>200,'message'=>'Booking Confirm','data'=>$request->all()],200);
//     }
    //new code start 8-2-2022
    public function newchecking(Request $request)
    {   
        if($request->room_qty){
            $room_qty= $request->room_qty;
        }
        else{
            $room_qty=1;
        }
        
       // $date=$request->check_in_date; 
        $date = dateConvert($request->check_in_date, 'Y-m-d');
        
        $todayDate = Carbon::now();
        $checkoutdatatime=$todayDate->addDays($request->duration_of_stay);
        $time = date("H:i:s");
        $datetime = $date ." ". $time;
        Carbon::useStrictMode(false);
        $to_date = Carbon::parse($checkoutdatatime);
        $from_date = Carbon::parse($datetime);
        $room = $request->per_room_price;
        $booking = $request->booking_payment;
            if(isset($request->document_upload)){
                $documentPath = $request->document_upload->store('public/files');
            }else{
                $documentPath = $request->document_id ?? '';
            }
            if($request->customer_id){
                $customer_id=$request->customer_id;
                $custData = Customer::whereId($customer_id)->first();
                $custName = $custData->name;
                $customerId = $customer_id;
            }
            else
            {
                $dateOfBirth = dateConvert($request->age, 'Y-m-d');
                $years = Carbon::parse($dateOfBirth)->age;
                $custName = $request->name;
                $customerData = [
                "Booking_id" => $request->name.rand(0000,9999),
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
                $customerId = Customer::insertGetId($customerData);
            }

        $hello = $request->room_num;
        $jc = explode(",",$hello);
        $room_count = count($jc);
       
        if($room_count == 1){
            $reservationData = [
            "customer_id" => $customerId,
            "booking_payment" => $booking,
            "room_qty" => 1,
            "unique_id"=>uniqid(),
            "per_room_price" => $request->booking_payment,
            'total_amount'=>$request->total_amount,
            "guest_type" => $request->guest_type,
            "check_in" => $datetime,
            "infant" => $request->infant ?? 0,
            "user_checkout" => $checkoutdatatime,
            "duration_of_stay" => $request->duration_of_stay,
            "Booking_Reason" => $request->Booking_Reason,
            "room_type_id" => $request->room_type_id,
            "room_num" => $request->room_num,
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
            "referred_by" => '',
            "remark_amount" => $request->remark_amount,
            "remark" => $request->remark,
            "package_id" => $request->package_id ?? '',
            "checkin_type" => 'single',
            "Employee_Check_In_name" => ''
        ];
        
            if(!$request->id){
                $reservationData["created_at_checkin"] = date('Y-m-d H:i:s');
            }
            $res = Reservation::updateOrCreate(['id'=>$request->id],$reservationData);
            $paytmParams["body"] = array(
                "clientId"             => "8e5a3jsp0hh7",
                "clientSecret"        => "xsW3fI3q45",
            );
    
            $history['payment']=$request->advance_payment ?? 0;
            $history['mode']=$request->payment_mode;
            $history['payment_date']=date('Y-m-d');
            $history['reservations_id']=$res->id;
            $history['remark']='Advance';
            DB::table("payment_history")->insert($history);
        }
        elseif($room_count > 1)
        {
            $unique_id=uniqid();
            foreach($jc as $rm_num)
            {
                //print_r($rm_num);die;
                $reservationData = [
                    "customer_id" => $customerId,
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
                    "referred_by" => '',
                    "remark_amount" => $request->remark_amount,
                    "remark" => $request->remark,
                    "package_id" => $request->package_id,
                    "checkin_type" => 'multiple',
                    "Employee_Check_In_name" => '',
                ];
                if(!$request->id){
                    $reservationData["created_at_checkin"] = date('Y-m-d H:i:s');
                }
                $res = Reservation::updateOrCreate(['id'=>$request->id],$reservationData);
                $paytmParams["body"] = array(
                    "clientId"             => "8e5a3jsp0hh7",
                    "clientSecret"        => "xsW3fI3q45",
                );
                //Setting::where('name', 'mid')->update(['value'=>$mid]);
                
                $history['payment']=$request->advance_payment/$room_count ?? 0;
                $history['mode']=$request->payment_mode;
                $history['payment_date']=date('Y-m-d');
                $history['reservations_id']=$res->id;
                $history['remark']='Advance';
                
                DB::table("payment_history")->insert($history);
            
            }
        }
        return response()->json(['status'=>200,'message'=>'Booking Confirm','data'=>$request->all()],200);
    }
    //new code end 8-2-2022
    
    public function roomInfo($hotel_id,$room_num)
    {
       
        $res['room_info']=DB::table('rooms')
        ->join('room_types','room_types.id','=','rooms.room_type_id')
        ->select('rooms.room_no','rooms.floor','rooms.reason','rooms.maintinance','room_types.title','room_types.short_code','room_types.adult_capacity','room_types.kids_capacity','room_types.base_price')
        ->where('room_types.is_deleted','0')
        ->where('rooms.room_no',$room_num)
        ->get();
        
          $res['booking_info']=DB::table('rooms')
         ->join('reservations','reservations.room_num','rooms.room_no')
         ->join('customers','customers.id','reservations.customer_id')
         ->select('reservations.id as bookingId','customers.name','customers.email','customers.mobile','customers.address','reservations.room_num','reservations.per_room_price','reservations.check_in','reservations.check_out','reservations.duration_of_stay','reservations.adult','reservations.kids')
         ->where('rooms.room_no',$room_num)
         ->get();
        
        if(count($res)>0)
        {
            return response()->json(['status'=>200,'data'=>$res],200);
        }else
        {
           return response()->json(['status'=>500,'data'=>[]],500); 
        }
        
        
    }

    public function billInfo($bookingId)
    {
       
        $res=DB::table('order_items')
        ->where('reservation_id',$bookingId)
        ->select('order_items.reservation_id as bookingId','order_items.item_name','order_items.item_price','order_items.item_qty','order_items.created_at')
        ->get();
        
        if(count($res)>0)
        {
            return response()->json(['status'=>200,'data'=>$res],200);
        }else
        {
           return response()->json(['status'=>500,'data'=>[]],500); 
        }
        
        
    }
   
      public function billsave(Request $request)
      {
         
         //dd($request->all());
         $data['reservation_id']=$request->bookingId;
         $data['total_amount']=$request->total_amount;
         $data['gst_apply']=$request->gst_apply;
         $data['gst_perc']=$request->gst_perc;
         $data['gst_amount']=$request->gst_amount;
         $data['cgst_perc']=$request->cgst_perc;
         $data['cgst_amount']=$request->sgst_perc;
         $data['discount']=$request->discount;
         DB::table('orders')->insert($data);
         foreach($request->item as $i)
         {
             $insert['item_name']=$i['item_name'];
             $insert['item_price']=$i['item_price'];
             $insert['item_price']=$i['item_qty'];
             $insert['status']=$i['status'];
             DB::table('order_items')->insert($insert);
         }
       
        return response()->json(['status'=>200,'message'=>'Successfully Saved'],200);
        
        
        
          
      }
      
    public function search(Request $request)
    {
        $data=Customer::select(DB::raw("CONCAT(customers.name,'-',customers.mobile,'-',customers.id) as name",""),"mobile","id")
        ->where("name","LIKE","%{$request->input('query')}%")
        ->orWhere( "mobile","LIKE","%{$request->input('query')}%")
        ->get();
        
        if(count($data)>0)
        {
            return response()->json(['status'=>200,'data'=>$data],200);
        }else
        {
           return response()->json(['status'=>500,'data'=>[]],500); 
        }
    }
    
    
    public function paymentMode(Request $request)
    {
        $data=DB::table('payment_mode')->get();
        if(count($data)>0)
        {
            return response()->json(['status'=>200,'data'=>$data],200);
        }else
        {
           return response()->json(['status'=>500,'data'=>[]],500); 
        }
    }
    
    public function roomType(Request $request)
    {
        $data=DB::table('room_types')->get();
        if(count($data)>0)
        {
            return response()->json(['status'=>200,'data'=>$data],200);
        }else
        {
           return response()->json(['status'=>500,'data'=>[]],500); 
        }
    }
    
    
    public function getRoom(Request $request)
    {
       
        $checkin_date = date('Y-m-d');//$request->checkin_date;
        $bookedRooms = [];
        $undermaintinance = [];
        $dirtyRooms= [];
        $reservationData = Reservation::whereStatus(1)->whereIsDeleted(0)->orderBy('room_num','ASC')->select('room_num','check_in','check_out','referred_by_name','user_checkout','id')->get();

        if($reservationData->count()>0){
            foreach($reservationData as $val){
                $exp = explode(',', $val->room_num);
                $count = count($exp);
                if( date('Y-m-d',strtotime($val->user_checkout)) == $checkin_date || ($val->check_out == null))
                {
                    if($val->check_out == null)
                    {
                        for($i=0; $i<$count; $i++)
                        {
                            $bookedRooms[$exp[$i]] = $exp[$i];
                        }
                    }
                    else
                    {
                        for($i=0; $i<$count; $i++)
                        {
                            $dirtyRooms[$exp[$i]] = $exp[$i];
                        }
                    }
                }
                if($val->check_out != null)
                {
                    for($i=0; $i<$count; $i++)
                        {
                            $dirtyRooms[$exp[$i]] = $exp[$i];
                        }
                }
               
            }
        }
        
        $this->data['booked_rooms'] = $bookedRooms;
        $this->data['dirty_rooms'] = $dirtyRooms;
        $resrvation = Room::whereStatus(1)->whereIsDeleted(0)->where(['room_type_id'=>$request->id])->orderBy('room_no','ASC')->get();
      
        $k=1;
        $newRoomd=[];
        foreach($resrvation as $r)
        {
            $newRoomd[$k]=$r['room_no'];
            $k++;
        }
      
       
        
        $reservationData2=Room::whereStatus(1)->whereIsDeleted(0)->where(['maintinance' =>1])->orderBy('room_no','ASC')->pluck('room_no','id');
        if($reservationData2->count()>0){
            foreach($reservationData2 as $val){
                $exp = explode(',', $val);
                $count = count($exp);
                for($i=0; $i<$count; $i++){
                    $undermaintinance[$exp[$i]] = $exp[$i];
                }
            }
        }
        $this->data['undermaintinance'] =$undermaintinance;
        $newList=array_diff($newRoomd,$bookedRooms);
        $this->data['rooms']=array_diff($newList,$undermaintinance);
         return response()->json(['status'=>200,'data'=>$this->data],200);
    }
    
      public function referred_by(Request $request)
      {
         $constants[]=config('constants.REFERRED_BY_NAME');
           return response()->json(['status'=>200,'data'=>$constants],200);
      }
      
      public function referred_by_data(Request $request)
      {
           $data=[];
          if($request->key=='OTA')
          {
              $data=DB::table('ota')->get();
              
          }
          if($request->key=='TA')
          {
              $data=DB::table('tas')->get();
          }
          
          if($request->key=='Corporate')
          {
              $data=DB::table('corporates')->get();
          }
          
    
           return response()->json(['status'=>200,'data'=>$data],200);
      }
    
    
    
    public function f9alist(Request $request){
        
          $amount = $request->amount;
          $bookingdetailurl=$request->invoice;
          $customerData = [
                "name" => $request->firstname,
                "Booking_id" => $request->booking_id,
                "father_name" => "",
                "email" => $request->email,
                "mobile" => $request->mobile,
                "address" => "",
                "nationality" => "",
                "country" => "",
                "state" => "",
                "city" => "",
                "gender" => "",
                "dob" => "",
                "age" => "",
                "password" => Hash::make($request->mobile),
            ];
           
         
            $customerId =DB::table('customers')->insertGetId($customerData);
            
           
            $date=$request->checkin;
            $checkoutdate=$request->checkout;
            $time = date("H:i:s");
            $datetime = $date ." ". $time;
            $checkoutdatatime = $checkoutdate ." ". $time;
            Carbon::useStrictMode(false);
            $to_date = Carbon::parse($checkoutdatatime);
            $from_date = Carbon::parse($datetime);
            $answer_in_days = $to_date->diffInDays($from_date);
            $check_in_day = date('l', strtotime($date));
            if($check_in_day == 'Saturday' &&  $check_in_day == 'Sunday')
            {
                $is_weekend = '1';
            }
            else{
                $is_weekend = '0';
            }
         $data= DB::table('arrivals')->insert([
                "customer_id" => $customerId,
                "check_in" => $datetime,
                "check_out" => $checkoutdatatime,
                "duration_of_stay" => $answer_in_days,
                "adult" => "",
                "kids" => "",
                "infant" => "",
                "Booking_Reason" => "",
                "vehicle_number" => "",
                "corporates" => "",
                "tas" => "",
                "ota" => "",
                "referred_by_name" =>"F9hotels",
                "room_type_id" => $request->room_id,
                "room_num" => "",
                "room_qty" => "",
                "package_id" => "",
                "check_in_day" => $check_in_day,
                "is_weekend" => $is_weekend,
                "payment" =>$amount,
                "payment_mode"=>"cash",
                "bookingdetailurl"=>$bookingdetailurl
              ]);
              return response()->json(['status'=>200,'data'=>$data],200);
    }
     
   
    
}
