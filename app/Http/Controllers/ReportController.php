<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
use App\StockHistory;
use App\Reservation;
use App\Order,App\OrderItem,App\OrderHistory;
use App\Product;
use App\Expense,App\ExpenseCategory;
use App\Exports\CheckoutExport;
use App\Exports\ReportExport;
use App\Exports\StockHistoryExport;
use App\Exports\ExpenseExport;
use App\Customerfoodorder;
class ReportController extends Controller
{
    private $core;
    public $data=[];
    public function __construct()
    {
        $this->core=app(\App\Http\Controllers\CoreController::class);
        $this->middleware('auth');
    }

    public function searchCheckins(Request $request) {
        $this->data['list'] = 'check_ins';

         $this->data['datalist']=Reservation::whereStatus(1)->whereIsDeleted(0)->whereNull('check_out')->orderBy('created_at','DESC')->get();
         return view('backend/rooms/room_reservation_list',$this->data);
    }
    public function searchCheckouts(Request $request) {
        $this->data['list'] = 'check_outs';
        $query = Reservation::whereStatus(1)->whereNotNull('check_out')->orderBy('created_at','DESC');

        // if($request->customer_id){
        //     $query->where('customer_id', $request->customer_id);
        // }
        if($request->date_from){
            $query->whereDate('check_out', '>=', dateConvert($request->date_from,'Y-m-d'));
        }
        if($request->date_to){
            $query->whereDate('check_out', '<=', dateConvert($request->date_to,'Y-m-d'));
        }

        if($request->room_type_id){
            $query->where('room_type_id', $request->room_type_id);
        }
        $this->data['datalist']=$query->get();
        $this->data['roomtypes_list']=getRoomTypesList();
         $this->data['customer_list']=getCustomerList();
        $this->data['search_data'] = $request->all();
        if($request->submit_btn=='export'){
            $params=['data'=>$this->data['datalist'],'view'=>'excel_view.checkouts_excel'];
            $filename='check_outs.xlsx';
            return Excel::download(new CheckoutExport($params), $filename);
        } else {
            return view('backend/rooms/room_reservation_list_search',$this->data);
        }

    }
    public function searchReport(Request $request){


        $query = Reservation::whereStatus(1)->whereIsDeleted(0)->orderBy('created_at','DESC');

        if($request->check_id=="Check_in"){

            $this->data['datalist_checkin']=Reservation::whereStatus(1)->whereIsDeleted(0)->whereNull('check_out')->whereDate('check_in', '>=', dateConvert($request->date_from,'Y-m-d'))->orderBy('created_at','DESC')->get();
            $this->data['search_data'] = $request->all();
            if($request->submit_btn=='export'){
                $params=['data'=>$this->data['datalist_checkin'],'view'=>'excel_view.reports_excel'];
                $filename='check_outs.xlsx';
                return Excel::download(new ReportExport($params), $filename);
            }else{
            return view('backend/rooms/room_reservation_report',$this->data);
            }
        }
        if($request->check_id=="show_all"){


            $this->data['datalist_checkin']=Reservation::whereStatus(1)->whereIsDeleted(0)->orderBy('created_at','DESC')->get();
            $this->data['search_data'] = $request->all();
            if($request->submit_btn=='export'){

                $params=['data'=>$this->data['datalist_checkin'],'view'=>'excel_view.reports_excel'];
                $filename='check_outs.xlsx';
                return Excel::download(new ReportExport($params), $filename);
            }else{
            return view('backend/rooms/room_reservation_report',$this->data);
            }
        }
        if($request->check_id=="Check_out"){
            $this->data['datalist_checkin']=Reservation::whereStatus(1)->whereIsDeleted(0)->whereNotNull('check_out')->whereDate('check_out', '<=', dateConvert($request->date_to,'Y-m-d'))->orderBy('created_at','DESC')->get();
            $this->data['search_data'] = $request->all();
            if($request->submit_btn=='export'){
                $params=['data'=>$this->data['datalist_checkin'],'view'=>'excel_view.reports_excel'];
                $filename='check_outs.xlsx';
                return Excel::download(new ReportExport($params), $filename);
            }else{
            return view('backend/rooms/room_reservation_report',$this->data);
            }
        }
        if($request->payment_mode){
            $payment = $request->payment_mode;
            $this->data['datalist_checkin']=Reservation::whereStatus(1)->whereIsDeleted(0)->wherePaymentMode($payment)->orderBy('created_at','DESC')->get();
            $this->data['search_data'] = $request->all();
            if($request->submit_btn=='export'){
                $params=['data'=>$this->data['datalist_checkin'],'view'=>'excel_view.reports_excel'];
                $filename='check_outs.xlsx';
                return Excel::download(new ReportExport($params), $filename);
            }else{
            return view('backend/rooms/room_reservation_report',$this->data);
            }
            // $query->whereDate('check_out', '<=', dateConvert($request->date_to,'Y-m-d'));
        }

        if($request->date_from){
            $query->whereDate('check_in', '>=', dateConvert($request->date_from,'Y-m-d'));
        }
        if($request->date_to){
            $query->whereDate('check_out', '<=', dateConvert($request->date_to,'Y-m-d'));
        }

        $this->data['datalist_checkin']=$query->get();

        $this->data['roomtypes_list']=getRoomTypesList();
        $this->data['customer_list']=getCustomerList();
        $this->data['search_data'] = $request->all();


        if($request->submit_btn=='export'){
            $params=['data'=>$this->data['datalist_checkin'],'view'=>'excel_view.reports_excel'];
            $filename='check_outs.xlsx';
            return Excel::download(new ReportExport($params), $filename);
        } else {
            return view('backend/rooms/room_reservation_report',$this->data);
        }

    }

