<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth,DB,Hash;
use App\User,App\Customer,App\Role;
use App\Room,App\RoomType;
use App\Revenue;
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
use App\Customerfoodorder;
use DataTables;

class AdminController extends Controller
{
    private $paginate=10;
    private $core;
    public $data=[];
    public function __construct()
    {
        $this->core=app(\App\Http\Controllers\CoreController::class);
        $this->middleware('auth');
    }
    public function dashboard(Request $request)
    {
        // $data = DB::connection('mysql2')->table("lajpatnagar_roomrates")->whereDate('datenew','=',date('Y-m-d'))->get();
        // print_r($data);
        $this->data['start'] = $request->start ?? date('Y-m-d');
        $this->data['end'] = $request->end ?? date('Y-m-d');
        $graphTotalCheckin = array();
        $graphTotalRevenue = array();
        $advance_pay = array();
        $graphTotalReferredByAll = array();
        $graphTotalReferredBy = array();
        $graphTotalPaymentMode = array();
        $gtrbn = array();
        $currentMonth = date("m");
        $currentYear = date("Y");
        // print_r($currentMonth);
        $currentMonthName = date("F");
        $this->data['currentMonthName'] = date("F");
        
        date_default_timezone_set("Asia/Kolkata");
        
        $starttime=date('Y-m-d H:i:s',strtotime("12:00:00"));
        $starttime=date('H:i:s',strtotime($starttime));
        //print_r($starttime);
        $endtime=date('Y-m-d H:i:s',strtotime("06:00:00"));
        $endtime=date('H:i:s',strtotime($endtime));
        $time = date("H:i:s");
        //print_r($time);
        $today_checkin_timenew = date('Y-m-d');
        if($starttime > $time && $endtime > $time)
        {
            $today_checkin_timenew=date('Y-m-d',strtotime($today_checkin_timenew.'-1 days'));
        }else{
            $today_checkin_timenew=$today_checkin_timenew;
        }
        
        
        $checkin_time = Setting::where('name', 'checkin_time')->select('value')->first();
        $checkout_time = Setting::where('name', 'checkout_time')->select('value')->first();
        $arrivalCheckoutDate = date('Y-m-d H:i:s', strtotime(Carbon::now()->subDays(1)));
        $today_checkin_time = date('Y-m-d', strtotime(Carbon::now())).' '.$checkin_time->value;
        $today_checkout_time = date('Y-m-d', strtotime(Carbon::now()->addDays(1))).$checkout_time->value;
        $today_time = date('Y-m-d', strtotime(Carbon::now()));
        if($checkout_time->value > date('H:i:s'))
        {
            $today_checkin_time=date('Y-m-d', strtotime(Carbon::now()->subDays(1))).' '.$checkin_time->value;
            
        }else
        {
             $today_checkin_time=$today_checkin_time;
           
        }
        
        // NEW CODE 5-sep-2022 FOR BOTH USER JC
        
        $stjj=date('Y-m-d H:i:s',strtotime("14:00:00"));
        $stjj=date('H:i:s',strtotime($stjj));
        $etjj=date('Y-m-d H:i:s',strtotime("23:55:00"));
        $etjj=date('H:i:s',strtotime($etjj));
        $tjjnew = date("H:i:s");
        
        if($stjj < $tjjnew && $etjj > $tjjnew)
        {
            $testtwopmupdatenew = DB::select(DB::raw("SELECT id as jidnew,unique_id,COUNT(unique_id) as uijc,per_room_price,user_checkout as uc,check_in,duration_of_stay,DATEDIFF(CURDATE(), date(check_in)) as df,((DATEDIFF(CURDATE(), date(check_in)) - duration_of_stay)*per_room_price)/COUNT(unique_id) as revenue FROM reservations WHERE check_out IS NULL and is_deleted='0' and status='1' and room_num != '' and user_checkout < CURRENT_DATE GROUP BY unique_id"));
            // return $testtwopmupdatenew;
            
            if(!empty($testtwopmupdatenew)){
                foreach($testtwopmupdatenew as $dttwopm){
                    if(!empty($dttwopm->per_room_price)){
                        $total_amount = $dttwopm->df * $dttwopm->per_room_price * $dttwopm->uijc;
                        $datatwopm = DB::update("UPDATE reservations SET user_checkout = DATE_ADD(CURDATE(),INTERVAL 1 DAY), duration_of_stay = '$dttwopm->df', total_amount = '$total_amount' WHERE unique_id = '$dttwopm->unique_id'");
                        $payhisupd = DB::insert("INSERT INTO payment_history(reservations_id,payment,payment_date,mode,remark) VALUES('$dttwopm->jidnew',ROUND('$dttwopm->revenue'),CURDATE(),'1','Partial Payment')");
                    }else{
                        $datatwopm = DB::update("UPDATE reservations SET user_checkout = DATE_ADD(CURDATE(),INTERVAL 1 DAY), duration_of_stay = '$dttwopm->df' WHERE unique_id = '$dttwopm->unique_id'");
                    }
                }
            }
            
            $testtwopmupdatenewless = DB::select(DB::raw("SELECT id as jidnew,unique_id,COUNT(unique_id) as uijc,per_room_price,user_checkout as uc,check_in,duration_of_stay,DATEDIFF(CURDATE(), date(check_in)) + 1 as df,((DATEDIFF(CURDATE(), date(check_in)) - duration_of_stay + 1)*per_room_price)/COUNT(unique_id) as revenue FROM reservations WHERE check_out IS NULL and is_deleted='0' and status='1' and room_num != '' and user_checkout <= CURRENT_DATE GROUP BY unique_id"));
            // return $testtwopmupdatenew;
            
            if(!empty($testtwopmupdatenewless)){
                foreach($testtwopmupdatenewless as $dttwopm){
                    if(!empty($dttwopm->per_room_price)){
                        $total_amount = $dttwopm->df * $dttwopm->per_room_price * $dttwopm->uijc;
                        $datatwopm = DB::update("UPDATE reservations SET user_checkout = DATE_ADD(CURDATE(),INTERVAL 1 DAY), duration_of_stay = '$dttwopm->df', total_amount = '$total_amount' WHERE unique_id = '$dttwopm->unique_id'");
                        $payhisupd = DB::insert("INSERT INTO payment_history(reservations_id,payment,payment_date,mode,remark) VALUES('$dttwopm->jidnew',ROUND('$dttwopm->revenue'),CURDATE(),'1','Partial Payment')");
                    }else{
                        $datatwopm = DB::update("UPDATE reservations SET user_checkout = DATE_ADD(CURDATE(),INTERVAL 1 DAY), duration_of_stay = '$dttwopm->df' WHERE unique_id = '$dttwopm->unique_id'");
                    }
                }
            }
            
        }
        
        // NEW CODE 5-sep-2022 END
          
        $this->data['counts']=DB::select(DB::raw("SELECT
        (SELECT COUNT(*) FROM users WHERE status = 1) as user_count,
        (SELECT COUNT(*) FROM orders WHERE DATE(`created_at`) = CURDATE()) as today_orders,
        (SELECT COUNT(*) FROM reservations WHERE DATE(`created_at_checkin`) = '$today_checkin_timenew') as today_check_ins,
        (SELECT COUNT(*) FROM arrivals WHERE DATE(check_in) >= DATE('$today_checkin_time') and is_deleted = 0 ) as today_arrivals,
        (SELECT COUNT(*) FROM arrivals WHERE DATE(check_in) <= DATE('$today_checkin_time') and is_deleted = 1) as noShow_arrivals,
        (SELECT COUNT(*) FROM arrivals WHERE DATE(check_in) = CURDATE() and is_deleted = 0) as only_today_arrivals,
        (SELECT COUNT(*) FROM reservations WHERE `created_at_checkout` >= '$today_checkin_time') as today_check_outs,
        (SELECT COUNT(*) FROM reservations WHERE `check_out` IS NULL and is_deleted='0' and status='1' and room_num != '' ) as continue_rooms,
        (SELECT COUNT(*) FROM reservations WHERE `check_out` IS NULL and is_deleted='0' and status='1' and room_num != '' and date(check_in) != '$today_checkin_timenew' ) as continue_rooms_new,
        (SELECT COUNT(*) FROM reservations WHERE date(check_out) = '$today_checkin_timenew' and is_deleted='0' and status='1' and room_num != '' and date(check_in) != '$today_checkin_timenew' ) as continue_rooms_todaycheckout,
        (SELECT COUNT(*) FROM reservations WHERE `created_at_checkin` >= '$today_checkin_time' && `created_at_checkout`>= '$today_checkin_time' ) as same_day_checkout"
        ));
       
        // (SELECT COUNT(*) FROM arrivals WHERE `check_in` >= '$today_checkin_time') as today_arrivals,
        // (SELECT COUNT(*) FROM arrivals WHERE DATE(`check_out`) = DATE('$arrivalCheckoutDate') and is_deleted = 0) as noShow_arrivals,
        
        // $query=DB::table('arrivals')->join('customers','customers.id','=','arrivals.customer_id')
        // ->select('arrivals.check_in as check_in','arrivals.check_out as check_out','arrivals.id as id','customers.name as name',
        // 'customers.email as email','customers.mobile as mobile','arrivals.is_deleted','arrivals.check_out as checkout')->where('arrivals.is_checked_in',0)->where('arrivals.is_deleted', '=', 0)->orwhereDate('check_out','>',date('Y-m-d'))->get();
        //  $this->data['counts'][0]->noShow_arrivals = count($query);
        
        $query=DB::table('arrivals')->join('customers','customers.id','=','arrivals.customer_id')
        ->select('arrivals.check_in as check_in','arrivals.check_out as check_out','arrivals.id as id','customers.name as name',
        'customers.email as email','customers.mobile as mobile','arrivals.is_deleted','arrivals.check_out as checkout')->where('arrivals.is_checked_in',0)->where('arrivals.is_deleted', '=', 0)->whereDate('check_in','<',date('Y-m-d'))->get();
         $this->data['counts'][0]->noShow_arrivals += count($query); 
         
        //print_r(count($query));
        
         $noshowgreater=DB::table('arrivals')->join('customers','customers.id','=','arrivals.customer_id')
        ->select('arrivals.check_in as check_in','arrivals.check_out as check_out','arrivals.id as id','customers.name as name',
        'customers.email as email','customers.mobile as mobile','arrivals.is_deleted','arrivals.check_out as checkout')->where('arrivals.is_checked_in',0)->where('arrivals.is_deleted', '=', 1)->whereDate('check_in','>',date('Y-m-d'))->get();
         $this->data['counts'][0]->noShow_arrivals += count($noshowgreater);
        //  print_r(count($noshowgreater));
         
         
         $this->data['payment_today']=DB::table('reservations')->join('payment_mode','payment_mode.id','=','reservations.payment_mode')->join('customers','customers.id','=','reservations.customer_id')->whereDate('reservations.created_at_checkin',$today_time)->groupBy('customer_id')->get();
        
        
        
        // $total_pay = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and `created_at_checkin` >= DATE('$today_time')"));
        // $total_pay1 = DB::select(DB::raw("SELECT SUM(IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and `updated_at` >= DATE('$today_time')"));
        $today_checkin_time_new = date('Y-m-d');
        // print_r($today_checkin_time_new);
        
        
        if($starttime > $time && $endtime > $time)
        {
            $today_checkin_time_new=date('Y-m-d',strtotime($today_checkin_time_new.'-1 days'));
            //return $today_checkin_time_new;
            //print_r($today_checkin_time_new);
            $extra_payment = DB::select("SELECT sum(payment) as extra_payment FROM payment_history where extra_revenue = 'er' and date(payment_date) ='$today_checkin_time_new'");
            $extra_payment_expense = DB::select("SELECT sum(payment) as extra_payment_expense FROM payment_history where extra_revenue = 'break' and date(payment_date) ='$today_checkin_time_new'");
            $totalerandbreak = $extra_payment[0]->extra_payment + $extra_payment_expense[0]->extra_payment_expense;
            $totalprofit = $extra_payment[0]->extra_payment - $extra_payment_expense[0]->extra_payment_expense;
            $total_pay=DB::select("select sum(payment) as total_payment from payment_history where reservations_id!='0' and date(payment_date)='$today_checkin_time_new'");
            $this->data['payment_today1'] = $total_pay[0]->total_payment - $totalerandbreak + $totalprofit;
        }else{
            //print_r($today_checkin_time_new);
            $extra_payment = DB::select("SELECT sum(payment) as extra_payment FROM payment_history where extra_revenue = 'er' and date(payment_date) ='$today_checkin_time_new'");
            $extra_payment_expense = DB::select("SELECT sum(payment) as extra_payment_expense FROM payment_history where extra_revenue = 'break' and date(payment_date) ='$today_checkin_time_new'");
            $totalerandbreak = $extra_payment[0]->extra_payment + $extra_payment_expense[0]->extra_payment_expense;
            $totalprofit = $extra_payment[0]->extra_payment - $extra_payment_expense[0]->extra_payment_expense;
            $total_pay=DB::select("select sum(payment) as total_payment from payment_history where reservations_id!='0' and date(payment_date)='$today_checkin_time_new'");
            $this->data['payment_today1'] = $total_pay[0]->total_payment - $totalerandbreak + $totalprofit;
            //print_r($this->data['payment_today1']);
        }
        
        $this->data['revenue_today']=DB::table('reservations')->whereDate('reservations.created_at_checkin',$today_time)->groupBy('customer_id')->get();
        
        $this->data['paymentmode_list']=PaymentMode::where('status', 1)->get();
        
        $this->data['sort_date']=$today_time;
            
        // echo "<pre>";
        
        // print_r($advance_cash_payment);
        
        // return;
        
        // 
        // $dataa = [];
        // $count_data = [];
        // $sum_data=[];
        // $payment = DB::table('payment_mode')->where('status',1)->get();
        // // return $today_time;
        // foreach($payment as $payment_value)
        // {
        //      $total_data []= DB::table('reservations')->whereDate('created_at_checkin',$today_time)->where('payment_mode',$payment_value->id)->get();
        //     $count_data = $total_data->count('advance_payment');
        //     // $sum_data = $total_data->sum('advance_payment');
        //     // echo $payment_value->payment_mode;
            
            
            
            
            
        // }
        // print_r($count_data);
        // return ;
          


        // return $this->data['counts'][0]->noShow_arrivals;
        // echo "<pre>";
        // print_r($this->data['counts']);
        //  return ;

     $this->data['products']=Product::whereStatus(1)->whereIsDeleted(0)->orderBy('stock_qty','ASC')->get();
     $orderIds = OrderHistory::where('is_book',1)->orderBy('id','DESC')->pluck('order_id');
     $undermaintinance =[];
     
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
     $this->data['undermaintinance_count'] =count($undermaintinance);
     $this->data['orders']=Order::with('last_order_history')->whereIn('id',$orderIds)->orderBy('created_at','DESC')->get();  
        $this->getRoomList();
        $room_types=$this->data['room_types'];
        $this->data['floor0']=array();
        $this->data['floor1']=array();
        $this->data['floor2']=array();
        $this->data['floor3']=array();
        $this->data['floor4']=array();
        $this->data['floor5']=array();
        $this->data['floor6']=array();
        $this->data['floor7']=array();
        $this->data['floor8']=array();
        $this->data['floor9']=array();
        $this->data['floor10']=array();
        $this->data['floor']= array();
        
       
        foreach ($room_types as $key => $value) {
           foreach ($value->rooms->where('is_deleted',0) as $key => $value) {
            if($value->count() > 0)
            {
                if($value->floor == 0)
                {
                    array_push($this->data['floor0'],$value);
                }
                if($value->floor == 1)
                {
                    array_push($this->data['floor1'],$value);
                }
                if($value->floor == 2)
                {
                    array_push($this->data['floor2'],$value);
                }
                if($value->floor == 3)
                {
                   array_push( $this->data['floor3'],$value);
                }
                if($value->floor == 4)
                {
                    array_push($this->data['floor4'],$value);
                }
                if($value->floor == 5)
                {
                    array_push($this->data['floor5'],$value);
                }
                if($value->floor == 6)
                {
                    array_push($this->data['floor6'],$value);
                }
                if($value->floor == 7)
                {
                    array_push($this->data['floor7'],$value);
                }
                 if($value->floor == 8)
                {
                    array_push($this->data['floor8'],$value);
                }
                 if($value->floor == 9)
                {
                    array_push($this->data['floor9'],$value);
                }
                 if($value->floor == 10)
                {
                    array_push($this->data['floor10'],$value);
                }
            }
        }
        }
       
       
            $floor0= collect($this->data['floor0'])->sortBy('room_no');
            $this->data['floor0']=$floor0;
            $floor1= collect($this->data['floor1'])->sortBy('room_no');
            $this->data['floor1']=$floor1;
            $floor2= collect($this->data['floor2'])->sortBy('room_no');
            $this->data['floor2']=$floor2;
            $floor3= collect($this->data['floor3'])->sortBy('room_no');
            $this->data['floor3']=$floor3;
            $floor4= collect($this->data['floor4'])->sortBy('room_no');
            $this->data['floor4']=$floor4;
            $floor5= collect($this->data['floor5'])->sortBy('room_no');
            $this->data['floor5']=$floor5;
            $floor6= collect($this->data['floor6'])->sortBy('room_no');
            $this->data['floor6']=$floor6;
            $floor7= collect($this->data['floor7'])->sortBy('room_no');
            $this->data['floor7']=$floor7;
            $floor8= collect($this->data['floor8'])->sortBy('room_no');
            $this->data['floor8']=$floor8;
            $floor9= collect($this->data['floor9'])->sortBy('room_no');
            $this->data['floor9']=$floor9;
            array_push($this->data['floor'],array($this->data['floor0'],$this->data['floor1'],$this->data['floor2'],
            $this->data['floor3'],$this->data['floor4'],$this->data['floor5'],$this->data['floor6'],$this->data['floor7'],
            $this->data['floor8'],$this->data['floor9'],$this->data['floor10']));
            
            
           
            
            
            
            
            
            
            // print_r($this->data['floor']);die();
            $total_expense_arr = DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE DATE(`datetime`) = CURDATE()"));
            $this->data['total_expense'] = $total_expense_arr[0]->total_expense;

            $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and DATE(`created_at_checkin`) = CURDATE()"));
            $total_checkin_amount = $total_checkin_arr[0]->tot_advanve_payment;

            $total_checkout_arr = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) as tot_payable_payment  FROM reservations WHERE booking_payment and DATE(`check_out`) = CURDATE()"));
            $total_checkout_amount = $total_checkout_arr[0]->tot_payable_payment;

           
            $this->data['total_payment'] = number_format($total_checkin_amount);
            $room_count = DB::select(DB::raw("SELECT COUNT(*) as total_room FROM `rooms` WHERE `is_deleted` = 0 AND `status` = 1"));

            $room_count = $room_count[0]->total_room;
            $this->data['total_rooms'] = $room_count;
            $rooms_occupied_arr = [];
            $room_count_data = Reservation::whereStatus(1)->whereIsDeleted(0)->where('room_num', '!=', '')->whereNull('check_out')->orderBy('created_at','DESC')->select('room_num','check_in','check_out','referred_by_name','user_checkout','id')->get();
            $room_count_data_new = DB::select("SELECT 'room_num','check_in','check_out','referred_by_name','user_checkout','id' FROM reservations WHERE `check_out` IS NULL and is_deleted='0' and status='1' and room_num != '' and date(check_in) != '$today_checkin_timenew'");
            $room_count_data_new_new = DB::select("SELECT 'room_num','check_in','check_out','referred_by_name','user_checkout','id' FROM reservations WHERE date(check_out) = '$today_checkin_timenew' and is_deleted='0' and status='1' and room_num != '' and date(check_in) != '$today_checkin_timenew' ");
            // print_r($room_count_data_new_new);
          //  dd($room_count_data);
            if($room_count_data->count()>0){
                // print_r('hello');
                foreach($room_count_data as $val){
                    $exp = explode(',', $val->room_num);
                    $count = count($exp);
                    for($i=0; $i<$count; $i++)
                    {
                        $rooms_occupied_arr[$exp[$i]] = $exp[$i];
                    }
                }
            }
            $occupied_room_chekout_today = count($room_count_data_new_new);
            // print_r($occupied_room_chekout_today);
            $occupied_room = count($room_count_data_new);
            $today_room_count_query =  DB::select("SELECT * FROM reservations WHERE DATE(`created_at_checkin`) = '$today_checkin_timenew'");
            $today_room_count_add = count($today_room_count_query);
            $occupied_room = $occupied_room + $occupied_room_chekout_today + $today_room_count_add;
            $total = (int)$room_count*100;
            if($total != 0)
            {
                $this->data['perc_room'] = number_format((int)$occupied_room/(int)$room_count*100,2);
            }
            $this->data['occupied_rooms'] = $occupied_room;
            $today_room_count_data1 =  DB::select("SELECT * FROM reservations WHERE DATE(`created_at_checkin`) = '$today_checkin_timenew'");
           
            $today_room_count_data = count($today_room_count_data1);
           
            if($total != 0)
            {
                $this->data['today_perc_room'] = number_format((int)$today_room_count_data/(int)$room_count*100,2);
            }
          
            
            $this->data['today_occupied_rooms'] = $today_room_count_data;
            $startMonth = Carbon::now()->startOfMonth();
            $month_day =$startMonth;
            $endMonth = Carbon::now()->endOfMonth();
          
            $total_expense_arr1 = DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE DATE(`datetime`)  between DATE('$startMonth') and DATE('$endMonth')"));
            $this->data['month_expense'] = $total_expense_arr1[0]->total_expense;
            
            
            
            $now = Carbon::now();
            $now=date('Y-m-d',strtotime($now));
        
             
            $arr_till_date_occupancy = array();
            if($now >= $startMonth && $now <= $endMonth)
            {
                
                while($month_day < $now)
                {
                    
                    $oneday=number_format((100/$room_count),2);
                    $month_day1=date('Y-m-d',strtotime($month_day));
                   // $till_date_room_count_data = Reservation::whereStatus(1)->whereIsDeleted(0)->where('room_num', '!=', '')->where('created_at_checkin', '>=', $startMonth)->where('created_at_checkin', '<=' ,$now)->count();
                   
                   //$till_date_room_count_data=DB::select("SELECT count(duration_of_stay) as dos FROM reservations WHERE DATE(`created_at_checkin`)= '$month_day1'");
                   $till_date_room_count_data=DB::select("SELECT sum(no_of_rooms) as dos FROM continue_rooms WHERE DATE(`created_at`)= '$month_day1'");
                   //print_r($till_date_room_count_data[0]->dos);
                
                    // if($total != 0)
                    // {   
                    //     $today_perc_room = number_format((int)$till_date_room_count_data/(int)$room_count*100,2);
                    //     array_push($arr_till_date_occupancy, $today_perc_room);
                    // }
                    array_push($arr_till_date_occupancy,($till_date_room_count_data[0]->dos)*$oneday);
                  
                    
                    $month_day = $month_day->addDays(1);
                
                }
              //  dd($month_day);
                 
            }
           // die();
                     
                
            if(count($arr_till_date_occupancy) != 0)
            {
                $this->data['monthly_perc_room'] = numberFormat(array_sum($arr_till_date_occupancy)/count($arr_till_date_occupancy));
            }
            
            //$this->data['pending']=DB::select("SELECT `total_amount`,`id` as r_id ,(SELECT SUM(payment) FROM payment_history WHERE `reservations_id`=`r_id`) as payment FROM reservations where room_num!='' and is_deleted='0' and check_out is null and total_amount is NOT null HAVING total_amount > payment");
            
            $this->data['pending']=DB::select("SELECT `total_amount`,`customer_id`,`id` as r_id ,(SELECT SUM(payment) FROM payment_history WHERE `reservations_id`=`r_id`) as payment,(SELECT count(payment) FROM payment_history WHERE `reservations_id`=`r_id`) as payment1 FROM reservations where room_num!='' and is_deleted='0' and check_out is null and total_amount is NOT null HAVING total_amount > payment");
            // print_r($this->data['pending']);
            $total_amount1=0;
            foreach($this->data['pending'] as $key => $pan){
                
                if($key != 0)
                {
                    if($pan->customer_id !=  $customer_id)
                    {
                        $customer_id = $pan->customer_id;
                        $total_amount1 += $pan->total_amount;
                    }
                    else
                    {
                        $customer_id = $pan->customer_id;
                    }
                }
                else
                {
                    $customer_id = $pan->customer_id;
                    $total_amount1 += $pan->total_amount;
                }
                
            }
             $this->data['pending_amount']=round(($total_amount1)-(array_sum(array_column($this->data['pending'],'payment'))),2);
            // print_r($total_amount1);
             //print_r($this->data['pendingnew']);
            // $multipletotal = array_sum(array_column($this->data['pending'],'total_amount'))/array_sum(array_column($this->data['pending'],'payment1'));
            // print_r($multipletotal);
            // $this->data['pending1single']=DB::select("SELECT `total_amount`,`id` as r_id ,(SELECT SUM(payment) FROM payment_history WHERE `reservations_id`=`r_id`) as payment,(SELECT count(payment) FROM payment_history WHERE `reservations_id`=`r_id`) as payment2 FROM reservations where room_num!='' and is_deleted='0' and checkin_type='single' and check_out is null and total_amount is NOT null HAVING total_amount > payment");
            // $singletotal = array_sum(array_column($this->data['pending1single'],'total_amount'))/array_sum(array_column($this->data['pending1single'],'payment2'));
            // print_r($singletotal);
            
            // $alltotal = $multipletotal + $singletotal;
            // print_r($alltotal);
            //$this->data['pending_amount']=(array_sum(array_column($this->data['pending'],'total_amount')))-(array_sum(array_column($this->data['pending'],'payment')));
            
           
            
