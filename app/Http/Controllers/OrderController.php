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
use DataTables;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->core=app(\App\Http\Controllers\CoreController::class);
        $this->middleware('auth');
    }
    
    public function menu(){
        $this->data['datalist'] = Room::whereStatus(1)->whereIsDeleted(0)->orderBy('room_no','ASC')->get();
        $this->data['category_list'] = FoodCategory::with('food_items')->whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
        // $this->data['category'] = FoodCategory::whereId($request->id)->first();
        // return $this->data['category_list'];
        return view('ordermenu/menu',$this->data);
    }
    
    public function RazorThankYou()
    {
       return view('ordermenu/thankyou');
    }
}