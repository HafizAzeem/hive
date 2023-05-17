<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth,Hash,Artisan,DB;
use App\Room,App\RoomType;
use App\Reservation;
use App\DatePriceRange;
use Carbon\Carbon;
use Validator;
use App\PaymentMode;
class AjaxController extends Controller
{
    public $data=[];
    // public function getRoomNumList(Request $request){
    //     $checkin_date = $request->checkin_date;
    //     $bookedRooms = [];
    //     $undermaintinance = [];
    //     $dirtyRooms= [];
    //     $reservationData = Reservation::whereStatus(1)->whereIsDeleted(0)->whereNull('check_out')->where('check_in', '<=', DATE($checkin_date))->where('user_checkout', '>', DATE($checkin_date))->orderBy('created_at','DESC')->select('room_num','check_in','check_out','referred_by_name','user_checkout','id')->get();
    //     // $reservationData = Reservation::whereStatus(1)->whereIsDeleted(0)->whereNull('check_out')->orderBy('created_at','DESC')->select('room_num','check_in','check_out','referred_by_name','user_checkout','id')->get();
    //     if($reservationData->count()>0){
    //         foreach($reservationData as $val){
    //             $exp = explode(',', $val->room_num);
    //             $count = count($exp);
    //             if( date('Y-m-d',strtotime($val->user_checkout)) == $checkin_date || ($val->check_out == null))
    //             {
    //                 if($val->check_out == null)
    //                 {
    //                     for($i=0; $i<$count; $i++)
    //                     {
    //                         $bookedRooms[$exp[$i]] = $exp[$i];
    //                     }
    //                 }
    //                 else
    //                 {
    //                     for($i=0; $i<$count; $i++)
    //                     {
    //                         $dirtyRooms[$exp[$i]] = $exp[$i];
    //                     }
    //                 }
    //             }
    //             if($val->check_out != null)
    //             {
    //                 for($i=0; $i<$count; $i++)
    //                     {
    //                         $dirtyRooms[$exp[$i]] = $exp[$i];
    //                     }
    //             }
    //             // for($i=0; $i<$count; $i++){
    //             //     $bookedRooms[$exp[$i]] = $exp[$i];
    //             // }
    //         }
    //     }
    //     $this->data['booked_rooms'] = $bookedRooms;
    //     $this->data['dirty_rooms'] = $dirtyRooms;
    //     $this->data['rooms'] = Room::whereStatus(1)->whereIsDeleted(0)->where(['room_type_id'=>$request->room_type_id])->orderBy('room_no','ASC')->pluck('room_no','id');
    //     $reservationData2=Room::whereStatus(1)->whereIsDeleted(0)->where(['maintinance' =>1])->orderBy('room_no','ASC')->pluck('room_no','id');
    //     if($reservationData2->count()>0){
    //         foreach($reservationData2 as $val){
    //             $exp = explode(',', $val);
    //             $count = count($exp);
    //             for($i=0; $i<$count; $i++){
    //                 $undermaintinance[$exp[$i]] = $exp[$i];
    //             }
    //         }
    //     }
    //     $this->data['undermaintinance'] =$undermaintinance;
    //     return response($this->data);
    // }
    public function getRoomNumList(Request $request){
        $checkin_date = $request->checkin_date;
        $bookedRooms = [];
        $undermaintinance = [];
        $dirtyRooms= [];
        // $reservationData = Reservation::whereStatus(1)->whereIsDeleted(0)->whereNull('check_out')->where('check_in', '<=', DATE($checkin_date))->where('user_checkout', '>', DATE($checkin_date))->orderBy('created_at','DESC')->pluck('room_num','id');
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
                // for($i=0; $i<$count; $i++){
                //     $bookedRooms[$exp[$i]] = $exp[$i];
                // }
            }
        }
        // print_r($bookedRooms);die();
        $this->data['booked_rooms'] = $bookedRooms;
        $this->data['dirty_rooms'] = $dirtyRooms;
        // $this->data['rooms'] = Room::whereStatus(1)->whereIsDeleted(0)->where(['room_type_id'=>$request->room_type_id])->select('room_no','id')->orderBy('room_no','ASC')->get();
        $this->data['rooms'] = Room::whereStatus(1)->whereIsDeleted(0)->where(['room_type_id'=>$request->room_type_id])->orderBy('room_no','ASC')->pluck('room_no','id');
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
        return response($this->data);
    }
    
    public function mob(Request $request)
    {
        $mob = DB::table('customers')->where('mobile','LIKE','%'.$request->mob.'%')->pluck('mobile');
        return  $mob;
    
    }
    
    public function checkin_getRoomNumList(Request $request){
        $checkin_date = $request->checkin_date;
        $bookedRooms = [];
        $undermaintinance = [];
        $dirtyRooms= [];
        // $reservationData = Reservation::whereStatus(1)->whereIsDeleted(0)->whereNull('check_out')->where('check_in', '<=', DATE($checkin_date))->where('user_checkout', '>', DATE($checkin_date))->orderBy('created_at','DESC')->pluck('room_num','id');
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
                // for($i=0; $i<$count; $i++){
                //     $bookedRooms[$exp[$i]] = $exp[$i];
                // }
            }
        }
        // print_r($bookedRooms);die();
        $this->data['booked_rooms'] = $bookedRooms;
        $this->data['dirty_rooms'] = $dirtyRooms;
        // $this->data['rooms'] = Room::whereStatus(1)->whereIsDeleted(0)->where(['room_type_id'=>$request->room_type_id])->select('room_no','id')->orderBy('room_no','ASC')->get();
        $this->data['rooms'] = Room::whereStatus(1)->whereIsDeleted(0)->where(['room_type_id'=>$request->room_type_id])->orderBy('room_no','ASC')->pluck('room_no','id');
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
        return response($this->data);
    }
    public function getRoomDetails(Request $request){
        $this->data['rooms'] = Room::whereIn('id',$request->room_ids)->get();
        return response()->json($this->data['rooms']);
    }
    public function cleanCache(){
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        DB::unprepared(file_get_contents('database/hotel_mgmt.sql'));
        return response(['status'=>1]);
    }
    public function getDailyReport(Request $request)
    {
        $auth_token = 'Xcvvfghj@1234$$$@WERtuv12';
        if ($auth_token == $request->auth_token)
        {
            $daily_report = DB::table('daily_report')->get();
            $response = [
                "status"=> true,
                "msg" => "Report data",
                "data" => $daily_report
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                "status" => false,
                "msg" => "Authentication failed",
                "data" => ""
            ];
            return response()->json($response);
        }
    }
    public function getRoomPrice(Request $request)
    {
        $checkin_date = $request->checkin_date;
        $date_price = DatePriceRange::where('start_date', '<=', $checkin_date)->where('end_date', '>=', $checkin_date)->select('date_price AS final_price')->latest('created_at')->first();
        if($date_price)
        {
            return response()->json($date_price);
        }
        else{
            $checkin_day = date('l',strtotime($checkin_date));
            $room_type_id = $request->room_type_id;
            if($checkin_day == 'Saturday' &&  $check_in_day == 'Sunday')
            {
                $is_weekend = '1';
                $week_price = RoomType::where('id', $room_type_id)->where('status', 1)->select('base_price_weekends AS final_price')->first();
            }
            else{
                $is_weekend = '0';
                $week_price = RoomType::where('id', $room_type_id)->where('status', 1)->select('base_price AS final_price')->first();
            }
            return response()->json($week_price);

        }

    }
    public function getFilteredReportData(Request $request)
    {
        $sort_date = $request->sortDate;
        $data = [];
        $paymentmode_list=PaymentMode::where('status', 1)->get();
        $arr = array();
        if($request->source == 'date')
        {
            $date = $request->sortDate;
            array_push($arr, $date);

            $noShow = DB::table('arrivals')->whereDate('check_out', '>=', $sort_date)->count();
            array_push($arr, $noShow);

            $police = DB::table('reservations')->whereDate('referred_by_name', 'Management')->whereDate('check_in','>=',$sort_date)->count();
            array_push($arr, $police);

            $fit_count = DB::table('reservations')->where('referred_by_name', 'FIT')->where('created_at_checkin','>=', $sort_date)->count();
            array_push($arr, $fit_count);

            $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  `created_at_checkout` >= DATE('$sort_date') "));
            $total_check_out = $total_check_out_arr[0]->total_check_out;
            array_push($arr, $total_check_out);

            $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  `created_at_checkin` >= DATE('$sort_date') "));
            $total_check_ins = $total_check_ins_arr[0]->total_check_ins;
            array_push($arr, $total_check_ins);

            $room_count = DB::table('rooms')->where('is_deleted', '0')->where('status', '1')->count();
            array_push($arr, $room_count);

            $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->where('created_at_checkin', '>=' ,$sort_date)->count();
            array_push($arr, $occupied_rooms);

            $user_count = DB::table('users')->where('status', '1')->count();
            array_push($arr, $user_count);

            $Continue_check_out = DB::select(DB::raw("SELECT COUNT(*) as check_out FROM reservations WHERE `created_at_checkout` IS NULL"));
            $Continue1 =$Continue_check_out[0]->check_out;
            array_push($arr, $Continue1);

            // $comming = DB::table('reservations')->where('user_checkout', "DATE_ADD(DATE('$sort_date'), INTERVAL 1 DAY)")->count();
            // array_push($arr, $comming);

           // $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and `created_at_checkin` >= DATE('$sort_date')"));
          //  $total_checkin_arr=DB::select("select sum(payment) as total_payment from payment_history where payment_date=DATE('$sort_date')");
           $total_checkin_arr = DB::select(DB::raw("select sum(payment) as tot_advanve_payment from payment_history where payment_date='$sort_date'"));
            $total_checkin_amount = $total_checkin_arr[0]->total_payment;
        //     $total_checkout_arr = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) as tot_payable_payment  FROM reservations WHERE booking_payment and DATE(`check_out`) = DATE('$sort_date')"));
        //   $total_checkout_amount = $total_checkout_arr[0]->tot_payable_payment;
      //  $total_payments = $total_checkin_amount+$total_checkout_amount;
            array_push($arr, $total_checkin_amount);
            
        
            
            $total_expense_arr =DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE DATE(`datetime`) = $sort_date"));
            $total_expense = $total_expense_arr[0]->total_expense;
            array_push($arr, $total_expense);

            foreach($paymentmode_list as $pay_list)
            {
                $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = $pay_list->id and `created_at_checkin` >= DATE('$sort_date') "));
                 $advance_cash = $advance_cash_payment[0]->advance_cash;
            //     $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE checkout_payment_mode = $pay_list->id and DATE(`check_out`) >= DATE('$sort_date') "));
            //     $due_cash = $due_cash_payment[0]->due_cash;
            //    $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);
            //    array_push($arr, $cash);
             array_push($arr, $advance_cash);
            }

            $data1=DB::table('corporates')->get();
            foreach($data1 as $corporates_val)
            {
                $corporate_count = DB::table('reservations')->where('referred_by_name', 'Corporate')->where('referred_by', $corporates_val->name)->whereDate('created_at_checkin','>=' , $sort_date)->count();
                array_push($arr, $corporate_count);
            }
          
            $data1=DB::table('tas')->get();
            foreach($data1 as $tas_val)
            {
                 $ta_count = DB::table('reservations')->where('referred_by_name', 'TA')->where('referred_by', $tas_val->name)->whereDate('created_at_checkin','>=' , $sort_date)->count();
                array_push($arr, $ta_count);
            }
             
            $data1=DB::table('ota')->get();
            foreach($data1 as $ota_val)
            {
               
                $ota_count = DB::table('reservations')->where('referred_by_name', 'OTA')->where('referred_by', $ota_val->name)->whereDate('created_at_checkin','>=' , $sort_date)->count();
                
                array_push($arr, $ota_count);
            }
            
  

          
            // $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and DATE(`check_in`) = DATE('$sort_date')"));
            // $total_checkin_amount = $total_checkin_arr[0]->tot_advanve_payment;

            

           

           

        }
        else if ($request->source == 'weekly'){
            if($sort_date == 'this_week')
            {
                $start_date = Carbon::now()->startOfWeek();
                $end_date =  Carbon::now()->endOfWeek();
                $date = date('Y-m-d', strtotime($start_date)).','.date('Y-m-d', strtotime($end_date));
                array_push($arr,$date);

                $noShow = DB::table('arrivals')->whereBetween('check_out', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                array_push($arr, $noShow);
    
                $police = DB::table('reservations')->whereDate('referred_by_name', 'Management')->whereBetween('check_in',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                array_push($arr, $police);
    
                $fit_count = DB::table('reservations')->where('referred_by_name', 'FIT')->whereBetween('created_at_checkin',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                array_push($arr, $fit_count);
    
                $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  `created_at_checkout`  BETWEEN DATE('$start_date') and DATE('$end_date') "));
                $total_check_out = $total_check_out_arr[0]->total_check_out;
                array_push($arr, $total_check_out);
    
                $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  `created_at_checkin`  BETWEEN DATE('$start_date') and DATE('$end_date') "));
                $total_check_ins = $total_check_ins_arr[0]->total_check_ins;
                array_push($arr, $total_check_ins);
    
                $room_count = DB::table('rooms')->where('is_deleted', '0')->where('status', '1')->count();
                array_push($arr, $room_count);
    
                $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->whereBetween('created_at_checkin', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                array_push($arr, $occupied_rooms);
    
                $user_count = DB::table('users')->where('status', '1')->count();
                array_push($arr, $user_count);
    
                $Continue_check_out = DB::select(DB::raw("SELECT COUNT(*) as check_out FROM reservations WHERE `created_at_checkout` IS NULL"));
                $Continue1 =$Continue_check_out[0]->check_out;
                array_push($arr, $Continue1);
    
                // $comming = DB::table('reservations')->where('user_checkout', "DATE_ADD(DATE('$sort_date'), INTERVAL 1 DAY)")->count();
                // array_push($arr, $comming);
    
               // $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE 
                //booking_payment and `created_at_checkin` BETWEEN DATE('$start_date') and DATE('$end_date')"));
               $total_checkin_arr=DB::select("select sum(payment) as total_payment from payment_history where payment_date BETWEEN DATE('$start_date') and DATE('$end_date')");
                $total_checkin_amount = $total_checkin_arr[0]->total_payment;
            //     $total_checkout_arr = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) as tot_payable_payment  FROM reservations WHERE booking_payment and DATE(`check_out`) = DATE('$sort_date')"));
            //   $total_checkout_amount = $total_checkout_arr[0]->tot_payable_payment;
          //  $total_payments = $total_checkin_amount+$total_checkout_amount;
                array_push($arr, $total_checkin_amount);
                
            
                
                $total_expense_arr =DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE DATE(`datetime`) BETWEEN DATE('$start_date') and DATE('$end_date')"));
                $total_expense = $total_expense_arr[0]->total_expense;
                array_push($arr, $total_expense);
    
                foreach($paymentmode_list as $pay_list)
                {
                    $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = $pay_list->id and `created_at_checkin` BETWEEN DATE('$start_date') and DATE('$end_date') "));
                     $advance_cash = $advance_cash_payment[0]->advance_cash;
                //     $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE checkout_payment_mode = $pay_list->id and DATE(`check_out`) >= DATE('$sort_date') "));
                //     $due_cash = $due_cash_payment[0]->due_cash;
                //    $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);
                //    array_push($arr, $cash);
                 array_push($arr, $advance_cash);
                }
    
                $data1=DB::table('corporates')->get();
                foreach($data1 as $corporates_val)
                {
                    $corporate_count = DB::table('reservations')->where('referred_by_name', 'Corporate')->where('referred_by', $corporates_val->name)->whereBetween('created_at_checkin',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    array_push($arr, $corporate_count);
                }
              
                $data1=DB::table('tas')->get();
                foreach($data1 as $tas_val)
                {
                     $ta_count = DB::table('reservations')->where('referred_by_name', 'TA')->where('referred_by', $tas_val->name)->whereBetween('created_at_checkin',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    array_push($arr, $ta_count);
                }
                 
                $data1=DB::table('ota')->get();
                foreach($data1 as $ota_val)
                {
                   
                    $ota_count = DB::table('reservations')->where('referred_by_name', 'OTA')->where('referred_by', $ota_val->name)->whereBetween('created_at_checkin',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    
                    array_push($arr, $ota_count);
                }
                
      
    
              
                // $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and DATE(`check_in`) = DATE('$sort_date')"));
                // $total_checkin_amount = $total_checkin_arr[0]->tot_advanve_payment;
    
                
    
               
    
               
    
            }
            else if($sort_date == 'previous_week')
            {
                $previous_week = strtotime("-1 week +1 day");
                $start_week = strtotime("last monday midnight",$previous_week);
                $end_week = strtotime("next sunday",$start_week);
                $start_week = date("Y-m-d",$start_week);
                $end_week = date("Y-m-d",$end_week);
                $start_next_week = Carbon::now()->startOfWeek();
                $end_next_week =  Carbon::now()->endOfWeek();

                $date = date('Y-m-d', strtotime($start_week)).','.date('Y-m-d', strtotime($end_week));
                array_push($arr,$date);

                 $noShow = DB::table('arrivals')->whereBetween('check_out', [$start_week, $end_week])->count();
                array_push($arr, $noShow);
    
                $police = DB::table('reservations')->whereDate('referred_by_name', 'Management')->whereBetween('check_in', [$start_week, $end_week])->count();
                array_push($arr, $police);
    
                $fit_count = DB::table('reservations')->where('referred_by_name', 'FIT')->whereBetween('created_at_checkin',[$start_week, $end_week])->count();
                array_push($arr, $fit_count);
    
                $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  `created_at_checkout`  BETWEEN DATE('$start_week') and DATE('$end_week') "));
                $total_check_out = $total_check_out_arr[0]->total_check_out;
                array_push($arr, $total_check_out);
    
                $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  `created_at_checkin`  BETWEEN DATE('$start_week') and DATE('$end_week') "));
                $total_check_ins = $total_check_ins_arr[0]->total_check_ins;
                array_push($arr, $total_check_ins);
    
                $room_count = DB::table('rooms')->where('is_deleted', '0')->where('status', '1')->count();
                array_push($arr, $room_count);
    
                $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->whereBetween('created_at_checkin', [$start_week, $end_week])->count();
                array_push($arr, $occupied_rooms);
    
                $user_count = DB::table('users')->where('status', '1')->count();
                array_push($arr, $user_count);
    
                $Continue_check_out = DB::select(DB::raw("SELECT COUNT(*) as check_out FROM reservations WHERE `created_at_checkout` IS NULL"));
                $Continue1 =$Continue_check_out[0]->check_out;
                array_push($arr, $Continue1);
    
                // $comming = DB::table('reservations')->where('user_checkout', "DATE_ADD(DATE('$sort_date'), INTERVAL 1 DAY)")->count();
                // array_push($arr, $comming);
    
                $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and `created_at_checkin` BETWEEN DATE('$start_week') and DATE('$end_week')"));
                $total_checkin_amount = $total_checkin_arr[0]->tot_advanve_payment;
            //     $total_checkout_arr = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) as tot_payable_payment  FROM reservations WHERE booking_payment and DATE(`check_out`) = DATE('$sort_date')"));
            //   $total_checkout_amount = $total_checkout_arr[0]->tot_payable_payment;
          //  $total_payments = $total_checkin_amount+$total_checkout_amount;
                array_push($arr, $total_checkin_amount);
                
            
                
                $total_expense_arr =DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE DATE(`datetime`) BETWEEN DATE('$start_week') and DATE('$end_week')"));
                $total_expense = $total_expense_arr[0]->total_expense;
                array_push($arr, $total_expense);
    
                foreach($paymentmode_list as $pay_list)
                {
                    $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = $pay_list->id and `created_at_checkin` BETWEEN DATE('$start_week') and DATE('$end_week') "));
                     $advance_cash = $advance_cash_payment[0]->advance_cash;
                //     $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE checkout_payment_mode = $pay_list->id and DATE(`check_out`) >= DATE('$sort_date') "));
                //     $due_cash = $due_cash_payment[0]->due_cash;
                //    $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);
                //    array_push($arr, $cash);
                 array_push($arr, $advance_cash);
                }
    
                $data1=DB::table('corporates')->get();
                foreach($data1 as $corporates_val)
                {
                    $corporate_count = DB::table('reservations')->where('referred_by_name', 'Corporate')->where('referred_by', $corporates_val->name)->whereBetween('created_at_checkin', [$start_week, $end_week])->count();
                    array_push($arr, $corporate_count);
                }
              
                $data1=DB::table('tas')->get();
                foreach($data1 as $tas_val)
                {
                     $ta_count = DB::table('reservations')->where('referred_by_name', 'TA')->where('referred_by', $tas_val->name)->whereBetween('created_at_checkin', [$start_week, $end_week])->count();
                    array_push($arr, $ta_count);
                }
                 
                $data1=DB::table('ota')->get();
                foreach($data1 as $ota_val)
                {
                   
                    $ota_count = DB::table('reservations')->where('referred_by_name', 'OTA')->where('referred_by', $ota_val->name)->whereBetween('created_at_checkin', [$start_week, $end_week])->count();
                    
                    array_push($arr, $ota_count);
                }
                
      
    
              
                // $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and DATE(`check_in`) = DATE('$sort_date')"));
                // $total_checkin_amount = $total_checkin_arr[0]->tot_advanve_payment;
    
                
    
               
    
               
    
            }
            else if($sort_date == 'this_month')
            {
                $month = date('m');
                $curr_date = Carbon::now();
                $monthName = $curr_date->format('F');
                if($month == 12)
                {
                    $next_month = 1;
                }
                else{
                    $next_month = (int)$month+(int)1;
                }
                $date = $monthName;
                array_push($arr,$date);

               

               $noShow = DB::table('arrivals')->whereMonth('check_out',   date('m'))->count();
                array_push($arr, $noShow);
    
                $police = DB::table('reservations')->whereDate('referred_by_name', 'Management')->whereMonth('check_in',  date('m'))->count();
                array_push($arr, $police);
    
                $fit_count = DB::table('reservations')->where('referred_by_name', 'FIT')->whereMonth('created_at_checkin',  date('m'))->count();
                array_push($arr, $fit_count);
    
                $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  MONTH(`created_at_checkout`) = $month "));
                $total_check_out = $total_check_out_arr[0]->total_check_out;
                array_push($arr, $total_check_out);
    
                $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  MONTH(`created_at_checkin`) = $month "));
                $total_check_ins = $total_check_ins_arr[0]->total_check_ins;
                array_push($arr, $total_check_ins);
    
                $room_count = DB::table('rooms')->where('is_deleted', '0')->where('status', '1')->count();
                array_push($arr, $room_count);
    
                $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->whereMonth('created_at_checkin', date('m'))->count();
                array_push($arr, $occupied_rooms);
    
                $user_count = DB::table('users')->where('status', '1')->count();
                array_push($arr, $user_count);
    
                $Continue_check_out = DB::select(DB::raw("SELECT COUNT(*) as check_out FROM reservations WHERE `created_at_checkout` IS NULL"));
                $Continue1 =$Continue_check_out[0]->check_out;
                array_push($arr, $Continue1);
    
                // $comming = DB::table('reservations')->where('user_checkout', "DATE_ADD(DATE('$sort_date'), INTERVAL 1 DAY)")->count();
                // array_push($arr, $comming);
               
                // $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and 
                // MONTH(`created_at_checkin`) = $month "));
                $total_checkin_arr=DB::select("select sum(payment) as total_payment from payment_history where MONTH(`payment_date`)='$month'");
                $total_checkin_amount = $total_checkin_arr[0]->total_payment;
            //     $total_checkout_arr = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) as tot_payable_payment  FROM reservations WHERE booking_payment and DATE(`check_out`) = DATE('$sort_date')"));
            //   $total_checkout_amount = $total_checkout_arr[0]->tot_payable_payment;
          //  $total_payments = $total_checkin_amount+$total_checkout_amount;
                array_push($arr, $total_checkin_amount);
                
            
                
                $total_expense_arr =DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE MONTH(`datetime`) = $month "));
                $total_expense = $total_expense_arr[0]->total_expense;
                array_push($arr, $total_expense);
    
                foreach($paymentmode_list as $pay_list)
                {
                    $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = $pay_list->id and MONTH(`created_at_checkin`) = $month "));
                     $advance_cash = $advance_cash_payment[0]->advance_cash;
                //     $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE checkout_payment_mode = $pay_list->id and DATE(`check_out`) >= DATE('$sort_date') "));
                //     $due_cash = $due_cash_payment[0]->due_cash;
                //    $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);
                //    array_push($arr, $cash);
                 array_push($arr, $advance_cash);
                }
    
                $data1=DB::table('corporates')->get();
                foreach($data1 as $corporates_val)
                {
                    $corporate_count = DB::table('reservations')->where('referred_by_name', 'Corporate')->where('referred_by', $corporates_val->name)->whereMonth('created_at_checkin',  date('m'))->count();
                    array_push($arr, $corporate_count);
                }
              
                $data1=DB::table('tas')->get();
                foreach($data1 as $tas_val)
                {
                     $ta_count = DB::table('reservations')->where('referred_by_name', 'TA')->where('referred_by', $tas_val->name)->whereMonth('created_at_checkin',  date('m'))->count();
                    array_push($arr, $ta_count);
                }
                 
                $data1=DB::table('ota')->get();
                foreach($data1 as $ota_val)
                {
                   
                    $ota_count = DB::table('reservations')->where('referred_by_name', 'OTA')->where('referred_by', $ota_val->name)->whereMonth('created_at_checkin',  date('m'))->count();
                    
                    array_push($arr, $ota_count);
                }
                
      
    
              
                // $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and DATE(`check_in`) = DATE('$sort_date')"));
                // $total_checkin_amount = $total_checkin_arr[0]->tot_advanve_payment;
    
            }
            else if($sort_date == 'previous_month')
            {
                $month = date('m');
                if($month == 1)
                {
                    $previous_month = '12';
                }
                else{
                    $previous_month = (int)$month-(int)1;
                }
                $monthName = date("F", mktime(0, 0, 0, $previous_month, 1));
                $date = $monthName;
                array_push($arr,$date);

                $noShow = DB::table('arrivals')->whereMonth('check_out',  $previous_month)->count();
                array_push($arr, $noShow);
    
                $police = DB::table('reservations')->whereDate('referred_by_name', 'Management')->whereMonth('check_in',  $previous_month)->count();
                array_push($arr, $police);
    
                $fit_count = DB::table('reservations')->where('referred_by_name', 'FIT')->whereMonth('created_at_checkin',   $previous_month)->count();
                array_push($arr, $fit_count);
    
                $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  MONTH(`created_at_checkout`) = $previous_month "));
                $total_check_out = $total_check_out_arr[0]->total_check_out;
                array_push($arr, $total_check_out);
    
                $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  MONTH(`created_at_checkin`) = $previous_month "));
                $total_check_ins = $total_check_ins_arr[0]->total_check_ins;
                array_push($arr, $total_check_ins);
    
                $room_count = DB::table('rooms')->where('is_deleted', '0')->where('status', '1')->count();
                array_push($arr, $room_count);
    
                $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->whereMonth('created_at_checkin',  $previous_month)->count();
                array_push($arr, $occupied_rooms);
    
                $user_count = DB::table('users')->where('status', '1')->count();
                array_push($arr, $user_count);
    
                $Continue_check_out = DB::select(DB::raw("SELECT COUNT(*) as check_out FROM reservations WHERE `created_at_checkout` IS NULL"));
                $Continue1 =$Continue_check_out[0]->check_out;
                array_push($arr, $Continue1);
    
                // $comming = DB::table('reservations')->where('user_checkout', "DATE_ADD(DATE('$sort_date'), INTERVAL 1 DAY)")->count();
                // array_push($arr, $comming);
    
                $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and MONTH(`created_at_checkin`) = $previous_month"));
                $total_checkin_amount = $total_checkin_arr[0]->tot_advanve_payment;
            //     $total_checkout_arr = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) as tot_payable_payment  FROM reservations WHERE booking_payment and DATE(`check_out`) = DATE('$sort_date')"));
            //   $total_checkout_amount = $total_checkout_arr[0]->tot_payable_payment;
          //  $total_payments = $total_checkin_amount+$total_checkout_amount;
                array_push($arr, $total_checkin_amount);
                
            
                
                $total_expense_arr =DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE MONTH(`datetime`) = $previous_month"));
                $total_expense = $total_expense_arr[0]->total_expense;
                array_push($arr, $total_expense);
    
                foreach($paymentmode_list as $pay_list)
                {
                    $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = $pay_list->id and MONTH(`created_at_checkin`) = $previous_month"));
                     $advance_cash = $advance_cash_payment[0]->advance_cash;
                //     $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE checkout_payment_mode = $pay_list->id and DATE(`check_out`) >= DATE('$sort_date') "));
                //     $due_cash = $due_cash_payment[0]->due_cash;
                //    $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);
                //    array_push($arr, $cash);
                    array_push($arr, $advance_cash);
                }
    
                $data1=DB::table('corporates')->get();
                foreach($data1 as $corporates_val)
                {
                    $corporate_count = DB::table('reservations')->where('referred_by_name', 'Corporate')->where('referred_by', $corporates_val->name)->whereMonth('created_at_checkin',   $previous_month)->count();
                    array_push($arr, $corporate_count);
                }
              
                $data1=DB::table('tas')->get();
                foreach($data1 as $tas_val)
                {
                     $ta_count = DB::table('reservations')->where('referred_by_name', 'TA')->where('referred_by', $tas_val->name)->whereMonth('created_at_checkin',   $previous_month)->count();
                    array_push($arr, $ta_count);
                }
                 
                $data1=DB::table('ota')->get();
                foreach($data1 as $ota_val)
                {
                   
                    $ota_count = DB::table('reservations')->where('referred_by_name', 'OTA')->where('referred_by', $ota_val->name)->whereMonth('created_at_checkin',   $previous_month)->count();
                    
                    array_push($arr, $ota_count);
                }
                
      
    
              
                // $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and DATE(`check_in`) = DATE('$sort_date')"));
                // $total_checkin_amount = $total_checkin_arr[0]->tot_advanve_payment;
    
            }
            
        }
            
        else if($request->source == 'dateRange')
        {
            $start_date = $request->start_date;
            $end_date =  $request->end_date;
            $date = date('Y-m-d', strtotime($start_date)).','.date('Y-m-d', strtotime($end_date));
            array_push($arr,$date);

            $noShow = DB::table('arrivals')->whereBetween('check_out', [$start_date, $end_date])->count();
                array_push($arr, $noShow);
    
                $police = DB::table('reservations')->whereDate('referred_by_name', 'Management')->whereBetween('check_in', [$start_date, $end_date])->count();
                array_push($arr, $police);
    
                $fit_count = DB::table('reservations')->where('referred_by_name', 'FIT')->whereBetween('created_at_checkin',[$start_date, $end_date])->count();
                array_push($arr, $fit_count);
    
                $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  `created_at_checkout`   BETWEEN DATE('$start_date') and DATE('$end_date') "));
                $total_check_out = $total_check_out_arr[0]->total_check_out;
                array_push($arr, $total_check_out);
    
                $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  `created_at_checkin`   BETWEEN DATE('$start_date') and DATE('$end_date') "));
                $total_check_ins = $total_check_ins_arr[0]->total_check_ins;
                array_push($arr, $total_check_ins);
    
                $room_count = DB::table('rooms')->where('is_deleted', '0')->where('status', '1')->count();
                array_push($arr, $room_count);
    
                $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->whereBetween('created_at_checkin', [$start_date, $end_date])->count();
                array_push($arr, $occupied_rooms);
    
                $user_count = DB::table('users')->where('status', '1')->count();
                array_push($arr, $user_count);
    
                $Continue_check_out = DB::select(DB::raw("SELECT COUNT(*) as check_out FROM reservations WHERE   ( `created_at_checkin` BETWEEN DATE('$start_date') and DATE('$end_date')) and (`created_at_checkout` IS NULL)"));
                $Continue1 =$Continue_check_out[0]->check_out;
                array_push($arr, $Continue1);
    
                // $comming = DB::table('reservations')->where('user_checkout', "DATE_ADD(DATE('$sort_date'), INTERVAL 1 DAY)")->count();
                // array_push($arr, $comming);
    
                // $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment 
                // FROM reservations WHERE booking_payment and `created_at_checkin`  BETWEEN DATE('$start_date') and DATE('$end_date')"));
                
              //   $total_checkin_arr=DB::select("select sum(payment) as total_payment from payment_history where payment_date BETWEEN DATE('$start_date') and DATE('$end_date')");
                 $total_checkin_arr=DB::select(DB::raw("select sum(payment) as tot_advanve_payment from payment_history where payment_date  BETWEEN DATE('$start_date') and DATE('$end_date')"));
                $total_checkin_amount = $total_checkin_arr[0]->total_payment;
                
            //     $total_checkout_arr = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) as tot_payable_payment  FROM reservations WHERE booking_payment and DATE(`check_out`) = DATE('$sort_date')"));
            //   $total_checkout_amount = $total_checkout_arr[0]->tot_payable_payment;
          //  $total_payments = $total_checkin_amount+$total_checkout_amount;
                array_push($arr, $total_checkin_amount);
                
            
                
                $total_expense_arr =DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE DATE(`datetime`) BETWEEN DATE('$start_date') and DATE('$end_date')"));
                $total_expense = $total_expense_arr[0]->total_expense;
                array_push($arr, $total_expense);
    
                foreach($paymentmode_list as $pay_list)
                {
                    // $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = $pay_list->id and `created_at_checkin` 
                    // BETWEEN DATE('$start_date') and DATE('$end_date') "));
                    $advance_cash_payment=DB::select("select sum(payment) as total_payment from payment_history where mode='$pay_list->id' and  payment_date BETWEEN DATE('$start_date') and DATE('$end_date')");
                     $advance_cash = $advance_cash_payment[0]->total_payment;
                //     $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE checkout_payment_mode = $pay_list->id and DATE(`check_out`) >= DATE('$sort_date') "));
                //     $due_cash = $due_cash_payment[0]->due_cash;
                //    $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);
                //    array_push($arr, $cash);
                 array_push($arr, $advance_cash);
                }
    
                $data1=DB::table('corporates')->get();
                foreach($data1 as $corporates_val)
                {
                    $corporate_count = DB::table('reservations')->where('referred_by_name', 'Corporate')->where('referred_by', $corporates_val->name)->whereBetween('created_at_checkin', [$start_date, $end_date])->count();
                    array_push($arr, $corporate_count);
                }
              
                $data1=DB::table('tas')->get();
                foreach($data1 as $tas_val)
                {
                     $ta_count = DB::table('reservations')->where('referred_by_name', 'TA')->where('referred_by', $tas_val->name)->whereBetween('created_at_checkin', [$start_date, $end_date])->count();
                    array_push($arr, $ta_count);
                }
                 
                $data1=DB::table('ota')->get();
                foreach($data1 as $ota_val)
                {
                   
                    $ota_count = DB::table('reservations')->where('referred_by_name', 'OTA')->where('referred_by', $ota_val->name)->whereBetween('created_at_checkin', [$start_date, $end_date])->count();
                    
                    array_push($arr, $ota_count);
                }
                
      
    
              
                // $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and DATE(`check_in`) = DATE('$sort_date')"));
                // $total_checkin_amount = $total_checkin_arr[0]->tot_advanve_payment;
    
                
    
               
    
               
    
            }
        array_push($data,$arr);
        echo json_encode($data);
    }




    public function getReportData(Request $request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $datetime2 = date_create();
        $sort_date = $request->sortDate;
        $data = [];
        $amenitie_id = [];
        $str="";
        $hotetamenitie= DB::table('hotetamenities')->where('Status','1')->pluck('name');
        $availedservices= DB::table('availedservices')->where('Status','1')->pluck('name');
        $setting= DB::table('settings')->pluck('value','name');
        $arr = "";
        if($request->source == 'date')
        {
            $ress= DB::table('reservations')
            ->join('customers','customers.id','=','reservations.customer_id','left outer')
            ->join('room_types','room_types.id','=','reservations.room_type_id','left outer')
            ->join('amenities','amenities.id','=','room_types.amenities','left outer')
            ->join('payment_mode','payment_mode.id','=','reservations.payment_mode','left outer')
            ->join('packages','packages.id','=','reservations.package_id','left outer')
            ->join('meal_plans','meal_plans.id','=','reservations.meal_plan','left outer')
            ->join('users','users.id','=','reservations.Employee_Check_In_name','left outer')
            ->join('ota','ota.name','=','reservations.referred_by','left outer')
            ->join('arrivals','arrivals.customer_id','=','customers.id','left outer')
            ->select('arrivals.*','arrivals.check_in as arrivals_check_in','ota.*','users.*','meal_plans.*','reservations.*','reservations.customer_id as reservations_customer_id','reservations.id as reservations_id','customers.*','room_types.*', 'amenities.*', 'payment_mode.*', 'packages.*','room_types.title as room_title','meal_plans.name as meal_plans_name','customers.name as customer_name','users.name as usersname','reservations.created_at as reservations_created_at','reservations.id as reservations_id')
            ->where('customers.created_at', '>=', $sort_date)
            ->orderBy('reservations.id', 'DESC');
             $res = $ress->groupBy('reservations_customer_id')->get();
             
            //  echo "<pre>";
            //  print_r($ress->get());
             
            //  return ;
             
             
             
            foreach( $res as $val)
            {
                $arr.= '<tr>';
                $arr.= '<td>'.$val->Booking_id.'</td>';
                
                 $arr.= '<td>'.$val->customer_name.'</td>';

                $arr.= '<td>'.$val->Reconciliation.'</td>';
                
                
                
              //$arrivals = $ress->join('arrivals','arrivals.customer_id','=','customers.id','left outer')->select('arrivals.*','arrivals.check_in as arrivals_check_in')->get();
                
                
            //      echo "<pre>";
            //  print_r($arrivals);
             
            //  return ;
             
                
                
                

                if($val->arrivals_check_in == "" || $val->created_at_checkin !="")
                {
                    $arr.= '<td>Confirm</td>';
                }
                else if($val->arrivals_check_in >= $datetime2)
                {
                    $arr.= '<td>On request</td>';
                }
                else if($val->arrivals_check_in <= $datetime2)
                {
                    if($val->created_at_checkin =="")
                    {
                        $arr.= '<td>Cancel</td>';
                    }
                    else
                    {
                       $arr.= '<td>Confirm</td>'; 
                    }
                }
                
                $arr.= '<td>'.$val->Booking_Reason.'</td>';
                
                $Recon_month = date('F', strtotime($val->created_at_checkin))."-".date('y', strtotime($val->created_at_checkin));
                $arr.= '<td>'.$Recon_month.'</td>';
                
                $arr.= '<td>'.$val->created_at_checkin.'</td>';
                
                $arr.= '<td>'.$val->created_at_checkout.'</td>';
                
               
                if($val->duration_of_stay == "" )
                {
                    $arr.= '<td>0</td>';
                }
                else
                {
                    $arr.= '<td>'.$val->duration_of_stay.'</td>';
                }
                
                $customer_id =  DB::table('reservations')->where('customer_id', "$val->customer_id")->count();
                $arr.= '<td>'.$customer_id.'</td>';
               
                $arr.= '<td>'.$val->base_price.'</td>';
                
                $arr.= '<td>'.$val->per_room_price.'</td>';

                if($val->referred_by_name == "OTA")
                {
                    // if( $val->reconciliation_type != "precentage")
                    // {
                    //     $reconciliation = $val->reconciliation; 
                    // }
                    // else
                    // {

                    // }
                    if(!isset($val->LCO_type))
                    {
                        $LCO = 0;
                    }
                    else if($val->LCO_type == "")
                    {
                        $LCO = 0;
                    }
                    else if( $val->LCO_type != "precentage")
                    {
                        $LCO = $val->LCO; 
                    }
                    else
                    {
                        $LCO = ($val->checkout_payment * $val->LCO)/100;
                    }

                    if(!isset($val->Meals_type))
                    {
                        $Meal = 0;
                    }
                    else if($val->Meals_type == "")
                    {
                        $Meal = 0;
                    }
                    else if( $val->Meals_type != "precentage")
                    {
                        $Meal = $val->Meals; 
                    }
                    else
                    {
                        $Meal = ($val->checkout_payment * $val->Meals)/100;
                    }
                    
                    if(!isset($val->Net_share_type))
                    {
                        $Net_share = 0;
                    }
                    else if($val->Net_share_type == "")
                    {
                        $Net_share = 0;
                    }
                    else if( $val->Net_share_type != "precentage")
                    {
                        $Net_share = $val->Net_share;
                    }
                    else
                    {
                        $Net_share = ($val->checkout_payment * $val->Net_share)/100;
                    }

                     if(!isset($val->Tax_commissions_type))
                    {
                        $Tax_commissions = 0;
                    }
                    else if($val->Tax_commissions_type == "")
                    {
                        $Tax_commissions = 0;
                    }
                    else if( $val->Tax_commissions_type != "precentage")
                    {
                        $Tax_commissions = $val->Tax_commissions;
                    }
                    else
                    {
                        $Tax_commissions = ($val->checkout_payment * $val->Tax_commissions)/100;
                    }

                    // if(!isset($val->post_tax_type))
                    // {
                    //     $post_tax = 0;
                    // }
                    // else if($val->post_tax_type == "")
                    // {
                    //     $post_tax = 0;
                    // }
                    // else if( $val->post_tax_type != "precentage")
                    // {
                    //     $post_tax = $val->post_tax; 
                    // }
                    // else
                    // {
                    //     $post_tax = ($val->checkout_payment * $val->post_tax)/100;
                    // }

                     if(!isset($val->TDS_type))
                    {
                        $TDS = 0;
                    }
                    else if($val->TDS_type == "")
                    {
                        $TDS = "";
                    }
                    else if( $val->TDS_type != "precentage")
                    {
                        $TDS = $val->TDS; 
                    }
                    else
                    {
                        $TDS = ($val->checkout_payment * $val->TDS)/100;
                    }

                    if(!isset($val->TDS_Deducted_type))
                    {
                        $TDS_Deducted = 0;
                    }
                    else if($val->TDS_Deducted_type == "")
                    {
                        $TDS_Deducted = 0;
                    }
                    else if( $val->TDS_Deducted_type != "precentage")
                    {
                        $TDS_Deducted =$val->TDS_Deducted; 
                    }
                    else
                    {
                        $TDS_Deducted = ($val->checkout_payment * $val->TDS_Deducted)/100;
                    }

                    if(!isset($val->TCS_type))
                    {
                        $TCS = 0;
                    }
                    else if($val->TCS_type == "")
                    {
                        $TCS = 0;
                    }
                    else if( $val->	TCS_type != "precentage")
                    {
                        $TCS = $val->TCS; 
                    }
                    else
                    {
                        $TCS = ($val->checkout_payment * $val->TCS)/100;
                    }
                    
                    if($val->created_at_checkout !="")
                    {
                        if($val->checkin_type == "single")
                        {
                            $tat =  ($val->per_room_price*$val->duration_of_stay* $val->room_qty) + ($LCO + $Meal - $Net_share - $Tax_commissions);
                        }
                        else
                        {
                            $tat =  ($val->per_room_price*$val->duration_of_stay*($val->room_qty+1)) + ($LCO + $Meal - $Net_share - $Tax_commissions);
                        }
                        
                        $arr.= '<td>'.$tat.'</td>';
                        
                        $arr.= '<td>'.$tat.'</td>';
                        
                        $arr.= '<td>'.$LCO.'</td>';
                        
                        $arr.= '<td>'.$Meal.'</td>';
                        
                        $arr.= '<td>'.$Net_share.'</td>';
                        
                        $arr.= '<td>'.$Tax_commissions.'</td>';
                        
                        $arr.= '<td>'.$tat.'</td>';
                        
                        $arr.= '<td>'.$TDS.'</td>';
                        
                        $arr.= '<td>'.$TDS_Deducted.'</td>';
                        
                        $arr.= '<td>'.$TCS.'</td>';
                    
                    }
                    else
                    {
                        $arr.= '<td>'.$val->checkout_payment.'</td>';
                    
                        $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                    }
                    
                }
                else
                {
                    
                    $arr.= '<td>'.$val->checkout_payment.'</td>';
                    
                    $arr.= '<td>'.$val->checkout_payment.'</td>';
                    
                    $arr.= '<td></td>';
                    
                    $arr.= '<td></td>';
                    
                    $arr.= '<td></td>';
                    
                    $arr.= '<td></td>';
                    
                    $arr.= '<td></td>';
                    
                    $arr.= '<td></td>';
                    
                    $arr.= '<td></td>';
                    
                    $arr.= '<td></td>';
                
                }
            
                $arr.= '<td>'.$val->mobile.'</td>';
            
                $arr.= '<td>'.$val->email.'</td>';
            
                $arr.= '<td>'.$val->gender.'</td>';
            
                $arr.= '<td>'.$val->dob.'</td>';
            
               $arr.= '<td>'.$val->address.'</td>';
               
               $arr.= '<td>'.$setting["hotel_name"].'</td>';
               
               $arr.= '<td>'.$setting["hotel_address"].'</td>';
               
               $arr.= '<td>'.$setting["Hotel_Star"].'</td>';
               
               $arr.= '<td>'.date("Y-m-d", strtotime($val->reservations_created_at)).'</td>';
               
               $arr.= '<td>'.date("H:i:s", strtotime($val->reservations_created_at)).'</td>';
               
               $arr.= '<td>'. $val->created_at_checkin.'</td>';
               
               $arr.= '<td>'. $val->created_at_checkout.'</td>';
               
               $arr.= '<td>'. $val->adult.'</td>';
               
               $arr.= '<td>'. $val->kids.'</td>';
                
               $person_lists = DB::table('person_lists')->where('age','<','18')->where('reservation_id',$val->reservations_id)->pluck('age');
               if($person_lists == '')
               {
                   $arr.= '<td>0</td>';
               }
                else if(count($person_lists) == 0)
               {
                   $arr.= '<td>0</td>';
               }
               else
               {
                   $arr.= '<td>'. $person_lists.'</td>';
               }
                
               $arr.= '<td>'. $val->infant.'</td>';
                
                $arr.= '<td>'. $val->meal_plans_name.'</td>';
               
                $arr.= '<td>'. $setting["Hotel_city"].'</td>';
               
                if($val->referred_by == "")
                {
                    $arr.= '<td>'. $val->referred_by_name.'</td>';
                    
                    $arr.= '<td>'. $val->referred_by_name.'</td>';
                     
                }
                else
                {
                    $arr.= '<td>'. $val->referred_by_name.'</td>';
                    
                    $arr.= '<td>'. $val->referred_by.'</td>';
                     
                }
                
               
                
                $rep = DB::table("reservations")->join('customers','customers.id','=','reservations.customer_id','left outer')->where("mobile",$val->mobile)->select('customers.*','reservations.*','reservations.id as reservations_id')->where("reservations.id",'<',197)->take(1)->count();
               if($rep ==0)
                {
                    $arr.= '<td>No</td>';
                    $arr.= '<td></td>';
                
                    $arr.= '<td></td>';
                
                
                }
                else
                {
                    if($val->arrivals_check_in == "" && $val->created_at_checkin !="")
                    {
                        $arr.= '<td>yes</td>';
                        
                        $arr.= '<td>No</td>';
                
                        $arr.= '<td>Yes</td>';
                        
                    }
                    else if($val->arrivals_check_in != "" and $datetime2 >$val->arrivals_check_in)
                    {
                        $arr.= '<td>Yes</td>';
                        
                        $arr.= '<td>Yes</td>';
                
                        $arr.= '<td>No</td>';
                    }
                }
                

              
                
                $arr.= '<td>'.$val->room_title.'</td>';

                $arr.= '<td>'.$val->room_types.'</td>';

                $arr.= '<td>'.$val->booking_changes_count.'</td>';
                
                if($val->advance_payment == "" && $val->created_at_checkout == "")
                {
                    $arr.= '<td>No Deposit</td>';
                }
                else
                {
                    $arr.= '<td>Deposit</td>';
                }

                $arr.= '<td>'.$val->payment_mode.'</td>';

                if(($val->advance_payment == $val->per_room_price) || $val->created_at_checkout != "")
                {
                    $arr.= '<td>Fully Paid</td>';
                    
                }
                else
                {
                    $arr.= '<td>Partial</td>';
                }

                $special_requests = DB::table('special_requests')->where('customer_id',$val->customer_id);
                $count_special_requests = $special_requests->count();
                $data_special_requests = $special_requests->pluck('name');

                if($count_special_requests != 0)
                {
                    $arr.= '<td>'.$count_special_requests.'</td>';
                    
                    $arr.= '<td>'.$data_special_requests.'</td>';
                    
                }
                else
                {
                    $arr.= '<td>0</td>';
                    
                    $arr.= '<td></td>';
                    
                }
                
                if($val->created_at_checkout != "")
                {
                    $arr.= '<td>check Out</td>';
                    
                    $arr.= '<td>'.$val->created_at_checkout.'</td>';
                }
                else if($val->created_at_checkin != "")
                {
                    $arr.= '<td>check In</td>';
                    
                    $arr.= '<td>'.$val->created_at_checkin.'</td>';
                }
                else
                {
                    $arr.= '<td>Canceled</td>';
                    
                    $arr.= '<td></td>';
                    
                }

                $arr.= '<td>'.$val->Average_duration.'</td>';
                 
                $arr.= '<td>'.$val->discount.'</td>';

                if($val->ota_discount == "")
                {
                    $arr.= '<td>No</td>';
                    
                    $arr.= '<td></td>';
                }
                else
                {
                    $arr.= '<td>Yes</td>';
                    
                    $arr.= '<td>'.$val->ota_discount.'</td>';
                    
                }
                if($val->package_id == 0)
                {
                    $arr.= '<td>Yes</td>';
                }
               else
               {
                    $arr.= '<td>No</td>';
               }

                $arr.= '<td>'.$availedservices.'</td>';

                $arr.= '<td>'. $val->Availed_Services_Details.'</td>';
                
                $arr.= '<td>'. $val->Guest_feedback.'</td>';

                $arr.= '<td>'. $hotetamenitie.'</td>';

                $amenities = explode(",",$val->amenities);
               
                foreach($amenities as $vals)
                {
                    $ameniti = DB::table('amenities')->where("id", $vals)->get();
                    // $amenitie[] = $ameniti[0]->name;
                }
                
            //     if(count($ameniti) != 0)
            //     {
            //         $nam = implode(",",$ameniti);
            //         $arr.= '<td>'.$nam.'</td>';
            //     }
            //      else
            //      {
            //          $arr.= '<td></td>';
            //      }
                
            //   $amenitie[]="";
               $arr.= '<td></td>';

                 $arr.= '<td>'. $val->Hotel_rate.'</td>';
 
               $arr.= '<td>'. $setting["car_parking_spaces"].'</td>';

                 $arr.= '<td>'. $val->Booking_Device.'</td>';

                $arr.= '<td>'. $val->usersname.'</td>';

                $arr.= '<td>'. $val->usersname.'</td>';

                
                $arr.= '</tr>';

               
            }
        }
        else if ($request->source == 'weekly')
        {
            if($sort_date == 'this_week')
            {
               $start_date = Carbon::now()->startOfWeek();
               $end_date =  Carbon::now()->endOfWeek();
                $date = date('Y-m-d', strtotime($start_date)).','.date('Y-m-d', strtotime($end_date));
                $ress= DB::table('reservations')
                ->join('customers','customers.id','=','reservations.customer_id')
                ->join('room_types','room_types.id','=','reservations.room_type_id')
                ->join('amenities','amenities.id','=','room_types.amenities')
                ->join('payment_mode','payment_mode.id','=','reservations.payment_mode')
                ->join('packages','packages.id','=','reservations.package_id')
                ->join('meal_plans','meal_plans.id','=','reservations.meal_plan')
                ->join('users','users.id','=','reservations.Employee_Check_In_name','left outer')
                ->join('ota','ota.name','=','reservations.referred_by','left outer')
                ->select('ota.*','users.*','meal_plans.*','reservations.*','customers.*','room_types.*', 'amenities.*', 'payment_mode.*', 'packages.*','room_types.title as room_title','meal_plans.name as meal_plans_name','customers.name as customer_name','users.name as usersname','reservations.created_at as reservations_created_at','reservations.id as reservations_id')
                 ->where('customers.created_at','>=', $start_date)->where('customers.created_at', '<=',$end_date)
                ->orderBy('reservations.id', 'DESC');
                 $res = $ress->groupBy('customer_id')->get();
                foreach( $res as $val)
                {
                    $arr.= '<tr>';
                    $arr.= '<td>'.$val->Booking_id.'</td>';
                    
                     $arr.= '<td>'.$val->customer_name.'</td>';
    
                    $arr.= '<td>'.$val->Reconciliation.'</td>';
                    
                    
                    
                  //$arrivals = $ress->join('arrivals','arrivals.customer_id','=','customers.id','left outer')->select('arrivals.*','arrivals.check_in as arrivals_check_in')->get();
                    
                    
                //      echo "<pre>";
                //  print_r($arrivals);
                 
                //  return ;
                 
                    
                    
                    
    
                    if($val->arrivals_check_in == "" || $val->created_at_checkin !="")
                    {
                        $arr.= '<td>Confirm</td>';
                    }
                    else if($val->arrivals_check_in >= $datetime2)
                    {
                        $arr.= '<td>On request</td>';
                    }
                    else if($val->arrivals_check_in <= $datetime2)
                    {
                        if($val->created_at_checkin =="")
                        {
                            $arr.= '<td>Cancel</td>';
                        }
                        else
                        {
                           $arr.= '<td>Confirm</td>'; 
                        }
                    }
                    
                    $arr.= '<td>'.$val->Booking_Reason.'</td>';
                    
                    $Recon_month = date('F', strtotime($val->created_at_checkin))."-".date('y', strtotime($val->created_at_checkin));
                    $arr.= '<td>'.$Recon_month.'</td>';
                    
                    $arr.= '<td>'.$val->created_at_checkin.'</td>';
                    
                    $arr.= '<td>'.$val->created_at_checkout.'</td>';
                    
                   
                    if($val->duration_of_stay == "" )
                    {
                        $arr.= '<td>0</td>';
                    }
                    else
                    {
                        $arr.= '<td>'.$val->duration_of_stay.'</td>';
                    }
                    
                    $customer_id =  DB::table('reservations')->where('customer_id', "$val->customer_id")->count();
                    $arr.= '<td>'.$customer_id.'</td>';
                   
                    $arr.= '<td>'.$val->base_price.'</td>';
                    
                    $arr.= '<td>'.$val->per_room_price.'</td>';
    
                    if($val->referred_by_name == "OTA")
                    {
                        // if( $val->reconciliation_type != "precentage")
                        // {
                        //     $reconciliation = $val->reconciliation; 
                        // }
                        // else
                        // {
    
                        // }
                        if(!isset($val->LCO_type))
                        {
                            $LCO = 0;
                        }
                        else if($val->LCO_type == "")
                        {
                            $LCO = 0;
                        }
                        else if( $val->LCO_type != "precentage")
                        {
                            $LCO = $val->LCO; 
                        }
                        else
                        {
                            $LCO = ($val->checkout_payment * $val->LCO)/100;
                        }
    
                        if(!isset($val->Meals_type))
                        {
                            $Meal = 0;
                        }
                        else if($val->Meals_type == "")
                        {
                            $Meal = 0;
                        }
                        else if( $val->Meals_type != "precentage")
                        {
                            $Meal = $val->Meals; 
                        }
                        else
                        {
                            $Meal = ($val->checkout_payment * $val->Meals)/100;
                        }
                        
                        if(!isset($val->Net_share_type))
                        {
                            $Net_share = 0;
                        }
                        else if($val->Net_share_type == "")
                        {
                            $Net_share = 0;
                        }
                        else if( $val->Net_share_type != "precentage")
                        {
                            $Net_share = $val->Net_share;
                        }
                        else
                        {
                            $Net_share = ($val->checkout_payment * $val->Net_share)/100;
                        }
    
                         if(!isset($val->Tax_commissions_type))
                        {
                            $Tax_commissions = 0;
                        }
                        else if($val->Tax_commissions_type == "")
                        {
                            $Tax_commissions = 0;
                        }
                        else if( $val->Tax_commissions_type != "precentage")
                        {
                            $Tax_commissions = $val->Tax_commissions;
                        }
                        else
                        {
                            $Tax_commissions = ($val->checkout_payment * $val->Tax_commissions)/100;
                        }
    
                        // if(!isset($val->post_tax_type))
                        // {
                        //     $post_tax = 0;
                        // }
                        // else if($val->post_tax_type == "")
                        // {
                        //     $post_tax = 0;
                        // }
                        // else if( $val->post_tax_type != "precentage")
                        // {
                        //     $post_tax = $val->post_tax; 
                        // }
                        // else
                        // {
                        //     $post_tax = ($val->checkout_payment * $val->post_tax)/100;
                        // }
    
                         if(!isset($val->TDS_type))
                        {
                            $TDS = 0;
                        }
                        else if($val->TDS_type == "")
                        {
                            $TDS = "";
                        }
                        else if( $val->TDS_type != "precentage")
                        {
                            $TDS = $val->TDS; 
                        }
                        else
                        {
                            $TDS = ($val->checkout_payment * $val->TDS)/100;
                        }
    
                        if(!isset($val->TDS_Deducted_type))
                        {
                            $TDS_Deducted = 0;
                        }
                        else if($val->TDS_Deducted_type == "")
                        {
                            $TDS_Deducted = 0;
                        }
                        else if( $val->TDS_Deducted_type != "precentage")
                        {
                            $TDS_Deducted =$val->TDS_Deducted; 
                        }
                        else
                        {
                            $TDS_Deducted = ($val->checkout_payment * $val->TDS_Deducted)/100;
                        }
    
                        if(!isset($val->TCS_type))
                        {
                            $TCS = 0;
                        }
                        else if($val->TCS_type == "")
                        {
                            $TCS = 0;
                        }
                        else if( $val->	TCS_type != "precentage")
                        {
                            $TCS = $val->TCS; 
                        }
                        else
                        {
                            $TCS = ($val->checkout_payment * $val->TCS)/100;
                        }
                        
                        if($val->created_at_checkout !="")
                        {
                            if($val->checkin_type == "single")
                            {
                                $tat =  ($val->per_room_price*$val->duration_of_stay* $val->room_qty) + ($LCO + $Meal - $Net_share - $Tax_commissions);
                            }
                            else
                            {
                                $tat =  ($val->per_room_price*$val->duration_of_stay*($val->room_qty+1)) + ($LCO + $Meal - $Net_share - $Tax_commissions);
                            }
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$LCO.'</td>';
                            
                            $arr.= '<td>'.$Meal.'</td>';
                            
                            $arr.= '<td>'.$Net_share.'</td>';
                            
                            $arr.= '<td>'.$Tax_commissions.'</td>';
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$TDS.'</td>';
                            
                            $arr.= '<td>'.$TDS_Deducted.'</td>';
                            
                            $arr.= '<td>'.$TCS.'</td>';
                        
                        }
                        else
                        {
                            $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                            $arr.= '<td>'.$val->checkout_payment.'</td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                        }
                        
                    }
                    else
                    {
                        
                        $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                        $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                    
                    }
                
                    $arr.= '<td>'.$val->mobile.'</td>';
                
                    $arr.= '<td>'.$val->email.'</td>';
                
                    $arr.= '<td>'.$val->gender.'</td>';
                
                    $arr.= '<td>'.$val->dob.'</td>';
                
                   $arr.= '<td>'.$val->address.'</td>';
                   
                   $arr.= '<td>'.$setting["hotel_name"].'</td>';
                   
                   $arr.= '<td>'.$setting["hotel_address"].'</td>';
                   
                   $arr.= '<td>'.$setting["Hotel_Star"].'</td>';
                   
                   $arr.= '<td>'.date("Y-m-d", strtotime($val->reservations_created_at)).'</td>';
                   
                   $arr.= '<td>'.date("H:i:s", strtotime($val->reservations_created_at)).'</td>';
                   
                   $arr.= '<td>'. $val->created_at_checkin.'</td>';
                   
                   $arr.= '<td>'. $val->created_at_checkout.'</td>';
                   
                   $arr.= '<td>'. $val->adult.'</td>';
                   
                   $arr.= '<td>'. $val->kids.'</td>';
                    
                   $person_lists = DB::table('person_lists')->where('age','<','18')->where('reservation_id',$val->reservations_id)->pluck('age');
                   if($person_lists == '')
                   {
                       $arr.= '<td>0</td>';
                   }
                    else if(count($person_lists) == 0)
                   {
                       $arr.= '<td>0</td>';
                   }
                   else
                   {
                       $arr.= '<td>'. $person_lists.'</td>';
                   }
                    
                   $arr.= '<td>'. $val->infant.'</td>';
                    
                    $arr.= '<td>'. $val->meal_plans_name.'</td>';
                   
                    $arr.= '<td>'. $setting["Hotel_city"].'</td>';
                   
                    if($val->referred_by == "")
                    {
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                        
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                         
                    }
                    else
                    {
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                        
                        $arr.= '<td>'. $val->referred_by.'</td>';
                         
                    }
                    
                   
                    
                    $rep = DB::table("reservations")->join('customers','customers.id','=','reservations.customer_id','left outer')->where("mobile",$val->mobile)->select('customers.*','reservations.*','reservations.id as reservations_id')->where("reservations.id",'<',197)->take(1)->count();
                   if($rep ==0)
                    {
                        $arr.= '<td>No</td>';
                        $arr.= '<td></td>';
                    
                        $arr.= '<td></td>';
                    
                    
                    }
                    else
                    {
                        if($val->arrivals_check_in == "" && $val->created_at_checkin !="")
                        {
                            $arr.= '<td>yes</td>';
                            
                            $arr.= '<td>No</td>';
                    
                            $arr.= '<td>Yes</td>';
                            
                        }
                        else if($val->arrivals_check_in != "" and $datetime2 >$val->arrivals_check_in)
                        {
                            $arr.= '<td>Yes</td>';
                            
                            $arr.= '<td>Yes</td>';
                    
                            $arr.= '<td>No</td>';
                        }
                    }
                    
    
                  
                    
                    $arr.= '<td>'.$val->room_title.'</td>';
    
                    $arr.= '<td>'.$val->room_types.'</td>';
    
                    $arr.= '<td>'.$val->booking_changes_count.'</td>';
                    
                    if($val->advance_payment == "" && $val->created_at_checkout == "")
                    {
                        $arr.= '<td>No Deposit</td>';
                    }
                    else
                    {
                        $arr.= '<td>Deposit</td>';
                    }
    
                    $arr.= '<td>'.$val->payment_mode.'</td>';
    
                    if(($val->advance_payment == $val->per_room_price) || $val->created_at_checkout != "")
                    {
                        $arr.= '<td>Fully Paid</td>';
                        
                    }
                    else
                    {
                        $arr.= '<td>Partial</td>';
                    }
    
                    $special_requests = DB::table('special_requests')->where('customer_id',$val->customer_id);
                    $count_special_requests = $special_requests->count();
                    $data_special_requests = $special_requests->pluck('name');
    
                    if($count_special_requests != 0)
                    {
                        $arr.= '<td>'.$count_special_requests.'</td>';
                        
                        $arr.= '<td>'.$data_special_requests.'</td>';
                        
                    }
                    else
                    {
                        $arr.= '<td>0</td>';
                        
                        $arr.= '<td></td>';
                        
                    }
                    
                    if($val->created_at_checkout != "")
                    {
                        $arr.= '<td>check Out</td>';
                        
                        $arr.= '<td>'.$val->created_at_checkout.'</td>';
                    }
                    else if($val->created_at_checkin != "")
                    {
                        $arr.= '<td>check In</td>';
                        
                        $arr.= '<td>'.$val->created_at_checkin.'</td>';
                    }
                    else
                    {
                        $arr.= '<td>Canceled</td>';
                        
                        $arr.= '<td></td>';
                        
                    }
    
                    $arr.= '<td>'.$val->Average_duration.'</td>';
                     
                    $arr.= '<td>'.$val->discount.'</td>';
    
                    if($val->ota_discount == "")
                    {
                        $arr.= '<td>No</td>';
                        
                        $arr.= '<td></td>';
                    }
                    else
                    {
                        $arr.= '<td>Yes</td>';
                        
                        $arr.= '<td>'.$val->ota_discount.'</td>';
                        
                    }
                    if($val->package_id == 0)
                    {
                        $arr.= '<td>Yes</td>';
                    }
                   else
                   {
                        $arr.= '<td>No</td>';
                   }
    
                    $arr.= '<td>'.$availedservices.'</td>';
    
                    $arr.= '<td>'. $val->Availed_Services_Details.'</td>';
                    
                    $arr.= '<td>'. $val->Guest_feedback.'</td>';
    
                    $arr.= '<td>'. $hotetamenitie.'</td>';
    
                    $amenities = explode(",",$val->amenities);
                   
                    foreach($amenities as $vals)
                    {
                        $ameniti = DB::table('amenities')->where("id", $vals)->get();
                        // $amenitie[] = $ameniti[0]->name;
                    }
                    
                //     if(count($ameniti) != 0)
                //     {
                //         $nam = implode(",",$ameniti);
                //         $arr.= '<td>'.$nam.'</td>';
                //     }
                //      else
                //      {
                //          $arr.= '<td></td>';
                //      }
                    
                //   $amenitie[]="";
                   $arr.= '<td></td>';
    
                     $arr.= '<td>'. $val->Hotel_rate.'</td>';
     
                   $arr.= '<td>'. $setting["car_parking_spaces"].'</td>';
    
                     $arr.= '<td>'. $val->Booking_Device.'</td>';
    
                    $arr.= '<td>'. $val->usersname.'</td>';
    
                    $arr.= '<td>'. $val->usersname.'</td>';
    
                    
                    $arr.= '</tr>';
    
                   
                }
            }
            else if($sort_date == 'previous_week')
            {
                $previous_week = strtotime("-1 week +1 day");
                $start_week = strtotime("last monday midnight",$previous_week);
                $end_week = strtotime("next sunday",$start_week);
                $start_week = date("Y-m-d",$start_week);
                $end_week = date("Y-m-d",$end_week);
                $start_next_week = Carbon::now()->startOfWeek();
                $end_next_week =  Carbon::now()->endOfWeek();
                $date = date('Y-m-d', strtotime($start_week)).','.date('Y-m-d', strtotime($end_week));
                $ress= DB::table('reservations')
                ->join('customers','customers.id','=','reservations.customer_id')
                ->join('room_types','room_types.id','=','reservations.room_type_id')
                ->join('amenities','amenities.id','=','room_types.amenities')
                ->join('payment_mode','payment_mode.id','=','reservations.payment_mode')
                ->join('packages','packages.id','=','reservations.package_id')
                ->join('meal_plans','meal_plans.id','=','reservations.meal_plan')
                ->join('users','users.id','=','reservations.Employee_Check_In_name','left outer')
                ->join('ota','ota.name','=','reservations.referred_by','left outer')
                ->select('ota.*','users.*','meal_plans.*','reservations.*','customers.*','room_types.*', 'amenities.*', 'payment_mode.*', 'packages.*','room_types.title as room_title','meal_plans.name as meal_plans_name','customers.name as customer_name','users.name as usersname','reservations.created_at as reservations_created_at','reservations.id as reservations_id')
                ->where('customers.created_at','>=', $start_week)->where('customers.created_at', '<=',$end_week)
                ->orderBy('reservations.id', 'DESC');
                 $res = $ress->groupBy('customer_id')->get();
                foreach( $res as $val)
                {
                    $arr.= '<tr>';
                    $arr.= '<td>'.$val->Booking_id.'</td>';
                    
                     $arr.= '<td>'.$val->customer_name.'</td>';
    
                    $arr.= '<td>'.$val->Reconciliation.'</td>';
                    
                    
                    
                  //$arrivals = $ress->join('arrivals','arrivals.customer_id','=','customers.id','left outer')->select('arrivals.*','arrivals.check_in as arrivals_check_in')->get();
                    
                    
                //      echo "<pre>";
                //  print_r($arrivals);
                 
                //  return ;
                 
                    
                    
                    
    
                    if($val->arrivals_check_in == "" || $val->created_at_checkin !="")
                    {
                        $arr.= '<td>Confirm</td>';
                    }
                    else if($val->arrivals_check_in >= $datetime2)
                    {
                        $arr.= '<td>On request</td>';
                    }
                    else if($val->arrivals_check_in <= $datetime2)
                    {
                        if($val->created_at_checkin =="")
                        {
                            $arr.= '<td>Cancel</td>';
                        }
                        else
                        {
                           $arr.= '<td>Confirm</td>'; 
                        }
                    }
                    
                    $arr.= '<td>'.$val->Booking_Reason.'</td>';
                    
                    $Recon_month = date('F', strtotime($val->created_at_checkin))."-".date('y', strtotime($val->created_at_checkin));
                    $arr.= '<td>'.$Recon_month.'</td>';
                    
                    $arr.= '<td>'.$val->created_at_checkin.'</td>';
                    
                    $arr.= '<td>'.$val->created_at_checkout.'</td>';
                    
                   
                    if($val->duration_of_stay == "" )
                    {
                        $arr.= '<td>0</td>';
                    }
                    else
                    {
                        $arr.= '<td>'.$val->duration_of_stay.'</td>';
                    }
                    
                    $customer_id =  DB::table('reservations')->where('customer_id', "$val->customer_id")->count();
                    $arr.= '<td>'.$customer_id.'</td>';
                   
                    $arr.= '<td>'.$val->base_price.'</td>';
                    
                    $arr.= '<td>'.$val->per_room_price.'</td>';
    
                    if($val->referred_by_name == "OTA")
                    {
                        // if( $val->reconciliation_type != "precentage")
                        // {
                        //     $reconciliation = $val->reconciliation; 
                        // }
                        // else
                        // {
    
                        // }
                        if(!isset($val->LCO_type))
                        {
                            $LCO = 0;
                        }
                        else if($val->LCO_type == "")
                        {
                            $LCO = 0;
                        }
                        else if( $val->LCO_type != "precentage")
                        {
                            $LCO = $val->LCO; 
                        }
                        else
                        {
                            $LCO = ($val->checkout_payment * $val->LCO)/100;
                        }
    
                        if(!isset($val->Meals_type))
                        {
                            $Meal = 0;
                        }
                        else if($val->Meals_type == "")
                        {
                            $Meal = 0;
                        }
                        else if( $val->Meals_type != "precentage")
                        {
                            $Meal = $val->Meals; 
                        }
                        else
                        {
                            $Meal = ($val->checkout_payment * $val->Meals)/100;
                        }
                        
                        if(!isset($val->Net_share_type))
                        {
                            $Net_share = 0;
                        }
                        else if($val->Net_share_type == "")
                        {
                            $Net_share = 0;
                        }
                        else if( $val->Net_share_type != "precentage")
                        {
                            $Net_share = $val->Net_share;
                        }
                        else
                        {
                            $Net_share = ($val->checkout_payment * $val->Net_share)/100;
                        }
    
                         if(!isset($val->Tax_commissions_type))
                        {
                            $Tax_commissions = 0;
                        }
                        else if($val->Tax_commissions_type == "")
                        {
                            $Tax_commissions = 0;
                        }
                        else if( $val->Tax_commissions_type != "precentage")
                        {
                            $Tax_commissions = $val->Tax_commissions;
                        }
                        else
                        {
                            $Tax_commissions = ($val->checkout_payment * $val->Tax_commissions)/100;
                        }
    
                        // if(!isset($val->post_tax_type))
                        // {
                        //     $post_tax = 0;
                        // }
                        // else if($val->post_tax_type == "")
                        // {
                        //     $post_tax = 0;
                        // }
                        // else if( $val->post_tax_type != "precentage")
                        // {
                        //     $post_tax = $val->post_tax; 
                        // }
                        // else
                        // {
                        //     $post_tax = ($val->checkout_payment * $val->post_tax)/100;
                        // }
    
                         if(!isset($val->TDS_type))
                        {
                            $TDS = 0;
                        }
                        else if($val->TDS_type == "")
                        {
                            $TDS = "";
                        }
                        else if( $val->TDS_type != "precentage")
                        {
                            $TDS = $val->TDS; 
                        }
                        else
                        {
                            $TDS = ($val->checkout_payment * $val->TDS)/100;
                        }
    
                        if(!isset($val->TDS_Deducted_type))
                        {
                            $TDS_Deducted = 0;
                        }
                        else if($val->TDS_Deducted_type == "")
                        {
                            $TDS_Deducted = 0;
                        }
                        else if( $val->TDS_Deducted_type != "precentage")
                        {
                            $TDS_Deducted =$val->TDS_Deducted; 
                        }
                        else
                        {
                            $TDS_Deducted = ($val->checkout_payment * $val->TDS_Deducted)/100;
                        }
    
                        if(!isset($val->TCS_type))
                        {
                            $TCS = 0;
                        }
                        else if($val->TCS_type == "")
                        {
                            $TCS = 0;
                        }
                        else if( $val->	TCS_type != "precentage")
                        {
                            $TCS = $val->TCS; 
                        }
                        else
                        {
                            $TCS = ($val->checkout_payment * $val->TCS)/100;
                        }
                        
                        if($val->created_at_checkout !="")
                        {
                            if($val->checkin_type == "single")
                            {
                                $tat =  ($val->per_room_price*$val->duration_of_stay* $val->room_qty) + ($LCO + $Meal - $Net_share - $Tax_commissions);
                            }
                            else
                            {
                                $tat =  ($val->per_room_price*$val->duration_of_stay*($val->room_qty+1)) + ($LCO + $Meal - $Net_share - $Tax_commissions);
                            }
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$LCO.'</td>';
                            
                            $arr.= '<td>'.$Meal.'</td>';
                            
                            $arr.= '<td>'.$Net_share.'</td>';
                            
                            $arr.= '<td>'.$Tax_commissions.'</td>';
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$TDS.'</td>';
                            
                            $arr.= '<td>'.$TDS_Deducted.'</td>';
                            
                            $arr.= '<td>'.$TCS.'</td>';
                        
                        }
                        else
                        {
                            $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                            $arr.= '<td>'.$val->checkout_payment.'</td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                        }
                        
                    }
                    else
                    {
                        
                        $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                        $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                    
                    }
                
                    $arr.= '<td>'.$val->mobile.'</td>';
                
                    $arr.= '<td>'.$val->email.'</td>';
                
                    $arr.= '<td>'.$val->gender.'</td>';
                
                    $arr.= '<td>'.$val->dob.'</td>';
                
                   $arr.= '<td>'.$val->address.'</td>';
                   
                   $arr.= '<td>'.$setting["hotel_name"].'</td>';
                   
                   $arr.= '<td>'.$setting["hotel_address"].'</td>';
                   
                   $arr.= '<td>'.$setting["Hotel_Star"].'</td>';
                   
                   $arr.= '<td>'.date("Y-m-d", strtotime($val->reservations_created_at)).'</td>';
                   
                   $arr.= '<td>'.date("H:i:s", strtotime($val->reservations_created_at)).'</td>';
                   
                   $arr.= '<td>'. $val->created_at_checkin.'</td>';
                   
                   $arr.= '<td>'. $val->created_at_checkout.'</td>';
                   
                   $arr.= '<td>'. $val->adult.'</td>';
                   
                   $arr.= '<td>'. $val->kids.'</td>';
                    
                   $person_lists = DB::table('person_lists')->where('age','<','18')->where('reservation_id',$val->reservations_id)->pluck('age');
                   if($person_lists == '')
                   {
                       $arr.= '<td>0</td>';
                   }
                    else if(count($person_lists) == 0)
                   {
                       $arr.= '<td>0</td>';
                   }
                   else
                   {
                       $arr.= '<td>'. $person_lists.'</td>';
                   }
                    
                   $arr.= '<td>'. $val->infant.'</td>';
                    
                    $arr.= '<td>'. $val->meal_plans_name.'</td>';
                   
                    $arr.= '<td>'. $setting["Hotel_city"].'</td>';
                   
                    if($val->referred_by == "")
                    {
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                        
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                         
                    }
                    else
                    {
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                        
                        $arr.= '<td>'. $val->referred_by.'</td>';
                         
                    }
                    
                   
                    
                    $rep = DB::table("reservations")->join('customers','customers.id','=','reservations.customer_id','left outer')->where("mobile",$val->mobile)->select('customers.*','reservations.*','reservations.id as reservations_id')->where("reservations.id",'<',197)->take(1)->count();
                   if($rep ==0)
                    {
                        $arr.= '<td>No</td>';
                        $arr.= '<td></td>';
                    
                        $arr.= '<td></td>';
                    
                    
                    }
                    else
                    {
                        if($val->arrivals_check_in == "" && $val->created_at_checkin !="")
                        {
                            $arr.= '<td>yes</td>';
                            
                            $arr.= '<td>No</td>';
                    
                            $arr.= '<td>Yes</td>';
                            
                        }
                        else if($val->arrivals_check_in != "" and $datetime2 >$val->arrivals_check_in)
                        {
                            $arr.= '<td>Yes</td>';
                            
                            $arr.= '<td>Yes</td>';
                    
                            $arr.= '<td>No</td>';
                        }
                    }
                    
    
                  
                    
                    $arr.= '<td>'.$val->room_title.'</td>';
    
                    $arr.= '<td>'.$val->room_types.'</td>';
    
                    $arr.= '<td>'.$val->booking_changes_count.'</td>';
                    
                    if($val->advance_payment == "" && $val->created_at_checkout == "")
                    {
                        $arr.= '<td>No Deposit</td>';
                    }
                    else
                    {
                        $arr.= '<td>Deposit</td>';
                    }
    
                    $arr.= '<td>'.$val->payment_mode.'</td>';
    
                    if(($val->advance_payment == $val->per_room_price) || $val->created_at_checkout != "")
                    {
                        $arr.= '<td>Fully Paid</td>';
                        
                    }
                    else
                    {
                        $arr.= '<td>Partial</td>';
                    }
    
                    $special_requests = DB::table('special_requests')->where('customer_id',$val->customer_id);
                    $count_special_requests = $special_requests->count();
                    $data_special_requests = $special_requests->pluck('name');
    
                    if($count_special_requests != 0)
                    {
                        $arr.= '<td>'.$count_special_requests.'</td>';
                        
                        $arr.= '<td>'.$data_special_requests.'</td>';
                        
                    }
                    else
                    {
                        $arr.= '<td>0</td>';
                        
                        $arr.= '<td></td>';
                        
                    }
                    
                    if($val->created_at_checkout != "")
                    {
                        $arr.= '<td>check Out</td>';
                        
                        $arr.= '<td>'.$val->created_at_checkout.'</td>';
                    }
                    else if($val->created_at_checkin != "")
                    {
                        $arr.= '<td>check In</td>';
                        
                        $arr.= '<td>'.$val->created_at_checkin.'</td>';
                    }
                    else
                    {
                        $arr.= '<td>Canceled</td>';
                        
                        $arr.= '<td></td>';
                        
                    }
    
                    $arr.= '<td>'.$val->Average_duration.'</td>';
                     
                    $arr.= '<td>'.$val->discount.'</td>';
    
                    if($val->ota_discount == "")
                    {
                        $arr.= '<td>No</td>';
                        
                        $arr.= '<td></td>';
                    }
                    else
                    {
                        $arr.= '<td>Yes</td>';
                        
                        $arr.= '<td>'.$val->ota_discount.'</td>';
                        
                    }
                    if($val->package_id == 0)
                    {
                        $arr.= '<td>Yes</td>';
                    }
                   else
                   {
                        $arr.= '<td>No</td>';
                   }
    
                    $arr.= '<td>'.$availedservices.'</td>';
    
                    $arr.= '<td>'. $val->Availed_Services_Details.'</td>';
                    
                    $arr.= '<td>'. $val->Guest_feedback.'</td>';
    
                    $arr.= '<td>'. $hotetamenitie.'</td>';
    
                    $amenities = explode(",",$val->amenities);
                   
                    foreach($amenities as $vals)
                    {
                        $ameniti = DB::table('amenities')->where("id", $vals)->get();
                        // $amenitie[] = $ameniti[0]->name;
                    }
                    
                //     if(count($ameniti) != 0)
                //     {
                //         $nam = implode(",",$ameniti);
                //         $arr.= '<td>'.$nam.'</td>';
                //     }
                //      else
                //      {
                //          $arr.= '<td></td>';
                //      }
                    
                //   $amenitie[]="";
                   $arr.= '<td></td>';
    
                     $arr.= '<td>'. $val->Hotel_rate.'</td>';
     
                   $arr.= '<td>'. $setting["car_parking_spaces"].'</td>';
    
                     $arr.= '<td>'. $val->Booking_Device.'</td>';
    
                    $arr.= '<td>'. $val->usersname.'</td>';
    
                    $arr.= '<td>'. $val->usersname.'</td>';
    
                    
                    $arr.= '</tr>';
    
                   
                }
            }
            else if($sort_date == 'this_month')
                {
                    $month = date('m');
                    $curr_date = Carbon::now();
                    $monthName = $curr_date->format('F');
                    if($month == 12)
                    {
                        $next_month = 1;
                    }
                    else{
                        $next_month = (int)$month+(int)1;
                    }
                    $date = $monthName;
                 $ress= DB::table('reservations')
                ->join('customers','customers.id','=','reservations.customer_id')
                ->join('room_types','room_types.id','=','reservations.room_type_id')
                ->join('amenities','amenities.id','=','room_types.amenities')
                ->join('payment_mode','payment_mode.id','=','reservations.payment_mode')
                ->join('packages','packages.id','=','reservations.package_id')
                ->join('meal_plans','meal_plans.id','=','reservations.meal_plan')
                ->join('users','users.id','=','reservations.Employee_Check_In_name','left outer')
                ->join('ota','ota.name','=','reservations.referred_by','left outer')
                ->select('ota.*','users.*','meal_plans.*','reservations.*','customers.*','room_types.*', 'amenities.*', 'payment_mode.*', 'packages.*','room_types.title as room_title','meal_plans.name as meal_plans_name','customers.name as customer_name','users.name as usersname','reservations.created_at as reservations_created_at','reservations.id as reservations_id')
                ->where('customers.created_at','>=', $month)
                ->orderBy('reservations.id', 'DESC');
                 $res = $ress->groupBy('customer_id')->get();
                foreach( $res as $val)
                {
                    $arr.= '<tr>';
                    $arr.= '<td>'.$val->Booking_id.'</td>';
                    
                     $arr.= '<td>'.$val->customer_name.'</td>';
    
                    $arr.= '<td>'.$val->Reconciliation.'</td>';
                    
                    
                    
                  //$arrivals = $ress->join('arrivals','arrivals.customer_id','=','customers.id','left outer')->select('arrivals.*','arrivals.check_in as arrivals_check_in')->get();
                    
                    
                //      echo "<pre>";
                //  print_r($arrivals);
                 
                //  return ;
                 
                    
                    
                    
    
                    if($val->arrivals_check_in == "" || $val->created_at_checkin !="")
                    {
                        $arr.= '<td>Confirm</td>';
                    }
                    else if($val->arrivals_check_in >= $datetime2)
                    {
                        $arr.= '<td>On request</td>';
                    }
                    else if($val->arrivals_check_in <= $datetime2)
                    {
                        if($val->created_at_checkin =="")
                        {
                            $arr.= '<td>Cancel</td>';
                        }
                        else
                        {
                           $arr.= '<td>Confirm</td>'; 
                        }
                    }
                    
                    $arr.= '<td>'.$val->Booking_Reason.'</td>';
                    
                    $Recon_month = date('F', strtotime($val->created_at_checkin))."-".date('y', strtotime($val->created_at_checkin));
                    $arr.= '<td>'.$Recon_month.'</td>';
                    
                    $arr.= '<td>'.$val->created_at_checkin.'</td>';
                    
                    $arr.= '<td>'.$val->created_at_checkout.'</td>';
                    
                   
                    if($val->duration_of_stay == "" )
                    {
                        $arr.= '<td>0</td>';
                    }
                    else
                    {
                        $arr.= '<td>'.$val->duration_of_stay.'</td>';
                    }
                    
                    $customer_id =  DB::table('reservations')->where('customer_id', "$val->customer_id")->count();
                    $arr.= '<td>'.$customer_id.'</td>';
                   
                    $arr.= '<td>'.$val->base_price.'</td>';
                    
                    $arr.= '<td>'.$val->per_room_price.'</td>';
    
                    if($val->referred_by_name == "OTA")
                    {
                        // if( $val->reconciliation_type != "precentage")
                        // {
                        //     $reconciliation = $val->reconciliation; 
                        // }
                        // else
                        // {
    
                        // }
                        if(!isset($val->LCO_type))
                        {
                            $LCO = 0;
                        }
                        else if($val->LCO_type == "")
                        {
                            $LCO = 0;
                        }
                        else if( $val->LCO_type != "precentage")
                        {
                            $LCO = $val->LCO; 
                        }
                        else
                        {
                            $LCO = ($val->checkout_payment * $val->LCO)/100;
                        }
    
                        if(!isset($val->Meals_type))
                        {
                            $Meal = 0;
                        }
                        else if($val->Meals_type == "")
                        {
                            $Meal = 0;
                        }
                        else if( $val->Meals_type != "precentage")
                        {
                            $Meal = $val->Meals; 
                        }
                        else
                        {
                            $Meal = ($val->checkout_payment * $val->Meals)/100;
                        }
                        
                        if(!isset($val->Net_share_type))
                        {
                            $Net_share = 0;
                        }
                        else if($val->Net_share_type == "")
                        {
                            $Net_share = 0;
                        }
                        else if( $val->Net_share_type != "precentage")
                        {
                            $Net_share = $val->Net_share;
                        }
                        else
                        {
                            $Net_share = ($val->checkout_payment * $val->Net_share)/100;
                        }
    
                         if(!isset($val->Tax_commissions_type))
                        {
                            $Tax_commissions = 0;
                        }
                        else if($val->Tax_commissions_type == "")
                        {
                            $Tax_commissions = 0;
                        }
                        else if( $val->Tax_commissions_type != "precentage")
                        {
                            $Tax_commissions = $val->Tax_commissions;
                        }
                        else
                        {
                            $Tax_commissions = ($val->checkout_payment * $val->Tax_commissions)/100;
                        }
    
                        // if(!isset($val->post_tax_type))
                        // {
                        //     $post_tax = 0;
                        // }
                        // else if($val->post_tax_type == "")
                        // {
                        //     $post_tax = 0;
                        // }
                        // else if( $val->post_tax_type != "precentage")
                        // {
                        //     $post_tax = $val->post_tax; 
                        // }
                        // else
                        // {
                        //     $post_tax = ($val->checkout_payment * $val->post_tax)/100;
                        // }
    
                         if(!isset($val->TDS_type))
                        {
                            $TDS = 0;
                        }
                        else if($val->TDS_type == "")
                        {
                            $TDS = "";
                        }
                        else if( $val->TDS_type != "precentage")
                        {
                            $TDS = $val->TDS; 
                        }
                        else
                        {
                            $TDS = ($val->checkout_payment * $val->TDS)/100;
                        }
    
                        if(!isset($val->TDS_Deducted_type))
                        {
                            $TDS_Deducted = 0;
                        }
                        else if($val->TDS_Deducted_type == "")
                        {
                            $TDS_Deducted = 0;
                        }
                        else if( $val->TDS_Deducted_type != "precentage")
                        {
                            $TDS_Deducted =$val->TDS_Deducted; 
                        }
                        else
                        {
                            $TDS_Deducted = ($val->checkout_payment * $val->TDS_Deducted)/100;
                        }
    
                        if(!isset($val->TCS_type))
                        {
                            $TCS = 0;
                        }
                        else if($val->TCS_type == "")
                        {
                            $TCS = 0;
                        }
                        else if( $val->	TCS_type != "precentage")
                        {
                            $TCS = $val->TCS; 
                        }
                        else
                        {
                            $TCS = ($val->checkout_payment * $val->TCS)/100;
                        }
                        
                        if($val->created_at_checkout !="")
                        {
                            if($val->checkin_type == "single")
                            {
                                $tat =  ($val->per_room_price*$val->duration_of_stay* $val->room_qty) + ($LCO + $Meal - $Net_share - $Tax_commissions);
                            }
                            else
                            {
                                $tat =  ($val->per_room_price*$val->duration_of_stay*($val->room_qty+1)) + ($LCO + $Meal - $Net_share - $Tax_commissions);
                            }
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$LCO.'</td>';
                            
                            $arr.= '<td>'.$Meal.'</td>';
                            
                            $arr.= '<td>'.$Net_share.'</td>';
                            
                            $arr.= '<td>'.$Tax_commissions.'</td>';
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$TDS.'</td>';
                            
                            $arr.= '<td>'.$TDS_Deducted.'</td>';
                            
                            $arr.= '<td>'.$TCS.'</td>';
                        
                        }
                        else
                        {
                            $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                            $arr.= '<td>'.$val->checkout_payment.'</td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                        }
                        
                    }
                    else
                    {
                        
                        $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                        $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                    
                    }
                
                    $arr.= '<td>'.$val->mobile.'</td>';
                
                    $arr.= '<td>'.$val->email.'</td>';
                
                    $arr.= '<td>'.$val->gender.'</td>';
                
                    $arr.= '<td>'.$val->dob.'</td>';
                
                   $arr.= '<td>'.$val->address.'</td>';
                   
                   $arr.= '<td>'.$setting["hotel_name"].'</td>';
                   
                   $arr.= '<td>'.$setting["hotel_address"].'</td>';
                   
                   $arr.= '<td>'.$setting["Hotel_Star"].'</td>';
                   
                   $arr.= '<td>'.date("Y-m-d", strtotime($val->reservations_created_at)).'</td>';
                   
                   $arr.= '<td>'.date("H:i:s", strtotime($val->reservations_created_at)).'</td>';
                   
                   $arr.= '<td>'. $val->created_at_checkin.'</td>';
                   
                   $arr.= '<td>'. $val->created_at_checkout.'</td>';
                   
                   $arr.= '<td>'. $val->adult.'</td>';
                   
                   $arr.= '<td>'. $val->kids.'</td>';
                    
                   $person_lists = DB::table('person_lists')->where('age','<','18')->where('reservation_id',$val->reservations_id)->pluck('age');
                   if($person_lists == '')
                   {
                       $arr.= '<td>0</td>';
                   }
                    else if(count($person_lists) == 0)
                   {
                       $arr.= '<td>0</td>';
                   }
                   else
                   {
                       $arr.= '<td>'. $person_lists.'</td>';
                   }
                    
                   $arr.= '<td>'. $val->infant.'</td>';
                    
                    $arr.= '<td>'. $val->meal_plans_name.'</td>';
                   
                    $arr.= '<td>'. $setting["Hotel_city"].'</td>';
                   
                    if($val->referred_by == "")
                    {
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                        
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                         
                    }
                    else
                    {
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                        
                        $arr.= '<td>'. $val->referred_by.'</td>';
                         
                    }
                    
                   
                    
                    $rep = DB::table("reservations")->join('customers','customers.id','=','reservations.customer_id','left outer')->where("mobile",$val->mobile)->select('customers.*','reservations.*','reservations.id as reservations_id')->where("reservations.id",'<',197)->take(1)->count();
                   if($rep ==0)
                    {
                        $arr.= '<td>No</td>';
                        $arr.= '<td></td>';
                    
                        $arr.= '<td></td>';
                    
                    
                    }
                    else
                    {
                        if($val->arrivals_check_in == "" && $val->created_at_checkin !="")
                        {
                            $arr.= '<td>yes</td>';
                            
                            $arr.= '<td>No</td>';
                    
                            $arr.= '<td>Yes</td>';
                            
                        }
                        else if($val->arrivals_check_in != "" and $datetime2 >$val->arrivals_check_in)
                        {
                            $arr.= '<td>Yes</td>';
                            
                            $arr.= '<td>Yes</td>';
                    
                            $arr.= '<td>No</td>';
                        }
                    }
                    
    
                  
                    
                    $arr.= '<td>'.$val->room_title.'</td>';
    
                    $arr.= '<td>'.$val->room_types.'</td>';
    
                    $arr.= '<td>'.$val->booking_changes_count.'</td>';
                    
                    if($val->advance_payment == "" && $val->created_at_checkout == "")
                    {
                        $arr.= '<td>No Deposit</td>';
                    }
                    else
                    {
                        $arr.= '<td>Deposit</td>';
                    }
    
                    $arr.= '<td>'.$val->payment_mode.'</td>';
    
                    if(($val->advance_payment == $val->per_room_price) || $val->created_at_checkout != "")
                    {
                        $arr.= '<td>Fully Paid</td>';
                        
                    }
                    else
                    {
                        $arr.= '<td>Partial</td>';
                    }
    
                    $special_requests = DB::table('special_requests')->where('customer_id',$val->customer_id);
                    $count_special_requests = $special_requests->count();
                    $data_special_requests = $special_requests->pluck('name');
    
                    if($count_special_requests != 0)
                    {
                        $arr.= '<td>'.$count_special_requests.'</td>';
                        
                        $arr.= '<td>'.$data_special_requests.'</td>';
                        
                    }
                    else
                    {
                        $arr.= '<td>0</td>';
                        
                        $arr.= '<td></td>';
                        
                    }
                    
                    if($val->created_at_checkout != "")
                    {
                        $arr.= '<td>check Out</td>';
                        
                        $arr.= '<td>'.$val->created_at_checkout.'</td>';
                    }
                    else if($val->created_at_checkin != "")
                    {
                        $arr.= '<td>check In</td>';
                        
                        $arr.= '<td>'.$val->created_at_checkin.'</td>';
                    }
                    else
                    {
                        $arr.= '<td>Canceled</td>';
                        
                        $arr.= '<td></td>';
                        
                    }
    
                    $arr.= '<td>'.$val->Average_duration.'</td>';
                     
                    $arr.= '<td>'.$val->discount.'</td>';
    
                    if($val->ota_discount == "")
                    {
                        $arr.= '<td>No</td>';
                        
                        $arr.= '<td></td>';
                    }
                    else
                    {
                        $arr.= '<td>Yes</td>';
                        
                        $arr.= '<td>'.$val->ota_discount.'</td>';
                        
                    }
                    if($val->package_id == 0)
                    {
                        $arr.= '<td>Yes</td>';
                    }
                   else
                   {
                        $arr.= '<td>No</td>';
                   }
    
                    $arr.= '<td>'.$availedservices.'</td>';
    
                    $arr.= '<td>'. $val->Availed_Services_Details.'</td>';
                    
                    $arr.= '<td>'. $val->Guest_feedback.'</td>';
    
                    $arr.= '<td>'. $hotetamenitie.'</td>';
    
                    $amenities = explode(",",$val->amenities);
                   
                    foreach($amenities as $vals)
                    {
                        $ameniti = DB::table('amenities')->where("id", $vals)->get();
                        // $amenitie[] = $ameniti[0]->name;
                    }
                    
                //     if(count($ameniti) != 0)
                //     {
                //         $nam = implode(",",$ameniti);
                //         $arr.= '<td>'.$nam.'</td>';
                //     }
                //      else
                //      {
                //          $arr.= '<td></td>';
                //      }
                    
                //   $amenitie[]="";
                   $arr.= '<td></td>';
    
                     $arr.= '<td>'. $val->Hotel_rate.'</td>';
     
                   $arr.= '<td>'. $setting["car_parking_spaces"].'</td>';
    
                     $arr.= '<td>'. $val->Booking_Device.'</td>';
    
                    $arr.= '<td>'. $val->usersname.'</td>';
    
                    $arr.= '<td>'. $val->usersname.'</td>';
    
                    
                    $arr.= '</tr>';
    
                   
                }
            }
            else if($sort_date == 'previous_month')
            {
                $month = date('m');
                if($month == 1)
                {
                    $previous_month = '12';
                }
                else{
                    $previous_month = (int)$month-(int)1;
                }
                $monthName = date("F", mktime(0, 0, 0, $previous_month, 1));
                $date = $monthName;
                 $ress= DB::table('reservations')
                ->join('customers','customers.id','=','reservations.customer_id')
                ->join('room_types','room_types.id','=','reservations.room_type_id')
                ->join('amenities','amenities.id','=','room_types.amenities')
                ->join('payment_mode','payment_mode.id','=','reservations.payment_mode')
                ->join('packages','packages.id','=','reservations.package_id')
                ->join('meal_plans','meal_plans.id','=','reservations.meal_plan')
                ->join('users','users.id','=','reservations.Employee_Check_In_name','left outer')
                ->join('ota','ota.name','=','reservations.referred_by','left outer')
                ->select('ota.*','users.*','meal_plans.*','reservations.*','customers.*','room_types.*', 'amenities.*', 'payment_mode.*', 'packages.*','room_types.title as room_title','meal_plans.name as meal_plans_name','customers.name as customer_name','users.name as usersname','reservations.created_at as reservations_created_at','reservations.id as reservations_id')
                ->where('customers.created_at', '>=', $previous_month)
                ->orderBy('reservations.id', 'DESC');
                 $res = $ress->groupBy('customer_id')->get();
                foreach( $res as $val)
                {
                    $arr.= '<tr>';
                    $arr.= '<td>'.$val->Booking_id.'</td>';
                    
                     $arr.= '<td>'.$val->customer_name.'</td>';
    
                    $arr.= '<td>'.$val->Reconciliation.'</td>';
                    
                    
                    
                  //$arrivals = $ress->join('arrivals','arrivals.customer_id','=','customers.id','left outer')->select('arrivals.*','arrivals.check_in as arrivals_check_in')->get();
                    
                    
                //      echo "<pre>";
                //  print_r($arrivals);
                 
                //  return ;
                 
                    
                    
                    
    
                    if($val->arrivals_check_in == "" || $val->created_at_checkin !="")
                    {
                        $arr.= '<td>Confirm</td>';
                    }
                    else if($val->arrivals_check_in >= $datetime2)
                    {
                        $arr.= '<td>On request</td>';
                    }
                    else if($val->arrivals_check_in <= $datetime2)
                    {
                        if($val->created_at_checkin =="")
                        {
                            $arr.= '<td>Cancel</td>';
                        }
                        else
                        {
                           $arr.= '<td>Confirm</td>'; 
                        }
                    }
                    
                    $arr.= '<td>'.$val->Booking_Reason.'</td>';
                    
                    $Recon_month = date('F', strtotime($val->created_at_checkin))."-".date('y', strtotime($val->created_at_checkin));
                    $arr.= '<td>'.$Recon_month.'</td>';
                    
                    $arr.= '<td>'.$val->created_at_checkin.'</td>';
                    
                    $arr.= '<td>'.$val->created_at_checkout.'</td>';
                    
                   
                    if($val->duration_of_stay == "" )
                    {
                        $arr.= '<td>0</td>';
                    }
                    else
                    {
                        $arr.= '<td>'.$val->duration_of_stay.'</td>';
                    }
                    
                    $customer_id =  DB::table('reservations')->where('customer_id', "$val->customer_id")->count();
                    $arr.= '<td>'.$customer_id.'</td>';
                   
                    $arr.= '<td>'.$val->base_price.'</td>';
                    
                    $arr.= '<td>'.$val->per_room_price.'</td>';
    
                    if($val->referred_by_name == "OTA")
                    {
                        // if( $val->reconciliation_type != "precentage")
                        // {
                        //     $reconciliation = $val->reconciliation; 
                        // }
                        // else
                        // {
    
                        // }
                        if(!isset($val->LCO_type))
                        {
                            $LCO = 0;
                        }
                        else if($val->LCO_type == "")
                        {
                            $LCO = 0;
                        }
                        else if( $val->LCO_type != "precentage")
                        {
                            $LCO = $val->LCO; 
                        }
                        else
                        {
                            $LCO = ($val->checkout_payment * $val->LCO)/100;
                        }
    
                        if(!isset($val->Meals_type))
                        {
                            $Meal = 0;
                        }
                        else if($val->Meals_type == "")
                        {
                            $Meal = 0;
                        }
                        else if( $val->Meals_type != "precentage")
                        {
                            $Meal = $val->Meals; 
                        }
                        else
                        {
                            $Meal = ($val->checkout_payment * $val->Meals)/100;
                        }
                        
                        if(!isset($val->Net_share_type))
                        {
                            $Net_share = 0;
                        }
                        else if($val->Net_share_type == "")
                        {
                            $Net_share = 0;
                        }
                        else if( $val->Net_share_type != "precentage")
                        {
                            $Net_share = $val->Net_share;
                        }
                        else
                        {
                            $Net_share = ($val->checkout_payment * $val->Net_share)/100;
                        }
    
                         if(!isset($val->Tax_commissions_type))
                        {
                            $Tax_commissions = 0;
                        }
                        else if($val->Tax_commissions_type == "")
                        {
                            $Tax_commissions = 0;
                        }
                        else if( $val->Tax_commissions_type != "precentage")
                        {
                            $Tax_commissions = $val->Tax_commissions;
                        }
                        else
                        {
                            $Tax_commissions = ($val->checkout_payment * $val->Tax_commissions)/100;
                        }
    
                        // if(!isset($val->post_tax_type))
                        // {
                        //     $post_tax = 0;
                        // }
                        // else if($val->post_tax_type == "")
                        // {
                        //     $post_tax = 0;
                        // }
                        // else if( $val->post_tax_type != "precentage")
                        // {
                        //     $post_tax = $val->post_tax; 
                        // }
                        // else
                        // {
                        //     $post_tax = ($val->checkout_payment * $val->post_tax)/100;
                        // }
    
                         if(!isset($val->TDS_type))
                        {
                            $TDS = 0;
                        }
                        else if($val->TDS_type == "")
                        {
                            $TDS = "";
                        }
                        else if( $val->TDS_type != "precentage")
                        {
                            $TDS = $val->TDS; 
                        }
                        else
                        {
                            $TDS = ($val->checkout_payment * $val->TDS)/100;
                        }
    
                        if(!isset($val->TDS_Deducted_type))
                        {
                            $TDS_Deducted = 0;
                        }
                        else if($val->TDS_Deducted_type == "")
                        {
                            $TDS_Deducted = 0;
                        }
                        else if( $val->TDS_Deducted_type != "precentage")
                        {
                            $TDS_Deducted =$val->TDS_Deducted; 
                        }
                        else
                        {
                            $TDS_Deducted = ($val->checkout_payment * $val->TDS_Deducted)/100;
                        }
    
                        if(!isset($val->TCS_type))
                        {
                            $TCS = 0;
                        }
                        else if($val->TCS_type == "")
                        {
                            $TCS = 0;
                        }
                        else if( $val->	TCS_type != "precentage")
                        {
                            $TCS = $val->TCS; 
                        }
                        else
                        {
                            $TCS = ($val->checkout_payment * $val->TCS)/100;
                        }
                        
                        if($val->created_at_checkout !="")
                        {
                            if($val->checkin_type == "single")
                            {
                                $tat =  ($val->per_room_price*$val->duration_of_stay* $val->room_qty) + ($LCO + $Meal - $Net_share - $Tax_commissions);
                            }
                            else
                            {
                                $tat =  ($val->per_room_price*$val->duration_of_stay*($val->room_qty+1)) + ($LCO + $Meal - $Net_share - $Tax_commissions);
                            }
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$LCO.'</td>';
                            
                            $arr.= '<td>'.$Meal.'</td>';
                            
                            $arr.= '<td>'.$Net_share.'</td>';
                            
                            $arr.= '<td>'.$Tax_commissions.'</td>';
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$TDS.'</td>';
                            
                            $arr.= '<td>'.$TDS_Deducted.'</td>';
                            
                            $arr.= '<td>'.$TCS.'</td>';
                        
                        }
                        else
                        {
                            $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                            $arr.= '<td>'.$val->checkout_payment.'</td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                        }
                        
                    }
                    else
                    {
                        
                        $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                        $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                    
                    }
                
                    $arr.= '<td>'.$val->mobile.'</td>';
                
                    $arr.= '<td>'.$val->email.'</td>';
                
                    $arr.= '<td>'.$val->gender.'</td>';
                
                    $arr.= '<td>'.$val->dob.'</td>';
                
                   $arr.= '<td>'.$val->address.'</td>';
                   
                   $arr.= '<td>'.$setting["hotel_name"].'</td>';
                   
                   $arr.= '<td>'.$setting["hotel_address"].'</td>';
                   
                   $arr.= '<td>'.$setting["Hotel_Star"].'</td>';
                   
                   $arr.= '<td>'.date("Y-m-d", strtotime($val->reservations_created_at)).'</td>';
                   
                   $arr.= '<td>'.date("H:i:s", strtotime($val->reservations_created_at)).'</td>';
                   
                   $arr.= '<td>'. $val->created_at_checkin.'</td>';
                   
                   $arr.= '<td>'. $val->created_at_checkout.'</td>';
                   
                   $arr.= '<td>'. $val->adult.'</td>';
                   
                   $arr.= '<td>'. $val->kids.'</td>';
                    
                   $person_lists = DB::table('person_lists')->where('age','<','18')->where('reservation_id',$val->reservations_id)->pluck('age');
                   if($person_lists == '')
                   {
                       $arr.= '<td>0</td>';
                   }
                    else if(count($person_lists) == 0)
                   {
                       $arr.= '<td>0</td>';
                   }
                   else
                   {
                       $arr.= '<td>'. $person_lists.'</td>';
                   }
                    
                   $arr.= '<td>'. $val->infant.'</td>';
                    
                    $arr.= '<td>'. $val->meal_plans_name.'</td>';
                   
                    $arr.= '<td>'. $setting["Hotel_city"].'</td>';
                   
                    if($val->referred_by == "")
                    {
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                        
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                         
                    }
                    else
                    {
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                        
                        $arr.= '<td>'. $val->referred_by.'</td>';
                         
                    }
                    
                   
                    
                    $rep = DB::table("reservations")->join('customers','customers.id','=','reservations.customer_id','left outer')->where("mobile",$val->mobile)->select('customers.*','reservations.*','reservations.id as reservations_id')->where("reservations.id",'<',197)->take(1)->count();
                   if($rep ==0)
                    {
                        $arr.= '<td>No</td>';
                        $arr.= '<td></td>';
                    
                        $arr.= '<td></td>';
                    
                    
                    }
                    else
                    {
                        if($val->arrivals_check_in == "" && $val->created_at_checkin !="")
                        {
                            $arr.= '<td>yes</td>';
                            
                            $arr.= '<td>No</td>';
                    
                            $arr.= '<td>Yes</td>';
                            
                        }
                        else if($val->arrivals_check_in != "" and $datetime2 >$val->arrivals_check_in)
                        {
                            $arr.= '<td>Yes</td>';
                            
                            $arr.= '<td>Yes</td>';
                    
                            $arr.= '<td>No</td>';
                        }
                    }
                    
    
                  
                    
                    $arr.= '<td>'.$val->room_title.'</td>';
    
                    $arr.= '<td>'.$val->room_types.'</td>';
    
                    $arr.= '<td>'.$val->booking_changes_count.'</td>';
                    
                    if($val->advance_payment == "" && $val->created_at_checkout == "")
                    {
                        $arr.= '<td>No Deposit</td>';
                    }
                    else
                    {
                        $arr.= '<td>Deposit</td>';
                    }
    
                    $arr.= '<td>'.$val->payment_mode.'</td>';
    
                    if(($val->advance_payment == $val->per_room_price) || $val->created_at_checkout != "")
                    {
                        $arr.= '<td>Fully Paid</td>';
                        
                    }
                    else
                    {
                        $arr.= '<td>Partial</td>';
                    }
    
                    $special_requests = DB::table('special_requests')->where('customer_id',$val->customer_id);
                    $count_special_requests = $special_requests->count();
                    $data_special_requests = $special_requests->pluck('name');
    
                    if($count_special_requests != 0)
                    {
                        $arr.= '<td>'.$count_special_requests.'</td>';
                        
                        $arr.= '<td>'.$data_special_requests.'</td>';
                        
                    }
                    else
                    {
                        $arr.= '<td>0</td>';
                        
                        $arr.= '<td></td>';
                        
                    }
                    
                    if($val->created_at_checkout != "")
                    {
                        $arr.= '<td>check Out</td>';
                        
                        $arr.= '<td>'.$val->created_at_checkout.'</td>';
                    }
                    else if($val->created_at_checkin != "")
                    {
                        $arr.= '<td>check In</td>';
                        
                        $arr.= '<td>'.$val->created_at_checkin.'</td>';
                    }
                    else
                    {
                        $arr.= '<td>Canceled</td>';
                        
                        $arr.= '<td></td>';
                        
                    }
    
                    $arr.= '<td>'.$val->Average_duration.'</td>';
                     
                    $arr.= '<td>'.$val->discount.'</td>';
    
                    if($val->ota_discount == "")
                    {
                        $arr.= '<td>No</td>';
                        
                        $arr.= '<td></td>';
                    }
                    else
                    {
                        $arr.= '<td>Yes</td>';
                        
                        $arr.= '<td>'.$val->ota_discount.'</td>';
                        
                    }
                    if($val->package_id == 0)
                    {
                        $arr.= '<td>Yes</td>';
                    }
                   else
                   {
                        $arr.= '<td>No</td>';
                   }
    
                    $arr.= '<td>'.$availedservices.'</td>';
    
                    $arr.= '<td>'. $val->Availed_Services_Details.'</td>';
                    
                    $arr.= '<td>'. $val->Guest_feedback.'</td>';
    
                    $arr.= '<td>'. $hotetamenitie.'</td>';
    
                    $amenities = explode(",",$val->amenities);
                   
                    foreach($amenities as $vals)
                    {
                        $ameniti = DB::table('amenities')->where("id", $vals)->get();
                        // $amenitie[] = $ameniti[0]->name;
                    }
                    
                //     if(count($ameniti) != 0)
                //     {
                //         $nam = implode(",",$ameniti);
                //         $arr.= '<td>'.$nam.'</td>';
                //     }
                //      else
                //      {
                //          $arr.= '<td></td>';
                //      }
                    
                //   $amenitie[]="";
                   $arr.= '<td></td>';
    
                     $arr.= '<td>'. $val->Hotel_rate.'</td>';
     
                   $arr.= '<td>'. $setting["car_parking_spaces"].'</td>';
    
                     $arr.= '<td>'. $val->Booking_Device.'</td>';
    
                    $arr.= '<td>'. $val->usersname.'</td>';
    
                    $arr.= '<td>'. $val->usersname.'</td>';
    
                    
                    $arr.= '</tr>';
    
                   
                }
            }
        }
        else if($request->source == 'dateRange')
        {
            $start_date = $request->start_date;
            $end_date =  $request->end_date;
            $date = date('Y-m-d', strtotime($start_date)).','.date('Y-m-d', strtotime($end_date));
            $ress= DB::table('reservations')
                ->join('customers','customers.id','=','reservations.customer_id')
                ->join('room_types','room_types.id','=','reservations.room_type_id')
                ->join('amenities','amenities.id','=','room_types.amenities')
                ->join('payment_mode','payment_mode.id','=','reservations.payment_mode')
                ->join('packages','packages.id','=','reservations.package_id')
                ->join('meal_plans','meal_plans.id','=','reservations.meal_plan')
                ->join('users','users.id','=','reservations.Employee_Check_In_name','left outer')
                ->join('ota','ota.name','=','reservations.referred_by','left outer')
                ->select('ota.*','users.*','meal_plans.*','reservations.*','customers.*','room_types.*', 'amenities.*', 'payment_mode.*', 'packages.*','room_types.title as room_title','meal_plans.name as meal_plans_name','customers.name as customer_name','users.name as usersname','reservations.created_at as reservations_created_at','reservations.id as reservations_id')
                ->where('customers.created_at','>=', $start_date)->where('customers.created_at', '<=',$end_date)
                ->orderBy('reservations.id', 'DESC');
                 $res = $ress->groupBy('customer_id')->get();
                foreach( $res as $val)
                {
                    $arr.= '<tr>';
                    $arr.= '<td>'.$val->Booking_id.'</td>';
                    
                     $arr.= '<td>'.$val->customer_name.'</td>';
    
                    $arr.= '<td>'.$val->Reconciliation.'</td>';
                    
                    
                    
                  //$arrivals = $ress->join('arrivals','arrivals.customer_id','=','customers.id','left outer')->select('arrivals.*','arrivals.check_in as arrivals_check_in')->get();
                    
                    
                //      echo "<pre>";
                //  print_r($arrivals);
                 
                //  return ;
                 
                    
                    
                    
    
                    if($val->arrivals_check_in == "" || $val->created_at_checkin !="")
                    {
                        $arr.= '<td>Confirm</td>';
                    }
                    else if($val->arrivals_check_in >= $datetime2)
                    {
                        $arr.= '<td>On request</td>';
                    }
                    else if($val->arrivals_check_in <= $datetime2)
                    {
                        if($val->created_at_checkin =="")
                        {
                            $arr.= '<td>Cancel</td>';
                        }
                        else
                        {
                           $arr.= '<td>Confirm</td>'; 
                        }
                    }
                    
                    $arr.= '<td>'.$val->Booking_Reason.'</td>';
                    
                    $Recon_month = date('F', strtotime($val->created_at_checkin))."-".date('y', strtotime($val->created_at_checkin));
                    $arr.= '<td>'.$Recon_month.'</td>';
                    
                    $arr.= '<td>'.$val->created_at_checkin.'</td>';
                    
                    $arr.= '<td>'.$val->created_at_checkout.'</td>';
                    
                   
                    if($val->duration_of_stay == "" )
                    {
                        $arr.= '<td>0</td>';
                    }
                    else
                    {
                        $arr.= '<td>'.$val->duration_of_stay.'</td>';
                    }
                    
                    $customer_id =  DB::table('reservations')->where('customer_id', "$val->customer_id")->count();
                    $arr.= '<td>'.$customer_id.'</td>';
                   
                    $arr.= '<td>'.$val->base_price.'</td>';
                    
                    $arr.= '<td>'.$val->per_room_price.'</td>';
    
                    if($val->referred_by_name == "OTA")
                    {
                        // if( $val->reconciliation_type != "precentage")
                        // {
                        //     $reconciliation = $val->reconciliation; 
                        // }
                        // else
                        // {
    
                        // }
                        if(!isset($val->LCO_type))
                        {
                            $LCO = 0;
                        }
                        else if($val->LCO_type == "")
                        {
                            $LCO = 0;
                        }
                        else if( $val->LCO_type != "precentage")
                        {
                            $LCO = $val->LCO; 
                        }
                        else
                        {
                            $LCO = ($val->checkout_payment * $val->LCO)/100;
                        }
    
                        if(!isset($val->Meals_type))
                        {
                            $Meal = 0;
                        }
                        else if($val->Meals_type == "")
                        {
                            $Meal = 0;
                        }
                        else if( $val->Meals_type != "precentage")
                        {
                            $Meal = $val->Meals; 
                        }
                        else
                        {
                            $Meal = ($val->checkout_payment * $val->Meals)/100;
                        }
                        
                        if(!isset($val->Net_share_type))
                        {
                            $Net_share = 0;
                        }
                        else if($val->Net_share_type == "")
                        {
                            $Net_share = 0;
                        }
                        else if( $val->Net_share_type != "precentage")
                        {
                            $Net_share = $val->Net_share;
                        }
                        else
                        {
                            $Net_share = ($val->checkout_payment * $val->Net_share)/100;
                        }
    
                         if(!isset($val->Tax_commissions_type))
                        {
                            $Tax_commissions = 0;
                        }
                        else if($val->Tax_commissions_type == "")
                        {
                            $Tax_commissions = 0;
                        }
                        else if( $val->Tax_commissions_type != "precentage")
                        {
                            $Tax_commissions = $val->Tax_commissions;
                        }
                        else
                        {
                            $Tax_commissions = ($val->checkout_payment * $val->Tax_commissions)/100;
                        }
    
                        // if(!isset($val->post_tax_type))
                        // {
                        //     $post_tax = 0;
                        // }
                        // else if($val->post_tax_type == "")
                        // {
                        //     $post_tax = 0;
                        // }
                        // else if( $val->post_tax_type != "precentage")
                        // {
                        //     $post_tax = $val->post_tax; 
                        // }
                        // else
                        // {
                        //     $post_tax = ($val->checkout_payment * $val->post_tax)/100;
                        // }
    
                         if(!isset($val->TDS_type))
                        {
                            $TDS = 0;
                        }
                        else if($val->TDS_type == "")
                        {
                            $TDS = "";
                        }
                        else if( $val->TDS_type != "precentage")
                        {
                            $TDS = $val->TDS; 
                        }
                        else
                        {
                            $TDS = ($val->checkout_payment * $val->TDS)/100;
                        }
    
                        if(!isset($val->TDS_Deducted_type))
                        {
                            $TDS_Deducted = 0;
                        }
                        else if($val->TDS_Deducted_type == "")
                        {
                            $TDS_Deducted = 0;
                        }
                        else if( $val->TDS_Deducted_type != "precentage")
                        {
                            $TDS_Deducted =$val->TDS_Deducted; 
                        }
                        else
                        {
                            $TDS_Deducted = ($val->checkout_payment * $val->TDS_Deducted)/100;
                        }
    
                        if(!isset($val->TCS_type))
                        {
                            $TCS = 0;
                        }
                        else if($val->TCS_type == "")
                        {
                            $TCS = 0;
                        }
                        else if( $val->	TCS_type != "precentage")
                        {
                            $TCS = $val->TCS; 
                        }
                        else
                        {
                            $TCS = ($val->checkout_payment * $val->TCS)/100;
                        }
                        
                        if($val->created_at_checkout !="")
                        {
                            if($val->checkin_type == "single")
                            {
                                $tat =  ($val->per_room_price*$val->duration_of_stay* $val->room_qty) + ($LCO + $Meal - $Net_share - $Tax_commissions);
                            }
                            else
                            {
                                $tat =  ($val->per_room_price*$val->duration_of_stay*($val->room_qty+1)) + ($LCO + $Meal - $Net_share - $Tax_commissions);
                            }
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$LCO.'</td>';
                            
                            $arr.= '<td>'.$Meal.'</td>';
                            
                            $arr.= '<td>'.$Net_share.'</td>';
                            
                            $arr.= '<td>'.$Tax_commissions.'</td>';
                            
                            $arr.= '<td>'.$tat.'</td>';
                            
                            $arr.= '<td>'.$TDS.'</td>';
                            
                            $arr.= '<td>'.$TDS_Deducted.'</td>';
                            
                            $arr.= '<td>'.$TCS.'</td>';
                        
                        }
                        else
                        {
                            $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                            $arr.= '<td>'.$val->checkout_payment.'</td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                            
                            $arr.= '<td></td>';
                        }
                        
                    }
                    else
                    {
                        
                        $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                        $arr.= '<td>'.$val->checkout_payment.'</td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                        
                        $arr.= '<td></td>';
                    
                    }
                
                    $arr.= '<td>'.$val->mobile.'</td>';
                
                    $arr.= '<td>'.$val->email.'</td>';
                
                    $arr.= '<td>'.$val->gender.'</td>';
                
                    $arr.= '<td>'.$val->dob.'</td>';
                
                   $arr.= '<td>'.$val->address.'</td>';
                   
                   $arr.= '<td>'.$setting["hotel_name"].'</td>';
                   
                   $arr.= '<td>'.$setting["hotel_address"].'</td>';
                   
                   $arr.= '<td>'.$setting["Hotel_Star"].'</td>';
                   
                   $arr.= '<td>'.date("Y-m-d", strtotime($val->reservations_created_at)).'</td>';
                   
                   $arr.= '<td>'.date("H:i:s", strtotime($val->reservations_created_at)).'</td>';
                   
                   $arr.= '<td>'. $val->created_at_checkin.'</td>';
                   
                   $arr.= '<td>'. $val->created_at_checkout.'</td>';
                   
                   $arr.= '<td>'. $val->adult.'</td>';
                   
                   $arr.= '<td>'. $val->kids.'</td>';
                    
                   $person_lists = DB::table('person_lists')->where('age','<','18')->where('reservation_id',$val->reservations_id)->pluck('age');
                   if($person_lists == '')
                   {
                       $arr.= '<td>0</td>';
                   }
                    else if(count($person_lists) == 0)
                   {
                       $arr.= '<td>0</td>';
                   }
                   else
                   {
                       $arr.= '<td>'. $person_lists.'</td>';
                   }
                    
                   $arr.= '<td>'. $val->infant.'</td>';
                    
                    $arr.= '<td>'. $val->meal_plans_name.'</td>';
                   
                    $arr.= '<td>'. $setting["Hotel_city"].'</td>';
                   
                    if($val->referred_by == "")
                    {
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                        
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                         
                    }
                    else
                    {
                        $arr.= '<td>'. $val->referred_by_name.'</td>';
                        
                        $arr.= '<td>'. $val->referred_by.'</td>';
                         
                    }
                    
                   
                    
                    $rep = DB::table("reservations")->join('customers','customers.id','=','reservations.customer_id','left outer')->where("mobile",$val->mobile)->select('customers.*','reservations.*','reservations.id as reservations_id')->where("reservations.id",'<',197)->take(1)->count();
                   if($rep ==0)
                    {
                        $arr.= '<td>No</td>';
                        $arr.= '<td></td>';
                    
                        $arr.= '<td></td>';
                    
                    
                    }
                    else
                    {
                        if($val->arrivals_check_in == "" && $val->created_at_checkin !="")
                        {
                            $arr.= '<td>yes</td>';
                            
                            $arr.= '<td>No</td>';
                    
                            $arr.= '<td>Yes</td>';
                            
                        }
                        else if($val->arrivals_check_in != "" and $datetime2 >$val->arrivals_check_in)
                        {
                            $arr.= '<td>Yes</td>';
                            
                            $arr.= '<td>Yes</td>';
                    
                            $arr.= '<td>No</td>';
                        }
                    }
                    
    
                  
                    
                    $arr.= '<td>'.$val->room_title.'</td>';
    
                    $arr.= '<td>'.$val->room_types.'</td>';
    
                    $arr.= '<td>'.$val->booking_changes_count.'</td>';
                    
                    if($val->advance_payment == "" && $val->created_at_checkout == "")
                    {
                        $arr.= '<td>No Deposit</td>';
                    }
                    else
                    {
                        $arr.= '<td>Deposit</td>';
                    }
    
                    $arr.= '<td>'.$val->payment_mode.'</td>';
    
                    if(($val->advance_payment == $val->per_room_price) || $val->created_at_checkout != "")
                    {
                        $arr.= '<td>Fully Paid</td>';
                        
                    }
                    else
                    {
                        $arr.= '<td>Partial</td>';
                    }
    
                    $special_requests = DB::table('special_requests')->where('customer_id',$val->customer_id);
                    $count_special_requests = $special_requests->count();
                    $data_special_requests = $special_requests->pluck('name');
    
                    if($count_special_requests != 0)
                    {
                        $arr.= '<td>'.$count_special_requests.'</td>';
                        
                        $arr.= '<td>'.$data_special_requests.'</td>';
                        
                    }
                    else
                    {
                        $arr.= '<td>0</td>';
                        
                        $arr.= '<td></td>';
                        
                    }
                    
                    if($val->created_at_checkout != "")
                    {
                        $arr.= '<td>check Out</td>';
                        
                        $arr.= '<td>'.$val->created_at_checkout.'</td>';
                    }
                    else if($val->created_at_checkin != "")
                    {
                        $arr.= '<td>check In</td>';
                        
                        $arr.= '<td>'.$val->created_at_checkin.'</td>';
                    }
                    else
                    {
                        $arr.= '<td>Canceled</td>';
                        
                        $arr.= '<td></td>';
                        
                    }
    
                    $arr.= '<td>'.$val->Average_duration.'</td>';
                     
                    $arr.= '<td>'.$val->discount.'</td>';
    
                    if($val->ota_discount == "")
                    {
                        $arr.= '<td>No</td>';
                        
                        $arr.= '<td></td>';
                    }
                    else
                    {
                        $arr.= '<td>Yes</td>';
                        
                        $arr.= '<td>'.$val->ota_discount.'</td>';
                        
                    }
                    if($val->package_id == 0)
                    {
                        $arr.= '<td>Yes</td>';
                    }
                   else
                   {
                        $arr.= '<td>No</td>';
                   }
    
                    $arr.= '<td>'.$availedservices.'</td>';
    
                    $arr.= '<td>'. $val->Availed_Services_Details.'</td>';
                    
                    $arr.= '<td>'. $val->Guest_feedback.'</td>';
    
                    $arr.= '<td>'. $hotetamenitie.'</td>';
    
                    $amenities = explode(",",$val->amenities);
                   
                    foreach($amenities as $vals)
                    {
                        $ameniti = DB::table('amenities')->where("id", $vals)->get();
                        // $amenitie[] = $ameniti[0]->name;
                    }
                    
                //     if(count($ameniti) != 0)
                //     {
                //         $nam = implode(",",$ameniti);
                //         $arr.= '<td>'.$nam.'</td>';
                //     }
                //      else
                //      {
                //          $arr.= '<td></td>';
                //      }
                    
                //   $amenitie[]="";
                   $arr.= '<td></td>';
    
                     $arr.= '<td>'. $val->Hotel_rate.'</td>';
     
                   $arr.= '<td>'. $setting["car_parking_spaces"].'</td>';
    
                     $arr.= '<td>'. $val->Booking_Device.'</td>';
    
                    $arr.= '<td>'. $val->usersname.'</td>';
    
                    $arr.= '<td>'. $val->usersname.'</td>';
    
                    
                    $arr.= '</tr>';
    
                   
                }
        }
        
        
        
        
        
        
        
        
        echo $arr;
        // array_push($data,$arr);
        // return response()->json($arr);
}



























    public function getFilteredReportApiData(Request $request)
    {
        $auth_token = 'Xcvvfghj@1234$$$@WERtuv12';
        if ($auth_token == $request->auth_token)
        {
            $sort_date = $request->sortDate;
            $data = [];
            $paymentmode_list=PaymentMode::where('status', 1)->get();
            $key_arr = array();
            $value_arr = array();
            if($request->source == 'date')
            {
                $date = $request->sortDate;
                array_push($key_arr, "date");
                array_push($value_arr, $date);

                $user_count = DB::table('users')->where('status', '1')->count();
                array_push($key_arr, "user_count");
                array_push($value_arr, $user_count);

                $noShow = DB::table('arrivals')->where('is_deleted', '1')->where('check_out', '>=', $sort_date)->count();
                array_push($key_arr, "noShow");
                array_push($value_arr, $noShow);

                $police = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Management')->where('check_in', $sort_date)->count();
                array_push($key_arr, "management_count");
                array_push($value_arr, $police);

                $ta_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'TA')->where('check_in', $sort_date)->count();
                array_push($key_arr, "tas_count");
                array_push($value_arr, $ta_count);

                $corporate_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Corporate')->where('check_in', $sort_date)->count();
                array_push($key_arr, "corporate_count");
                array_push($value_arr, $corporate_count);

                $fit_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'FIT')->where('check_in', $sort_date)->count();
                array_push($key_arr, "fit_count");
                array_push($value_arr, $fit_count);

                $ota_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'OTA')->where('check_in', $sort_date)->count();
                array_push($key_arr, "ota_count");
                array_push($value_arr, $ota_count);

                $room_count = DB::table('rooms')->where('is_deleted', '0')->where('status', '1')->count();
                array_push($key_arr, "room_count");
                array_push($value_arr, $room_count);

                foreach($paymentmode_list as $pay_list)
                {
                    $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = $pay_list->id and DATE(`check_in`) = DATE('$sort_date') "));
                    $advance_cash = $advance_cash_payment[0]->advance_cash;

                    $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE checkout_payment_mode = $pay_list->id and DATE(`check_out`) = DATE('$sort_date') "));
                    $due_cash = $due_cash_payment[0]->due_cash;
                    $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);
                    array_push($key_arr, $pay_list->payment_mode);
                    array_push($value_arr, $cash);
                }

                $Continue1 = DB::table('reservations')->where('user_checkout', $sort_date)->count();
                array_push($key_arr, "continue_count");
                array_push($value_arr, $Continue1);

                $comming = DB::table('reservations')->where('user_checkout', "DATE_ADD(DATE('$sort_date'), INTERVAL 1 DAY)")->count();
                array_push($key_arr, "upcoming_count");
                array_push($value_arr, $comming);

                $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->where('check_in', $sort_date)->count();
                array_push($key_arr, "occupied_rooms");
                array_push($value_arr, $occupied_rooms);

                $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  DATE(`check_in`) = DATE('$sort_date') "));
                $total_check_ins = $total_check_ins_arr[0]->total_check_ins;
                array_push($key_arr, "total_checkins");
                array_push($value_arr, $total_check_ins);

                $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  DATE(`check_out`) = DATE('$sort_date') "));
                $total_check_out = $total_check_out_arr[0]->total_check_out;
                array_push($key_arr, "total_checkouts");
                array_push($value_arr, $total_check_out);

                $total_expense_arr = DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE DATE(`created_at`) = DATE('$sort_date')"));
                $total_expense = $total_expense_arr[0]->total_expense;
                array_push($key_arr, "total_expense");
                array_push($value_arr, $total_expense);

                $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and DATE(`check_in`) = DATE('$sort_date')"));
                $total_checkin_amount = $total_checkin_arr[0]->tot_advanve_payment;

                $total_checkout_arr = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) as tot_payable_payment  FROM reservations WHERE booking_payment and DATE(`check_out`) = DATE('$sort_date')"));
                $total_checkout_amount = $total_checkout_arr[0]->tot_payable_payment;
                $total_payments = $total_checkin_amount+$total_checkout_amount;
                array_push($key_arr, "total_payments");
                array_push($value_arr, $total_payments);
            }
            else if ($request->source == 'weekly'){
                if($sort_date == 'this_week')
                {
                    $start_date = Carbon::now()->startOfWeek();
                    $end_date =  Carbon::now()->endOfWeek();
                    $date = date('Y-m-d', strtotime($start_date)).','.date('Y-m-d', strtotime($end_date));
                    array_push($key_arr, "date");
                    array_push($value_arr, $date);

                    $corporate_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Corporate')->whereBetween('check_in', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    array_push($key_arr, "corporate_count");
                    array_push($value_arr, $corporate_count);

                    $noShow = DB::table('arrivals')->where('is_deleted', '1')->whereBetween('check_out', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    array_push($key_arr, "noShow");
                    array_push($value_arr, $noShow);

                    $police = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Management')->whereBetween('check_in', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    array_push($key_arr, "management_count");
                    array_push($value_arr, $police);

                    $ta_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'TA')->whereBetween('check_in', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    array_push($key_arr, "tas_count");
                    array_push($value_arr, $ta_count);

                    $ota_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'OTA')->whereBetween('check_in', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    array_push($key_arr, "ota_count");
                    array_push($value_arr, $ota_count);

                    $fit_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'FIT')->whereBetween('check_in', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    array_push($key_arr, "fit_count");
                    array_push($value_arr, $fit_count);

                    $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  DATE(`check_out`) BETWEEN DATE('$start_date') and DATE('$end_date') "));
                    $total_check_out = $total_check_out_arr[0]->total_check_out;
                    array_push($key_arr, "total_checkouts");
                    array_push($value_arr, $total_check_out);

                    $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  DATE(`check_in`) BETWEEN DATE('$start_date') and DATE('$end_date') "));
                    $total_check_ins = $total_check_ins_arr[0]->total_check_ins;
                    array_push($key_arr, "total_checkins");
                    array_push($value_arr, $total_check_ins);

                    $room_count = DB::table('rooms')->where('is_deleted', '0')->where('status', '1')->count();
                    array_push($key_arr, "room_count");
                    array_push($value_arr, $room_count);

                    $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->whereBetween('check_in', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    array_push($key_arr, "occupied_rooms");
                    array_push($value_arr, $occupied_rooms);

                    $user_count =DB::table('users')->where('status', '1')->count();
                    array_push($key_arr, "user_count");
                    array_push($value_arr, $user_count);

                    $Continue1 = DB::table('reservations')->whereBetween('user_checkout', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    array_push($key_arr, "continue_count");
                    array_push($value_arr, $Continue1);

                    $comming = DB::table('reservations')->where('user_checkout', "DATE_ADD(DATE('$end_date'), INTERVAL 1 DAY)")->count();
                    array_push($key_arr, "upcoming_count");
                    array_push($value_arr, $comming);

                    $total_payment_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)+IFNULL(sec_payment_mode,0)+IFNULL(third_payment_mode,0)+IFNULL(fourth_payment_mode,0)+IFNULL(fifth_payment_mode,0)+IFNULL(sixth_payment_mode,0)) AS total_payments FROM reservations WHERE  ( booking_payment and DATE(`check_in`) BETWEEN DATE('$start_date') and DATE('$end_date') ) or ( booking_payment and DATE(`check_out`) BETWEEN DATE('$start_date') and DATE('$end_date') )"));
                    $total_payments = $total_payment_arr[0]->total_payments;
                    array_push($key_arr, "total_payments");
                    array_push($value_arr, $total_payments);

                    foreach($paymentmode_list as $pay_list)
                    {
                        $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = $pay_list->id and DATE(`check_in`) BETWEEN DATE('$start_date') and DATE('$end_date')"));
                        $advance_cash = $advance_cash_payment[0]->advance_cash;

                        $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE checkout_payment_mode = $pay_list->id and DATE(`check_out`) BETWEEN DATE('$start_date') and DATE('$end_date')"));
                        $due_cash = $due_cash_payment[0]->due_cash;
                        $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);

                        array_push($key_arr, $pay_list->payment_mode);
                        array_push($value_arr, $cash);
                    }











                    $total_expense_arr = DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE DATE(`created_at`) BETWEEN DATE('$start_date') and DATE('$end_date')"));
                    $total_expense = $total_expense_arr[0]->total_expense;
                    array_push($key_arr, "total_expense");
                    array_push($value_arr, $total_expense);


                }
                else if($sort_date == 'previous_week')
                {
                    $previous_week = strtotime("-1 week +1 day");
                    $start_week = strtotime("last monday midnight",$previous_week);
                    $end_week = strtotime("next sunday",$start_week);
                    $start_week = date("Y-m-d",$start_week);
                    $end_week = date("Y-m-d",$end_week);
                    $start_next_week = Carbon::now()->startOfWeek();
                    $end_next_week =  Carbon::now()->endOfWeek();
                    $date = date('Y-m-d', strtotime($start_week)).','.date('Y-m-d', strtotime($end_week));
                    array_push($key_arr, "date");
                    array_push($value_arr, $date);

                    $user_count =DB::table('users')->where('status', '1')->count();
                    array_push($key_arr, "user_count");
                    array_push($value_arr, $user_count);


                    $noShow = DB::table('arrivals')->where('is_deleted', '1')->whereBetween('check_out', [$start_week, $end_week])->count();
                    array_push($key_arr, "noShow");
                    array_push($value_arr, $noShow);


                    $police = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Management')->whereBetween('check_in', [$start_week, $end_week])->count();
                    array_push($key_arr, "management_count");
                    array_push($value_arr, $police);

                    $ta_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'TA')->whereBetween('check_in', [$start_week, $end_week])->count();
                    array_push($key_arr, "tas_count");
                    array_push($value_arr, $ta_count);

                    $corporate_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Corporate')->whereBetween('check_in', [$start_week, $end_week])->count();
                    array_push($key_arr, "corporate_count");
                    array_push($value_arr, $corporate_count);

                    $fit_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'FIT')->whereBetween('check_in', [$start_week, $end_week])->count();
                    array_push($key_arr, "fit_count");
                    array_push($value_arr, $fit_count);

                    $ota_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'OTA')->whereBetween('check_in', [$start_week, $end_week])->count();
                    array_push($key_arr, "ota_count");
                    array_push($value_arr, $ota_count);

                    $room_count = DB::table('rooms')->where('is_deleted', '0')->where('status', '1')->count();
                    array_push($key_arr, "room_count");
                    array_push($value_arr, $room_count);

                    foreach($paymentmode_list as $pay_list)
                    {
                        $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = $pay_list->id and DATE(`check_in`) BETWEEN DATE('$start_week') and DATE('$end_week') "));
                        $advance_cash = $advance_cash_payment[0]->advance_cash;

                        $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE checkout_payment_mode = $pay_list->id and DATE(`check_out`) BETWEEN DATE('$start_week') and DATE('$end_week') "));
                        $due_cash = $due_cash_payment[0]->due_cash;
                        $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);
                        array_push($key_arr, $pay_list->payment_mode);
                        array_push($value_arr, $cash);
                    }

                    $Continue1 = DB::table('reservations')->whereBetween('user_checkout', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    array_push($key_arr, "continue_count");
                    array_push($value_arr, $Continue1);

                    $comming = DB::table('reservations')->whereBetween('user_checkout', [$start_next_week, $end_next_week])->count();
                    array_push($key_arr, "upcoming_count");
                    array_push($value_arr, $comming);

                    $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->whereBetween('check_in', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    array_push($key_arr, "occupied_rooms");
                    array_push($value_arr, $occupied_rooms);

                    $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  DATE(`check_in`) BETWEEN DATE('$start_week') and DATE('$end_week') "));
                    $total_check_ins = $total_check_ins_arr[0]->total_check_ins;
                    array_push($key_arr, "total_checkins");
                    array_push($value_arr, $total_check_ins);

                    $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  DATE(`check_out`) BETWEEN DATE('$start_week') and DATE('$end_week') "));
                    $total_check_out = $total_check_out_arr[0]->total_check_out;
                    array_push($key_arr, "total_checkouts");
                    array_push($value_arr, $total_check_out);

                    $total_expense_arr = DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE DATE(`created_at`) BETWEEN DATE('$start_week') and DATE('$end_week')"));
                    $total_expense = $total_expense_arr[0]->total_expense;
                    array_push($key_arr, "total_expense");
                    array_push($value_arr, $total_expense);

                    $total_payment_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)+IFNULL(sec_payment_mode,0)+IFNULL(third_payment_mode,0)+IFNULL(fourth_payment_mode,0)+IFNULL(fifth_payment_mode,0)+IFNULL(sixth_payment_mode,0)) AS total_payments FROM reservations WHERE  ( booking_payment and DATE(`check_in`) BETWEEN DATE('$start_week') and DATE('$end_week') ) or ( booking_payment and DATE(`check_out`) BETWEEN DATE('$start_week') and DATE('$end_week') )"));
                    $total_payments = $total_payment_arr[0]->total_payments;
                    array_push($key_arr, "total_payments");
                    array_push($value_arr, $total_payments);

                }
                else if($sort_date == 'this_month')
                {
                    $month = date('m');
                    $curr_date = Carbon::now();
                    $monthName = $curr_date->format('F');
                    if($month == 12)
                    {
                        $next_month = 1;
                    }
                    else{
                        $next_month = (int)$month+(int)1;
                    }
                    $date = $monthName;
                    array_push($key_arr, "date");
                    array_push($value_arr, $date);

                    $user_count =DB::table('users')->where('status', '1')->count();
                    array_push($key_arr, "user_count");
                    array_push($value_arr, $user_count);

                    $noShow = DB::table('arrivals')->where('is_deleted', '1')->whereMonth('check_out',  date('m'))->count();
                    array_push($key_arr, "noShow");
                    array_push($value_arr, $noShow);

                    $police = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Management')->whereMonth('check_in',  date('m'))->count();
                    array_push($key_arr, "management_count");
                    array_push($value_arr, $police);

                    $ta_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'TA')->whereMonth('check_in',  date('m'))->count();
                    array_push($key_arr, "tas_count");
                    array_push($value_arr, $ta_count);

                    $corporate_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Corporate')->whereMonth('check_in',  date('m'))->count();
                    array_push($key_arr, "corporate_count");
                    array_push($value_arr, $corporate_count);

                    $fit_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'FIT')->whereMonth('check_in',  date('m'))->count();
                    array_push($key_arr, "fit_count");
                    array_push($value_arr, $fit_count);

                    $ota_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'OTA')->whereMonth('check_in',  date('m'))->count();
                    array_push($key_arr, "ota_count");
                    array_push($value_arr, $ota_count);

                    $room_count = DB::table('rooms')->where('is_deleted', '0')->where('status', '1')->count();
                    array_push($key_arr, "room_count");
                    array_push($value_arr, $room_count);

                    foreach($paymentmode_list as $pay_list)
                    {
                        $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = $pay_list->id and MONTH(`check_in`) = $month "));
                        $advance_cash = $advance_cash_payment[0]->advance_cash;

                        $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE  checkout_payment_mode = $pay_list->id and MONTH(`check_out`) = $month "));
                        $due_cash = $due_cash_payment[0]->due_cash;
                        $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);
                        array_push($key_arr, $pay_list->payment_mode);
                        array_push($value_arr, $cash);

                    }

                    $Continue1 = DB::table('reservations')->whereMonth('user_checkout',  date('m'))->count();
                    array_push($key_arr, "continue_count");
                    array_push($value_arr, $Continue1);

                    $comming = DB::table('reservations')->where('user_checkout', $next_month)->count();
                    array_push($key_arr, "upcoming_count");
                    array_push($value_arr, $comming);

                    $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->whereMonth('check_in',  date('m'))->count();
                    array_push($key_arr, "occupied_rooms");
                    array_push($value_arr, $occupied_rooms);

                    $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  MONTH(`check_in`) = $month "));
                    $total_check_ins = $total_check_ins_arr[0]->total_check_ins;
                    array_push($key_arr, "total_checkins");
                    array_push($value_arr, $total_check_ins);

                    $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  MONTH(`check_out`) = $month "));
                    $total_check_out = $total_check_out_arr[0]->total_check_out;
                    array_push($key_arr, "total_checkouts");
                    array_push($value_arr, $total_check_out);

                    $total_expense_arr = DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE MONTH(`created_at`) = $month"));
                    $total_expense = $total_expense_arr[0]->total_expense;
                    array_push($key_arr, "total_expense");
                    array_push($value_arr, $total_expense);

                    $total_payment_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)+IFNULL(sec_payment_mode,0)+IFNULL(third_payment_mode,0)+IFNULL(fourth_payment_mode,0)+IFNULL(fifth_payment_mode,0)+IFNULL(sixth_payment_mode,0)) AS total_payments FROM reservations WHERE  ( booking_payment and MONTH(`check_in`) = $month ) or ( booking_payment and MONTH(`check_out`) = $month )"));
                    $total_payments = $total_payment_arr[0]->total_payments;
                    array_push($key_arr, "total_payments");
                    array_push($value_arr, $total_payments);

                }
                else if($sort_date == 'previous_month')
                {
                    $month = date('m');
                    if($month == 1)
                    {
                        $previous_month = '12';
                    }
                    else{
                        $previous_month = (int)$month-(int)1;
                    }
                    $monthName = date("F", mktime(0, 0, 0, $previous_month, 1));
                    $date = $monthName;
                    array_push($key_arr, "date");
                    array_push($value_arr, $date);

                    $user_count =DB::table('users')->where('status', '1')->count();
                    array_push($key_arr, "user_count");
                    array_push($value_arr, $user_count);

                    $noShow = DB::table('arrivals')->where('is_deleted', '1')->whereMonth('check_out',  $previous_month)->count();
                    array_push($key_arr, "noShow");
                    array_push($value_arr, $noShow);

                    $police = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Management')->whereMonth('check_in',  $previous_month)->count();
                    array_push($key_arr, "management_count");
                    array_push($value_arr, $police);

                    $ta_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'TA')->whereMonth('check_in',  $previous_month)->count();
                    array_push($key_arr, "tas_count");
                    array_push($value_arr, $ta_count);

                    $corporate_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Corporate')->whereMonth('check_in',  $previous_month)->count();
                    array_push($key_arr, "corporate_count");
                    array_push($value_arr, $corporate_count);

                    $fit_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'FIT')->whereMonth('check_in',  $previous_month)->count();
                    array_push($key_arr, "fit_count");
                    array_push($value_arr, $fit_count);

                    $ota_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'OTA')->whereMonth('check_in',  $previous_month)->count();
                    array_push($key_arr, "ota_count");
                    array_push($value_arr, $ota_count);

                    $room_count = DB::table('rooms')->where('is_deleted', '0')->where('status', '1')->count();
                    array_push($key_arr, "room_count");
                    array_push($value_arr, $room_count);

                    foreach($paymentmode_list as $pay_list)
                    {
                        $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = $pay_list->id and MONTH(`check_in`) = $previous_month"));
                        $advance_cash = $advance_cash_payment[0]->advance_cash;

                        $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE checkout_payment_mode = $pay_list->id and MONTH(`check_out`) = $previous_month"));
                        $due_cash = $due_cash_payment[0]->due_cash;
                        $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);
                        array_push($key_arr, $pay_list->payment_mode);
                        array_push($value_arr, $cash);

                    }

                    $Continue1 = DB::table('reservations')->whereMonth('user_checkout',  $previous_month)->count();
                    array_push($key_arr, "continue_count");
                    array_push($value_arr, $Continue1);

                    $comming = DB::table('reservations')->where('user_checkout', $month)->count();
                    array_push($key_arr, "upcoming_count");
                    array_push($value_arr, $comming);

                    $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->whereMonth('check_in',  $previous_month)->count();
                    array_push($key_arr, "occupied_rooms");
                    array_push($value_arr, $occupied_rooms);

                    $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  MONTH(`check_in`) = $previous_month "));
                    $total_check_ins = $total_check_ins_arr[0]->total_check_ins;
                    array_push($key_arr, "total_checkins");
                    array_push($value_arr, $total_check_ins);

                    $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  MONTH(`check_out`) = $previous_month "));
                    $total_check_out = $total_check_out_arr[0]->total_check_out;
                    array_push($key_arr, "total_checkouts");
                    array_push($value_arr, $total_check_out);

                    $total_expense_arr = DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE MONTH(`created_at`) = $previous_month"));
                    $total_expense = $total_expense_arr[0]->total_expense;
                    array_push($key_arr, "total_expense");
                    array_push($value_arr, $total_expense);

                    $total_payment_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)+IFNULL(sec_payment_mode,0)+IFNULL(third_payment_mode,0)+IFNULL(fourth_payment_mode,0)+IFNULL(fifth_payment_mode,0)+IFNULL(sixth_payment_mode,0)) AS total_payments FROM reservations WHERE  ( booking_payment and MONTH(`check_in`) = $previous_month ) or ( booking_payment and MONTH(`check_out`) = $previous_month )"));
                    $total_payments = $total_payment_arr[0]->total_payments;
                    array_push($key_arr, "total_payments");
                    array_push($value_arr, $total_payments);

                }


            }
            else if($request->source == 'dateRange')
            {
                $start_date = $request->start_date;
                $end_date =  $request->end_date;
                $date = date('Y-m-d', strtotime($start_date)).','.date('Y-m-d', strtotime($end_date));
                array_push($key_arr, "date");
                array_push($value_arr, $date);

                $user_count =DB::table('users')->where('status', '1')->count();
                array_push($key_arr, "user_count");
                array_push($value_arr, $user_count);

                $noShow = DB::table('arrivals')->where('is_deleted', '1')->whereBetween('check_out', [$start_date, $end_date])->count();
                array_push($key_arr, "noShow");
                array_push($value_arr, $noShow);

                $police = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Management')->whereBetween('check_in', [$start_date, $end_date])->count();
                array_push($key_arr, "management_count");
                array_push($value_arr, $police);

                $ta_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'TA')->whereBetween('check_in', [$start_date, $end_date])->count();
                array_push($key_arr, "tas_count");
                array_push($value_arr, $ta_count);

                $corporate_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Corporate')->whereBetween('check_in', [$start_date, $end_date])->count();
                array_push($key_arr, "corporate_count");
                array_push($value_arr, $corporate_count);

                $fit_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'FIT')->whereBetween('check_in', [$start_date, $end_date])->count();
                array_push($key_arr, "fit_count");
                array_push($value_arr, $fit_count);

                $ota_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'OTA')->whereBetween('check_in', [$start_date, $end_date])->count();
                array_push($key_arr, "ota_count");
                array_push($value_arr, $ota_count);

                $room_count = DB::table('rooms')->where('is_deleted', '0')->where('status', '1')->count();
                array_push($key_arr, "room_count");
                array_push($value_arr, $room_count);

                foreach($paymentmode_list as $pay_list)
                {
                    $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = $pay_list->id and DATE(`check_in`) BETWEEN DATE('$start_date') and DATE('$end_date')"));
                    $advance_cash = $advance_cash_payment[0]->advance_cash;

                    $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE checkout_payment_mode = $pay_list->id and DATE(`check_out`) BETWEEN DATE('$start_date') and DATE('$end_date')"));
                    $due_cash = $due_cash_payment[0]->due_cash;
                    $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);
                    array_push($key_arr, $pay_list->payment_mode);
                    array_push($value_arr, $cash);

                }

                $Continue1 = DB::table('reservations')->whereBetween('user_checkout', [$start_date, $end_date])->count();
                array_push($key_arr, "continue_count");
                array_push($value_arr, $Continue1);

                $comming = DB::table('reservations')->where('user_checkout', "DATE_ADD(DATE('$end_date'), INTERVAL 1 DAY)")->count();
                array_push($key_arr, "upcoming_count");
                array_push($value_arr, $comming);

                $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->whereBetween('check_in', [$start_date, $end_date])->count();
                array_push($key_arr, "occupied_rooms");
                array_push($value_arr, $occupied_rooms);

                $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  DATE(`check_in`) BETWEEN DATE('$start_date') and DATE('$end_date') "));
                $total_check_ins = $total_check_ins_arr[0]->total_check_ins;
                array_push($key_arr, "total_checkins");
                array_push($value_arr, $total_check_ins);

                $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  DATE(`check_out`) BETWEEN DATE('$start_date') and DATE('$end_date') "));
                $total_check_out = $total_check_out_arr[0]->total_check_out;
                array_push($key_arr, "total_checkouts");
                array_push($value_arr, $total_check_out);

                $total_expense_arr = DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE DATE(`created_at`) BETWEEN DATE('$start_date') and DATE('$end_date')"));
                $total_expense = $total_expense_arr[0]->total_expense;
                array_push($key_arr, "total_expense");
                array_push($value_arr, $total_expense);

                $total_payment_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)+IFNULL(sec_payment_mode,0)+IFNULL(third_payment_mode,0)+IFNULL(fourth_payment_mode,0)+IFNULL(fifth_payment_mode,0)+IFNULL(sixth_payment_mode,0)) AS total_payments FROM reservations WHERE  ( booking_payment and DATE(`check_in`) BETWEEN DATE('$start_date') and DATE('$end_date') ) or ( booking_payment and DATE(`check_out`) BETWEEN DATE('$start_date') and DATE('$end_date') )"));
                $total_payments = $total_payment_arr[0]->total_payments;
                array_push($key_arr, "total_payments");
                array_push($value_arr, $total_payments);

            }

            // $arr = array(
            //                 "date" => $date,
            //                 "corporate_count" => $corporate_count,
            //                 "noShow" => $noShow,
            //                 "management_count" => $police,
            //                 "tas_count" => $ta_count,
            //                 "ota_count" =>$ota_count,
            //                 "fit_count" => $fit_count,
            //                 "total_checkouts" => $total_check_out,
            //                 "total_checkins" =>$total_check_ins,
            //                 "room_count" =>$room_count,
            //                 "occupied_rooms" =>$occupied_rooms,
            //                 "user_count" => $user_count,
            //                 "continue_count" => $Continue1,
            //                 "upcoming_count" =>$comming,
            //                 "total_payments" =>$total_payments,
            //                 "cash" =>$cash,
            //                 "debit_card" =>$debit_card,
            //                 "google_pay" =>$google_pay,
            //                 "upi" =>$upi,
            //                 "phone_pay" =>$phone_pay,
            //                 "paytm" =>$paytm,
            //                 "bill_to_corporate" =>$bill_to_corporate,
            //                 "prepaid_by_ota" =>$prepaid_by_ota,
            //                 "total_expense" =>$total_expense
            //             );
            $arr = array_combine($key_arr, $value_arr);
            array_push($data,$arr);
            if($arr)
            {
                $response = [
                    'status' => true,
                    'msg' => 'Data Found',
                    "data" => $data
                ];
            }
            else{
                $response = [
                    'status' => false,
                    'msg' => 'Data Not Found',
                    "data" => ''
                ];
            }

            return response()->json($response);

        }
        else{
            $response = [
                "status" => false,
                "msg" => "Authentication failed",
                "data" => ""
            ];
            return response()->json($response);
        }

    }
    public function userLogin(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $response = [
                            'status' => false,
                            'msg' => $validator->errors()->first(),
                        ];
            return response()->json($response);

        }
        else{
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1]))
            {
                $response = [
                    'status' => true,
                    'msg' => 'Login successful',
                ];
                return response()->json($response);

            }
            else{
                $response = [
                    'status' => false,
                    'msg' => 'Username/Password incorrect',
                ];
                return response()->json($response);
            }
        }

    }
    public function getDashboardData(Request $request)
    {
        $data = [];
        $arrivalCheckoutDate = date('Y-m-d H:i:s', strtotime(Carbon::now()->subDays(1)));
        $today_arrivals_query = DB::select((DB::raw("SELECT COUNT(*) as today_arrivals FROM arrivals  WHERE DATE(`check_in`) = CURDATE() ")));
        $today_arrivals = $today_arrivals_query[0]->today_arrivals;
        $noShow_query =  DB::select((DB::raw("SELECT COUNT(*) as noShow_arrivals FROM arrivals WHERE DATE(`check_out`) = DATE('$arrivalCheckoutDate') and is_deleted = 0")));
        $noShow_arrivals = $noShow_query[0]->noShow_arrivals;
        $today_check_ins_query =  DB::select((DB::raw("SELECT COUNT(*) as today_check_ins FROM reservations WHERE DATE(`check_in`) = CURDATE()")));
        $today_check_ins = $today_check_ins_query[0]->today_check_ins;
        $today_check_out_query =  DB::select((DB::raw("SELECT COUNT(*) as today_check_out FROM reservations WHERE DATE(`check_out`) = CURDATE()")));
        $today_check_out = $today_check_out_query[0]->today_check_out;
        $today_orders_query =  DB::select((DB::raw("SELECT COUNT(*) as today_orders FROM orders WHERE DATE(`created_at`) = CURDATE()")));
        $today_orders = $today_orders_query[0]->today_orders;
        $ocuupancy_query =  DB::select((DB::raw("SELECT COUNT(*) as today_orders FROM orders WHERE DATE(`created_at`) = CURDATE()")));
        $today_orders = $today_orders_query[0]->today_orders;

        $room_count = DB::select(DB::raw("SELECT COUNT(*) as total_room FROM `rooms` WHERE `is_deleted` = 0 AND `status` = 1"));

        $room_count = $room_count[0]->total_room;
        $total_rooms = $room_count;
        $rooms_occupied_arr = [];
        $room_count_data = Reservation::whereStatus(1)->whereIsDeleted(0)->where('room_num', '!=', '')->whereNull('check_out')->orderBy('created_at','DESC')->select('room_num','check_in','check_out','referred_by_name','user_checkout','id')->get();
        if($room_count_data->count()>0){
            foreach($room_count_data as $val){
                $exp = explode(',', $val->room_num);
                $count = count($exp);
                for($i=0; $i<$count; $i++)
                {
                    $rooms_occupied_arr[$exp[$i]] = $exp[$i];
                }
            }
        }
        $occupied_room = count($rooms_occupied_arr);
        $perc_room = number_format((int)$occupied_room/(int)$room_count*100,2);
        $occupied_rooms = $occupied_room;

        $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and DATE(`check_in`) = CURDATE()"));
        $total_checkin_amount = $total_checkin_arr[0]->tot_advanve_payment;

        $total_checkout_arr = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) as tot_payable_payment  FROM reservations WHERE booking_payment and DATE(`check_out`) = CURDATE()"));
        $total_checkout_amount = $total_checkout_arr[0]->tot_payable_payment;
        $total_payment = number_format($total_checkin_amount+$total_checkout_amount);

        $total_expense_arr = DB::select(DB::raw("SELECT SUM(IFNULL(amount,0)) AS total_expense FROM expenses WHERE DATE(`datetime`) = CURDATE()"));
        $total_expense = $total_expense_arr[0]->total_expense;

        $arr = array(
            "today_arrivals" => $today_arrivals,
            "noShow_arrivals" => $noShow_arrivals,
            "today_check_ins" => $today_check_ins,
            "today_check_out" => $today_check_out,
            "today_orders" => $today_orders,
            "occupancy" => $perc_room,
            "today_revenue" => $total_payment,
            "today_expense" => $total_expense
        );
        array_push($data,$arr);
        $response = [
            'status' => true,
            'msg' => 'Data Found',
            'data' => $data
        ];
        return response()->json($response);

    }
}