            $this->data['monthly_occupied_rooms'] = count($arr_till_date_occupancy);
            
            $today_date=date('Y-m-d', strtotime(Carbon::now()));
            
            if($starttime > $time && $endtime > $time)
            {
                $today_date=date('Y-m-d',strtotime($today_date.'-1 days'));
                $tr1 = DB::select("select sum(payment) as total_payment1 from payment_history where reservations_id!='0' and mode='1' and extra_revenue is null and date(payment_date) > '2022-08-23'");
                
                $extra_payment = DB::select("SELECT sum(payment) as extra_payment FROM payment_history where mode='1' and extra_revenue = 'er' and date(payment_date) > '2022-08-23'");
                $extra_payment_expense = DB::select("SELECT sum(payment) as extra_payment_expense FROM payment_history where mode='1' and extra_revenue = 'break' and date(payment_date) > '2022-08-23'");
                // $totalerandbreak = $extra_payment[0]->extra_payment + $extra_payment_expense[0]->extra_payment_expense;
                $totalprofit = $extra_payment[0]->extra_payment - $extra_payment_expense[0]->extra_payment_expense;
                
                $ex4less = DB::select("select sum(amount) as expenses4 from expenses where amount!='0' and date(datetime) > '2022-08-23'");
            
                // $this->data['cashinhand'] = $tr1[0]->total_payment1 - $ex4less[0]->expenses4 - $totalerandbreak + $totalprofit;
                $this->data['cashinhand'] = $tr1[0]->total_payment1 + $totalprofit - $ex4less[0]->expenses4;
            }else{
                $tr1 = DB::select("select sum(payment) as total_payment1 from payment_history where reservations_id!='0' and mode='1' and extra_revenue is null and date(payment_date) >'2022-08-23'");
                
                $extra_payment = DB::select("SELECT sum(payment) as extra_payment FROM payment_history where mode='1' and extra_revenue = 'er' and date(payment_date) > '2022-08-23'");
                $extra_payment_expense = DB::select("SELECT sum(payment) as extra_payment_expense FROM payment_history where mode='1' and extra_revenue = 'break' and date(payment_date) > '2022-08-23'");
                // $totalerandbreak = $extra_payment[0]->extra_payment + $extra_payment_expense[0]->extra_payment_expense;
                $totalprofit = $extra_payment[0]->extra_payment - $extra_payment_expense[0]->extra_payment_expense;
                
                $ex4less = DB::select("select sum(amount) as expenses4 from expenses where amount!='0' and date(datetime) > '2022-08-23'");
            
                // $this->data['cashinhand'] = $tr1[0]->total_payment1 - $ex4less[0]->expenses4 - $totalerandbreak + $totalprofit;
                $this->data['cashinhand'] = $tr1[0]->total_payment1 + $totalprofit - $ex4less[0]->expenses4;
            }
           
            $this->data['graphTotalCheckin'] = DB::select("SELECT COUNT(room_num) as totalCheckin, DATE(check_in) as checkinDate FROM `reservations` WHERE MONTH(check_in) = '".$currentMonth."' and YEAR(check_in) = '".$currentYear."' group by checkinDate");
            
            //$graphTotalRevenuenew = DB::select("select sum(payment) as totalRevenue, DATE(payment_date) as checkinDate FROM `payment_history` WHERE reservations_id!='0' and MONTH(payment_date) = '".$currentMonth."' and YEAR(payment_date) = '".$currentYear."' group by checkinDate");
            //$graphTotalRevenue = DB::select("select sum(advance) as totalRevenue,DATE(created_at) as checkinDate FROM `arrivals` WHERE referred_by_name = 'F9' and MONTH(created_at)= '".$currentMonth."' and YEAR(created_at)= '".$currentYear."' group by checkinDate");
            $this->data['graphTotalRevenue'] = DB::select("SELECT SUM(revenue) AS totalRevenue, revenue, checkinDate from((select sum(payment) as revenue, DATE(payment_date) as checkinDate FROM `payment_history` WHERE reservations_id!='0' and MONTH(payment_date) = '".$currentMonth."' and YEAR(payment_date) = '".$currentYear."' group by checkinDate) UNION (select sum(advance) as revenue,DATE(created_at) as checkinDate FROM `arrivals` WHERE referred_by_name = 'F9' and MONTH(created_at)= '".$currentMonth."' and YEAR(created_at)= '".$currentYear."' group by checkinDate)) as allGet GROUP BY checkinDate");
            
            //return $graphTotalRevenue;
            //return $graphTotalRevenuenew;
            // if(!empty($graphTotalRevenuenew)){
            //     foreach($graphTotalRevenuenew as $key=>$gtrbn1){
            //         // print_r($gtrbn1->checkinDate);
                    
            //         foreach($graphTotalRevenue as $jatnewq){
                        
            //             if($gtrbn1->checkinDate == $jatnewq->checkinDate){
            //                 print_r($jatnewq);
            //             }
            //         }
            //         // $graphTotalRevenue += $gtrbn1;
            //     }
               
                
                // array_push($graphTotalRevenue,$gtrbn1);
            // }else{
            //     //print_r('hello'); die;
            //     $graphTotalRevenue = DB::select("select sum(advance) as totalRevenue,DATE(created_at) as checkinDate FROM `arrivals` WHERE referred_by_name = 'F9' and MONTH(created_at)= '".$currentMonth."' and YEAR(created_at)= '".$currentYear."' group by checkinDate");
            //     array_push($graphTotalRevenue);
            // }
            
            
            
            // $advance_pay = DB::select("select sum(advance) as totalRevenue,DATE(created_at) as checkinDate FROM `arrivals` WHERE referred_by_name = 'F9' and MONTH(created_at)= '".$currentMonth."' and YEAR(created_at)= '".$currentYear."' group by checkinDate");
            // // array_push($graphTotalRevenue,$advance_pay);
            
            
            // // $array1 = array("color" => "red", 2, 4);
            // // $array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);
            // $g = array_merge($graphTotalRevenue, $advance_pay);
            // $this->data['graphTotalRevenue'] = $graphTotalRevenue;
            
            //return $this->data['graphTotalRevenue'];
            
            $graphTotalReferredByName = DB::select("select count(referred_by_name) as totalRevenue, referred_by_name as rby from `reservations` where referred_by_name ='F9' and MONTH(check_in) = '".$currentMonth."' and YEAR(check_in) = '".$currentYear."' group by referred_by_name HAVING referred_by_name != '' ");
            if(!empty($graphTotalReferredByName)){
                foreach($graphTotalReferredByName as $gtrbn){
                    //print_r($gtrbn);
                }
                $graphTotalReferredBy = DB::select("select count(referred_by) as totalRevenue, referred_by as rby from `reservations` where MONTH(check_in) = '".$currentMonth."' and YEAR(check_in) = '".$currentYear."' group by referred_by HAVING referred_by != '' ");
                array_push($graphTotalReferredBy,$gtrbn);
            }else{
                //print_r('hello'); die;
                $graphTotalReferredBy = DB::select("select count(referred_by) as totalRevenue, referred_by as rby from `reservations` where MONTH(check_in) = '".$currentMonth."' and YEAR(check_in) = '".$currentYear."' group by referred_by HAVING referred_by != '' ");
                array_push($graphTotalReferredBy);
            }
            
            // foreach($graphTotalReferredByName as $gtrbn){
            //     //print_r($gtrbn);
            // }
            // $graphTotalReferredBy = DB::select("select count(referred_by) as totalRevenue, referred_by as rby from `reservations` where MONTH(check_in) = '".$currentMonth."' group by referred_by HAVING referred_by != '' ");
            // array_push($graphTotalReferredBy,$gtrbn);
            $this->data['graphTotalReferredBy'] = $graphTotalReferredBy;
            
            //$this->data['graphTotalPaymentMode'] = DB::select("SELECT SUM(r.total_amount) as totalRevenue, pm.payment_mode as paymentMode FROM `reservations` as r INNER JOIN payment_mode as pm ON pm.id = r.payment_mode WHERE MONTH(r.check_in) = '".$currentMonth."' group by paymentMode");
            
            // $this->data['graphTotalPaymentMode'] = DB::select("SELECT SUM(r.payment) as totalRevenue, pm.payment_mode as paymentMode FROM `payment_history` as r INNER JOIN payment_mode as pm ON pm.id = r.mode WHERE MONTH(r.payment_date) = '".$currentMonth."' and YEAR(r.payment_date) = '".$currentYear."' group by paymentMode");
            $this->data['graphTotalPaymentMode'] = DB::select("SELECT SUM(revenue) AS totalRevenue, revenue, paymentMode from((SELECT SUM(r.payment) as revenue, pm.payment_mode as paymentMode FROM `payment_history` as r INNER JOIN payment_mode as pm ON pm.id = r.mode WHERE MONTH(r.payment_date) = '".$currentMonth."' and YEAR(r.payment_date) = '".$currentYear."' group by paymentMode) UNION (select sum(a.advance) as revenue, pm.payment_mode as paymentMode FROM `arrivals` as a INNER JOIN payment_mode as pm ON pm.id = a.payment_mode WHERE a.referred_by_name = 'F9' and MONTH(a.created_at)= '".$currentMonth."' and YEAR(a.created_at)= '".$currentYear."' group by paymentMode)) as allGet GROUP BY paymentMode");
            $this->data['aRR'] = DB::select("SELECT (SUM(per_room_price) / COUNT(room_num)) as sumARR, DATE(check_in) as checkinDate FROM reservations WHERE MONTH(check_in) = '".$currentMonth."' and YEAR(check_in) = '".$currentYear."' group by checkinDate");
            
          //  dd($this->data);
        return view('backend/new_dashboard',$this->data);
    }
    
    // analytics code jatin
    // public function analytics(Request $request){
    //     $graphTotalCheckin = array();
    //     $graphTotalRevenue = array();
    //     $graphTotalReferredBy = array();
    //     $graphTotalPaymentMode = array();
    //     $currentMonth = date("m");
    //     $currentMonthName = date("F");
                    
    //     if($request->input("hotel_id") != null){
    //         $dbs=DB::table('dbmapping')->where(array("id" => $request->input("hotel_id")))->get();
    //         $i=1;
    //         foreach($dbs as $value){
    //             $param['database']=$value->db_name;
    //             $param['username']=$value->user;
    //             $param['password']=$value->password;
    //             $param['hostname']=$value->host;
                
    //             $param['number']=$i++;
    //             $connection = DatabaseConnection::setConnection($param);
                
    //             $graphTotalCheckin = $connection->select("SELECT COUNT(room_num) as totalCheckin, DATE(check_in) as checkinDate FROM `reservations` WHERE MONTH(check_in) = '".$currentMonth."' group by checkinDate");
    //             foreach($graphTotalCheckin as $item){
    //                 $item->checkinDate = date("dS M", strtotime($item->checkinDate));
    //             }
    //             $graphTotalRevenue = $connection->select("SELECT SUM(per_room_price) as totalRevenue, DATE(check_in) as checkinDate FROM `reservations` WHERE MONTH(check_in) = '".$currentMonth."' group by checkinDate");
    //             foreach($graphTotalRevenue as $item){
    //                 $item->checkinDate = date("dS M", strtotime($item->checkinDate));
    //             }
    //             $graphTotalReferredBy = $connection->select("SELECT SUM(per_room_price) as totalRevenue, referred_by FROM `reservations` WHERE MONTH(check_in) = '".$currentMonth."' group by referred_by HAVING referred_by != '' ");
    //             $graphTotalPaymentMode = $connection->select("SELECT SUM(r.per_room_price) as totalRevenue, pm.payment_mode as paymentMode FROM `reservations` as r INNER JOIN payment_mode as pm ON pm.id = r.payment_mode WHERE MONTH(r.check_in) = '".$currentMonth."' group by paymentMode");
                
    //         }
    //     }
    //     return view('analytics', compact('graphTotalCheckin', 'graphTotalRevenue', 'currentMonthName', 'graphTotalReferredBy', 'graphTotalPaymentMode'));
    // }
    // analytics code end jatin

    public function index()
    {

        $this->data['counts']=DB::select(DB::raw("SELECT
            (SELECT COUNT(*) FROM users WHERE status = 1) as user_count,
            (SELECT COUNT(*) FROM orders WHERE DATE(`created_at`) = CURDATE()) as today_orders,
            (SELECT COUNT(*) FROM reservations WHERE DATE(`check_in`) = CURDATE()) as today_check_ins,
            (SELECT COUNT(*) FROM reservations WHERE DATE(`check_out`) = CURDATE()) as today_check_outs"
            ));
         $this->data['products']=Product::whereStatus(1)->whereIsDeleted(0)->orderBy('stock_qty','ASC')->get();
         $orderIds = OrderHistory::where('is_book',1)->orderBy('id','DESC')->pluck('order_id');
         $this->data['orders']=Order::with('last_order_history')->whereIn('id',$orderIds)->orderBy('created_at','DESC')->get();
         $this->getRoomList();

        return view('backend/dashboard',$this->data);
    }

