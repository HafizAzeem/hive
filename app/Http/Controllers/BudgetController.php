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

class BudgetController extends Controller
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
    
    public function addbudget() {
        return view('budget/budgetforecast');
    }
    public function listbudget() {
        $this->data['datalist']= DB::select("SELECT * FROM `estimatebudgets`");
        $this->data['tags']= DB::select("SELECT * FROM `alltags`");
        return view('budget/budgetforecast_list',$this->data);
    }
    public function deletebudget(Request $request) {
        if($this->core->checkWebPortal()==0){
            return redirect()->back()->with(['info' => config('constants.FLASH_NOT_ALLOW_FOR_DEMO')]);
        }
        
        if(DB::table('estimatebudgets')->whereId($request->id)->delete()){
            return redirect()->back()->with(['success' => config('constants.FLASH_REC_DELETE_1')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_REC_DELETE_0')]);
    }
    public function savebudget(Request $request) {
        // $tilldate = $request->tilldate;
        // $tilldate = $tilldate.'-01';
        // print_r($tilldate);
        // return $request;
        //return $request->estimation;
        $settings = DB::select("SELECT * FROM `settings`");
        $title =  $settings[2]->value ?? '';
        $address =  $settings[8]->value ?? '';
        $estimation = $request->estimation;
        $tilldate = $request->tilldate;
        $tilldate = $tilldate.'-01';
        
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
        
        $res = DB::table("estimatebudgets")->insert(['title' => $title, 'location' => $address,  'budgetestimate' => $estimation, 'tilldate' =>$tilldate ]);
        
        if($res){
            return redirect()->route('list-budget')->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    public function updatebudget(Request $request) {
        // return $request;
        $id = $request->id;
        $budget = $request->budgetestimate;
        $tilldate = $request->tilldate;
        $tilldate = $tilldate.'-01';
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
        
        $res = DB::table("estimatebudgets")->where("id", $id)->update(["budgetestimate" => $budget, "tilldate" => $tilldate]);
        
        if($res){
            return redirect()->route('list-budget')->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    public function editbudget(Request $request){
        $this->data['data_row'] = DB::table('estimatebudgets')->whereId($request->id)->get();
        if(!$this->data['data_row']){
            return redirect()->back()->with(['error' => config('constants.FLASH_REC_NOT_FOUND')]);
        }
        return view('budget/edit_budget',$this->data);
    }
    public function budgetchart(){
        
        $urlnew = array();
        $budget = array();
        $actualmr = array();
        $today = array();
        $arrReturn = array();
        
        // $start = date('Y-m-01');
        // $end = date('Y-m-d');
        // $this->data['datalist']= DB::select("SELECT * FROM `estimatebudgets`");
        // $revenue = DB::select("SELECT sum(payment_history.payment) as total FROM reservations inner join payment_history on payment_history.reservations_id=reservations.id and payment_history.payment_date between '$start' and '$end'");
        // $data1= DB::select("SELECT sum(payment) as total FROM payment_history where extra_revenue = 'er' and date(payment_date) between '$start' and '$end' ");
        // $data2= DB::select("SELECT sum(payment) as total FROM payment_history where extra_revenue = 'break' and date(payment_date) between '$start' and '$end' ");
        // $datanew = $data1[0]->total + $revenue[0]->total - $data2[0]->total;
        // $this->data['actualmr'] = $datanew ?? 0;
        // $this->data['today'] = date('d');
        // $this->data['average'] = round($this->data['actualmr']/$this->data['today']);
        // $this->data['DaysInCurrentMonth'] = date('t');
        // $this->data['forecast'] = round($this->data['average'] * $this->data['DaysInCurrentMonth']);
        
        $budget = DB::select("SELECT * FROM `estimatebudgets`");
        foreach($budget as $budgetvar){
            $start = date('Y-m-01', strtotime($budgetvar->tilldate));
            $currentMonth = date('m',strtotime($start));
            $currentYear = date('Y',strtotime($start));
            $end = date('Y-m-t', strtotime($budgetvar->tilldate));
            $DaysInCurrentMonth = date('t',strtotime($end));
            
            if(date('m')==$currentMonth){
                $todaynew = date('d') ;
            }else{
                $todaynew = $DaysInCurrentMonth;
            }
            
            $budget = DB::select("select * from estimatebudgets where MONTH(tilldate) = '".$currentMonth."' and YEAR(tilldate) = '".$currentYear."' ");
            $revenue = DB::select("SELECT sum(payment_history.payment) as total FROM reservations inner join payment_history on payment_history.reservations_id=reservations.id and payment_history.payment_date between '$start' and '$end'");
            $data1= DB::select("SELECT sum(payment) as total FROM payment_history where extra_revenue = 'er' and date(payment_date) between '$start' and '$end' ");
            $data2= DB::select("SELECT sum(payment) as total FROM payment_history where extra_revenue = 'break' and date(payment_date) between '$start' and '$end' ");
            $advance_pay= DB::select("SELECT sum(advance) as total_advance from arrivals where referred_by_name = 'F9' and date(created_at) between '$start' and '$end' ");
            $datanew = $data1[0]->total + $revenue[0]->total - $data2[0]->total + $advance_pay[0]->total_advance;
            $actualmr = $datanew ?? 0;
            array_push($arrReturn,array('budget'=>$budget,'actualmr'=>$actualmr,'DaysInCurrentMonth'=>$DaysInCurrentMonth,'today'=>$todaynew));
        }
        return view('budget/budget_chart',compact('start','end','arrReturn'));
    }
    
    // public function budgetforecast(Request $request)
    // {
    //     $i=1;
    //     $value=DB::table('estimatebudgets')->get();
    //     $array = array();
    //     $co = array();
    //     foreach($value as $item){
    //         $param['database']=$item->db_name;
    //         $param['username']=$item->user;
    //         $param['password']=$item->password;
    //         $param['hostname']=$item->host;
    //         $param['number']=$i++;
    //         $connection = DatabaseConnection::setConnection($param);
    
    //         $id = $item->id;
    //         $title = $item->title;
    //         $location = $item->location;
    //         $budgetestimate = $item->budgetestimate;
    //         $tilldate = $item->tilldate;
            
    //         array_push($co,array('id'=> $id,'title'=>$title,'location'=>$location,'budgetestimate'=>$budgetestimate,'tilldate'=>$tilldate,'connection'=>$connection));
    //         DatabaseConnection::close($param);
    //     }
    //     return view('budget.budgetforecast',compact('array','id','title','location','budgetestimate','tilldate','connection','co'));
    // }
    
    // public function budgetupdate(Request $request)
    // {
    //     $data = $request->all();
    //     $gth = count($data['idall']);
    //     if(!empty($data['estimation']))
    //     {
    //         for($i=0;$i<$gth;$i++)
    //         {
    //             DB::table('estimatebudgets')->where('id',$data['idall'][$i])->update(['budgetestimate' => $data['estimation'][$i]]);
    //         }
    //     }
    //     return redirect()->back();
    //  }
    
    public function savetags(Request $request) {
        $tgs = $request->tagsnew;
        $tagsall = explode(" ",$tgs);
        $dbid = Setting::where('name', 'dbid')->select('value')->first();
        $dbmainid =  $dbid->value;
        
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
        
        $res = DB::table("alltags")->updateOrInsert(['id'=>$dbmainid],["tags" => $tgs]);
        
        if($res){
            return redirect()->route('list-budget')->with(['success' => $success]);
        }
        return redirect()->back()->with(['error' => $error]);
    }
    
}