    public function searchStockHistory(Request $request) {
        $query = StockHistory::orderBy('id','DESC');
        if($request->product_id){
            $query->where('product_id', $request->product_id);
        }
        if($request->date_from){
            $query->whereDate('created_at', '>=', dateConvert($request->date_from,'Y-m-d'));
        }
        if($request->date_to){
            $query->whereDate('created_at', '<=', dateConvert($request->date_to,'Y-m-d'));
        }
        if($request->is_stock){
            $query->where('stock_is', $request->is_stock);
        }
        $this->data['datalist']=$query->get();
        $this->data['products']=Product::where('is_deleted',0)->pluck('name','id');
        $this->data['search_data'] = $request->all();

        if($request->submit_btn=='export'){
            $params=['data'=>$this->data['datalist'],'view'=>'excel_view.stock_history_excel'];
            $filename='stock_history.xlsx';
            return Excel::download(new StockHistoryExport($params), $filename);
        } else {
            return view('backend/stock_history',$this->data);
        }
    }
    public function searchExpense(Request $request) {
        $query = Expense::orderBy('datetime','DESC');
        if($request->category_id){
            $query->where('category_id', $request->category_id);
        }
        if($request->date_from){
            $query->whereDate('datetime', '>=', dateConvert($request->date_from,'Y-m-d'));
        }
        if($request->date_to){
            $query->whereDate('datetime', '<=', dateConvert($request->date_to,'Y-m-d'));
        }
        $this->data['datalist']=$query->get();
        $this->data['category_list']=ExpenseCategory::whereStatus(1)->orderBy('name','ASC')->pluck('name','id');
        $this->data['search_data'] = $request->all();

        if($request->submit_btn=='export'){
            $params=['data'=>$this->data['datalist'],'view'=>'excel_view.expense_excel'];
            $filename='expenses.xlsx';
            return Excel::download(new ExpenseExport($params), $filename);
        } else {
            return view('backend/expenses/list',$this->data);
        }
    }
    public function searchFoodreport(Request $request) {
        $query = Customerfoodorder::where('amount', '!=', "")->where('payment_done', 1)->orderBy('order_date','DESC');
        if($request->category_id == 'ActiveOrders'){
            $query->where('closeorder', 0);
        }else{
            $query->where('closeorder', 1);
        }
        if($request->date_from){
            $query->whereDate('order_date', '>=', dateConvert($request->date_from,'Y-m-d'));
        }
        if($request->date_to){
            $query->whereDate('order_date', '<=', dateConvert($request->date_to,'Y-m-d'));
        }
        $this->data['datalist']=$query->get();
        
        $query = Order::where('total_amount', '!=', "")->orderBy('created_at','DESC');
        // if($request->category_id){
        //     $query->where('category_id', $request->category_id);
        // }
        if($request->category_id == 'ActiveOrders'){
            $query->where('closeorder', 0);
        }else{
            $query->where('closeorder', 1);
        }
        
        if($request->date_from){
            $query->whereDate('created_at', '>=', dateConvert($request->date_from,'Y-m-d'));
        }
        if($request->date_to){
            $query->whereDate('created_at', '<=', dateConvert($request->date_to,'Y-m-d'));
        }
        $this->data['datalist2']=$query->get();
        $cat = array(
                'ActiveOrders' => 'ActiveOrders',
                'ClosedOrders' => 'ClosedOrders'
            );
        $this->data['category_list'] = $cat;
        // $this->data['category_list']=ExpenseCategory::whereStatus(1)->orderBy('name','ASC')->pluck('name','id');
        $this->data['search_data'] = $request->all();

        if($request->submit_btn=='export'){
            $params=['data'=>$this->data['datalist'],'view'=>'excel_view.expense_excel'];
            $filename='expenses.xlsx';
            return Excel::download(new ExpenseExport($params), $filename);
        } else {
            return view('backend/foodsalesreport',$this->data);
        }
    }
    public function searchOrders(Request $request) {
        $query=Order::where('status','!=',4)->orderBy('created_at','DESC');
        if($request->order_type=='roomOrders'){
            $query->whereNotNull('reservation_id');
        } else if($request->order_type=='tableOrders'){
            $query->whereNotNull('table_num');
        }
        if($request->date_from){
            $query->whereDate('created_at', '>=', dateConvert($request->date_from,'Y-m-d'));
        }
        if($request->date_to){
            $query->whereDate('created_at', '<=', dateConvert($request->date_to,'Y-m-d'));
        }

        $this->data['datalist']=$query->get();
        $this->data['search_data'] = $request->all();
        if($request->submit_btn=='export'){
            $params=['data'=>$this->data,'view'=>'excel_view.orders_excel'];
            $this->core->exportFiles($params,'orders');
            return view('excel_view.orders_excel',$this->data);
        } else {
            return view('backend/orders_list',$this->data);
        }
    }
    
    
    function UploadFile(Request $request)
    {
       $value = [];
        if (($open = fopen($request->csv, "r")) !== FALSE)
        {
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE)
            {
                $value[] = $data;
            }
            fclose($open);
        }
    //     echo "<pre>";
    //     print_r($value);
    //  return;
       for($i=0; $i<count($value);$i++)
       {
            date_default_timezone_set("Asia/Kolkata");
            
            $date1 = $value[$i][25];
            $datetime1 = date_create($value[$i][25]); 
            $datetime2 = date_create();
            $interval = date_diff($datetime1, $datetime2);
            
            $customers=[
                "Booking_id" => $value[$i][0],
                "name" => $value[$i][1],
                "email" => $value[$i][23],
                "mobile" => $value[$i][22],
                "address" => $value[$i][26],
                "gender" => $value[$i][24],
                "age" => $interval->format('%y'),
                "dob" => date("Y-m-d", strtotime($value[$i][25])),
                "created_at" => date("Y-m-d", strtotime($value[$i][32]))    
            ];
            
            DB::table("customers")->insert($customers);
            
            $customers_ids = DB::table('customers')->orderBy('id', 'DESC')->take(1)->get();
            $customers_id = $customers_ids[0]->id;
            
            if($value[$i][3] == "Confirm")
            {
                if($value[$i][9] == "")
                {
                    $val = 1;
                }
                else
                {
                    $val = $value[$i][9];
                }
                for($k=1; $k<= $val; $k++)
                {
                    if($value[$i][49] != "")
                    {
                        $payment_ids = DB::table('payment_mode')->where('payment_mode', $value[$i][49])->take(1)->pluck("id");
                        if(count($payment_ids) !=0)
                        {
                            $payment_id = $payment_ids[0];
                        }
                        else
                        {
                            $payment_id = "";
                        }
                    }
                    else
                    {
                        $payment_id = "";
                    }
                    
                    if($value[$i][45] != "")
                    {
                        $room_types_ids = DB::table('room_types')->where('title', $value[$i][45])->take(1)->pluck("id");
                        if(count($room_types_ids) !=0)
                        {
                            $room_types_id = $room_types_ids[0]; 
                        }
                        else
                        {
                             $room_types_id = "";
                        }
                    }
                    else
                    {
                        $room_types_id = "";
                    }
                    
                    if($value[$i][38] != "")
                    {
                        $meal_plans = DB::table('meal_plans')->where('name', $value[$i][38])->take(1)->pluck("id");
                        if(count($meal_plans) !=0)
                        {
                            $meal_plan = $meal_plans[0]; 
                        }
                        else
                        {
                             $meal_plan = "";
                        }
                    }
                    else
                    {
                        $meal_plan = "";
                    }
                    
                    if($value[$i][38] != "")
                    {
                        $packages = DB::table('packages')->where('title', $value[$i][59])->take(1)->pluck("id");
                        if(count($packages) !=0)
                        {
                            $package = $packages[0]; 
                        }
                        else
                        {
                             $package = "";
                        }  
                    }
                    else
                    {
                        $package = "";
                    }
                    
                    if($value[$i][11] !="")
                    {
                        $total = $value[$i][11]/$val;
                    }
                    else
                    {
                        $total = 1;
                    }
                    
                    $reservations=[
                    "customer_id" => $customers_id,
                     "room_type_id" => $room_types_id,
                    "room_types" => $value[$i][46],
                    "booking_changes_count" => $value[$i][47],
                    "Availed_Services_Details" => $value[$i][61],
                    "room_qty" => 1,
                    "per_room_price" => $value[$i][11],
                    "booking_payment" => $total,
                    "check_in" =>date("Y-m-d H:i:s", strtotime($value[$i][32])),
                    "check_out" =>date("Y-m-d H:i:s", strtotime($value[$i][33])),
                    "duration_of_stay" => $value[$i][8],
                    "adult" => $value[$i][34],
                    "kids" => $value[$i][35],
                    "infant" => $value[$i][36],
                    "referred_by" => $value[$i][41],
                    "referred_by_name" => $value[$i][40],
                    "discount" => $value[$i][56],
                    "ota_discount" => $value[$i][58],
                    "payment_mode" => $payment_id,
                    "payment_status" => 1,
                    "Booking_Reason" => $value[$i][4],
                    "meal_plan" => $meal_plan,
                    "status" => 1,
                    "LCO" => $value[$i][14],
                    "LCO_type" => "Amount",
                    "Meals" => $value[$i][15],
                    "Meals_type" => "Amount",
                    "created_at_checkin" => date("Y-m-d H:i:s", strtotime($value[$i][32])),
                    "created_at_checkout" =>date("Y-m-d H:i:s", strtotime($value[$i][33])),
                    "package_id" => $package,
                    "Reconciliation" => $value[$i][2],
                    "Average_duration" => $value[$i][55],
                    "Guest_feedback" => $value[$i][62],
                    "Hotel_rate" => $value[$i][65],
                    "Booking_Device" => $value[$i][67]
                    ];
                    DB::table("reservations")->insert($reservations);
                     if($value[$i][52] != "")
                     {
                        $req = explode(',', $value[$i][52]);
                        foreach($req as $req_data)
                        {
                            $special_requests=[
                                "customer_id" => $customers_id,
                                 "name" => $req_data
                            ];
                            DB::table("special_requests")->insert($special_requests);
                        }
                     }
                } 
                
                // echo "<pre>";
                // print_r($reservations);
                
               
                
                
                
                
                
                
                
                
                
            }
            else if($value[$i][3] == "Cancel"  ||   $value[$i][3] == "On request" )
            {
                
                if($value[$i][45] != "")
                {
                    $room_types_ids = DB::table('room_types')->where('title', $value[$i][45])->take(1)->pluck("id");
                    if(count($room_types_ids) !=0)
                    {
                        $room_types_id = $room_types_ids[0]; 
                    }
                    else
                    {
                         $room_types_id = "";
                    }  
                }
                else
                {
                    $room_types_id = "";
                }
                
                if($value[$i][40] == "corporates")
                {
                    $corporates = $value[$i][41];
                    $tas = "";
                    $ota = "";
                }
                else if($value[$i][40] == "tas")
                {
                    $corporates = "";
                    $tas = $value[$i][41];
                    $ota = "";
                }
                else if($value[$i][40] == "ota")
                {
                    $corporates = "";
                    $tas = "";
                    $ota = $value[$i][41];
                }
                else
                {
                    $corporates = "";
                    $tas = "";
                    $ota = "";
                }
                
                if($value[$i][38] != "")
                {
                    $packages = DB::table('packages')->where('title', $value[$i][59])->take(1)->pluck("id");
                    if(count($room_types_ids) !=0)
                    {
                        $package = $packages[0]; 
                    }
                    else
                    {
                         $package = "";
                    }  
                }
                else
                {
                    $package = "";
                }
                    
                $arrivals=[
                    "customer_id" => $customers_id,
                    "adult" => $value[$i][34],
                    "kids" => $value[$i][35],
                    "infant" => $value[$i][36],
                    "referred_by_name" => $value[$i][40],
                    "check_in" =>date("Y-m-d H:i:s", strtotime($value[$i][6])),
                    "check_out" =>date("Y-m-d H:i:s", strtotime($value[$i][7])),
                    "corporates" =>$corporates,
                    "tas" =>$tas,
                    "ota" =>$ota,
                    "Booking_Reason" => $value[$i][4],
                    "duration_of_stay" => $value[$i][8],
                    "room_type_id" => $room_types_id,
                    "room_qty" =>$value[$i][9],
                    "package_id" => $package
                    ];
                DB::table("arrivals")->insert($arrivals);
            }
       }
       return redirect()->back();
    }
}