/* ***** Start User Functions ***** */
    public function editLoggedUserProfile(Request $request){
        $this->data['data_row']=User::whereId(Auth::user()->id)->first();
        return view('backend/users/logged_user_profile',$this->data);
    }
    public function saveProfile(Request $request) {
        if($this->core->checkWebPortal()==0 && in_array(Auth::user()->id, [1,2,3])){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        if($request->form_type == 'updatePassword'){
            $request->merge(['password'=>Hash::make($request->new_password)]);
        }

        $res = User::updateOrCreate(['id'=>Auth::user()->id],$request->except(['_token','new_password','conf_password','email']));
        if($res){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_UPDATE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_UPDATE_0')]);
    }
    
    public function addExtrarevenue() {
        $this->data['payment_mode_list']=PaymentMode::select('id', 'payment_mode')->whereStatus(1)->orderBy('id','ASC')->pluck('payment_mode', 'id');
        $this->data['roles']=$this->getRoleList();
        return view('extrarevenue/add_edit_extrarevenue',$this->data);
    }

    public function addUser() {
        $this->data['roles']=$this->getRoleList();
        return view('backend/users/user_add_edit',$this->data);
    }
    public function addCorporate() {
        $this->data['roles']=$this->getRoleList();
        return view('backend/corporates/corporate_add_edit',$this->data);
    }
    
    public function editrevenue(Request $request){
        $this->data['roles']=$this->getRoleList();
        $this->data['payment_mode_list']=PaymentMode::select('id', 'payment_mode')->whereStatus(1)->orderBy('id','ASC')->pluck('payment_mode', 'id');
        //return $this->data['payment_mode_list'];
        //$this->data['data_row']=Revenue::whereId($request->id)->first();
       // $dtrow= DB::select("SELECT * FROM `payment_history` WHERE id = '$request->id'");
        $this->data['data_row'] = DB::table('payment_history')->whereId($request->id)->get();
        // foreach ($arraynew as $value1)
        // {
        //     $this->data['data_row'] = $value1;
        // }
        
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('extrarevenue/edit_revenue',$this->data);
    }

    public function editUser(Request $request){
        $this->data['roles']=$this->getRoleList();
        $this->data['data_row']=User::whereId($request->id)->first();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('backend/users/user_add_edit',$this->data);
    }
    public function editCorporate(Request $request){
        $this->data['roles']=$this->getRoleList();
        $this->data['data_row']=DB::table('corporates')->whereId($request->id)->first();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('backend/corporates/corporate_add_edit',$this->data);
    }

    public function saveCorporate(Request $request) {
        date_default_timezone_set('Asia/Kolkata');
        if($request->exists('id'))
        {
         $res=DB::table('corporates')->where('id',$request->id)->update($request->except('_token','id'));
         $success = config('constants.FLASH_REC_UPDATE_1');
         $error = config('constants.FLASH_REC_UPDATE_0');
         $query = DB::statement("ALTER TABLE daily_report ADD $request->name FLOAT(10,2)");

        }
         else
         {
             $res=DB::table('corporates')->insert($request->except('_token','id'));
             $success = config('constants.FLASH_REC_ADD_1');
             $error = config('constants.FLASH_REC_ADD_0');
             $query = DB::statement("ALTER TABLE daily_report ADD $request->name FLOAT(10,2)");


         }
        if($res){
            return redirect()->route('list-corporate')->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    
    public function saveExtrarevenue(Request $request) {
        //return $request;die;
        if($request->id>0){
            if($this->core->checkWebPortal()==0){
                return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
            }
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        
        // if($request->id){
        //     DB::table('payment_history')->updateOrInsert(['id'=>$request->id],['payment'=>$request->payment, 'payment_date'=>$request->payment_date, 'mode'=>$request->payment_mode, 'remark'=>$request->remark, 'extra_revenue'=>'er', 'title'=>$request->title]);
        // }else{
        //     DB::table('payment_history')->insert(['payment'=>$request->payment, 'payment_date'=>$request->payment_date, 'mode'=>$request->payment_mode, 'remark'=>$request->remark, 'extra_revenue'=>'er', 'title'=>$request->title]);
        // }
        $res_id = rand(0000000,9999999);
        $paymentdate=date('Y-m-d');
        $res = DB::table('payment_history')->updateOrInsert(['id'=>$request->id],['reservations_id'=>$res_id, 'payment'=>$request->payment, 'payment_date'=>$request->payment_date, 'mode'=>$request->mode, 'remark'=>$request->remark, 'extra_revenue'=>'er', 'title'=>$request->title]);
        //print_r($res);die;
        if($request->payment1 != null){
                foreach($request->payment1 as $key => $value){
                    if($value > 0){
                        $r_id = $res_id;
                        $value1 = $value;
                        $today = $paymentdate;
                        $mode = $request->mode1[$key];
                        $remark = $request->remark1[$key];
                        DB::table("payment_history")->insert(['reservations_id' => $r_id, 'payment' => $value1, 'payment_date' => $today, 'mode' => $mode,  'remark' => $remark, 'extra_revenue'=>'break']);
                    }
                }
            } 
        //$res = Revenue::updateOrCreate(['id'=>$request->id],['title'=>$request->title,'payment'=>$request->payment, 'payment_mode'=>$request->payment_mode, 'remark'=>$request->remark, 'payment_date'=>$request->payment_date]);
        if($res){
            return redirect()->route('list-extrarevenue')->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    
    public function updateExtrarevenue(Request $request) {
        //return $request;die;
        if($request->id>0){
            if($this->core->checkWebPortal()==0){
                return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
            }
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        
        $thisid = DB::table('payment_history')->whereId($request->id)->get('reservations_id');
        $idresupd =  $thisid[0]->reservations_id;
        //return $idresupd;
        # start updating payment history
       
        if($request->input("payment_history_ids") != null){
            foreach($request->input("payment_history_ids") as $key => $id){
                $isPaymentHistory = DB::table("payment_history")->where("id", $id)->count();
                if($isPaymentHistory > 0){
                    $res = DB::table("payment_history")->where("id", $id)->update(["payment" => $request->input("payment")[$key], "remark" => $request->input("remark_old")[$key], "mode" => $request->input("payment_mode")[$key], "payment_date" =>$request->input("payment_date")[$key] ]);
                }
            }
        }
        
        $paymentdate=date('Y-m-d');
        
        if($request->payment1 != null){
            foreach($request->payment1 as $key => $value){
                if($value > 0){
                    $r_id = $idresupd;
                    $value1 = $value;
                    $today = $paymentdate;
                    $mode = $request->mode1[$key];
                    $remark = $request->remark1[$key];
                    $res = DB::table("payment_history")->insert(['reservations_id' => $r_id, 'payment' => $value1, 'payment_date' => $today, 'mode' => $mode,  'remark' => $remark, 'extra_revenue'=>'break']);
                }
            }
        } 
        //$res = DB::table('payment_history')->insert(['reservations_id'=>$idresupd, 'payment'=>$request->payment_expense, 'mode'=>$request->mode, 'remark'=>$request->remark, 'extra_revenue'=>'break']);
        
        
        # end updating payment history
        
        // if($request->id){
        //     DB::table('payment_history')->updateOrInsert(['id'=>$request->id],['payment'=>$request->payment, 'payment_date'=>$request->payment_date, 'mode'=>$request->payment_mode, 'remark'=>$request->remark, 'extra_revenue'=>'er', 'title'=>$request->title]);
        // }else{
        //     DB::table('payment_history')->insert(['payment'=>$request->payment, 'payment_date'=>$request->payment_date, 'mode'=>$request->payment_mode, 'remark'=>$request->remark, 'extra_revenue'=>'er', 'title'=>$request->title]);
        // }
        // $res_id = rand(0000000,9999999);
        // $paymentdate=date('Y-m-d');
        // $res = DB::table('payment_history')->updateOrInsert(['id'=>$request->id],['reservations_id'=>$res_id, 'payment'=>$request->payment, 'payment_date'=>$request->payment_date, 'mode'=>$request->mode, 'remark'=>$request->remark, 'extra_revenue'=>'er', 'title'=>$request->title]);
        // //print_r($res);die;
        // if($request->payment1 != null){
        //         foreach($request->payment1 as $key => $value){
        //             if($value > 0){
        //                 $r_id = $res_id;
        //                 $value1 = $value;
        //                 $today = $paymentdate;
        //                 $mode = $request->mode1[$key];
        //                 $remark = $request->remark1[$key];
        //                 DB::table("payment_history")->insert(['reservations_id' => $r_id, 'payment_expense' => $value1, 'payment_date' => $today, 'mode' => $mode,  'remark' => $remark, 'extra_revenue'=>'break']);
        //             }
        //         }
        //     } 
        // //$res = Revenue::updateOrCreate(['id'=>$request->id],['title'=>$request->title,'payment'=>$request->payment, 'payment_mode'=>$request->payment_mode, 'remark'=>$request->remark, 'payment_date'=>$request->payment_date]);
        if($res){
            return redirect()->route('list-extrarevenue')->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    
    public function saveUser(Request $request) {
        if($request->id>0){
            if($this->core->checkWebPortal()==0){
                return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
            }
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        if($request->new_password){
            $request->merge(['password'=>Hash::make($request->new_password)]);
        }
        $res = User::updateOrCreate(['id'=>$request->id],$request->except(['_token','new_password','conf_password']));
        if($res){
            return redirect()->route('list-user')->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    public function listCorporate() {
         $this->data['datalist']=DB::table('corporates')->orderBy('name','ASC')->get();
        return view('backend/corporates/corporates_list',$this->data);
    }
    public function addTa() {
        $this->data['roles']=$this->getRoleList();
        return view('backend/tas/ta_add_edit',$this->data);
    }
    public function editTa(Request $request){
        $this->data['roles']=$this->getRoleList();
        $this->data['data_row']=DB::table('tas')->whereId($request->id)->first();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('backend/tas/ta_add_edit',$this->data);
    }
    public function saveTa(Request $request) {
        if($request->exists('id'))
       {
        $res=DB::table('tas')->where('id',$request->id)->update($request->except('_token','id'));
        $success = config('constants.FLASH_REC_UPDATE_1');
        $error = config('constants.FLASH_REC_UPDATE_0');
        $query = DB::statement("ALTER TABLE daily_report ADD $request->name FLOAT(10,2)");
       }
        else
        {
            $res=DB::table('tas')->insert($request->except('_token','id'));
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
            $query = DB::statement("ALTER TABLE daily_report ADD $request->name FLOAT(10,2)");
        }

        if($res){
            return redirect()->route('list-ta')->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    public function listTa() {
        $this->data['datalist']=DB::table('tas')->orderBy('name','ASC')->get();
       return view('backend/tas/ta_list',$this->data);
   }
   public function deleteTa(Request $request) {
    if($this->core->checkWebPortal()==0){
        return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
    }
    if(DB::table('tas')->whereId($request->id)->delete()){
        return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
    }
    return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
}
                //    OTA
                public function addOTA() {
                    $this->data['roles']=$this->getRoleList();
                    return view('backend/ota/ota_add_edit',$this->data);
                }
                
                // public function addOTAWithPaymentMode(){
                //     $this->data['roles']=$this->getRoleList();
                //     return view('backend/ota/otawithmode_add_edit',$this->data);
                // }
                
                public function editOTA(Request $request){
                    $this->data['roles']=$this->getRoleList();
                    $this->data['data_row']=DB::table('ota')->whereId($request->id)->first();
                    if(!$this->data['data_row']){
                        return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
                    }
                    return view('backend/ota/ota_add_edit',$this->data);
                }
                
                // public function editOTAWithPaymentMode(Request $request){
                //     $this->data['roles']=$this->getRoleList();
                //     $this->data['data_row']=DB::table('ota')->whereId($request->id)->first();
                //     if(!$this->data['data_row']){
                //         return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
                //     }
                //     return view('backend/ota/otawithmode_add_edit',$this->data);
                // }
                
                public function saveOTA(Request $request) {

                    if($request->exists('id'))
                    {
                        $res1=DB::table('ota')->where('id',$request->id)->get();
                        //return $res1;
                        $name = $res1[0]->name;
                        $myid = $res1[0]->id;
                        $newname = $request->name.' BTC Payment';
                        $query = DB::statement("ALTER TABLE daily_report CHANGE `$name` `$request->name` FLOAT(10,2)");
                        $res=DB::table('ota')->where('id',$request->id)->update($request->except('_token','id'));
                        
                        $requestname = array(
                            "payment_mode" => $newname,
                        );
                        $resupdate=PaymentMode::where('otarelation',$myid)->update($requestname);
                        
                        $success = config('constants.FLASH_REC_UPDATE_1');
                        $error = config('constants.FLASH_REC_UPDATE_0');
                    }
                    else
                    {
                        $res=DB::table('ota')->insertGetId($request->except('_token','id'));
                        
                        $idotarela = $res;
                        $namepm = $request->name.' BTC Payment';
                        $respm = PaymentMode::max('orderShorting');
                        $respm2 = $respm + 1;
                        
                        $paymoderel = array(
                            "payment_mode" => $namepm,
                            "status" => 1,
                            "orderShorting" => $respm2,
                            "otarelation" => $idotarela
                        );
                        
                        $respm = PaymentMode::insert($paymoderel);
                        
                        $success = config('constants.FLASH_REC_ADD_1');
                        $error = config('constants.FLASH_REC_ADD_0');
                        $query = DB::statement("ALTER TABLE daily_report ADD `$request->name` FLOAT(10,2)");
                    }

                    if($res){
                        return redirect()->route('list-ota')->with(['success' => $success]);
                    }
                    return redirect()->back()->with(['error' => $error]);
                }
                
                // public function saveOTAWithPaymentMode(Request $request) {

                //     if($request->exists('id'))
                //     {
                //         $res1=DB::table('ota')->where('id',$request->id)->get();
                //         //return $res1;
                //         $name = $res1[0]->name;
                //         $myid = $res1[0]->id;
                //         $newname = $request->name.' BTC Payment';
                //         $query = DB::statement("ALTER TABLE daily_report CHANGE `$name` `$request->name` FLOAT(10,2)");
                //         $res=DB::table('ota')->where('id',$request->id)->update($request->except('_token','id'));
                        
                //         $requestname = array(
                //             "payment_mode" => $newname,
                //         );
                //         $resupdate=PaymentMode::where('otarelation',$myid)->update($requestname);
                        
                //         $success = config('constants.FLASH_REC_UPDATE_1');
                //         $error = config('constants.FLASH_REC_UPDATE_0');
                //     }
                //     else
                //     {
                //         $res=DB::table('ota')->insertGetId($request->except('_token','id'));
                        
                //         $idotarela = $res;
                //         $namepm = $request->name.' BTC Payment';
                //         $respm = PaymentMode::max('orderShorting');
                //         $respm2 = $respm + 1;
                        
                //         $paymoderel = array(
                //             "payment_mode" => $namepm,
                //             "status" => 1,
                //             "orderShorting" => $respm2,
                //             "otarelation" => $idotarela
                //         );
                        
                //         $respm = PaymentMode::insert($paymoderel);
                //         //return $respm;
                        
                //         $success = config('constants.FLASH_REC_ADD_1');
                //         $error = config('constants.FLASH_REC_ADD_0');
                //         $query = DB::statement("ALTER TABLE daily_report ADD `$request->name` FLOAT(10,2)");
                //     }

                //     if($res){
                //         return redirect()->route('list-ota-with-paymentmode')->with(['success' => $success]);
                //     }
                //     return redirect()->back()->with(['error' => $error]);
                // }
                
                public function listOTA() {
                    $this->data['datalist']=DB::table('ota')->orderBy('name','ASC')->get();
                   return view('backend/ota/ota_list',$this->data);
                }
                
                // public function listOTAWithPaymentMode() {
                //     $this->data['datalist']=DB::table('ota')->orderBy('name','ASC')->get();
                //   return view('backend/ota/ota_list_with_paymentmode',$this->data);
                // }
                
                public function deleteOTA(Request $request) {
                    if($this->core->checkWebPortal()==0){
                        return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
                    }
                    $otadelte = DB::table('ota')->whereId($request->id)->delete();
                    $otadeltepm = DB::table('payment_mode')->where('otarelation',$request->id)->delete();
                    if($otadeltepm){
                        return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
                    }
                    return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
                }
                
                // public function deleteOTAWithPaymentMode(Request $request) {
                //     if($this->core->checkWebPortal()==0){
                //         return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
                //     }
                //     if(DB::table('ota')->whereId($request->id)->delete()){
                //         return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
                //     }
                //     return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
                // }
                
                
public function addEmail() {
    $this->data['roles']=$this->getRoleList();
    return view('backend/emails/email_add_edit',$this->data);
}
public function editEmail(Request $request){
    $this->data['roles']=$this->getRoleList();
    $this->data['data_row']=DB::table('emails')->whereId($request->id)->first();
    if(!$this->data['data_row']){
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
    }
    return view('backend/emails/email_add_edit',$this->data);
}
public function saveEmail(Request $request) {
    if($request->exists('id'))
   {
    $res=DB::table('emails')->where('id',$request->id)->update($request->except('_token','id'));
    $success = config('constants.FLASH_REC_UPDATE_1');
    $error = config('constants.FLASH_REC_UPDATE_0');
   }
    else
    {
        $res=DB::table('emails')->insert($request->except('_token','id'));
        $success = config('constants.FLASH_REC_ADD_1');
        $error = config('constants.FLASH_REC_ADD_0');
    }

    if($res){
        return redirect()->route('list-email')->with(['success' => $success]);
    }
    return redirect()->back()->with(['error' => $error]);
}

            public function listEmail() {
                // $this->data['datalist']=DB::select(DB::raw("SELECT
                // (SELECT COUNT(*) FROM users WHERE status = 1) as user_count,
                // (SELECT COUNT(*) FROM reservations WHERE referred_by_name = 'TA' and DATE(`check_in`) = CURDATE()) as ta_count,
                // (SELECT COUNT(*) FROM reservations WHERE referred_by_name = 'Corporate' and DATE(`check_in`) = CURDATE()) as corporate_count,
                // (SELECT COUNT(*) FROM reservations WHERE referred_by_name = 'FIT' and DATE(`check_in`) = CURDATE()) as fit_count,
                // (SELECT COUNT(*) FROM reservations WHERE referred_by_name = 'OTA' and DATE(`check_in`) = CURDATE()) as ota_count,
                // (SELECT COUNT(*) FROM rooms WHERE status = 1) as room_count,
                // (SELECT COUNT(*) FROM reservations WHERE  room_num and DATE(`check_in`) = CURDATE()) as occupied_rooms,
                // (SELECT COUNT(*) FROM reservations WHERE  DATE(`check_in`) = CURDATE()) as total_check_ins,
                // (SELECT COUNT(*) FROM reservations WHERE  DATE(`check_out`) = CURDATE()) as total_check_outs,
                // (SELECT COUNT(*) FROM reservations WHERE booking_payment and DATE(`check_in`) = CURDATE()) as total_payment" ,
                // ));
                // return view('backend.new_report',$this->data);
                $this->data['datalist']=DB::table('emails')->orderBy('email','ASC')->get();
            return view('backend/emails/email_list',$this->data);
            }

        public function deleteEmail(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        if(DB::table('emails')->whereId($request->id)->delete()){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
        }
        
    // public function listExtrarevenue() {
    //     $this->data['datalist']= DB::select("SELECT * FROM `payment_history` WHERE extra_revenue = 'er'");
    //     return view('extrarevenue/extra_revenue_list',$this->data);
    // }
   
    public function listExtrarevenue() {
        $this->data['payment_mode_list']=PaymentMode::select('id', 'payment_mode')->whereStatus(1)->orderBy('id','ASC')->pluck('payment_mode', 'id');
        $this->data['datalist']= DB::select("SELECT * FROM `payment_history` WHERE extra_revenue = 'er'");
        $this->data['breakerrevenue']= DB::select("SELECT * FROM `payment_history` WHERE extra_revenue = 'break'");
        return view('extrarevenue/extra_revenue_list',$this->data);
    }
    
    public function listUser() {
        $this->data['datalist']=User::orderBy('name','ASC')->get();
       return view('backend/users/user_list',$this->data);
   }
   
    // public function deleteExtrarevenue(Request $request) {
    //     if($this->core->checkWebPortal()==0){
    //         return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
    //     }
    //     if(DB::table('payment_history')->whereId($request->id)->delete()){
    //         return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
    //     }
    //     return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    // }
    
    public function deleteExtrarevenue(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        $deleteid = DB::table('payment_history')->whereId($request->id)->get('reservations_id');
        $id = $deleteid[0]->reservations_id;
        //return $deleteid[0]->reservations_id;
        if(DB::table('payment_history')->where('reservations_id','=',$id)->delete()){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
    
    public function deleteUser(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        if(User::whereId($request->id)->delete()){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
    public function deleteCorporate(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        if(DB::table('corporates')->whereId($request->id)->delete()){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }

/* ***** End User Functions ***** */

/* ***** Start Room Functions ***** */
    public function addRoom() {
        $this->data['roomtypes_list']=getRoomTypesList();
        return view('backend/rooms/room_add_edit',$this->data);
    }
    public function editRoom(Request $request){
        $this->data['roomtypes_list']=getRoomTypesList();
        $this->data['data_row']=Room::whereId($request->id)->first();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('backend/rooms/room_add_edit',$this->data);
    }
    public function saveRoom(Request $request) {
           $room=Room::where('room_no',$request->room_no)->where('is_deleted', 0)->first();
           if(!empty($room))
           {
            $updateRoom = array("floor" => $request->floor,
                            "room_type_id" => $request->room_type_id,
                            "price" => $request->price,
                            "status" => $request->status,
                            "maintinance" => $request->maintinance);
            $res = Room::whereId($request->id)->update($updateRoom);
            if($res){
                return redirect()->back()->with(['success' => 'Room updated Successfully']);
            }
             else
                 return redirect()->back()->with(['error' => 'error in updating Exist']);
           }
           else
           {
                $res = Room::create($request->except(['_token']));
            if($res){
                return redirect()->back()->with(['success' => 'Room created  Successfully']);
            }
             else
                 return redirect()->back()->with(['error' => 'error in creating Room']);
           }

    }
    public function listRoom() {
        $this->data['datalist']=Room::whereStatus(1)->whereIsDeleted(0)->orderBy('room_no','ASC')->get();
        return view('backend/rooms/room_list',$this->data);
    }
    public function deleteRoom(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        if(Room::whereId($request->id)->update(['is_deleted'=>1])){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
/* ***** End Room Functions ***** */

/* ***** Start Room Types Functions ***** */
    public function addRoomType() {
        $this->data['amenities_list']=$this->getAmenitiesList();
        return view('backend/rooms/room_types_add_edit',$this->data);
    }
    public function editRoomType(Request $request){
        $this->data['amenities_list']=$this->getAmenitiesList();
        $this->data['data_row']=RoomType::whereId($request->id)->first();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('backend/rooms/room_types_add_edit',$this->data);
    }
    public function saveRoomType(Request $request) {

        if($request->id>0){
            if($this->core->checkWebPortal()==0){
                return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
            }
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        $request->merge(['amenities'=>(join(',',$request->amenities_ids))]);
        $res = RoomType::updateOrCreate(['id'=>$request->id],$request->except(['_token','amenities_ids']));
        $room_type_id = $res->id;

        $res = new DatePriceRange;
        $res->date_price = $request->input("date_price");
        $res->start_date = $request->input("start_date");
        $res->end_date = $request->input("end_date");
        $res->room_type_id = $room_type_id;
        $res->save();
        if($res){
            return redirect()->back()->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    public function listDatePriceRange() {
        $this->data['datalist']=DatePriceRange::whereStatus(1)->orderBy('id','Desc')->get();
        return view('backend/rooms/date_price_range_list',$this->data);
   }
//    public function editDatePriceRange(Request $request){
//     $this->data['amenities_list']=$this->getAmenitiesList();
//     $this->data['data_row']=DatePriceRange::whereId($request->id)->first();
//     if(!$this->data['data_row']){
//         return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
//     }
//     return view('backend/rooms/room_types_add_edit',$this->data);
// }
    public function listRoomType() {
         $this->data['datalist']=RoomType::whereStatus(1)->whereIsDeleted(0)->orderBy('title','ASC')->get();
        return view('backend/rooms/room_types_list',$this->data);
    }
    public function getroomtype(Request $request) {
        $id = $request->id;
        $data = DB::select("select * from room_types where id= '$id'");
        return $data;
    }
    public function deleteRoomType(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        if(RoomType::whereId($request->id)->update(['is_deleted'=>1])){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
/* ***** End Room Types Functions ***** */

/* ***** Start Amenities Functions ***** */
    public function addAmenities() {
        return view('backend/rooms/amenities_add_edit',$this->data);
    }

    




    public function editAmenities(Request $request){
        $this->data['data_row']=Amenities::whereId($request->id)->first();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['success' => config('constants.Record successfully added!')]);
        }
        return view('backend/rooms/amenities_add_edit',$this->data);
    }
    
    
    
    public function editHotelAmenities(Request $request){
        $this->data['data_row']=DB::table('hotetamenities')->where('id',$request->id)->first();
        
       return view('backend/rooms/hotel_amenities_add_edit',$this->data);
    }
    
    
    
      public function editAvailedServices(Request $request){
        $this->data['data_row']=DB::table('availedservices')->where('id',$request->id)->first();
        
       return view('backend/rooms/availed_services_add_edit',$this->data);
    }
    
    
    
    
    
    
    

    public function Addhotalamenities(){
        
        return view('backend/rooms/Add_hotal_amenities',$this->data);
    }


    public function savehotalamenities(Request $request) {



        $hotalamenities = [
            "name" => $request->name,
            "description" => $request->description,
            "Status" => $request->status
        ];
        $savehotalamenities = DB::table('hotetamenities')->insert($hotalamenities);
        return redirect()->back()->with(['success' => config('constants.Record successfully added!')]);
    }




    public function Addavailedservices(){
        
        return view('backend/rooms/Addavailedservices',$this->data);
    }


    public function saveAddavailedservices(Request $request) {



        $availedservices = [
            "name" => $request->name,
            "description" => $request->description,
            "Status" => $request->status
        ];
        $saveavailedservices = DB::table('availedservices')->insert($availedservices);
        return redirect()->back()->with(['success' => config('constants.Record successfully added!')]);
    }


    function CorporateBill(Request $request)
    {
        if(isset($request->date1))
        {
            $v=explode("/",$request->date1);
             $from=$v[0] ?? '';
             $to=$v[1] ?? '';
             $query = Reservation::whereStatus(1)->whereIsDeleted(1)->wherePaymentStatus(1)->whereBetween('check_out', [$from, $to]);
        }
        else
        {
            $query = Reservation::whereStatus(1)->whereIsDeleted(1)->wherePaymentStatus(1);
        }
        if($request->type == 'corporate')
        {
            if(isset($request->corporate))
            {
                $corporates=DB::table('corporates')->where('name',$request->corporate)->first();
                $query->where('corporates',$corporates->name ?? '')->whereReferredByName('Corporate');
            }
            else
            {
                $query->whereReferredByName('Corporate');
            }
            $corporates=DB::table('corporates')->pluck('name');
            $reservationData=$query->orderBy('created_at','DESC')->select('id','amount_json','customer_id','referred_by_name','corporates')->get();
         }
        if($request->type == 'ta')
        {
            if(isset($request->corporate))
            {

                $tas=DB::table('tas')->where('name',$request->corporate)->first();
                $query->whereReferredByName('TA')->where('tas',$tas->name ?? '');
            }
            else
            {
                $query->whereReferredByName('TA');
            }
            $corporates=DB::table('tas')->pluck('name');
            $reservationData=$query->orderBy('created_at','DESC')->select('id','amount_json','customer_id','referred_by_name','tas')->get();
            // dd( $reservationData);

        }
        if($request->type == 'ota')
        {
            if(isset($request->corporate))
            {
                $ota=DB::table('ota')->where('name',$request->corporate)->first();
                $query->whereStatus(1)->whereReferredByName('OTA')->where('ota',$ota->name ?? '');
            }
            else
            {
                $query->whereReferredByName('OTA');
            }

            $corporates=DB::table('ota')->pluck('name');
            $reservationData=$query->orderBy('created_at','DESC')->select('id','amount_json','customer_id','referred_by_name','ota')->get();

        }
        return view('backend/billing',compact('reservationData','corporates'));
    }
    public function saveAmenities(Request $request) {
        if($request->id>0){
            if($this->core->checkWebPortal()==0){
                return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
            }
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        $res = Amenities::updateOrCreate(['id'=>$request->id],$request->except(['_token']));

        if($res){
            return redirect()->back()->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    
    
    
    
     public function updatehotelamenities(Request $request) {
    //   return $request;
        $hotetamenities = [
            "name"=>$request->name,
            "description"=>$request->description,
            "Status"=>$request->status
            ];
        
        
       $res = DB::table('hotetamenities')->where('id',$request->id)->update($hotetamenities);
         $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        // $res = Amenities::updateOrCreate(['id'=>$request->id],$request->except(['_token']));
  if($res){
            return redirect()->back()->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
      
    }
    
    
     public function updateAvailedServices(Request $request) {
    //   return $request;
        $availedservices = [
            "name"=>$request->name,
            "description"=>$request->description,
            "Status"=>$request->status
            ];
        
        
       $res = DB::table('availedservices')->where('id',$request->id)->update($availedservices);
         $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        // $res = Amenities::updateOrCreate(['id'=>$request->id],$request->except(['_token']));
  if($res){
            return redirect()->back()->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
      
    }
    
    
    
    
    public function listAmenities() {
        $this->data['datalist']=Amenities::whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
        return view('backend/rooms/amenities_list',$this->data);
    }
    
    public function listHotalAmenities() {
        $this->data['datalist']=DB::table('hotetamenities')->where('Status',1)->orderBy('id','DESC')->get();
        return view('backend/rooms/hotel_amenities_list',$this->data);
    }
    
    
     public function listAvailedServices() {
        $this->data['datalist']=DB::table('availedservices')->where('Status',1)->orderBy('id','DESC')->get();
        return view('backend/rooms/availed_services_list',$this->data);
    }
    
    
    
    
    
    
    public function deleteAmenities(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        if(Amenities::whereId($request->id)->update(['is_deleted'=>1])){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
    
    
    
    
      public function deleteHotelAmenities(Request $request) {
        if(DB::table('hotetamenities')->where('id',$request->id)->delete()){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
    
    
    
      public function deleteAvailedServices(Request $request) {
        if(DB::table('availedservices')->where('id',$request->id)->delete()){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
    
    
    
    
    
    
    
/* ***** End Amenities Functions ***** */

/* ***** Start RoomReservation Functions ***** */

    public function roomReservation(Request $request) {
          
        $this->data['data_row']=DB::table('arrivals')->join('customers','customers.id','=','arrivals.customer_id')->leftjoin('packages', 'packages.id', '=', 'arrivals.package_id')->leftjoin('date_price_range', function($join){
            $join->on('date_price_range.start_date', '<=', 'arrivals.check_in')
            ->On('date_price_range.end_date', '>=', 'arrivals.check_in');
        } )->leftjoin('room_types', 'room_types.id', '=', 'arrivals.room_type_id')->select('arrivals.check_in as check_in','arrivals.id as id','arrivals.*','customers.*','arrivals.payment as advance_payment', 'packages.package_price', 'date_price_range.date_price', DB::RAW('(CASE WHEN arrivals.is_weekend = "0" then `room_types`.`base_price` ELSE  `room_types`.`base_price_weekends` end ) as final_price'))->where('arrivals.id',$request->id)->first();
//dd($this->data['data_row']);
        $this->data['roomtypes_list']=RoomType::select('id','title','is_base_price','base_price')->whereStatus(1)->whereIsDeleted(0)->orderBy('title','ASC')->pluck('title','id');
        $this->data['customer_list']=getCustomerList();
        $this->data['getmid'] = Setting::where('name', 'mid')->select('value')->first();
        $this->data['corporates']=DB::table('corporates')->pluck('name');
        $this->data['tas']=DB::table('tas')->pluck('name');
        $this->data['ota']=DB::table('ota')->select('id','name')->get();
        // $jatin =  $this->data['ota'];
        // foreach($jatin as $j){
        //     print_r($j->id);
        // }
        // die;
        $this->data['package_list']=PackageMaster::select('id','title', 'package_price', 'room_type_id')->whereStatus(1)->orderBy('id','DESC')->get();
        $this->data['mealplan_list']=MealPlan::select('id', 'name')->whereStatus(1)->orderBy('id','ASC')->pluck('name', 'id');
        $this->data['payment_mode_list']=PaymentMode::select('id', 'payment_mode')->whereStatus(1)->orderBy('id','ASC')->pluck('payment_mode', 'id');
        $this->data['arrivals_id'] = $request->id;
        return view('backend/rooms/room_reservation_add_edit',$this->data);
    }
    
    public function myotaalldata(Request $request){
        $id = $request->id;
        //$selctoption = PaymentMode::where('otarelation',$id)->get();
        $selctoption = PaymentMode::whereIn('otarelation', [$id,1000, 2000, 3000, 4000,5000])->get();
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

    public function roomArrivalReservation() {
        //  echo "Herer";

        //print_r($result);
        //$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


    $this->data['roomtypes_list']=RoomType::select('id','title','is_base_price','base_price')->whereStatus(1)->whereIsDeleted(0)->orderBy('title','ASC')->pluck('title','id');
    $this->data['customer_list']=getCustomerList();
    $this->data['getmid'] = Setting::where('name', 'mid')->select('value')->first();
    $this->data['corporates']=DB::table('corporates')->pluck('name');
    $this->data['tas']=DB::table('tas')->pluck('name');
    $this->data['ota']=DB::table('ota')->pluck('name');
    $this->data['payment_mode']=DB::table('payment_mode')->get();
    $this->data['package_list']=PackageMaster::select('id','title', 'package_price','room_type_id')->whereStatus(1)->orderBy('id','DESC')->get();
    return view('backend/rooms/room_arrival_reservation_add_edit',$this->data);
}

     public function roomReservationAvailable($id) {

        $data['available-room']=DB::select("select * from rooms where id='$id' and is_deleted = '0' and status= '1'");
         $this->data['roomtypes_list']=RoomType::select('id',DB::raw('CONCAT(title, " (Price: ", base_price,")") AS title'))->whereStatus(1)->whereIsDeleted(0)->orderBy('title','ASC')->pluck('title','id');
         $this->data['data_row']=DB::table('arrivals')->join('customers','customers.id','=','arrivals.customer_id')->leftjoin('packages', 'packages.id', '=', 'arrivals.package_id')->leftjoin('date_price_range', function($join){
            $join->on('date_price_range.start_date', '<=', 'arrivals.check_in')
            ->On('date_price_range.end_date', '>=', 'arrivals.check_in');
        } )->leftjoin('room_types', 'room_types.id', '=', 'arrivals.room_type_id')->select('arrivals.check_in as check_in','arrivals.id as id','arrivals.*','customers.*', 'packages.package_price', 'date_price_range.date_price', DB::RAW('(CASE WHEN arrivals.is_weekend = "0" then `room_types`.`base_price` ELSE  `room_types`.`base_price_weekends` end ) as final_price'))->where('arrivals.id',$id)->first();
        $this->data['customer_list']=getCustomerList();
        $this->data['corporates']=DB::table('corporates')->pluck('name');
        $this->data['tas']=DB::table('tas')->pluck('name');
        $this->data['ota']=DB::table('ota')->pluck('name');
        $this->data['package_list']=PackageMaster::select('id','title', 'package_price', 'room_type_id')->whereStatus(1)->orderBy('id','DESC')->get();
        $this->data['mealplan_list']=MealPlan::select('id', 'name')->whereStatus(1)->orderBy('id','ASC')->pluck('name', 'id');
        return view('backend/rooms/room_reservation_available',$this->data)->with(compact('data'));
    }

     public function editRoomReservation(Request $request){
       $this->data['roomtypes_list']=getRoomTypesList();
       $this->data['customer_list']=getCustomerList();
        $this->data['unique_id']=$request->unique_id;
       $this->data['data_row']=Reservation::with('orders_items','orders_info')->where('payment_status',0)->where('unique_id','=',$request->unique_id)->first();
       //SELECT payment FROM `payment_history` WHERE reservations_id = 475 AND remark = 'Extra Stay'
       //$this->data['data_row']->final_total_amount = $this->data['data_row']->total_amount;
       
        // $extraDaysAmount = DB::table("payment_history")->where(array("reservations_id" => $this->data['data_row']->id, "remark" => 'Extra Stay'));
        // //echo $extraDaysAmount->first()->payment;die;
        // if($extraDaysAmount->count() > 0){
        //     //$this->data['data_row']->total_amount = ($this->data['data_row']->total_amount + $extraDaysAmount->first()->payment);
        // }
            
      
       $this->data['corporates']=DB::table('corporates')->pluck('name');
       $this->data['tas']=DB::table('tas')->pluck('name');

      $this->data['setting']=DB::table('settings')->get();

        if($this->data['data_row']->referred_by_name == "OTA")
        {
            $this->data['ota_check']=DB::table('ota')->where('name',$this->data['data_row']->referred_by)->get();
        }
       $this->data['ota']=DB::table('ota')->pluck('name');


       $this->data['mealplan_list']=MealPlan::select('id', 'name')->whereStatus(1)->orderBy('id','ASC')->pluck('name', 'id');
       $this->data['payment_mode_list']=PaymentMode::select('id', 'payment_mode')->whereStatus(1)->orderBy('id','ASC')->pluck('payment_mode', 'id');
       if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        else if($this->data['data_row']){
            
            $multi_room_data = Reservation::where('payment_status',0)->where('customer_id', $this->data['data_row']->customer_id)->where('unique_id','=',$this->data['data_row']->unique_id)->get();
            //return $multi_room_data;
            $this->data['count'] = count($multi_room_data);
           
            if(count($multi_room_data) > 0)
            {
                $this->data["customer_room_data"] = $multi_room_data;
            }
            else{
                $this->data["customer_room_data"] = "empty";
            }
        }
        
        //return $this->data;

        return view('backend/rooms/room_reservation_edit',$this->data);
    }
       
       public function getDocument(Request $request)
       {
           $customer=$request->customer_id;
            $arr=explode("-",$customer);
            $customer_id=$arr[2];
            
            $media=DB::table('reservations')
            ->join('customers','customers.id','=','reservations.customer_id')
            ->where('reservations.customer_id',$customer_id)
            ->select('customers.document','reservations.idcard_no','reservations.idcard_type')
            ->get();
            
             
             return response()->json($media[0]);
            
       }
    
    
    
    public function setTime(Request $request){
        $emails=DB::table('emails')->get();
        if(empty($emails))
        {
           return redirect()->route('add-email')->with(['error' => 'First Enter Email for which you want to shedule report']);
        }
        DB::table('emails')->update(['time'=>$request->time]);
        return redirect()->back()->with(['success' => 'Time set for Reporting email Successful']);
    }
    public function report(){

        $this->data['list_checkin'] = 'check_ins';
        // $this->data['datalist']=Reservation::whereDate('check_in', '>=', $startDate." 00:00:00")->whereDate('check_in', '<=', DB::raw('CURDATE()'))->whereStatus(1)->whereIsDeleted(0)->whereNotNull('check_in')->orderBy('created_at','DESC')->get();
        $this->data['datalist_checkin']=Reservation::whereStatus(1)->whereIsDeleted(0)->orderBy('created_at','DESC')->get();

        $startDate = getNextPrevDate('prev');
        $this->data['list'] = 'check_outs';
        $this->data['datalist']=Reservation::whereDate('check_out', '>=', $startDate." 00:00:00")->whereDate('check_out', '<=', DB::raw('CURDATE()'))->whereStatus(1)->whereIsDeleted(0)->whereNotNull('check_out')->orderBy('created_at','DESC')->get();
        $this->data['roomtypes_list']=getRoomTypesList();
        $this->data['customer_list']=getCustomerList();
        $this->data['emails']=DB::table('emails')->get();
        $this->data['search_data'] = ['customer_id'=>'','room_type_id'=>'','date_from'=>'', 'date_to'=>''];
         return view('backend/rooms/room_reservation_report',$this->data);
    }
    public function dailyReport()
    {
        $this->data['datalist']=DB::table('daily_report')->get();
        $this->data['paymentmode_list']=PaymentMode::where('status', 1)->get();
        $this->data['corporate']=DB::table('corporates')->get();
        $this->data['ta']=DB::table('tas')->get();
        $this->data['ota']=DB::table('ota')->get();
        //dd($this->data);
        
         //return $this->data;
        return view('backend/dailyReport',$this->data);
    }


    public function reportExcel()
    {
        return view('backend/reportExcel');
    }




    public function activity()
    {
        $datalist= UserLog::latest()->get();
        return view('backend/activities',compact('datalist',$datalist));
    }

    public function editReservation(Request $request){
        $this->data['roomtypes_list']=getRoomTypesList();
        $this->data['customer_list']=getCustomerList();
        $this->data['data_row']=Reservation::with('orders')->whereId($request->id)->first();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
       
        return view('backend/rooms/check_out',$this->data);
    }





    public function updateArrival(Request $request)
    {
                         Customer::where('id', $request->customerId)->update($customerData);
                                    $date=$request->check_in_date;
                                    $checkoutdate=$request->check_out_date;
                                    $time = date("H:i:s");
                                    $datetime = $date ." ". $time;
                                    $checkoutdatatime = $checkoutdate ." ". $time;
                                    Carbon::useStrictMode(false);
                                    $to_date = Carbon::parse($checkoutdatatime);
                                    $from_date = Carbon::parse($datetime);
                                    $answer_in_days = $to_date->diffInDays($from_date);
                             $res=DB::table('arrivals')->where('id',$request->id)->update([
                                        "customer_id" => $customerId,
                                        "check_in" => $datetime,
                                        // "check_out" => $checkoutdatatime,
                                        "duration_of_stay" => $request->duration_of_stay,
                                        "adult" => $request->adult,
                                        "kids" => $request->kids,
                                        "vehicle_number" => $request->vehicle_number,
                                        "corporates" => $request->corporate,
                                        "tas" => $request->ta,
                                        "ota" => $request->ota,
                                        "referred_by_name" => $request->referred_by_name,
                                      ]);
                                      if($res)
                                        $success = config('constants.FLASH_REC_UPDATE_1');
                                       else
                                        $error = config('constants.FLASH_REC_UPDATE_0');

                            if($res){
                                return redirect()->route('arrival-list')->with(['success' => $success]);
                            }
                               return redirect()->back()->with(['error' => $error]);
    }
        public function saveArrival(Request $request) {
                    $validatedData = $request->validate([
                        'name' => 'required',
                        // 'and_number' => 'required'
                    ]);
                    
                    if($request->referred_by_name == "F9" || $request->referred_by_name == "Management")
                    {
                        $spl = str_split($request->name);
                        $Booking_id = $spl[0].$spl[1].rand(0000,9999);  
                    }
                    else
                    {
                        $Booking_id = "";
                    }
                    
                    $dateOfBirth = dateConvert($request->age, 'Y-m-d');
                    $years = Carbon::parse($dateOfBirth)->age;
                            $customerData = [
                                "Booking_id" => $request->Booking_id ?? $Booking_id,
                                "and_number" => $request->and_number,
                                "name" => $request->name,
                                "father_name" => $request->father_name,
                                "email" => $request->email,
                                "mobile" => $request->mobile,
                                "address" => $request->address,
                                "nationality" => $request->nationality,
                                "country" => $request->country,
                                "state" => $request->state,
                                "city" => $request->city,
                                "gender" => $request->gender,
                                "dob" => dateConvert($request->age, 'Y-m-d'),
                                "age" => $years,
                                "password" => Hash::make($request->mobile),
                            ];

                                    $customerId = Customer::insertGetId($customerData);
                                    $date=$request->check_in_date;
                                    $checkoutdate=$request->check_out_date;
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
                                    $res=DB::table('arrivals')->insert([
                                        "customer_id" => $customerId,
                                        "check_in" => $datetime,
                                        "check_out" => $checkoutdatatime,
                                        "duration_of_stay" => $answer_in_days,
                                        "adult" => $request->adult,
                                        "kids" => $request->kids,
                                        "infant" => $request->infant,
                                        "Booking_Reason" => $request->Booking_Reason,
                                        "vehicle_number" => $request->vehicle_number,
                                        "corporates" => $request->corporate,
                                        "tas" => $request->ta,
                                        "ota" => $request->ota,
                                        "referred_by_name" => $request->referred_by_name,
                                        "room_type_id" => $request->room_type_id,
                                        "room_num" => $request->arrival_room_num,
                                        "room_qty" => $request->no_of_rooms,
                                        "package_id" => $request->package_id,
                                        "check_in_day" => $check_in_day,
                                        "is_weekend" => $is_weekend,
                                        "advance" =>$request->advance,
                                        "payment" =>$request->payment,
                                        "payment_mode"=>$request->payment_mode
                                      ]);

                                        $success = config('constants.FLASH_REC_ADD_1');
                                        $error = config('constants.FLASH_REC_ADD_0');


                            if($res){
                                return redirect()->route('list-arrival-reservation')->with(['success' => $success]);
                            }
                               return redirect()->back()->with(['error' => $error]);
        }

        public function saveReservation(Request $request) {
            //   return $request;
            //   die;
            $data = $request->all();
            // return $data;die;
            date_default_timezone_set('Asia/Kolkata');
            
            if($request->referred_by_name == 'OTA'){
                $validatedData = $request->validate([
                    'ota' => 'required'
                ]);
            }
            
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
                $todayDate = date('Y-m-d');
                $date = date('Y-m-d',strtotime($todayDate.'-1 days'));
                $datetime = $date ." ". $time;
                $checkoutdatatime=date('Y-m-d',strtotime($date.'+ '.$request->duration_of_stay.' days'));
                $paymentdate=$date;
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
            $room = $request->per_room_price_new;
            if($request->booking_payment){
                $booking = $request->booking_payment;
            }else{
                $booking = $request->per_room_price_new;
            }

            $reservationData = [];
            $customerData = [];

            if($request->guest_type=='existing'){
                $user_arr=explode("-",$request->selected_customer_id);
                $custData = Customer::whereId(@$user_arr[2])->first();
                $custName = $custData->name;
                $customerId = $custData->id;
            }
            else {
                if(isset($request->id))
                {
                    $custData = Customer::whereId($request->id)->first();
                    $custName = $custData->name;
                    $customerId = $custData->id;
                    
                    $dateOfBirth = dateConvert($request->age, 'Y-m-d');
                    $years = Carbon::parse($dateOfBirth)->age;
                    
                    $customerData = [
                        "and_number" => $mid,
                        "mobile" => $request->mobile,
                        "address" => $request->Address,
                        "gender" => $request->gender,
                        "dob" => dateConvert($request->age, 'Y-m-d'),
                        "age" => $years
                        
                    ];
                
                    $andnodone = Customer::whereId($customerId)->update($customerData);
                    // print_r($andnodone);
                }
                else
                {
            
                    if($request->referred_by_name == "F9" || $request->referred_by_name == "Management")
                    {
                        $spl = str_split($request->name);
                        $Booking_id = $spl[0].$spl[1].rand(0000,9999);  
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
                   
                    $customerId = Customer::insertGetId($customerData);
                }
            }
            //print_r($customerId);
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
                    "customer_id" => $customerId,
                     'total_amount'=>$request->total_amount ?? 0,
                     "booking_payment" => $booking,
                     "room_qty" => $room_qty,
                     "unique_id"=>uniqid(),
                     "per_room_price" => $request->per_room_price_new,
                     "guest_type" => $request->guest_type,
                     "check_in" => $datetime,
                     "created_at_checkin" => $datetime,
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
                     'mid'=>$mid,
                     'arrival_ornot' => 'arrive'
                     
                 ];
            
                if(!$request->id){
                    $reservationData["created_at_checkin"] = date('Y-m-d H:i:s');
                }
                $res = Reservation::insertGetId($reservationData);
            
                $paytmParams["body"] = array(
                    "clientId"             => "8e5a3jsp0hh7",
                    "clientSecret"        => "xsW3fI3q45",
                );
                Setting::where('name', 'mid')->update(['value'=>$mid]);
           
                $history['payment']=$request->advance_payment ?? 0;
                $history['mode']=$request->payment_mode;
                $history['payment_date']=$paymentdate;
                $history['reservations_id']=$res;
                $history['remark']='Advance';
            
                DB::table("payment_history")->insert($history);
                // dd($reservationData['room_num'])
                $f=$this->foreca($reservationData['room_num'],$custName,$datetime,$checkoutdatatime,$res,$request->adult,$request->kids);
                //dd($f);
                
                $hit['checkin']=$datetime;
                $hit['checkout']=$checkoutdatatime;
                $hit['payment']=$booking;
                $hit['adult']=$request->adult;
                $hit['source']=$referred_by;
                $hit['payment_mode']=$request->payment_mode;
                $se=Setting::where('name','hotel_name')->first();
                $hit['hotel']=$se->value;
                $hit['room_number']=($request->room_num) ? join(',',$request->room_num) : null;
                $hit['nights']=$request->duration_of_stay;
                $hit['invoice_number']=$reservationData['unique_id'];
                $re=centralDataInsert($hit);
            }
            elseif($room_count > 1)
            {
                $unique_id=uniqid();
                foreach($request->room_num as $rm_num)
                {
                    // echo $customerId;die();
                    $reservationData = [
                        "customer_id" => $customerId,
                        'total_amount'=>$request->total_amount ?? 0,
                        'unique_id'=>$unique_id,
                         "booking_payment" => $request->total_amount/$room_count,
                         "per_room_price" => $perroom,
                         "room_qty" => $room_qty/$room_count,//$request->room_qty,
                         "guest_type" => $request->guest_type,
                         "check_in" => $datetime,
                         "created_at_checkin" => $datetime,
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
                         'mid'=>$mid,
                         'arrival_ornot' => 'arrive'
                    ];
                    // print_r($reservationData);
                
                    if(!$request->id){
                        $reservationData["created_at_checkin"] = date('Y-m-d H:i:s');
                    }
                    $res = Reservation::insertGetId($reservationData);
                    // return $res;
                    // $res = Reservation::updateOrCreate(['id'=>$request->id],$reservationData);
                
                    $paytmParams["body"] = array(
                        "clientId"             => "8e5a3jsp0hh7",
                        "clientSecret"        => "xsW3fI3q45",
                    );
                
                    Setting::where('name', 'mid')->update(['value'=>$mid]);
                    $history['payment']=$request->advance_payment/$room_count ?? 0;
                    $history['mode']=$request->payment_mode;
                    $history['payment_date']=$paymentdate;
                    $history['reservations_id']= $res;
                    $history['remark']='Advance';
                    
                    DB::table("payment_history")->insert($history);
                    
                    $hit['checkin']=$datetime;
                    $hit['checkout']=$checkoutdatatime;
                    $hit['payment']=$booking;
                    $hit['adult']=$request->adult;
                    $hit['source']=$referred_by;
                    $hit['payment_mode']=$request->payment_mode;
                    $se=Setting::where('name','hotel_name')->first();
                    $hit['hotel']=$se->value;
                    $hit['room_number']=($request->room_num) ? join(',',$request->room_num) : null;
                    $hit['nights']=$request->duration_of_stay;
                    $hit['invoice_number']=$reservationData['unique_id'];
                    $re=centralDataInsert($hit);
                }
            }

            if($room_count !=1)
            {
                $idd = $res -1;
            }
            else
            {
                $idd = $res;
            }

            // if(!$request->id){
            //     $reservationData["created_at_checkin"] = date('Y-m-d H:i:s');
            // }
            // $res = Reservation::updateOrCreate(['id'=>$request->id],$reservationData);
            //         $paytmParams["body"] = array(
            //     "clientId"             => "8e5a3jsp0hh7",
            //     "clientSecret"        => "xsW3fI3q45",
            // );


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
                
                    $idImages[] = ['tbl_id'=>$res, 'file'=>$fileName];
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
                'tbl_id'=>$res,
                'file'=>$fileNameFront,
                'cnic_back'=>$fileNameBack,
                
                );
        
                DB::table('media_files')->InsertGetId($mediaData);
                if(isset($request->persons_info['name'])){
            
                    $personReqData = $request->persons_info;
            
                    $personsData = [];
                    
                    foreach($personReqData['name'] as $k=>$val){
                        // if ( !empty($personReqData['document_upload'][$k]) && !empty($personReqData['age'][$k]) && !empty($personReqData['gender'][$k]) && !empty($personReqData['idcard_type']) )
                        // {
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
                   
                    // print_r($personsData);die();
                    // $request->session()->flush();
                    if(count($personsData)>0){
                        PersonList::insert($personsData);
                    }
            
                }
            
                if(!$request->id && $request->mobile){
                    $this->core->sendSms(1,$request->mobile,["name" => $custName]);
                }
                //return redirect()->back()->with(['success' => $success]);
                return redirect('admin/list-arrivals')->with('success', 'User Inserted Successfully');
            }
            return redirect()->back()->with(['error' => $error]);
        }


    //saveGuestCard

    public function saveGuestCard(Request $request) {
        if(isset($request->step)){
            $data = $request->all();
            $step = $request->step;
            $oldId = $request->oldId;
            if($step == 0){
                $img = $request->id_cardno;
                if(!empty($img)){
                    foreach($img as $key => $imgs){
                        if(!empty($imgs)){
                            $image_parts = explode(";base64,", $imgs);
                            $image_type_aux = explode("image/", $imgs);
                            $image_type = $image_type_aux[1];
                            $image_base64 = base64_decode($image_parts[1]);
                            $fileName = uniqid() . '.png';
                            if($key == 0){
                                $field = 'file';
                            }
                            if($key == 1){
                                $field = 'cnic_back';
                            }
                            $destination = 'public/uploads/id_cards/';
                            $file = $destination . $fileName;
                            file_put_contents($file, $image_base64);
                            $this->updateImgDatabase($oldId, $field, $fileName);
                        }
                    }
                }
            }else{
                $img = $request->id_cardno;
                if(!empty($img)){
                    foreach($img as $key => $imgs){
                        if(!empty($imgs)){
                            $image_parts = explode(";base64,", $imgs);
                            $image_type_aux = explode("image/", $imgs);
                            $image_type = $image_type_aux[1];
                            $image_base64 = base64_decode($image_parts[1]);
                            $fileName = uniqid() . '.png';
                            $fileDatabaseName = 'public/uploads/id_cards/'.$fileName;
                            if($key == 0){
                                $field = 'cnic_front';
                            }
                            if($key == 1){
                                $field = 'cnic_back';
                            }
                            $destination = 'public/uploads/id_cards/';
                            $file = $destination . $fileName;
                            file_put_contents($file, $image_base64);
                            $this->updateImgDatabaseSecound($oldId, $field, $fileDatabaseName);
                        }
                    }
                }
            }
        }else{
            $data = $request->all();
            
            $temp_id = session()->get('temp_id');
             if(!$temp_id) {
             $unique_id=uniqid();
            session()->put('temp_id', $unique_id);


                     }







                 $img = $request->id_cardno;
     //            for($c=0; $c < count($img); $c++){



         $folderPath = "public/uploads/id_cards/";

        $image_parts = explode(";base64,", $img[0]);
         $image_type_aux = explode("image/", $image_parts[0]);
         $image_type = $image_type_aux[1];
         
         $image_base64 = base64_decode($image_parts[1]);
         $fileName = uniqid() . '.png';

         $file = $folderPath . $fileName;
         file_put_contents($file, $image_base64);

         


         $folderPath = "public/uploads/id_cards/";

         $image_parts = explode(";base64,", $img[1]);
         $image_type_aux = explode("image/", $image_parts[0]);
         $image_type = $image_type_aux[1];

         $image_base64 = base64_decode($image_parts[1]);
         $fileName = uniqid() . '.png';

         $back = $folderPath . $fileName;
         file_put_contents($back, $image_base64);

         print_r($back);
             $data=array(
             'front'=>$file,
             'back'=>$back,
             'is_fetch'=>session()->get('temp_id'),
             );

             DB::table('guest_cnic_images')->InsertGetId($data);
        }
    }


    //Auto Complete
    public function autocomplete(Request $request)
    {
        $data=Customer::select(DB::raw("CONCAT(customers.name,'-',customers.mobile,'-',customers.id) as name",""),"mobile","id")
        ->where("name","LIKE","%{$request->input('query')}%")
        ->orWhere( "mobile","LIKE","%{$request->input('query')}%")
        ->get();
        return response()->json($data);
    }
    public function paytmSendLink(Request $request){
        $string = Str::random(5);
       if($request->guest_type=="existing"){
           $customer=$request->customer;
           $arr=explode("-",$customer);

           $phone=$arr[1];

           $customer=Customer::where('mobile',$phone)->first();
           $name=$customer->name;
           $email=$customer->email;
           $phone=$customer->mobile;



       }else{
           $name=$request->name;
           $email=$request->email;
           $phone=$request->phone;
           $payment=$request->payment;
       }
      // $phone="9941636316";
     //  $email="sivatgi@gmail.com";
        $paytmParams = array();

       $paytmParams["body"] = array(
           "mid"             => "pFzAof74619396706958",
           "linkType"        => "GENERIC",
           "linkId"             => "31309",
           "linkDescription" => "Payment for Room",
           "linkName"        => "Payment",
           "sendSms"            => "true",
           "sendEmail"            => "true",
           "notifyContact"      => array(
               "customerMobile" => $phone,
               "customerEmail" =>  $email,
               "customerName"  => $name,
           ),

       );

       /*
       * Generate checksum by parameters we have in body
       * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
       */
       $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "&8Y#pxCRy4jUYGbI");

       $paytmParams["head"] = array(
           "tokenType"       => "AES",
           "signature"       => $checksum
       );

       $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

       /* for Staging */
       //$url = "https://securegw-stage.paytm.in/link/create";

       /* for Production */
        $url = "https://securegw.paytm.in/link/create";
       $headers = [
           'Content-Type' => 'application/json',
       ];


       $ch = curl_init($url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
       $response = curl_exec($ch);
       $result = json_decode($response,true);

       $paytmParam = array();

       $paytmParam["body"] = array(
           "mid"                => "pFzAof74619396706958",
           "linkId"             => $result['body']['linkId'],
           "sendSms"            => "true",
           "sendEmail"          => "true",
           "notifyContact"      => array(
               "customerMobile" => $phone,
               "customerEmail" =>  $email,
               "customerName"  => $name,
           ),
       );

       /*
       * Generate checksum by parameters we have in body
       * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
       */
       $checksum = PaytmChecksum::generateSignature(json_encode($paytmParam["body"], JSON_UNESCAPED_SLASHES), "&8Y#pxCRy4jUYGbI");

       $paytmParam["head"] = array(
           "tokenType"        => "AES",
           "signature"        => $checksum
       );

       $post_data = json_encode($paytmParam, JSON_UNESCAPED_SLASHES);

       /* for Staging */
       //$url = "https://securegw-stage.paytm.in/link/resendNotification";

       /* for Production */
        $url = "https://securegw.paytm.in/link/resendNotification";

       $ch = curl_init($url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
       $response = curl_exec($ch);
       print_r($response);
    }
    //Razor Pay
    public function sendPaymentLink(Request $request){

        $string = Str::random(5);
        $pay=$request->advanced_payment*100;
        if($request->guest_type=="existing"){
            $customer=$request->customer;
            $arr=explode("-",$customer);
            $phone=$arr[1];
            $customer=Customer::where('mobile',$phone)->first();
            $name=$customer->name;
            $email=$customer->email;
            $phone=$customer->mobile;
        }else
        {
            $name=$request->name;
            $email=$request->email;
            $phone=$request->phone;
        }

        $response = Http::withBasicAuth('rzp_test_Pv8yT0Oydgloit', 'eHSknSiWzBkJgapN52UrQxZI')
        ->post('https://api.razorpay.com/v1/payment_links',[
            "amount"=>$payable,
            "currency"=>"INR",
            "accept_partial"=>false,
            "first_min_partial_amount"=>$payable,
            "expire_by"=>1691097057,
            "reference_id"=>$string,
            "description"=>"Payment for Room",
            "customer" =>[
                "name"=> $name,
                "contact"=> '+923138905308',
                "email"=> $email
            ],
            "notify"=>[
                "sms"=> true,
                "email"=> true
            ],

        ]);

            return response()->json($payable);
    }
    public function updateReservation(Request $request) {
        
        //return $request;
        # start updating payment history
       
        if($request->input("payment_history_ids") != null){
            foreach($request->input("payment_history_ids") as $key => $id){
                $isPaymentHistory = DB::table("payment_history")->where("id", $id)->count();
                if($isPaymentHistory > 0){
                    DB::table("payment_history")->where("id", $id)->update(["mode" => $request->input("payment_mode")[$key],"payment_date" => $request->input("pdateupdate")[$key]]);
                    // DB::table("payment_history")->where("id", $id)->update(["mode" => $request->input("payment_mode")[$key]]);
                }
            }
        }
        # end updating payment history

        $this->data['data_row']=Reservation::with('orders_items','orders_info')->where('payment_status',0)->where('customer_id','=',$request->customerId)->first();
        $idrs =  $this->data['data_row']->id;
        // $extraDaysAmount = DB::table("payment_history")->where(array("reservations_id" => $idrs, "remark" => 'Extra Stay'))->get();
        // if($extraDaysAmount->count() > 0){
        //     $total_amount = ($this->data['data_row']->total_amount + $extraDaysAmount->first()->payment);
        // }else{
            $total_amount = $request->total_amount;
        // }
       
        
        $arrResIds = explode(",", $request->input("resId"));
        if(count($arrResIds) > 0 && $request->input("room_num") != null){
            for($i=0; $i<count($arrResIds); $i++ ){
                Reservation::whereId($arrResIds[$i])->update(['room_num'=> $request->input("room_num")[$i]]);
            }
        }
          
        # end switching room
       
        
        if($request->cancel_btn == "cancel")
        {
            Reservation::whereId($request->id)->update(['is_deleted'=>1]);
            return redirect()->route('list-reservation');
        }

        $data = $request->all();
        $user_checkout_arr = DB::table('reservations')->where('id',$request->resId)->pluck('created_at_checkin');
        $user_checkout = $user_checkout_arr[0];
         //echo "hello";die;
        $user_checkout_Date = date("H:i:s", strtotime($user_checkout));  
        $new_date = date('Y-m-d', strtotime($user_checkout. ' + '.$request->duration_of_stay.' days'));
        $user_checkout_new_date =  $new_date;
         
        if(isset($data['document_upload'])){
             $id= $data['document_upload_id'];
           $img = $request->file('document_upload');
                    $name = $img->getClientOriginalName();
                    $image = $request->file('document_upload');
                     $fileNamePath ='storage/app/public/files/';
                    
                    
                    
                    
                    
                 
                    $fileNamePath ='storage/app/public/files/'.$name;
                    $img->move('storage/app/public/files/',$fileNamePath);

                    $documentPath = 'public/files/'.$name;

            //   $documentPath = $filename->store('public/files');
               
            Customer::where('id', $id)->update(['document' => $documentPath]);
        }
        if(isset($data['persons_info']['document_upload'])){
             foreach($data['persons_info']['document_upload'] as $key => $value){
              
                 if(!empty($value)){
                    // $id= $data['persons_info']['document_upload'][$key];
                    // $documentPath = $value->store('public/files');
                    
                    
                     $img = $data['persons_info']['document_upload'][$key];
                    $name = $img->getClientOriginalName();
                    $image = $request->file('document_upload');
                    $fileNamePath ='storage/app/public/files/'.$name;
                    $img->move('storage/app/public/files/',$fileNamePath);

                    $documentPath = 'public/files/'.$name;
                    
                    
                    
                    
                    PersonList::where('id', $data['persons_info']['id'][$key])->update(['document' => $documentPath]);
                 }
             }
        }
         
        $reservationData = [];
        $customerData = [];
        $success = config('constants.FLASH_REC_UPDATE_1');
        $error = config('constants.FLASH_REC_UPDATE_0');

        $dateOfBirth = dateConvert($request->age, 'Y-m-d');
        $years = Carbon::parse($dateOfBirth)->age;
        // echo $years;die();
        $custName = $request->name;
        $customerData = [
            "name" => $request->name,
            "Booking_id" => $request->Booking_id,
            "father_name" => $request->father_name,
            "email" => $request->email,
            "mobile" => $request->mobile,
            "address" => $request->address,
            "nationality" => $request->nationality,
            "country" => $request->country,
            "state" => $request->state,
            "city" => $request->city,
            "gender" => $request->gender,
            "age" => $years,
            "dob" => dateConvert($request->age, 'Y-m-d'),
            "password" => Hash::make($request->mobile),
        ];
        // $customerId = Customer::insertGetId($customerData);
        $customerId = Customer::where('id', $request->customerId)->update($customerData);
            
        if($request->Special_Requests !="")
        {
            $Special_Requests = [
                "customer_id" => $request->customerId,
                "name" => $request->Special_Requests
            ];
            $Special_Requests_data = DB::table('special_requests')->insert($Special_Requests);
        }

        if(isset($request->room_num))
        {
            $data = DB::table('reservations')->where('id',$request->resId)->get();
            $booking_changes_total = $data[0]->booking_changes_count +1;

            $booking_change = [
                "booking_changes_count" =>  $booking_changes_total
            ];
            $update_data = DB::table('reservations')->where('id',$request->resId)->update($booking_change);
        }
        
        if($request->room_num)
        {
            $roomnum = join(',',$request->room_num);
        }else
        {
            $roomnum = $request->room_no_switch;
        }
        // dd($request->room_no_switch);
        // dd($roomnum);
       
        $date=$request->check_in_date;
         
        // $checkoutdate=$request->check_out_date;
        $datetime = $date;
        $time = date("H:i:s");
        // $checkoutdatatime = $checkoutdate;
        Carbon::useStrictMode(false);
        // $to_date = Carbon::parse($checkoutdatatime);
        $from_date = Carbon::parse($datetime);
        // $answer_in_days = $to_date->diffInDays($from_date);
        if($request->room_type_id)
        {
            $rm_type_id = $request->room_type_id;
        }
        else{
            $rm_type_id = $request->default_room_type_id;
        }
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
        $checkin_type = $request->checkin_type;
        if(isset($request->persons_info['Reconciliation']))
        {
            $Reconciliation = $request->persons_info['Reconciliation'];
        }
        else
        {

            $Reconciliation = "";
        }
        // return $request->room_qty;
        
        
        $rqty = 1;
        if($checkin_type == 'single')
        {
          
            $reservationData = [
                "customer_id" => $request->customerId,
                "user_checkout" => $user_checkout_new_date,
                "room_qty" => $rqty,
                "guest_type" => $request->guest_type,
                //"check_in" => dateConvert($request->check_in_date, 'Y-m-d H:i'),
                "Reconciliation" => $Reconciliation,
                "room_types" => $request->room_types,
                "ota_booking_date" => $request->ota_booking_date,
                "duration_of_stay" => $request->duration_of_stay,
                // "booking_payment" => $request->booking_payment,
                "ota_discount" => $request->ota_discount,
                "room_type_id" => $rm_type_id,
                "room_num" => $roomnum,
                "LCO" => $request->LCO,
                "LCO_type" => $request->LCO_type,
                "Meals" => $request->Meals,
                "Meals_type" => $request->Meals_type,
                "room_num_switch" => $request->room_no_switch,
                "Booking_Reason" => $request->Booking_Reason,
                "adult" => $request->adult,
                "kids" => $request->kids,
                "infant" => $request->infant,
                "booked_by" => $request->booked_by,
                "idcard_type" => $request->idcard_type,
                "idcard_no" => $request->idcard_no,
                "referred_by" => $request->referred_by,
                "referred_by_name" => $request->referred_by_name,
                "remark_amount" => $request->remark_amount,
                "remark" => $request->remark,
                "meal_plan" => $request->meal_plan,
                "referred_by" => $referred_by,
                "total_amount" => $total_amount,
                "payment_mode"=>$request->payment_mode1,
                "per_room_price" => $request->booking_payment1,
            ];
            
            //return $reservationData;
               
            $res = Reservation::where('id',$request->resId)->update($reservationData);
            
           
            
            $response = Http::withToken('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7ImNsaWVudElkIjoiVjE6OGU1YTNqc3AwaGg3In0sImlhdCI6MTYyNjY3NzI5MCwiZXhwIjoxNjI3MTA5MjkwfQ.g4CzaqrNbJ_eyhY8mxPYtJAoa3yLP_ZB_okrpWBRlZY')
            ->put('https://service-dev.horecafox.com/v1/pms/check-in',[

                "firstame"=> $request->name,
                "mobile"=> $request->mobile,
                "email"=> $request->email,
                "checkOutDateUtc"=> $from_date,
                "noOfGuests"=> 0,
            ]);
             

            if(!empty($data['payment']))
            {
          $payment=array_filter($data['payment']);
          $payment_mode=array_filter($data['mode']);
          $payment_remark=array_filter($data['payment_remark']);
          for($a=0;$a<count($payment);$a++)
          {
             $history['payment']=$payment[$a];
             $history['remark']=$payment_remark[$a];
             $history['mode']=$payment_mode[$a];
             $history['payment_date']=date('Y-m-d');
             $history['reservations_id']=$request->resId;
             DB::table("payment_history")->insert($history); 
          }
            }
     if($request->room_num ==''){
    // print_r($request->room_num[0]);die;
 
     }else{
         $update=DB::table('orders')->where('mobile',$request->mobile)->update(['table_num'=>$request->room_num[0]]);
     }
 
        }
        else if($checkin_type == 'multiple')
        {
            $total_room_id = explode(',',$request->total_room_id);
           
            $count_room_id = count(array_filter($total_room_id));
            
            
            foreach($total_room_id as $rm_id)
            {
                   if($rm_id!='')
                $reservationData = [
                    "customer_id" => $request->customerId,
                    "per_room_price" => $request->booking_payment1,
                    "room_qty" => 1,
                    "user_checkout" => $user_checkout_new_date,
                    "guest_type" => $request->guest_type,
                    "ota_booking_date" => $request->ota_booking_date,
                    //"check_in" => dateConvert($request->check_in_date, 'Y-m-d H:i'),
                    "Reconciliation" => $Reconciliation,
                    "room_types" => $request->room_types,
                    // "user_checkout" => $checkoutdatatime,
                    "duration_of_stay" => $request->duration_of_stay,
                    "Booking_Reason" => $request->Booking_Reason,
                    "room_type_id" => $rm_type_id,
                    
                    "adult" => $request->adult,
                    "kids" => $request->kids,
                    "infant" => $request->infant,
                    "booked_by" => $request->booked_by,
                    "idcard_type" => $request->idcard_type,
                    "idcard_no" => $request->idcard_no,
                    "referred_by" => $request->referred_by,
                    "referred_by_name" => $request->referred_by_name,
                    "remark_amount" => $request->remark_amount,
                    "remark" => $request->remark,
                    "meal_plan" => $request->meal_plan,
                    "referred_by" => $referred_by,
                    "total_amount" => $total_amount,
                    "payment_mode"=>$request->payment_mode1,
                ];
                
                $res = Reservation::where('id',$rm_id)->update($reservationData);
               Reservation::where([['id','=',$rm_id],['room_num','=',$request->room_no_switch]])->update(['room_num'=>$request->room_num[0] ?? $request->room_no_switch]);
                
                 
               
                $response = Http::withToken('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7ImNsaWVudElkIjoiVjE6OGU1YTNqc3AwaGg3In0sImlhdCI6MTYyNjY3NzI5MCwiZXhwIjoxNjI3MTA5MjkwfQ.g4CzaqrNbJ_eyhY8mxPYtJAoa3yLP_ZB_okrpWBRlZY')
                ->put('https://service-dev.horecafox.com/v1/pms/check-in',[

                    "firstame"=> $request->name,
                    "mobile"=> $request->mobile,
                    "email"=> $request->email,
                    "checkOutDateUtc"=> $from_date,
                    "noOfGuests"=> 0,
                ]);
                 
                if(!empty($data['payment'])){
                  $payment=array_filter($data['payment']);
                 
                  $payment_mode=array_filter($data['mode']);
                  $payment_remark=array_filter($data['payment_remark']);
                  for($a=0;$a<count($payment);$a++){
                     $history['payment']=round($payment[$a]/$count_room_id);
                     $history['remark']=$payment_remark[$a];
                     $history['mode']=$payment_mode[$a];
                     $history['payment_date']=date('Y-m-d');
                     $history['reservations_id']=$rm_id;
                     DB::table("payment_history")->insert($history); 
                  }
                }
                
            }
            //return $reservationData;
            //print_r($reservationData);die;
        }

       

            if(isset($request->persons_info['name'])){
                $personsData = [];
                $personReqData = $request->persons_info;
                foreach($personReqData['name'] as $k=>$val){
                    if($val!=''){
                        $id= $personReqData['id'][$k];
                        $personsData[] = [
                            'reservation_id'=>$request->resId,
                            'name'=>$val,
                            'gender'=>$personReqData['gender'][$k],
                            'age'=>$personReqData['age'][$k],
                            'idcard_type'=>$personReqData['idcard_type'][$k],
                            'idcard_no'=>$personReqData['idcard_no'][$k]
                        ];
                        // $personsData = DB::table("person_lists")->where('id',$id)->update($personsData);
                    }
                      
                }
                // if(count($personsData)>0){
                //     PersonList::insert($personsData);
               
                // }
            }
            //send sms
            //  foreach($total_room_id as $rm_id)
            // {
            //       if($rm_id!='')
            //     $reservationData1 = [
            //         // "customer_id" => $request->customerId,
            //         "per_room_price" => $request->booking_payment1,
            //         ];
            // print_r($request->room_num[0]);
            // print_r($request->mobile); die;
           
           
           
             
            
            // }
            
            if(!$request->id && $request->mobile){
                $this->core->sendSms(1,$request->mobile,["name" => $custName]);
            }
            return redirect()->back()->with(['success' => $success]);

        return redirect()->back()->with(['error' => $error]);
    }

   public function updateImgDatabase($id, $field, $fileName){
      return  MediaFile::where('id', $id)->update([$field => $fileName]);
   }

   public function updateImgDatabaseSecound($id, $field, $fileName){
     return  PersonList::where('id', $id)->update([$field => $fileName]);
   }

    public function viewReservation(Request $request) {
     $this->data['data_row']=Reservation::with('orders_items','persons','meal_items')->whereId($request->id)->first();
        if($this->data['data_row']){
              $multi_room_data = Reservation::where('customer_id', $this->data['data_row']->customer_id)->where('unique_id', '=', $this->data['data_row']->unique_id)->get();
              
            if(count($multi_room_data) > 1)
            {
                $this->data["customer_room_data"] = $multi_room_data;
            }
            else{
                   $this->data["customer_room_data"] = "empty";
            }
            
            // $extraDaysAmount = DB::table("payment_history")->where(array("reservations_id" => $this->data['data_row']->id, "remark" => 'Extra Stay'));
            // if($extraDaysAmount->count() > 0){
            //     $this->data['totalamountwithextrastay'] = $extraDaysAmount->first()->payment;
            // }
        }
       
     
       $this->data['payment_history']=DB::table('payment_history')
       ->join('reservations','reservations.id','=','payment_history.reservations_id')
       ->select('payment_history.*')
       ->where('reservations.unique_id',$this->data['data_row']->unique_id)
       ->get();
       
        
       $this->data['payment_mode']=PaymentMode::where('id',$this->data['data_row']->payment_mode)->get();
      
        return view('backend/rooms/room_reservation_view',$this->data);
    }
    // 12-08-2022
    public function updateviewReservation(Request $request) {
        // return $request;
        $id = $request->id;
        $customerdata = [
            "name"=> $request->name,
            "mobile" => $request->mobile,
            "email" => $request->email
        ];
        $cus_id = Reservation::where('id',$id)->get('customer_id');
        $custid = $cus_id[0]->customer_id;
        $res = Customer::where('id',$custid)->update($customerdata);
        
        $reservationData = [
            "company_gst_num"=>$request->company_gst_num,
            "gst_company" => $request->gst_company,
            "gst_address" => $request->gst_address
        ];
                
        $res = Reservation::where('id',$id)->update($reservationData);
        return redirect()->route('view-reservation',['id' => $id]);
        // return view('backend/rooms/room_reservation_view',$this->data);
    }
    // 12-08-2022 end
    
    public function checkOut(Request $request) {
        
        date_default_timezone_set('Asia/Kolkata');

        $this->data['data_row']=Reservation::with('orders_items','orders_info')
        ->whereUniqueId($request->id)->where('payment_status',0)->first();
       
        if($this->data['data_row']){
            $multi_room_data = Reservation::where('payment_status',0)->where('customer_id', $this->data['data_row']->customer_id)->where('unique_id', '=', $request->id)->get();
            $this->data['count'] = DB::table('reservations')->where('unique_id', $request->id)->count();
            $this->data['payment_mode_list']=PaymentMode::select('id', 'payment_mode')->whereStatus(1)->orderBy('id','ASC')->pluck('payment_mode', 'id');
            //   return count($multi_room_data);
            if(count($multi_room_data) > 1)
            {
               $this->data["customer_room_data"] = $multi_room_data;
            }
            else{
                $this->data["customer_room_data"] = "empty";
            }
            $this->data['availedservices'] = DB::table('availedservices')->where('Status',1)->get();
            
            $extraDaysAmount = DB::table("payment_history")->where(array("reservations_id" => $this->data['data_row']->id, "remark" => 'Extra Stay'));
            if($extraDaysAmount->count() > 0){
               // $this->data['totalamountwithextrastay'] = $extraDaysAmount->first()->payment;
            }
            //echo $this->data['totalamountwithextrastay'];die;
            
            $this->data['payment_history']=DB::table('payment_history')
            ->join('reservations','reservations.id','=','payment_history.reservations_id')
            ->select('payment_history.*')
            ->where('reservations.unique_id',$this->data['data_row']->unique_id)
            ->where('payment_history.remark','!=','Advance')
            ->get();
           
            $this->data['payment_mode']=PaymentMode::where('id',$this->data['data_row']->payment_mode)->get();
            //return $this->data['payment_mode'];
            //return  $this->data["customer_room_data"];
            return view('backend/rooms/check_out',$this->data);
        } else {
            return redirect()->route('list-reservation')->with(['error' => config('constants.FLASH_NOT_ALLOW_URL')]);
        }


    }
    // protected function  invoiceEmail($type,$id) {
    //     $this->data['type'] = $type;
    //     $this->data['data_row']=Reservation::with('orders_items','orders_info')->whereId($id)->first();
    //      return view('backend/rooms/invoice',$this->data);
    //      dd("kfk");
    // }
    public function saveCheckOutData(Request $request) {
        
// return $request;
        
        
        
        
        date_default_timezone_set('Asia/Kolkata');
        $settings = getSettings();
        
         $amount=$request->amount['total_room_amount'];
         if(($amount>=0) && ($amount<=999))
         {
             $gst=$settings['gst_0'];
              $cst=$settings['cgst_0'];
         }
         else if(($amount>=1000) && ($amount<=2499))
         {
              $gst=$settings['gst'];
              $cst=$settings['cgst'];
         }
           else if(($amount>=2500) && ($amount<=7499))
         {
             $gst=$settings['gst_1'];
              $cst=$settings['cgst_1'];
         }
         else if($amount > 7499)
         {
            $gst=$settings['gst_2'];
            $cst=$settings['cgst_2'];
         }
         if(count(explode(',',$request->row_id)) > 1)
         {
            $totalRoom = count(explode(',',$request->row_id));
         }
         else
         {
            $totalRoom = 1;
         }
        
        
        $reservationData = [];
        $orderInfo = [];
        $amountArr =  $request->amount;
        $amountArr['room_amount_discount'] = $request->discount_amount;
        $reservationData = [
            "per_room_price" => $amountArr['per_room_price'],
            "check_out" => dateConvert($request->check_out_date, 'Y-m-d H:i'),
            "created_at_checkout" => date('Y-m-d H:i:s'),
            "amount_json" => json_encode($amountArr),
            "Average_duration" => $request->Average_duration,
            "Guest_feedback" => $request->Guest_feedback,
            "Hotel_rate" => $request->Hotel_rate,
            "Booking_Device" => $request->Booking_Device,
            "idcard_type" => $request->idcard_type,
            "discount" => $request->discount_amount,
            "idcard_no" => $request->idcard_no,
            'gst_perc'=>$gst,
            'cgst_perc'=>$cst,
            "payment_status" => 1,
            "gst_company"=> $request->gst_company ?? '',
            "gst_address"=>$request->gst_address ?? '',
            "company_gst_num"=>$request->company_gst_num,
            "checkout_payment_mode"=>$request->payment_mode,
            "checkout_payment" => $request->amount_payable/$totalRoom,
            "Availed_Services_Details" => $request->Availed_Services_Details,
            "Employee_Check_out_name" => Auth::user()->id
        ];
        $mobile = '';
        $name = '';
        $ckeckout_ok = 0; 
      // To check all documents uploaded or not
        if(isset($request->persons_info['name'])){
            $personReqData = $request->persons_info;
            $personsData = [];
            foreach($personReqData['name'] as $k=>$val)
            {
                // if (empty($personReqData['document_upload'][$k]) )
                // {
                //     return redirect()->back()->with(['error' => 'All Documents not uploaded']);
                // }
                // else{
                    $ckeckout_ok = 1;
              //  }
            }

        }
        else{
            $ckeckout_ok = 1;
        }
        
        if($ckeckout_ok == 1)
        {
            if($request->id>0){
                $resData = Reservation::whereId($request->id)->first();
                 
                if($resData){
                    if($resData->customer){
                        $mobile = $resData->customer->mobile;
                        $name = $resData->customer->name;
                    }
                    if($resData->invoice_num==null && $request->invoice_applicable==1){
                        
                       if(!empty(getInvoiceNumber($request->id)))
                        {
                        $reservationData['invoice_num'] = getInvoiceNumber($request->id);
                        $orderInfo['invoice_num'] = getNextInvoiceNo('orders');
                        }else
                        {
                        $reservationData['invoice_num'] = getNextInvoiceNo();
                        $orderInfo['invoice_num'] = getNextInvoiceNo('orders');
                        }
                        
                    }
                }
            }
             
            if($request->hasFile('id_image')){
                if(count($request->media_ids)>0){
                    $row_data= MediaFile::whereIn($request->media_ids)->get();
                    foreach ($row_data as $key => $value) {
                        unlinkImg($value->file,'uploads/id_cards/');
                    }
                }
                $idImages = [];
                foreach($request->id_image as $img){
                    $filename=$this->core->fileUpload($img,'uploads/id_cards');
                    $idImages[] = ['tbl_id'=>$request->id, 'file'=>$filename];
                }
                if(count($idImages)>0){
                    MediaFile::insert($idImages);
                }
            }
             
            if(count(explode(',',$request->row_id)) == 1)
            {
               if(isset($request->listed_rooms))
               {
                    for($i=0; $i < count($request->listed_rooms); $i++)
                    {
                         if($request->listed_rooms[$i] != "")
                         {
                            
                            $res = Reservation::updateOrCreate(['id'=>$request->listed_rooms[$i]],$reservationData);
                         }
                       
                    }
               }
               else
               {
                    if($request->row_id != "")
                     {
                        
                        $res = Reservation::updateOrCreate(['id'=>$request->row_id],$reservationData);
                     }
               }

            }
            else if(count(explode(',',$request->row_id)) > 1){
                
                // echo "<pre>";
                // print_r($request->listed_rooms);
                // return ;
                
               // $rowCount = count(explode(',',$request->row_id));
               
                $rowData = explode(',',$request->row_id);
                
             //  echo count($request->listed_rooms);
                
               // echo $request->listed_rooms[0];
                
                // $room_Count = count(explode(',',$request->listed_rooms));
                
                for($i=0; $i < count($request->listed_rooms); $i++)
                {
                     if($rowData[$i] != "")
                     {
                        
                        $res = Reservation::updateOrCreate(['id'=>$request->listed_rooms[$i]],$reservationData);
                     }
                   
                }
                
                
            }
            
 
            if($res){
                $gstApply = $gstPerc = $gstAmount = $cgstPerc = $cgstAmount = 0;
                if($request->food_gst_apply==1){
                    $gstApply = 1;
                    $gstPerc = $settings['food_gst'];
                    $gstAmount = $request->amount['order_amount_gst'];

                    $cgstPerc = $settings['food_cgst'];
                    $cgstAmount = $request->amount['order_amount_cgst'];
                }

                $orderInfo['reservation_id'] = $request->id;
                $orderInfo['invoice_date'] = dateConvert($request->check_out_date, 'Y-m-d H:i');
                $orderInfo['gst_apply'] = $gstApply;
                $orderInfo['gst_perc'] = $gstPerc;
                $orderInfo['cgst_perc'] = $cgstPerc;
                $orderInfo['gst_amount'] = $gstAmount;
                $orderInfo['cgst_amount'] = $cgstAmount;
                $orderInfo['discount'] = $request->discount_order_amount;

                $orderData = Order::where('reservation_id',$request->id)->first();
                if(Order::where('reservation_id',$request->id)->first()){
                    $orderInfo["original_date"] = date('Y-m-d H:i:s');
                Order::where('reservation_id',$request->id)->update($orderInfo);
                }

                //send sms
                if($mobile!=''){
                    $this->core->sendSms(2,$mobile,['name'=>$name]);
                }
                $this->data['type'] = 1;
                $this->data['data_row']=Reservation::with('orders_items','orders_info')->whereId($request->id)->first();

                //   Mail::to($request->email)->send(new invoiceEmail($this->data));

                $this->data['type'] = 2;
                $this->data['data_row']=Reservation::with('orders_items','orders_info')->whereId($request->id)->first();

                    //   Mail::to($request->email)->send(new invoiceEmail($this->data));
                    
                //$now = date('Y-m-d');
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
                
                $detail2=  DB::table('reservations')->select('room_num')->where('id',$request->row_id)->first();
                
// print_r($detail2->room_num);die;
 //new code
      $detail=  DB::table('hotels_room_light')->select('light_off')->where('room_no',$detail2->room_num)->first();
    //   print_r($detail->light_off);die;
  $curl = curl_init();

curl_setopt_array($curl, array(
     CURLOPT_URL => 'https://maker.ifttt.com/trigger/{{$detail->light_off}}/with/key/djA7Jb9Ro-feDYX8rC7esx',
//   CURLOPT_URL => 'https://maker.ifttt.com/trigger/NG121_608_MS_OFF/with/key/cCCBs5uLNQJDGkDH-65yXr',
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
        


                return redirect()->route('multi-list-reservation')->with(['success' => config('constants.FLASH_CHECKOUT_1')]);
            }
            return redirect()->back()->with(['error' => config('constants.FLASH_CHECKOUT_0')]);
        }
    }

    public function invoice(Request $request) {
        $this->data['type'] = $request->type;
        $this->data['data_row']=Reservation::with('orders_items','orders_info')->whereId($request->id)->first();
        dd($this->data['data_row']->customer->name);
        $this->data['room_numbers']=DB::table('reservations')
        ->where('reservations.unique_id',$this->data['data_row']->unique_id)
        ->get();
       
        $extraDaysAmount = DB::table("payment_history")->where(array("reservations_id" => $this->data['data_row']->id, "remark" => 'Extra Stay'));
        //echo $extraDaysAmount->first()->payment;die;
        if($extraDaysAmount->count() > 0){
            $this->data['totalamountwithextrastay'] = $extraDaysAmount->first()->payment;
        }else{
            $this->data['totalamountwithextrastay'] = 0;
        }
       
        $this->data['payment']=$this->data['payment_history']=DB::table('payment_history')
        ->join('reservations','reservations.id','=','payment_history.reservations_id')
        ->select('payment_history.*')
        ->where('reservations.unique_id',$this->data['data_row']->unique_id)
        ->get();
        // dd($this->data['payment']);
        return view('backend/rooms/invoice',$this->data);
    }
    public function listReservationtoday() {
        $this->data['list'] = 'check_ins';
         $this->data['datalist'] = Reservation::whereStatus(1)->wherePaymentStatus(0)->whereIsDeleted(0)->whereNull('check_out')->whereDate('check_in','=',date('Y-m-d'))->orderBy('created_at','DESC')->distinct('room_num')->get();
        //  print_r($this->data['datalist']);
         return view('backend/rooms/room_reservation_list_today',$this->data);
    }
    public function singleListReservation() {
          $this->data['list'] = 'check_ins';
          $this->data['datalist']=Reservation::whereStatus(1)->wherePaymentStatus(0)->whereIsDeleted(0)->whereNull('check_out')->orderBy('created_at','DESC')->distinct('room_num')->where('checkin_type', 'single')->get();
        
          return view('backend/rooms/room_reservation_list',$this->data);
    }
    public function multiListReservation() {
        $this->data['list'] = 'check_ins';
       $this->data['datalist']=Reservation::whereStatus(1)->wherePaymentStatus(0)->whereIsDeleted(0)->whereNull('check_out')->orderBy('created_at','DESC')->select(DB::raw("id,customer_id,room_type_id,SUM(booking_payment) as booking_payment1,GROUP_CONCAT(room_num) as room_num, duration_of_stay,check_in,check_out,created_at_checkin,unique_id, booking_payment, per_room_price"))->where('checkin_type', 'multiple')->groupBy('customer_id','unique_id')->get();
    //   echo "<pre>";
    //   print_r($this->data['datalist']);
    //   return ; 
     $this->data['count_room']=Reservation::whereNull('check_out')->where('checkin_type','multiple')->orderBy('created_at','DESC')->count("customer_id");
        return view('backend/rooms/room_reservation_list',$this->data);
    }
    public function housekeeping() {
        $this->data['list'] = 'check_ins';
         $this->data['datalist']=Reservation::whereStatus(1)->whereIsDeleted(0)->orderBy('check_out','DESC')->whereDate('user_checkout','>=',date('Y-m-d'))
         ->select('room_num','status','user_checkout','check_out')->get();
         return view('backend/rooms/housekeeping',$this->data);
    }
    
    public function outlet()
    {
        $data=DB::table('outlet')->get();
        $remark=DB::table('payment_remark')->get();
        return view('backend.outlet',compact('data','remark'));
    }
    
    public function outlet_action(Request $request)
    {
    $insert['name']=ucfirst($request->outlet);
    $insert['status']=1;
    if(DB::table('outlet')->insert($insert))
    {
        return redirect('admin/outlet');    
    }else
    {
        return redirect('admin/outlet');
    }
    }
    
    public function remark_action(Request $request)
    {
    $insert['title']=ucfirst($request->title);
    if(DB::table('payment_remark')->insert($insert))
    {
        return redirect('admin/outlet');    
    }else
    {
        return redirect('admin/outlet');
    }
    }
    
    public function listArrivalReservation(Request $request) {
        
        $get_data = Http::get('https://www.eglobe-solutions.com/webapichannelmanager/bookings/nJoLe2SYjL1ObN9pXcVO/fetch?bookingStatus=0');
        //$get_data->failed(); //demo key - nJoLe2SYjL1ObN9pXcVO
        $response = json_decode($get_data, true);
        $elementCount  = count($response);
            
    // if($elementCount > 0){
            foreach($response as $hello){
                $test = $hello['BookingId'];
                $getanydata = Customer::where('Booking_id','=',$test)->first();
                //print_r($getanydata);
                $totalbookid = $getanydata['Booking_id']?? "";
                if($totalbookid == null){
                    $Booking_id = $hello['BookingId'];
                    $name = $hello['CustomerName'];
                    $email = $hello['CustomerEmail'];
                    $mobile = $hello['CustomerMobile'];
                    
                    $customerData = [
                        "Booking_id" => $Booking_id,
                        "name" => $name,
                        "email" => $email,
                        "mobile" => $mobile
                    ];
                    $customerId = Customer::insertGetId($customerData);
                    
                    date_default_timezone_set("Asia/Kolkata");
                    $check_in_d = $hello['CheckIn'];
                    $check_in_date = date("Y-m-d", strtotime($check_in_d));
                    $check_out_d = $hello['CheckOut'];
                    $check_out_date = date("Y-m-d", strtotime($check_out_d));
                    
                    $date = $check_in_date;
                    $checkoutdate = $check_out_date;
                    $time = date("H:i:s");
                    $datetime = $date ." ". $time;
                    $checkoutdatatime = $checkoutdate;
                    Carbon::useStrictMode(false);
                    $to_date = Carbon::parse($checkoutdatatime);
                    $from_date = Carbon::parse($datetime);
                    $answer_in_days = $to_date->diffInDays($from_date);
                    $check_in_day = date('l', strtotime($date));
                    if($check_in_day == 'Saturday' &&  $check_in_day == 'Sunday')
                    {
                        $is_weekend = '1';
                    }
                    else
                    {
                        $is_weekend = '0';
                    }
                    
                    $payment = $hello['BilledAmount'];
                    $adult = $hello['TotalAdults'];
                    $kids = $hello['TotalChildren'];
                    $refbyname = $hello['ChannelName'];
                    $roomqty = $hello['NumRooms'];
                    $PaymentType = $hello['PaymentType'];
                    $BookingDetailUrl = $hello['BookingDetailUrl'];
                    $BookingStatus = $hello['BookingStatus'];
                    
                    if($answer_in_days == 0){
                        $answer_in_days = $hello['NumNights'];
                    }else{
                        $answer_in_days = $answer_in_days;
                    }
                    
                    
                    $res=DB::table('arrivals')->insert([
                        "customer_id" => $customerId,
                        "check_in" => $datetime,
                        "check_out" => $checkoutdatatime,
                        "duration_of_stay" => $answer_in_days,
                        "adult" => $adult,
                        "kids" => $kids,
                        "referred_by_name" => $refbyname,
                        "room_type_id" => '1',
                        "room_qty" => $roomqty,
                        "check_in_day" => $check_in_day,
                        "is_weekend" => $is_weekend,
                        "payment" => $payment,
                        "paymenttype" => $PaymentType,
                        "bookingdetailurl" => $BookingDetailUrl,
                        "bookingstatus" => $BookingStatus,
                        // "payment_mode"=> $request->payment_mode
                    ]);
        
                    $success = config('constants.FLASH_REC_ADD_1');
                    $error = config('constants.FLASH_REC_ADD_0');
                }
            }
    // }
            
        date_default_timezone_set("Asia/Kolkata");    
        $this->data['list'] = 'check_ins';

        $checkeout=DB::table('arrivals')->join('reservations','reservations.customer_id','=','arrivals.customer_id')
        ->select('arrivals.id')->get()->map(function($data){
        return $arrival=DB::table('arrivals')->where('id',$data->id)->delete();
        });

        $this->data['datalist']=array('');
        $query1=DB::table('arrivals')->join('customers','customers.id','=','arrivals.customer_id')
        ->select('arrivals.check_in as check_in','arrivals.check_out as check_out','arrivals.id as id','arrivals.is_deleted as deleted','arrivals.referred_by_name as source','arrivals.paymenttype as paymenttype','arrivals.bookingdetailurl as bookingdetailurl','arrivals.bookingstatus as bookingstatus','arrivals.duration_of_stay as duration',
        'customers.name as name','customers.email as email','customers.Booking_id as Booking_id','customers.mobile as mobile');
        $this->data['datalist']=$query1->whereDate('check_in','>=',date('Y-m-d'))->where('arrivals.is_deleted',0)->orderBy('id', 'desc')->get();
        // return $this->data['datalist'];
        //   if(date('H:i') > '09:00')
        //                 {
        //                   $this->data['datalist3']= $this->data['common'];
        //                  }
        //                 else
        //                 {
        //                          array_push($this->data['datalist'],$this->data['common']);
        //                 }
            $starttime=date('Y-m-d H:i:s',strtotime("12:00:00"));
            $starttime=date('H:i:s',strtotime($starttime));
            $endtime=date('Y-m-d H:i:s',strtotime("06:00:00"));
            $endtime=date('H:i:s',strtotime($endtime));
            $time = date("H:i:s");
            
            if($starttime > $time && $endtime > $time)
            {
                $todayDate = date('Y-m-d');
                $date = date('Y-m-d',strtotime($todayDate.'-1 days'));
                // $datetime = $date ." ". $time;
                $datenew = $date;
            }else
            {
                $datenew = date('Y-m-d');
            }
        // $datenew = date("Y-m-d H:i:s", strtotime('+6 hours'));
        // print_r($datenew);
        
        // $query=DB::table('arrivals')->join('customers','customers.id','=','arrivals.customer_id')
        // ->select('arrivals.check_in as check_in','arrivals.check_out as check_out','arrivals.id as id','arrivals.referred_by_name as source','arrivals.duration_of_stay as duration','arrivals.reason as reason','arrivals.bookingstatus as bookingstatus','customers.name as name',
        // 'customers.email as email','customers.mobile as mobile','arrivals.is_deleted','arrivals.check_out as checkout')->where('arrivals.is_checked_in',0)->where('arrivals.is_deleted', '!=', 0)->orwhereDate('check_in','<',$datenew)->orderBy('id', 'desc')->get();
    
        // $this->data['datalist3']=$query;
        
        if(request()->ajax())
        {
            $datalist3=DB::table('arrivals')->join('customers','customers.id','=','arrivals.customer_id')
            ->select('arrivals.check_in as check_in','arrivals.check_out as check_out','arrivals.id as id','arrivals.referred_by_name as source','arrivals.duration_of_stay as duration','arrivals.reason as reason','arrivals.bookingstatus as bookingstatus','customers.name as name',
            'customers.email as email','customers.mobile as mobile','arrivals.is_deleted as is_deleted')->where('arrivals.is_checked_in',0)->where('arrivals.is_deleted', '!=', 0)->orwhereDate('check_in','<',$datenew)->orderBy('id', 'desc')->get();

            return Datatables::of($datalist3) 
            ->editColumn('check_in', function ($request1) {
                return dateConvert($request1->check_in,'d-m-Y H:i'); // human readable format
            })
            ->editColumn('check_out', function ($request1) {
                return dateConvert($request1->check_out,'d-m-Y H:i'); // human readable format
            })
            ->addIndexColumn()
            ->addColumn('action', function($request) {
                if($request->is_deleted == '1'){
                  return $btn = '<a class="btn btn-danger">void</a>';
                }else if(dateConvert($request->check_in,'d-m-Y') < date('d-m-Y')){
                  return $btn = '<a class="btn btn-danger">No Show</a>';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('backend/rooms/room_arrival_reservation_list',$this->data);
    }
    
    public function foodorderlistnew() {
        $datalist4 = Customerfoodorder::where('payment_done',1)->where('closeorder',0)->get();
        return response()->json([
            'studata'=>$datalist4,
        ]);
        // if(request()->ajax())
        // {
        //     $datalist4 = Customerfoodorder::where('order_date',date('Y-m-d'))->where('payment_done',1)->get();
            
        //     return Datatables::of($datalist4)
        //     ->editColumn('name', function ($request1) {
        //         $first = $request1->name;
        //         $love = explode(', ', $first);
                
        //         $second = $request1->quantity;
        //         $love2 = explode(', ', $second);
                
        //         $third = $request1->unitprice;
        //         $love3 = explode(', ', $third);
                
        //         $combined = [];
        //         foreach ($love as $key => $val) {
        //             $combined[] = [$val, '(',$love2[$key],'Quantity * ', $love3[$key],'Price) =  ', $love2[$key]*$love3[$key]];
                    
        //         }
            
        //         foreach ($combined as $key => $val) {
                    
        //             $new[] = implode(" ",$val);
                    
        //         }
        //         return $new;
                
        //     })
        //     ->editColumn('updated_at', function ($request1) {
        //         return dateConvert($request1->updated_at,'d-m-Y H:i'); // human readable format
        //     })
           
        //     ->addIndexColumn()
            
        //     ->make(true);
        // }
        // return view('backend/new_dashboard',$datalist4);
    }
    
    public function markpreparing(Request $request){
        $markp['markpreparing'] = $request->type;
        $id = $request->orderid;
        $updatemark = Customerfoodorder::where('order_id',$id)->update($markp);
        return response()->json([
            'updatemark'=>$updatemark,
        ]);
    }
    
    public function markpreparinglocal(Request $request){
        $markp['markpreparing'] = $request->type;
        $id = $request->orderid;
        $updatemark = Order::where('id',$id)->update($markp);
        return response()->json([
            'updatemark'=>$updatemark,
        ]);
    }
    
    
    
    public function closeroomorder(Request $request){
        // return $request->orderid;
        $markp['closeorder'] = 1;
        $id = $request->orderid;
        $close = Customerfoodorder::where('order_id',$id)->update($markp);
        return response()->json([
            'closeord'=>$close,
        ]);
    }
    
    public function closeroomorderlocal(Request $request){
        // return $request->orderid;
        $markp['closeorder'] = 1;
        $id = $request->orderid;
        $close = Order::where('id',$id)->update($markp);
        return response()->json([
            'closeord'=>$close,
        ]);
    }
    
    public function printbill(Request $request){
        // return $request->billid;
        $getiddetails = Customerfoodorder::where('order_id',$request->billid)->first();
        return response()->json([
            'detailsiddata'=>$getiddetails,
        ]);
    }
    
    public function ordercount(){
        $datalist4 = Customerfoodorder::where('order_date',date('Y-m-d'))->where('payment_done',1)->count();
        return $datalist4;
    }
    
    public function latestOrders(){
        //$orderIds = OrderHistory::where('is_book',1)->orderBy('id','DESC')->pluck('order_id');
        $this->data['orders']=Order::where('closeorder',0)->orderBy('created_at','DESC')->get();
        $this->data['datalist4'] = Customerfoodorder::where('payment_done',1)->where('closeorder',0)->get();
        return view('backend/latestorders',$this->data);
    }
    
    // Today's Upcoming Arrivals
    public function todaysupcoming() {
        
        $this->data['list'] = 'check_ins';

        $checkeout=DB::table('arrivals')->join('reservations','reservations.customer_id','=','arrivals.customer_id')
        ->select('arrivals.id')->get()->map(function($data){
        return $arrival=DB::table('arrivals')->where('id',$data->id)->delete();
        });

        $this->data['datalist']=array('');
        $query1=DB::table('arrivals')->join('customers','customers.id','=','arrivals.customer_id')
        ->select('arrivals.check_in as check_in','arrivals.check_out as check_out','arrivals.id as id','arrivals.is_deleted as deleted','arrivals.referred_by_name as source','arrivals.paymenttype as paymenttype','arrivals.bookingdetailurl as bookingdetailurl','arrivals.bookingstatus as bookingstatus','arrivals.duration_of_stay as duration',
        'customers.name as name','customers.email as email','customers.Booking_id as Booking_id','customers.mobile as mobile');
        $this->data['datalist']=$query1->whereDate('check_in','=',date('Y-m-d'))->where('arrivals.is_deleted',0)->orderBy('id', 'desc')->get();
        
        $query=DB::table('arrivals')->join('customers','customers.id','=','arrivals.customer_id')
        ->select('arrivals.check_in as check_in','arrivals.check_out as check_out','arrivals.id as id','arrivals.referred_by_name as source','arrivals.duration_of_stay as duration','arrivals.reason as reason','customers.name as name',
        'customers.email as email','customers.mobile as mobile','arrivals.is_deleted','arrivals.check_out as checkout')->where('arrivals.is_deleted', '!=', 0)->whereDate('check_in','=',date('Y-m-d'))->orderBy('id', 'desc')->get();
    
        $this->data['datalist3']=$query;
        return view('backend/rooms/room_arrival_reservation_list_today',$this->data);
    }
    // Today's Upcoming Arrivals End code
    
    public function listCheckOuts(Request $request) {
        $startDate = getNextPrevDate('prev');
        $this->data['list'] = 'check_outs';
        $this->data['roomtypes_list']=getRoomTypesList();
        $this->data['customer_list']=getCustomerList();
        $this->data['search_data'] = ['customer_id'=>'','room_type_id'=>'','date_from'=>'', 'date_to'=>''];
        
        if(request()->ajax())
        {
            if(!empty($request->from_date))
            {
                $from = date('Y-m-d', strtotime($request->from_date));
                $to = date('Y-m-d', strtotime($request->to_date));
                $datalist = DB::table('reservations')->join('customers','customers.id','=','reservations.customer_id')
                ->select('reservations.id as id','reservations.room_type_id as room_type_id','reservations.room_num as room_num','reservations.check_in as check_in','reservations.check_out as check_out','reservations.referred_by_name as source','reservations.referred_by as refby','reservations.booking_payment as booking_payment','reservations.duration_of_stay as duration','reservations.created_at_checkout as created_at_checkout','customers.and_number as and_number','customers.name as name',
                'customers.email as email','customers.mobile as mobile')->whereStatus(1)->whereNotNull('check_out')->whereBetween('check_in', array($from, $to))->get();
            }
            else
            {
                $datalist = DB::table('reservations')->join('customers','customers.id','=','reservations.customer_id')
                ->select('reservations.id as id','reservations.room_type_id as room_type_id','reservations.room_num as room_num','reservations.check_in as check_in','reservations.check_out as check_out','reservations.referred_by_name as source','reservations.referred_by as refby','reservations.booking_payment as booking_payment','reservations.duration_of_stay as duration','reservations.created_at_checkout as created_at_checkout','customers.and_number as and_number','customers.name as name',
                'customers.email as email','customers.mobile as mobile')->whereStatus(1)->whereNotNull('check_out')->orderBy('id', 'DESC')->get();
            }
            return Datatables::of($datalist) 
            ->editColumn('check_in', function ($request) {
                return dateConvert($request->check_in,'d-m-Y H:i'); // human readable format
            })
            ->editColumn('check_out', function ($request) {
                return dateConvert($request->created_at_checkout,'d-m-Y H:i'); // human readable format
            })
            ->addIndexColumn()
            ->addColumn('action', function($request) {
                   $btn = '<a class="btn btn-sm btn-success" href="' . route('view-reservation', [$request->id]) .'">View</i></a> 
                   <a class="btn btn-sm btn-danger" href="' . route('invoice',[$request->id,1]) .'" target="_blank">Invoice Room</i></a>
                   <a class="btn btn-sm btn-warning" href="' . route('invoice',[$request->id,2]) .'" target="_blank">Invoice Food</i></a>';
                   return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
            return view('backend/rooms/room_reservation_list',$this->data);
        
    }
    public function cancelArrival(Request $request)
    {
        $reason = DB::table('arrivals')->whereId($request->id)->update(['reason'=>$request->bcreason]);
        $arrival=DB::table('arrivals')->whereId($request->id)->update(['is_deleted'=>1]);
        if($arrival){
            return redirect()->back()->with(['success' => 'Arrival Cancelled Successfully']);
        }
        return redirect()->back()->with(['error' => 'Error in Cancelling Arrival']);

    }
    public function deleteReservation(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        // ->with(['success' => config('constants.FLASH_REC_DELETE_1')])
        if(Reservation::whereId($request->id)->update(['is_deleted'=>1])){
            return redirect()->back()->with(['success' => 'Status Changed Successfully']);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
/* ***** End RoomReservation Functions ***** */

/* ***** Start FoodCategory Functions ***** */
    public function addFoodCategory() {
        return view('backend/food_category_add_edit',$this->data);
    }
    public function editFoodCategory(Request $request){
        $this->data['data_row']=FoodCategory::whereId($request->id)->first();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('backend/food_category_add_edit',$this->data);
    }
    public function saveFoodCategory(Request $request) {
        if($request->id>0){
            if($this->core->checkWebPortal()==0){
                return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
            }
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        $res = FoodCategory::updateOrCreate(['id'=>$request->id],$request->except(['_token']));

        if($res){
            return redirect()->back()->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    public function listFoodCategory() {
         $this->data['datalist']=FoodCategory::whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
        return view('backend/food_category_list',$this->data);
    }
    public function deleteFoodCategory(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        if(FoodCategory::whereId($request->id)->update(['is_deleted'=>1])){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
/* ***** End FoodCategory Functions ***** */

/* ***** Start FoodItems Functions ***** */
    public function addFoodItem() {
        $this->data['category_list']=$this->getFoodCategoryList();
        return view('backend/food_item_add_edit',$this->data);
    }
    public function editFoodItem(Request $request){
        $this->data['category_list']=$this->getFoodCategoryList();
        $this->data['data_row']=FoodItem::whereId($request->id)->first();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('backend/food_item_add_edit',$this->data);
    }
    public function saveFoodItem(Request $request) {
        
        if($request->id>0){
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        
        if ($request->hasFile('food_image')) {
            $request->validate([
                'image' => 'mimes:jpeg,png'
            ]);
            $request->file('food_image')->store('productjack', 'public');
            $imagename = $request->file('food_image')->hashName();
            // return $product;
            $product = [
                "category_id" => $request->category_id,
                "name" => $request->name,
                "price" => $request->price,
                "description" => $request->description,
                
                "itemcode" => $request->itemcode,
                "category" => $request->category,
                "strikethrough" => $request->strikethrough,
                "units" => $request->units,
                "costunits" => $request->costunits,
                "sku" => $request->sku,
                "preptime" => $request->preptime,
                "bestfor" => $request->bestfor,
                "energy" => $request->energy,
                "protein" => $request->protein,
                "fat" => $request->fat,
                "carb" => $request->carb,
                
                "status" => $request->status,
                "food_image" => $imagename
            ];
        }else{
            $product = [
                "category_id" => $request->category_id,
                "name" => $request->name,
                "price" => $request->price,
                "description" => $request->description,
                
                "itemcode" => $request->itemcode,
                "category" => $request->category,
                "strikethrough" => $request->strikethrough,
                "units" => $request->units,
                "costunits" => $request->costunits,
                "sku" => $request->sku,
                "preptime" => $request->preptime,
                "bestfor" => $request->bestfor,
                "energy" => $request->energy,
                "protein" => $request->protein,
                "fat" => $request->fat,
                "carb" => $request->carb,
                
                "status" => $request->status,
                "food_image" => $request->oldimage
            ];
        }
        
        
        // die;
        $res = FoodItem::updateOrCreate(['id'=>$request->id],$product);

        if($res){
            return redirect()->back()->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    public function listFoodItem() {
         $this->data['datalist']=FoodItem::whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
        //  return $this->data['datalist'];
        return view('backend/food_item_list',$this->data);
    }
    public function deleteFoodItem(Request $request) {
        if(FoodItem::whereId($request->id)->update(['is_deleted'=>1])){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
    
    public function foodsalesreport(){
        //$orderIds = OrderHistory::where('is_book',1)->orderBy('id','DESC')->pluck('order_id');
        // $this->data['orders']=Order::where('closeorder',0)->orderBy('created_at','DESC')->get();
        // $this->data['datalist4'] = Customerfoodorder::where('payment_done',1)->where('closeorder',0)->get();
        // return view('backend/foodsalesreport',$this->data);
        
        $startDate = getNextPrevDate('prev');
        // $this->data['category_list']=$this->getExpenseCategoryList();
            $cat = array(
                'ActiveOrders' => 'ActiveOrders',
                'ClosedOrders' => 'ClosedOrders'
            );
        $this->data['category_list'] = $cat;
        //  $this->data['datalist']=Customerfoodorder::whereDate('order_date', '>=', $startDate." 00:00:00")->whereDate('order_date', '<=', DB::raw('CURDATE()'))->orderBy('order_date','DESC')->get();
        //$this->data['datalist2']=Order::whereDate('created_at', '>=', $startDate." 00:00:00")->whereDate('created_at', '<=', DB::raw('CURDATE()'))->orderBy('created_at','DESC')->get();
        $this->data['datalist']=Customerfoodorder::where('amount', '!=', "")->where('payment_done', 1)->orderBy('created_at','DESC')->get();
        $this->data['datalist2']=Order::where('total_amount', '!=', "")->where('closeorder', 1)->orderBy('created_at','DESC')->get();
        $this->data['search_data'] = ['category_id'=>'','date_from'=>$startDate, 'date_to'=>date('Y-m-d')];
        $data = ($this->data['datalist'].' '.$this->data['datalist2']);
        // print_r($data);die;
        // return view('backend/foodsalesreport',$this->data);
         return view('backend/foodsalesreport',collect($this->data)->sortBy('created_at')->all());
        
    }
    
    // upload food item sheet start
    public function saveFocuskeyword(Request $request)
    {    
        // return request;
        ini_set('max_execution_time', 180); 
        $row = 0;
         if (($open = fopen($request->excel, "r")) !== FALSE)
        {
            while (($data = fgetcsv($open, 10000000, ",")) !== FALSE)
            {
                $row++;
                if($row == 1) continue;
                $value[] = $data;
            }
            fclose($open);
        }
        for($i=0; $i<count($value);$i++)
        {
            $select_data = DB::table("food_items")->where('name', $value[$i][1])->count();
            if($select_data != 0)
            {
                $data=[
                    "category_id" => $value[$i][0],
                    "name" => $value[$i][1],
                    "itemcode" => $value[$i][2],
                    "strikethrough" => $value[$i][3],
                    "price" => $value[$i][4],
                    "description" => $value[$i][5],
                    "category" => $value[$i][6],
                    "units" => $value[$i][7],
                    "costunits" => $value[$i][8],
                    "sku" => $value[$i][9],
                    "preptime" => $value[$i][10],
                    "bestfor" => $value[$i][11],
                    "energy" => $value[$i][12],
                    "protein" => $value[$i][13],
                    "fat" => $value[$i][14],
                    "carb" => $value[$i][15],
                    "status" => $value[$i][16],
                    "is_deleted" => $value[$i][17]
                    // food_image
                ];
                $insert_data = DB::table("food_items")->where('name',$value[$i][1])->update($data);
                
            }
            else
            {
                $data=[
                    "category_id" => $value[$i][0],
                    "name" => $value[$i][1],
                    "itemcode" => $value[$i][2],
                    "strikethrough" => $value[$i][3],
                    "price" => $value[$i][4],
                    "description" => $value[$i][5],
                    "category" => $value[$i][6],
                    "units" => $value[$i][7],
                    "costunits" => $value[$i][8],
                    "sku" => $value[$i][9],
                    "preptime" => $value[$i][10],
                    "bestfor" => $value[$i][11],
                    "energy" => $value[$i][12],
                    "protein" => $value[$i][13],
                    "fat" => $value[$i][14],
                    "carb" => $value[$i][15],
                    "status" => $value[$i][16],
                    "is_deleted" => $value[$i][17]
                ];
                $insert_data = DB::table("food_items")->insert($data);
                // print_r($insert_data);
                // die;
            }
        }
             
        if($insert_data == 1)
        {
            return redirect()->back()->with(['success' => 'Successfully Insert Data']);
        }
        else if($insert_data == 0)
        {
            return redirect()->back()->with(['success' => 'Successfully Updated Data']);
        }else{
            return redirect()->back()->with(['error' =>  'Sorry We got some error']);
        }
        
    }
    // food itme sheet end 
/* ***** End FoodItems Functions ***** */

/* ***** Start ExpenseCategory Functions ***** */
    public function addExpenseCategory() {
        return view('backend/expenses/category_add_edit',$this->data);
    }
    public function editExpenseCategory(Request $request){
        $this->data['data_row']=ExpenseCategory::whereId($request->id)->first();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('backend/expenses/category_add_edit',$this->data);
    }
    public function saveExpenseCategory(Request $request) {
        if($request->id>0){
            if($this->core->checkWebPortal()==0){
                return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
            }
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        $res = ExpenseCategory::updateOrCreate(['id'=>$request->id],$request->except(['_token']));

        if($res){
            return redirect()->back()->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    public function listExpenseCategory() {
         $this->data['datalist']=ExpenseCategory::whereStatus(1)->orderBy('name','ASC')->get();
        return view('backend/expenses/category_list',$this->data);
    }
    public function deleteExpenseCategory(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        if(ExpenseCategory::whereId($request->id)->update(['status'=>0])){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
/* ***** End ExpenseCategory Functions ***** */

/* ***** Start Expenses Functions ***** */
    public function addExpense() {
        $this->data['category_list']=$this->getExpenseCategoryList();
        return view('backend/expenses/add_edit',$this->data);
    }
    public function editExpense(Request $request){
        $this->data['category_list']=$this->getExpenseCategoryList();
        $this->data['data_row']=Expense::with('attachments')->whereId($request->id)->first();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('backend/expenses/add_edit',$this->data);
    }
    public function saveExpense(Request $request) {
        date_default_timezone_set("Asia/Kolkata");
        if($request->id>0){
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        // print_r($request->datetime);die();
        $expenseData = [
            "category_id" => $request->category_id,
            "title" => $request->title,
            "amount" => $request->amount,
            "remark" => $request->remark,
            "datetime" => $request->datetime
        ];
        $res = Expense::updateOrCreate(['id'=>$request->id],$expenseData,$request->except(['_token']));

        if($res){
            if($request->media_ids){
                if(count($request->media_ids)>0){
                    $row_data= MediaFile::whereIn($request->media_ids)->get();
                    foreach ($row_data as $key => $value) {
                        unlinkImg($value->file,'uploads/expenses/');
                    }
                }
            }
            if($request->hasFile('attachments')){
                $idImages = [];
                foreach($request->attachments as $img){
                    $filename=$this->core->fileUpload($img,'uploads/expenses',1);
                    $idImages[] = ['tbl_id'=>$res->id, 'file'=>$filename, 'type'=>'expenses'];
                }
                if(count($idImages)>0){
                    MediaFile::insert($idImages);
                }
            }
            return redirect()->back()->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    public function listExpense() {
        $startDate = getNextPrevDate('prev');
        $this->data['category_list']=$this->getExpenseCategoryList();
        $this->data['datalist']=Expense::whereDate('datetime', '>=', $startDate." 00:00:00")->whereDate('datetime', '<=', DB::raw('CURDATE()'))->orderBy('datetime','DESC')->get();
        $this->data['search_data'] = ['category_id'=>'','date_from'=>$startDate, 'date_to'=>date('Y-m-d')];
        return view('backend/expenses/list',$this->data);
    }
    
    public function listExpensetoday() {
        $startDate = getNextPrevDate('prev');
        $this->data['category_list']=$this->getExpenseCategoryList();
        $this->data['datalist']=Expense::whereDate('datetime', '>=', $startDate." 00:00:00")->whereDate('datetime', '=', DB::raw('CURDATE()'))->orderBy('datetime','DESC')->get();
        $this->data['search_data'] = ['category_id'=>'','date_from'=>$startDate, 'date_to'=>date('Y-m-d')];
        return view('backend/expenses/today_expenses_list',$this->data);
    }
    
    public function deleteExpense(Request $request) {
        if(Expense::whereId($request->id)->delete()){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
/* ***** End Expenses Functions ***** */

/* ***** Start StockManage Functions ***** */
    public function addProduct() {
        return view('backend/product_add_edit',$this->data);
    }
    public function editProduct(Request $request){
        $this->data['data_row']=Product::whereId($request->id)->first();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('backend/product_add_edit',$this->data);
    }
    public function saveProduct(Request $request) {
        if($request->id>0){
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        $res = Product::updateOrCreate(['id'=>$request->id],$request->except(['_token','curr_stock']));

        if($res){
            return redirect()->back()->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    public function listProduct() {
         $this->data['datalist']=Product::whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
        return view('backend/product_list',$this->data);
    }
    public function deleteProduct(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        if(Product::whereId($request->id)->update(['is_deleted'=>1])){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }

    public function inOutStock() {
        $this->data['product_list']=$this->getProductList();
        return view('backend/stock_in_out',$this->data);
    }
    public function saveStock(Request $request) {
        $request->merge(['added_by'=>Auth::user()->id]);
        $res = StockHistory::insert($request->except(['_token']));
        if($res){
            if($request->stock_is=='add'){
                Product::whereId($request->product_id)->increment('stock_qty', $request->qty);
            } else {
               Product::whereId($request->product_id)->decrement('stock_qty', $request->qty);
            }
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_ADD_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_ADD_0')]);
    }
    public function stockHistory() {
        $startDate = getNextPrevDate('prev');
        $this->data['datalist']=StockHistory::whereDate('created_at', '>=', $startDate." 00:00:00")->whereDate('created_at', '<=', DB::raw('CURDATE()'))->orderBy('id','DESC')->get();
        $this->data['products']=Product::where('is_deleted',0)->pluck('name','id');
        $this->data['search_data'] = ['product_id'=>'','is_stock'=>'','date_from'=>$startDate, 'date_to'=>date('Y-m-d')];
        return view('backend/stock_history',$this->data);
    }
/* ***** End StockManage Functions ***** */

/* ***** Start FoodOrders Functions ***** */
    public function listOrders() {
        $this->data['datalist']=Order::whereDate('created_at', DB::raw('CURDATE()'))->where('status','!=',4)->orderBy('id','DESC')->get();
        $this->data['search_data'] = ['date_from'=>date('Y-m-d'), 'date_to'=>date('Y-m-d')];
        return view('backend/orders_list',$this->data);
    }
    public function roomfoodOrder() {
        $this->data['categories_list']=FoodCategory::with('food_items')->whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
        $this->data['skills']= Room::whereStatus(1)->whereIsDeleted(0)->orderBy('room_no','ASC')->get();
        $this->data['skillsnew'] = Reservation::whereNull('check_out')->orderBy('created_at','DESC')->get('room_num');
        return view('backend/room_food_order_page',$this->data);
    }
    public function roomfoodOrderTable(Request $request) {
        $this->data['categories_list']=FoodCategory::with('food_items')->whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
         $this->data['order_row']=Order::where('id',$request->segment(3))->first();
        return view('backend/room_food_order_table_page',$this->data);
    }
    public function roomfoodOrderFinal(Request $request) {
        $this->data['categories_list']=FoodCategory::with('food_items')->whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
        $this->data['order_row']=Order::where('id',$request->segment(3))->first();
        return view('backend/room_food_order_final_page',$this->data);
    }
    public function saveFoodOrderRoom(Request $request){
        $insertRec = true;
        $insertRecOrderHistorty = true;
        $orderHistoryResId = null;

        $invoiceDate = date('Y-m-d');
        $settings = getSettings();
        $orderArr = [];
        $itemsArr = array_filter($request->item_qty);
        if(count($itemsArr)>0){
            $orderData = [];
            $gstPerc = $cgstPerc = $gstAmount = $cgstAmount = 0;
            if($request->food_gst_apply==1){
                $gstPerc = $request->gst_perc;
                $cgstPerc = $request->cgst_perc;
                $gstAmount = $request->gst_amount;
                $cgstAmount = $request->cgst_amount;
            }
            $orderInfo= [
                'reservation_id'=>$request->reservation_id,
                'invoice_num'=>($request->food_invoice_apply=="on") ? getNextInvoiceNo('orders') : null,
                'invoice_date'=>$invoiceDate,
                'table_num'=>$request->table_num,
                'gst_apply'=>$request->food_gst_apply,
                'gst_perc'=>$gstPerc,
                'gst_amount'=>$gstAmount,
                'cgst_perc'=>$cgstPerc,
                'cgst_amount'=>$cgstAmount,
                'discount'=>$request->discount_amount,
                'total_amount'=>$request->final_amount,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'gender' => $request->gender,
                'num_of_person' => $request->num_of_person,
                'waiter_name' => $request->waiter_name,
                'payment_mode' => $request->payment_mode,

            ];
            // print_r($orderInfo);die;
            if($request->page=='ff_order'){
               
                $orderInfo['original_date'] = date('Y-m-d H:i:s');
                $orderRes = Order::where('id',$request->order_id)->update($orderInfo);
                if($orderRes){
                    OrderHistory::where('order_id',$request->order_id)->update(['is_book'=>0]);
                    //send sms
                    if($request->mobile){
                        $this->core->sendSms(3,$request->mobile,['name'=>$request->name]);
                    }
                    // return redirect()->route('order-invoice-final',[$request->order_id])->with(['success' => 'Orders Successfully submitted']);
                    return redirect()->route('latest-orders')->with(['success' => 'Payment done Successfully']);
                    
                } else {
                    return redirect()->back()->with(['error' => 'Order placed failed.Try again']);
                }

            } else {
                if($request->reservation_id>0){
                    $insertRecOrderHistorty = false;
                } else {
                    // check table num is booked or not (if table num booked , no new orders row added, added in orderHistory table)
                    $isTableBooked = isTableBook($request->table_num);
                    if($isTableBooked){
                        $insertRec = false;
                        $orderResId = $isTableBooked->order_id;
                    }
                }

                if($insertRec){
                    $orderResId = Order::insertGetId($orderInfo);
                }
                if($insertRecOrderHistorty){
                    $orderHistoryResId = OrderHistory::insertGetId(['order_id'=>$orderResId, 'table_num'=>$request->table_num]);
                }

                $lastOrderId = $orderResId; // $orderRes->id;
                foreach($itemsArr as $k=>$val){
                    $exp = explode('~', $request->items[$k]);
                    $jsonData = ['category_id'=>$exp[0], 'category_name'=>$exp[1], 'item_name'=>$exp[2], 'item_id'=>$k];
                     $orderArr[] = [
                        'order_id'=>$lastOrderId,
                        'order_history_id'=>$orderHistoryResId,
                        'reservation_id'=>$request->reservation_id,
                        'item_name'=>$exp[2],
                        'item_price'=>$exp[3],
                        'item_qty'=>$val,
                        'json_data'=>json_encode($jsonData),
                        'status'=>3
                    ];
                }
                $res = OrderItem::insert($orderArr);
                if($res){
                    if($request->reservation_id>0) {
                        return redirect()->route('room-kitchen-invoice',['order_id'=>$lastOrderId,'order_type'=>'room-order'])->with(['success' => 'Orders Successfully submitted']);
                    }
                    return redirect()->route('room-kitchen-invoice',['order_id'=>$orderHistoryResId,'order_type'=>'room-order'])->with(['success' => 'Orders Successfully submitted']);
                } else {
                    return redirect()->back()->with(['error' => 'Order placed failed.Try again']);
                }
            }


        }
        return redirect()->back()->with(['error' => 'Please item quantity']);
    }
    public function getrooomdatacustomer(Request $request){
        $roomno = $request->roomno;
        $roomnouserdata = Reservation::whereNull('check_out')->where('room_num',$roomno)->orderBy('created_at','DESC')->distinct('room_num')->get();
        return response()->json([
            'roomnouserdata'=>$roomnouserdata,
        ]);
    }
    
    // table order
    public function foodOrder() {
        $this->data['categories_list']=FoodCategory::with('food_items')->whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
        return view('backend/food_order_page',$this->data);
    }
    public function foodOrderTable(Request $request) {
        $this->data['categories_list']=FoodCategory::with('food_items')->whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
        $this->data['order_row']=Order::where('id',$request->segment(3))->first();
        return view('backend/food_order_table_page',$this->data);
    }
    public function foodOrderFinal(Request $request) {
        $this->data['categories_list']=FoodCategory::with('food_items')->whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
        $this->data['order_row']=Order::where('id',$request->segment(3))->first();
        return view('backend/food_order_final_page',$this->data);
    }
    public function saveFoodOrder(Request $request){
        $insertRec = true;
        $insertRecOrderHistorty = true;
        $orderHistoryResId = null;

        $invoiceDate = date('Y-m-d');
        $settings = getSettings();
        $orderArr = [];
        $itemsArr = array_filter($request->item_qty);
        if(count($itemsArr)>0){
            $orderData = [];
            $gstPerc = $cgstPerc = $gstAmount = $cgstAmount = 0;
            if($request->food_gst_apply==1){
                $gstPerc = $request->gst_perc;
                $cgstPerc = $request->cgst_perc;
                $gstAmount = $request->gst_amount;
                $cgstAmount = $request->cgst_amount;
            }
            $orderInfo= [
                'reservation_id'=>$request->reservation_id,
                'invoice_num'=>($request->food_invoice_apply=="on") ? getNextInvoiceNo('orders') : null,
                'invoice_date'=>$invoiceDate,
                'table_num'=>$request->table_num,
                'gst_apply'=>$request->food_gst_apply,
                'gst_perc'=>$gstPerc,
                'gst_amount'=>$gstAmount,
                'cgst_perc'=>$cgstPerc,
                'cgst_amount'=>$cgstAmount,
                'discount'=>$request->discount_amount,
                'total_amount'=>$request->final_amount,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'gender' => $request->gender,
                'num_of_person' => $request->num_of_person,
                'waiter_name' => $request->waiter_name,
                'payment_mode' => $request->payment_mode,
                'ordertype' => 'table'

            ];
            if($request->page=='ff_order'){
                $orderInfo['original_date'] = date('Y-m-d H:i:s');
                $orderRes = Order::where('id',$request->order_id)->update($orderInfo);
                if($orderRes){
                    OrderHistory::where('order_id',$request->order_id)->update(['is_book'=>0]);

                    //send sms
                    if($request->mobile){
                        $this->core->sendSms(3,$request->mobile,['name'=>$request->name]);
                    }

                    return redirect()->route('order-invoice-final',[$request->order_id])->with(['success' => 'Orders Successfully submitted']);
                } else {
                    return redirect()->back()->with(['error' => 'Order placed failed.Try again']);
                }

            } else {
                if($request->reservation_id>0){
                    $insertRecOrderHistorty = false;
                } else {
                    // check table num is booked or not (if table num booked , no new orders row added, added in orderHistory table)
                    $isTableBooked = isTableBook($request->table_num);
                    if($isTableBooked){
                        $insertRec = false;
                        $orderResId = $isTableBooked->order_id;
                    }
                }

                if($insertRec){
                    $orderResId = Order::insertGetId($orderInfo);
                }
                if($insertRecOrderHistorty){
                    $orderHistoryResId = OrderHistory::insertGetId(['order_id'=>$orderResId, 'table_num'=>$request->table_num]);
                }

                $lastOrderId = $orderResId; // $orderRes->id;
                foreach($itemsArr as $k=>$val){
                    $exp = explode('~', $request->items[$k]);
                    $jsonData = ['category_id'=>$exp[0], 'category_name'=>$exp[1], 'item_name'=>$exp[2], 'item_id'=>$k];
                     $orderArr[] = [
                        'order_id'=>$lastOrderId,
                        'order_history_id'=>$orderHistoryResId,
                        'reservation_id'=>$request->reservation_id,
                        'item_name'=>$exp[2],
                        'item_price'=>$exp[3],
                        'item_qty'=>$val,
                        'json_data'=>json_encode($jsonData),
                        'status'=>3
                    ];
                }
                $res = OrderItem::insert($orderArr);
                if($res){
                    if($request->reservation_id>0) {
                        return redirect()->route('kitchen-invoice',['order_id'=>$lastOrderId,'order_type'=>'room-order'])->with(['success' => 'Orders Successfully submitted']);
                    }
                    return redirect()->route('kitchen-invoice',['order_id'=>$orderHistoryResId,'order_type'=>'table-order'])->with(['success' => 'Orders Successfully submitted']);
                } else {
                    return redirect()->back()->with(['error' => 'Order placed failed.Try again']);
                }
            }


        }
        return redirect()->back()->with(['error' => 'Please item quantity']);
    }
    
    public function orderInvoiceFinal(Request $request) {
        $this->data['data_row']=Order::where('id',$request->segment(3))->first();
        return view('backend/food_order_final_invoice',$this->data);
    }
    public function kitchenInvoice(Request $request){
        $id = $request->segment(3);
        $type = $request->segment(4);
        if($type=='room-order'){
            $this->data['data_row']=Order::whereId($id)->first();
        } else {
            $this->data['data_row']=OrderHistory::with('order')->whereId($id)->first();
        }
         $this->data['type'] = $type;
        return view('backend/kitchen_invoice',$this->data);
    }
    // table order end
    
    public function deleteOrderItem(Request $request) {
        if(OrderItem::whereId($request->id)->delete()){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
    public function orderInvoice(Request $request) {
        $id = $request->segment(3);
        $this->data['data_row']=Order::with('orders_items')->whereId($id)->first();
        return view('backend/food_order_invoice',$this->data);
    }
    public function roomorderInvoiceFinal(Request $request) {
        $this->data['data_row']=Order::where('id',$request->segment(3))->first();
        return view('backend/room_food_order_final_invoice',$this->data);
    }
    public function onlineorderInvoiceFinal(Request $request) {
        // return $request->order_id;
        $this->data['data_row']=Customerfoodorder::where('order_id',$request->order_id)->first();
        return view('backend/online_food_order_final_invoice',$this->data);
    }
    
    public function roomkitchenInvoice(Request $request){
        
        // return "Hello";
         $id = $request->segment(3);
        $type = $request->segment(4);
    //   print_r($type);die;
        if($type=='room-order'){
            // print_r($id);
           
        //   print_r($hotels[0]->order_id);die;
            $hotel11=DB::table('order_items')->select('order_items.*')->where('order_history_id','=',$id)->get();
           $hotel13= $hotel11;
           
        //  print_r($hotel13);die;
            // $this->data['data_row']=Order::whereId($id)->first();
        } else {
            // print_r('hello');die;
            $this->data['data_row']=OrderHistory::with('order')->whereId($id)->first();
        }
         $this->data['type'] = $type;
     
        return view('backend/room_kitchen_invoice',compact('hotel13'));
    }
    
    
/* ***** End FoodOrders Functions ***** */

/* ***** Start Setting Functions ***** */
    public function settingsForm() {
         $this->data['data_row']=Setting::pluck('value','name');
         
        return view('backend/settings',$this->data);
    }
    public function saveSettings(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        $requestExcept = ['_token', 'sms_api_active'];
        $res = null;

        //save settings: sms api active or not
        $value = ($request->sms_api_active && $request->sms_api_active == 'on') ? 1 : 0;
        Setting::updateOrCreate(['name'=>'sms_api_active'], ['name'=>'sms_api_active', 'value'=>$value, 'updated_at'=>date('Y-m-d H:i:s')]);

        foreach($request->all() as $key => $value){
             
            if(!in_array($key, $requestExcept)){
                
               $res = Setting::updateOrCreate(['name'=>$key], ['name'=>$key, 'value'=>$value, 'updated_at'=>date('Y-m-d H:i:s')]);
            }
        }
        if($res){
           //set updated settings in session
           setSettings();

            return redirect()->back()->with(['success' => config('constants.FLASH_REC_UPDATE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_UPDATE_0')]);
    }
/* ***** End Setting Functions ***** */

/* ***** Start Permissions Functions ***** */
    public function listPermission() {
        $this->data['datalist']=Permission::where('status',1)->orderBy('permission_type','ASC')->get();
        // print_r($this->data['datalist']);die();
        return view('backend/permissions/list',$this->data);
    }
    public function savePermission(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        $requestExcept = ['_token'];
        $res = null;
        $ids = $request->ids;
        $superAdmin = $request->super_admin;
        $admin = $request->admin;
        $receptionist = $request->receptionist;
         $kitchen = $request->kitchen;
        //  print_r($request->kitchen);die;
        foreach($ids as $key => $id){
            $superAdminP = 1; //not change superadmin, so set default 1
            $adminP = $recP = $kitP = 0;
            if(isset($superAdmin[$id])){
                $superAdminP = 1;
            }
            if(isset($admin[$id])){
                $adminP = 1;
            }
            if(isset($receptionist[$id])){
                $recP = 1;
            }
             if(isset($kitchen[$id])){
                $kitP = 1;
            }
            //  print_r($kitP);die;
            $res = Permission::where('id',$id)->update(["super_admin"=>$superAdminP, 'admin'=>$adminP, 'receptionist'=>$recP, 'kitchen'=>$kitP ]);
        }
        if($res){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_UPDATE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_UPDATE_0')]);
    }
/* ***** End Permissions Functions ***** */

/* ***** Start MediaFile Functions ***** */
    public function deleteMediaFile(Request $request) {
        $row_data= MediaFile::whereId($request->id)->first();
        if(MediaFile::whereId($request->id)->delete()){
            unlinkImg($row_data->file,'uploads/'.$row_data->type.'/');
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
    public function mealMaster(Request $request)
    {
        $this->data['list'] = 'check_ins';
        $this->data['datalist']=DB::table('meal_plans')->get();
        return view('backend/rooms/mealpackage',$this->data);
    }
    public function addMealPlan(Request $request)
    {
        return view('backend/rooms/add_meal_plan',$this->data);
    }
    public function saveMealPlan(Request $request) {
        if($request->id>0){
            if($this->core->checkWebPortal()==0){
                return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
            }
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        $res = new MealPlan;
        $res->name =$request->input("name");
        $res->included_meal =($request->included_meal) ? join(',',$request->included_meal) : null;
        $res->save();
        if($res){
            return redirect()->back()->with(['success' => $success]);
        }
        else{
            return redirect()->back()->with(['error' => $error]);
        }

    }
    public function packageMaster(Request $request)
    {
        $this->data['list'] = 'check_ins';
        $this->data['datalist']=PackageMaster::whereStatus(1)->whereIsDeleted(0)->get();
        return view('backend/packagelist',$this->data);
    }
    public function addPackage(Request $request)
    {
        $this->data['roomtypes_list']=RoomType::select('id','title','is_base_price','base_price')->whereStatus(1)->whereIsDeleted(0)->orderBy('title','ASC')->pluck('title','id');
        $this->data['mealplan_list']=MealPlan::select('id', 'name')->whereStatus(1)->orderBy('id','ASC')->pluck('name', 'id');
        return view('backend/add_package',$this->data);
    }
    public function savePackage(Request $request)
    {
        if($request->id>0)
        {
            if($this->core->checkWebPortal()==0){
                return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
            }
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }

        $pack = new PackageMaster;
        $pack->title =$request->input("title");
        $pack->room_type_id =$request->input("room_type_id");
        $pack->meal_plan_id =$request->input("meal_plan_id");
        $pack->package_price =$request->input("package_price");
        $pack->package_description =$request->input("package_description");
        $pack->no_of_days =$request->input("no_of_days");
        $pack->save();
        if($pack){
            return redirect()->back()->with(['success' => $success]);
        }
        else{
            return redirect()->back()->with(['error' => $error]);
        }
    }
    public function editpackage(Request $request)
    {
        $this->data['roomtypes_list']=getRoomTypesList();
        $this->data['data_row']=PackageMaster::whereId($request->id)->first();
        $this->data['mealplan_list']=MealPlan::select('id', 'name')->whereStatus(1)->orderBy('id','ASC')->pluck('name', 'id');
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('backend/add_package',$this->data);
    }
    public function updatepackage(Request $request)
    {
        $updatepackage = array(
            "title" => $request->input("title"),
            "room_type_id" => $request->input("room_type_id"),
            "meal_type_id" => $request->input("meal_plan_id"),
            "package_price" => $request->input("package_price"),
            "package_description" => $request->input("package_description"),
            "no_of_days" => $request->input("no_of_days")
        );
        $res = PackageMaster::whereId($request->id)->update($updatepackage);
        if($res){
            return redirect()->back()->with(['success' => 'Package updated Successfully']);
        }
         else
         {
             return redirect()->back()->with(['error' => 'error in updating Exist']);
       }

    }
    public function deletepackage(Request $request)
    {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        if(PackageMaster::whereId($request->id)->update(['is_deleted'=>1])){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
    public function paymentmodeMaster(Request $request)
    {
        $this->data['list'] = 'check_ins';
        $this->data['datalist']=PaymentMode::where('status', 1)->get();
        return view('backend/paymentmode',$this->data);
    }
    public function addPaymentMode(Request $request)
    {
        return view('backend/add_paymentmode',$this->data);
    }
    public function savePaymentmode(Request $request) {
        if($request->id>0){
            if($this->core->checkWebPortal()==0){
                return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
            }
            $success = config('constants.FLASH_REC_UPDATE_1');
            $error = config('constants.FLASH_REC_UPDATE_0');
        } else {
            $success = config('constants.FLASH_REC_ADD_1');
            $error = config('constants.FLASH_REC_ADD_0');
        }
        $res = new PaymentMode();
        $res->payment_mode =$request->input("payment_mode");
        $res->status = $request->input("status");
        $res->save();
        //$payment_mode = str_replace(" ","",$request->payment_mode);
        if($res){
            $query = DB::statement("ALTER TABLE daily_report ADD `$request->payment_mode` FLOAT(10,2)");
            return redirect()->back()->with(['success' => $success]);
        }
        else{
            return redirect()->back()->with(['error' => $error]);
        }

    }


    public function roomsInventory(Request $request)
    {
        $this->data['list'] = 'check_ins';
        $bookedRooms = [];
        $other_rooms = DB::select("SELECT * FROM `rooms` where rooms.status = '1' and rooms.is_deleted = '0'  and room_no NOT in (SELECT room_num FROM `arrivals` where (is_deleted = '0' and DATE(`check_out`) = CURDATE()) or (is_deleted = 0 and DATE(`check_in`) = CURDATE()) )  ");

        $reservationData =DB::select(DB::raw("SELECT id,room_num,room_type_id,referred_by_name,check_in,check_out FROM arrivals WHERE  ( is_deleted = 0 and DATE(`check_out`) = CURDATE() ) or ( is_deleted = 0 and DATE(`check_in`) = CURDATE() )"));

        if($reservationData){
            foreach($reservationData as $val){
                $exp = explode(',', $val->room_num);
                $status = 'Booked';
                $checkin = DATE($val->check_in);
                $checkout = DATE($val->check_out);
                $count = count($exp);
                if($count > 1)
                {
                    for($i=0; $i<$count; $i++){
                        $arr = array(
                            "room_num" => $exp[$i],
                            "checkin" => $checkin,
                            "checkout" => $checkout,
                            "status" => $status,
                            "referred_by_name" => $val->referred_by_name,
                        );
                        array_push($bookedRooms,$arr);
                    }

                }
                else{
                    $arr = array(
                        "room_num" => $exp[0],
                        "checkin" => $checkin,
                        "checkout" => $checkout,
                        "status" => $status,
                        "referred_by_name" => $val->referred_by_name,
                    );
                    array_push($bookedRooms,$arr);
                }
            }

        }
        if($other_rooms)
        {
            foreach($other_rooms as $val){
                if($val->maintinance == '0')
                {
                    $arr1 = array(
                        "room_num" => $val->room_no,
                        "checkin" => "",
                        "checkout" => "",
                        "status" => "Available",
                        "referred_by_name" => '',
                    );
                }
                else{
                    $arr1 = array(
                        "room_num" => $val->room_no,
                        "checkin" => "",
                        "checkout" => "",
                        "status" => "R&M Issue",
                        "referred_by_name" => '',
                    );
                }

                array_push($bookedRooms,$arr1);

            }
        }
        $this->data['booked_rooms'] = $bookedRooms;
        return view('backend/room_inventory_list',$this->data);
    }
    public function getFilteredRoomData(Request $request)
    {
        $bookedRooms = [];
        $sort_date = Carbon::createFromFormat('Y-m-d',$request->sortDate)->format('Y-m-d');
        $reservationData =DB::select(DB::raw("SELECT id,room_num,room_type_id,referred_by_name,check_in,check_out FROM arrivals WHERE  ( is_deleted = 0 and DATE(`check_out`) = DATE('$sort_date') ) or ( is_deleted = 0 and DATE(`check_in`) = DATE('$sort_date') )"));
        $other_rooms = DB::select("SELECT * FROM `rooms` where rooms.status = '1' and rooms.is_deleted = '0'  and room_no NOT in (SELECT room_num FROM `arrivals` where (is_deleted = '0' and DATE(`check_out`) = $request->sortDate) or (is_deleted = 0 and DATE(`check_in`) = $request->sortDate) )  ");

        if($reservationData){
            foreach($reservationData as $val){
                $exp = explode(',', $val->room_num);
                $status = 'Booked';
                $checkin = DATE($val->check_in);
                $checkout = DATE($val->check_out);
                $count = count($exp);
                if($count > 1)
                {
                    for($i=0; $i<$count; $i++){
                        $arr = array(
                            $i+1,
                            $exp[$i],
                            $status,
                            $val->referred_by_name,
                        );
                        array_push($bookedRooms,$arr);
                    }

                }
                else{
                    $arr = array(
                        1,
                        $val->room_num,
                        $status,
                        $val->referred_by_name,
                    );
                    array_push($bookedRooms,$arr);
                }
            }

        }
        if($other_rooms)
        {
            foreach($other_rooms as $key => $val){
                if($val->maintinance == '0')
                {
                    $arr1 = array(
                        $key+1,
                        $val->room_no,
                        '<span class="btn btn-xs btn-success">Available</span>',
                        ''
                    );
                }
                else{
                    $arr1 = array(
                        $key+1,
                        $val->room_no,
                        '<span class="btn btn-xs btn-info">R&amp;M Issue</span>',
                        ''
                    );
                }

                array_push($bookedRooms,$arr1);

            }
        }
        echo json_encode($bookedRooms);
    }


/* ***** End MediaFile Functions ***** */

/* ***** Start Internal Functions ***** */
    function getRoleList(){
        return Role::orderBy('role','ASC')->pluck('role','id');
    }
    function getAmenitiesList(){
        return Amenities::whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
    }
    function getFoodCategoryList(){
        return FoodCategory::whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->pluck('name','id');
    }
    function getExpenseCategoryList(){
        return ExpenseCategory::whereStatus(1)->orderBy('name','ASC')->pluck('name','id');
    }
    function getProductList(){
        return Product::whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->pluck('name','id');
    }
    function getRoomList(){
        
        date_default_timezone_set("Asia/Kolkata");
        $starttime=date('Y-m-d H:i:s',strtotime("12:00:00"));
        $starttime=date('H:i:s',strtotime($starttime));
        $endtime=date('Y-m-d H:i:s',strtotime("06:00:00"));
        $endtime=date('H:i:s',strtotime($endtime));
        $time = date("H:i:s");
        $today_time_new = date('Y-m-d');
        if($starttime > $time && $endtime > $time)
        {
            $today_timefix = date('Y-m-d',strtotime($today_time_new.'-1 days'));
        }else{
            $today_timefix = $today_time_new;
        }
        
        $bookedRooms = [];
        $checkedRooms = [];
        $OTARooms =[];
        $FABRooms = [];
        $OYORooms = [];
        $dirtyRooms =[];
        $CorporateRooms=[];
        $ManagementRooms=[];
         $FITRooms=[];

        $reservationData = Reservation::whereStatus(1)->whereIsDeleted(0)->orderBy('created_at','DESC')->select('room_num','check_in','check_out','referred_by_name','referred_by','user_checkout','id','unique_id')->get();

        //  dump(date('Y-m-d'));
        // dd($reservationData);
        if($reservationData->count()>0){
            foreach($reservationData as $key=>$val){
                $exp = explode(',', $val->room_num);
                $count = count($exp);

            if( date('Y-m-d',strtotime($val->user_checkout)) == $today_timefix && ($val->check_out == null))
                {

                    if($val->check_out == null || $val->check_out == "" )
                    {
                        for($i=0; $i<$count; $i++)
                        {
                            $checkedRooms[$exp[$i]] = $exp[$i];
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
                else
                {
                    if($val->referred_by_name == 'TA' && date('Y-m-d',strtotime($val->user_checkout)) != $today_timefix)
                    {
                        for($i=0; $i<$count; $i++){
                            $bookedRooms[$exp[$i]] = $exp[$i];
                        }
                    }
                    if($val->referred_by_name == 'OTA' && date('Y-m-d',strtotime($val->user_checkout)) != $today_timefix)
                    {
                        for($i=0; $i<$count; $i++){
                            $OTARooms[$exp[$i]] = $exp[$i];
                        }
                    }
                    
                     if($val->referred_by == 'FAB' && date('Y-m-d',strtotime($val->user_checkout)) != $today_timefix)
                    {
                        for($i=0; $i<$count; $i++){
                            $FABRooms[$exp[$i]] = $exp[$i];
                        }
                    }
                    
                    if($val->referred_by == 'OYO'  && date('Y-m-d',strtotime($val->user_checkout)) != $today_timefix)
                    {
                        for($i=0; $i<$count; $i++){
                            $OYORooms[$exp[$i]] = $exp[$i];
                        }
                    }
                    
                    if($val->referred_by_name == 'Corporate' && date('Y-m-d',strtotime($val->user_checkout)) != $today_timefix)
                    {
                        for($i=0; $i<$count; $i++){
                            $CorporateRooms[$exp[$i]] = $exp[$i];
                        }
                    }
                    if($val->referred_by_name == 'Management' && date('Y-m-d',strtotime($val->user_checkout)) != $today_timefix)
                    {
                        for($i=0; $i<$count; $i++){
                            $ManagementRooms[$exp[$i]] = $exp[$i];
                        }
                    }
                      if($val->referred_by_name == 'F9' && date('Y-m-d',strtotime($val->user_checkout)) != $today_timefix)
                    {
                        for($i=0; $i<$count; $i++){
                            $FITRooms[$exp[$i]] = $exp[$i];
                        }
                    }

                }

        }
            // dd("jfj");
        }
        $this->data['reservation'] =$reservationData;
        $this->data['checked_rooms'] = $checkedRooms;
        $this->data['booked_rooms'] = $bookedRooms;
        $this->data['dirty_rooms'] = $dirtyRooms;
        // print_r($this->data['dirty_rooms']);
        $this->data['ota_rooms'] = $OTARooms;
       
       $this->data['fab_rooms'] = $FABRooms;
         $this->data['oyo_rooms'] = $OYORooms;
        $this->data['corporate_rooms'] = $CorporateRooms;
        $this->data['management_rooms'] = $ManagementRooms;
        $this->data['fit_rooms']=$FITRooms;
        $this->data['checked_rooms_count'] = count($checkedRooms);
        $this->data['booked_rooms_count'] = count($bookedRooms);
        $this->data['dirty_rooms_count'] = count($dirtyRooms);
         $this->data['fab_rooms_count'] = count($FABRooms);
        $this->data['oyo_rooms_count'] = count($OYORooms);
        $this->data['ota_rooms_count'] = count($OTARooms);
        $this->data['corporate_rooms_count'] = count($CorporateRooms);
        $this->data['management_rooms_count'] = count($ManagementRooms);
        $this->data['fit_rooms_count'] = count($FITRooms);
        // print_r(count($OYORooms));die;
        $this->data['room_types'] = RoomType::with('rooms')->whereStatus(1)->whereIsDeleted(0)->orderBy('base_price','ASC')->get();
        //$this->data['rooms'] = Room::whereStatus(1)->whereIsDeleted(0)->orderBy('room_no','ASC')->get();
        $totalrooms = Room::whereStatus(1)->whereIsDeleted(0)->orderBy('room_no','ASC')->get();
        $this->data['totrooms'] = count($totalrooms);
        return $this->data;
        
        
    }
    
    public function foreca($roomid,$guestname,$checkin,$checkout,$booking_id,$adult,$kids)
    {
        

    $curl = curl_init();
     
     $array['roomDetails']['roomId']=$roomid;
     $array['roomDetails']['roomNo']=$roomid;
     $array['roomDetails']['propertyCode']=1;
     $array['roomDetails']['checkInDate']=$checkin;
     $array['roomDetails']['checkOutDate']=$checkout;
     $array['roomDetails']['bookingId']=$booking_id;
    //  $array['roomDetails']['source']=$referred_by;
    //  $array['roomDetails']['payment_mode']=$paymentmode;
     $array['roomDetails']['status']="CHECK_IN";
     $array['roomDetails']['noOfGuests']['total']=$adult ?? 0 + $kids ?? 0;
     $array['roomDetails']['noOfGuests']['Adults']=$adult;
     $array['roomDetails']['noOfGuests']['Children']=$kids;
     
     $array['roomDetails']['rateCode']='';
     $array['roomDetails']['remark']='';
     $array['roomDetails']['package']='';
     $array['roomDetails']['billingInstruction']='';
     $array['roomDetails']['onlineOrderPref']['payNow']=true;
     $array['roomDetails']['onlineOrderPref']['payAtCheckout']=false;
     
     $array['roomDetails']['guestDetails']['guestId']='';
     $array['roomDetails']['guestDetails']['firstName']=$guestname;
     $array['roomDetails']['guestDetails']['middleName']='';
     $array['roomDetails']['guestDetails']['lastName']='';
     $array['roomDetails']['guestDetails']['gender']='Male';
     $array['roomDetails']['guestDetails']['email']='';
     $array['roomDetails']['guestDetails']['mobile']='';
     $array['roomDetails']['guestDetails']['nationality']='';
     $array['roomDetails']['guestDetails']['homeCountry']='';
     
     
     
     $data=json_encode($array,JSON_UNESCAPED_SLASHES);
   //  echo $data;

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://service-dev.horecafox.com/v1/pms/check-in',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$data,
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7ImNsaWVudElkIjoiVjE6OGU1YTNqc3AwaGg3In0sImlhdCI6MTY1MTA0NjcyNCwiZXhwIjoxNjUxNDc4NzI0fQ.wkNkVoATOScJofaZaHu4B79mERohegiMXRvXH3Jo_C0',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
return $response;

    }
    
    public function foreca_checkout($roomid,$bookingid)
    {
        $data['roomId']=$roomid;
        $data['propertyCode']=1;
        $data['bookingId']=$bookingid;
        
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://service-dev.horecafox.com/v1/pms/check-out',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>json_encode($data),
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7ImNsaWVudElkIjoiVjE6OGU1YTNqc3AwaGg3In0sImlhdCI6MTY1MTA0NjcyNCwiZXhwIjoxNjUxNDc4NzI0fQ.wkNkVoATOScJofaZaHu4B79mERohegiMXRvXH3Jo_C0',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
return $response;
    }
    
    public function collection_report()
    {
        return view('backend/collaction_report');
    }
    
     public function collection_report_action(Request $request)
    {
        
         $start=$request->start;
         $end=$request->end;
        //  $range=$request->range;
         $now = Carbon::now();
         $now=date('Y-m-d',strtotime($now));
        
         $payment=DB::table('payment_mode')->where('status','1')->orderBy('orderShorting','asc')->get();
         
        return view('backend/collaction_report',compact('start','payment','end','now'));
    }
    
    public function arrival_invoice(Request $request)
    {
        $this->data['data_row']=DB::table('arrivals')->where('id',$request->id)->first();
        return view('backend/rooms/arrival_invoice',$this->data); 
    }
    
     public function exportExcel(Request $request)
     {
         $start=$request->start;
         $end=$request->end;
                $data['data']=DB::select(DB::raw("SELECT payment_history.reservations_id,payment_history.remark as p_remark,payment_history.payment_date,customers.Booking_id,customers.name,customers.and_number,customers.mobile,reservations.* FROM ((customers INNER JOIN reservations on customers.id=reservations.customer_id) inner join payment_history on payment_history.reservations_id=reservations.id and payment_history.payment_date between '$start' and '$end') GROUP BY payment_history.reservations_id"));
                $name=Setting::where('name','hotel_name')->first();
                $data['title']=$name->value;
                $data['start']=$start;
                $data['end']=$end;
                //  dd($data);
                return Excel::download(new ExcelExport($data), time().'.xlsx');
     }
     
    // public function collectionReportview(Request $request)
    // {
    //             $start=$request->start;
    //             $end=$request->end;
    //             $data['data']=DB::select(DB::raw("SELECT payment_history.reservations_id,payment_history.remark as p_remark,payment_history.payment_date,customers.Booking_id,customers.name,customers.mobile,reservations.* FROM ((customers INNER JOIN reservations on customers.id=reservations.customer_id) inner join payment_history on payment_history.reservations_id=reservations.id and payment_history.payment_date between '$start' and '$end') GROUP BY payment_history.reservations_id"));
    //             $name=Setting::where('name','hotel_name')->first();
    //             $data['title']=$name->value;
    //             $data['start']=$start;
    //             $data['end']=$end;
    //             return view('excel_view/collectionreportview',$this->data);
    // }
     
     public function ta_report()
     {
        return view('backend/ta_report');   
     }
     
     public function ta_report_action(Request $request)
     { 
         $start=$request->start;
         $end=$request->end;
         
         
         if(!empty($request->tas))
         {     
              $this->data['tas']=DB::table('tas')->where('id',$request->tas)->first();
              $this->data['data_row']=$this->data['data_row']=Reservation::where('tas',$request->tas)->whereBetween('check_in',[$start,$end])->with('orders_items','orders_info')->get();
        
         return view('backend/newinvoice',$this->data);
         }else if(!empty($request->corporates))
         {
             $this->data['corporates']=DB::table('corporates')->where('id',$request->corporates)->first();
              $this->data['data_row']=$this->data['data_row']=Reservation::where('corporates',$request->corporates)->whereBetween('check_in',[$start,$end])->with('orders_items','orders_info')->get();
        
         return view('backend/newinvoice',$this->data);
         }else
         {
             return redirect()->back();
         }
        
     }
     
     public function pending_amount()
     {
         return view('backend/rooms/pending_amount');
     }
     
     public function continueRoomslist() {
        $this->data['list'] = 'continue_rooms_list';
        $this->data['datalist']=Reservation::whereStatus(1)->wherePaymentStatus(0)->whereIsDeleted(0)->whereNull('check_out')->orderBy('created_at','DESC')->distinct('room_num')->get();
        return view('backend/rooms/continue_rooms_list',$this->data);
     }
    
/* ***** End Internal Functions ***** */
    public function addPerforma() {
        
        // $this->data['payment_mode_list']=PaymentMode::select('id', 'payment_mode')->whereStatus(1)->orderBy('id','ASC')->pluck('payment_mode', 'id');
        // $this->data['roles']=$this->getRoleList();
        $this->data['roles']=$this->getRoleList();
        $this->data['roomtypes_list']=RoomType::select('id','title','is_base_price','base_price')->whereStatus(1)->whereIsDeleted(0)->orderBy('title','ASC')->pluck('title','id');
        $this->data['customer_list']=getCustomerList();
        $this->data['corporates']=DB::table('corporates')->pluck('name');
        $this->data['tas']=DB::table('tas')->pluck('name');
        $this->data['ota']=DB::table('ota')->pluck('name');
        $this->data['payment_mode']=DB::table('payment_mode')->get();
        $this->data['package_list']=PackageMaster::select('id','title', 'package_price','room_type_id')->whereStatus(1)->orderBy('id','DESC')->get();
        //return view('backend/rooms/room_arrival_reservation_add_edit',$this->data);
        return view('performainvoice/add_edit_performainvoice',$this->data);
    }
    
    public function editperforma(Request $request){
        $this->data['roles']=$this->getRoleList();
        //$this->data['payment_mode_list']=PaymentMode::select('id', 'payment_mode')->whereStatus(1)->orderBy('id','ASC')->pluck('payment_mode', 'id');
        $this->data['roomtypes_list']=RoomType::select('id','title','is_base_price','base_price')->whereStatus(1)->whereIsDeleted(0)->orderBy('title','ASC')->pluck('title','id');
        $this->data['customer_list']=getCustomerList();
        $this->data['corporates']=DB::table('corporates')->pluck('name');
        $this->data['tas']=DB::table('tas')->pluck('name');
        $this->data['ota']=DB::table('ota')->pluck('name');
        $this->data['payment_mode']=DB::table('payment_mode')->get();
        $this->data['package_list']=PackageMaster::select('id','title', 'package_price','room_type_id')->whereStatus(1)->orderBy('id','DESC')->get();
        
        $this->data['data_row'] = DB::table('performainvoices')->whereId($request->id)->get();
        
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('performainvoice/edit_performainvoice',$this->data);
    }
    
    public function savePerforma(Request $request) {
        //return $request->id;
        date_default_timezone_set("Asia/Kolkata");
                    $validatedData = $request->validate([
                        'name' => 'required',
                        // 'and_number' => 'required'
                    ]);
                    
                    $getmid = Setting::where('name', 'ivid')->select('value')->first();
                    $mid=$getmid->value+1;
                    
                    // $dateOfBirth = dateConvert($request->age, 'Y-m-d');
                    // $years = Carbon::parse($dateOfBirth)->age;
                    
                    $date=$request->check_in_date;
                    $checkoutdate=$request->check_out_date;
                    $time = date("H:i:s");
                    $datetime = $date ." ". $time;
                    $checkoutdatatime = $checkoutdate ." ". $time;
                    Carbon::useStrictMode(false);
                    $to_date = Carbon::parse($checkoutdatatime);
                    $from_date = Carbon::parse($datetime);
                    $answer_in_days = $to_date->diffInDays($from_date);
                    
                    $customerData = [
                        "invoice_id" => $mid,
                        "name" => $request->name,
                        "mobile" => $request->mobile,
                        "title" => $request->title,
                        "check_in" => $datetime,
                        "check_out" => $checkoutdatatime,
                        "duration_of_stay" => $answer_in_days,
                        "payment_mode"=>$request->payment_mode,
                        "room_type_id" => $request->room_type_id,
                        "no_of_rooms" => $request->no_of_rooms,
                        "payment" =>$request->payment,
                        "remarkone" => $request->remarkone,
                        "amountone" => $request->amountone,
                        "remarktwo" => $request->remarktwo,
                        "amounttwo" => $request->amounttwo,
                        "remarkthree" => $request->remarkthree,
                        "amountthree" => $request->amountthree,
                        "remarkfour" => $request->remarkfour,
                        "amountfour" => $request->amountfour,
                        "remarkfive" => $request->remarkfive,
                        "amountfive" => $request->amountfive,
                        "advance" => $request->advance,
                        "advance_date" => $request->advance_date,
                    ];
                    
                    //return $customerData;

                    //$customerId = Performainvoice::insert($customerData);
                    $customerId = DB::table('performainvoices')->insert($customerData);
                    Setting::where('name', 'ivid')->update(['value'=>$mid]);

                    $success = config('constants.FLASH_REC_ADD_1');
                    $error = config('constants.FLASH_REC_ADD_0');
                
                if($customerId){
                    return redirect()->route('list-performa')->with(['success' => $success]);
                }
                return redirect()->back()->with(['error' => $error]);
        }
    
    public function updatePerforma(Request $request) {
        date_default_timezone_set("Asia/Kolkata");
        //return $request;die;
                    $id = $request->id;
                    //return $id;
                    $date = date("Y-m-d", strtotime($request->check_in_date));
                    // print_r($date);
                    //$datetime = $request->check_in_date;
                    $checkoutdate= date("Y-m-d", strtotime($request->check_out_date));
                    $time = date("H:i:s");
                    $datetime = $date ." ". $time;
                    $checkoutdatatime = $checkoutdate ." ". $time;
                    //$checkoutdatatime = $request->check_out_date;
                    //return $checkoutdatatime;
                    Carbon::useStrictMode(false);
                    $to_date = Carbon::parse($checkoutdatatime);
                    $from_date = Carbon::parse($datetime);
                    $answer_in_days = $to_date->diffInDays($from_date);
                    
                    $customerData = [
                        "name" => $request->name,
                        "mobile" => $request->mobile,
                        "title" => $request->title,
                        "check_in" => $datetime,
                        "check_out" => $checkoutdatatime,
                        "duration_of_stay" => $answer_in_days,
                        "payment_mode"=>$request->payment_mode,
                        "room_type_id" => $request->room_type_id,
                        "no_of_rooms" => $request->no_of_rooms,
                        "payment" =>$request->payment,
                        "remarkone" => $request->remarkone,
                        "amountone" => $request->amountone,
                        "remarktwo" => $request->remarktwo,
                        "amounttwo" => $request->amounttwo,
                        "remarkthree" => $request->remarkthree,
                        "amountthree" => $request->amountthree,
                        "remarkfour" => $request->remarkfour,
                        "amountfour" => $request->amountfour,
                        "remarkfive" => $request->remarkfive,
                        "amountfive" => $request->amountfive,
                        "advance" => $request->advance,
                        "advance_date" => $request->advance_date,
                    ];
                    //return $customerData;
                    
        
                $res = DB::table("performainvoices")->where('id',$id)->update($customerData);
                    $success = config('constants.FLASH_REC_ADD_1');
                    $error = config('constants.FLASH_REC_ADD_0');
        
            if($res){
                return redirect()->route('list-performa')->with(['success' => $success]);
            }
            return redirect()->back()->with(['error' => $error]);
    }
    
    public function listPerforma() {
        $this->data['invoicedata']= DB::select("SELECT * FROM `performainvoices`");
        return view('performainvoice/performainvoice_list',$this->data);
    }
    
    public function deletePerforma(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        // $deleteid = DB::table('payment_history')->whereId($request->id)->get('reservations_id');
        // $id = $deleteid[0]->reservations_id;
        //return $deleteid[0]->reservations_id;
        if(DB::table('performainvoices')->where('id','=',$request->id)->delete()){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
    
    public function invoiceperforma(Request $request) {
        //return $request->id;
        $this->data['type'] = $request->type;
        $this->data['data_row'] = DB::table('performainvoices')->where('id','=',$request->id)->get();
        $idnewone =  $this->data['data_row'][0]->room_type_id;
        $this->data['roomtypes_list']=RoomType::select('title')->whereStatus(1)->whereIsDeleted(0)->where('id',$idnewone)->get();
        //dd($this->data['data_row_new']);
        return view('backend/rooms/invoice_performa',$this->data);
    }
    
    public function clicktocallnew(Request $request){
        $mobile = $request->clientnumber;
        // return $mobile;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://app.callerdesk.io/api/click_to_call_v2?calling_party_a=8929901731&calling_party_b=$mobile&deskphone=08069145501&authcode=6e6f92c5650c2c9f768f436c44c8b6a7&call_from_did=1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        if ($err) {
            // echo "cURL Error #:" . $err;
            return redirect()->back()->with(['success' => $err]);
        } else {
            $datanewmy = json_decode($response);
            // print_r($datanewmy);
            if($datanewmy->type = "success"){
                return redirect()->back()->with(['success' => $datanewmy->message]);
            }
        
        }
    }


 


}
