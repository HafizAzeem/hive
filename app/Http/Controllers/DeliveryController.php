<?php
  
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Foodlist;
use App\FoodCategory,App\FoodItem;
use App\Customerfoodorder;
use App\Deliverytable;
use App\Reservation;
use DB;
// use App\Room,App\RoomType;
  
class DeliveryController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
     
    public function __construct()
    {
        $this->core=app(\App\Http\Controllers\CoreController::class);
        // $this->middleware('auth');
    }
    
    public function deliveryindex()
    {
        // $products  = FoodCategory::with('food_items')->whereStatus(1)->whereIsDeleted(0)->orderBy('name','ASC')->get();
        return view('delivery/deliveryorder');
    }
    
    public function savedeliveryorder(Request $request){
        $delvid = $request->delvid;
        $foodname = $request->foodname;
        $rate = $request->rate;
        $quantity = $request->quantity;
        // return $usermob;
        $product = [
            "child_id" => $delvid,
            "foodname" => $foodname,
            "rate" => $rate,
            "quantity" => $quantity
        ];
        // $data = Deliverytable::updateOrCreate(['child_id'=>$delvid],$product);
        $data = Deliverytable::insert($product);
        return response()->json([
            'datadelivery'=>$data,
        ]);
        
        // if($userotp == $data->otp){
        //     return true;
        // }else{
        //     return false;
        // }
    }
    
    // public function savecustomerdetails(Request $request){
    //     $delvid = $request->delvid;
    //     $foodname = $request->foodname;
    //     $rate = $request->rate;
    //     $quantity = $request->quantity;
    //     // return $usermob;
    //     $product = [
    //         "child_id" => $delvid,
    //         "foodname" => $foodname,
    //         "rate" => $rate,
    //         "quantity" => $quantity
    //     ];
    //     // $data = Deliverytable::updateOrCreate(['child_id'=>$delvid],$product);
    //     $data = Deliverytable::insert($product);
    //     return response()->json([
    //         'datadelivery'=>$data,
    //     ]);
        
    // }
    
    // public function cart()
    // {
    //     return view('cart');
    // }
  
    // public function addToCart($id)
    // {
        
    //     // var roomnumber = $('#roomnumber').val();
    //     $product = Foodlist::findOrFail($id);
          
    //     $cart = session()->get('cart', []);
  
    //     if(isset($cart[$id])) {
    //         $cart[$id]['quantity']++;
    //     } else {
    //         $cart[$id] = [
    //             "name" => $product->name,
    //             "quantity" => 1,
    //             "price" => $product->price,
    //             "image" => $product->food_image,
                
    //         ];
    //     }
          
    //     session()->put('cart', $cart);
    //     return redirect()->back()->with('success', 'Product added to cart successfully!');
    // }
     
    // public function update(Request $request)
    // {
    //     if($request->id && $request->quantity){
    //         $cart = session()->get('cart');
    //         $cart[$request->id]["quantity"] = $request->quantity;
    //         session()->put('cart', $cart);
    //         session()->flash('success', 'Cart updated successfully');
    //     }
    // }
  
    // public function remove(Request $request)
    // {
    //     if($request->id) {
    //         $cart = session()->get('cart');
    //         if(isset($cart[$request->id])) {
    //             unset($cart[$request->id]);
    //             session()->put('cart', $cart);
    //         }
    //         session()->flash('success', 'Product removed successfully');
    //     }
    // }
    
    // public function getmobnumb(Request $request){
    //     $room = $request->roomvalue;
    //     $datalistgetuserdata = Reservation::whereStatus(1)->wherePaymentStatus(0)->whereIsDeleted(0)->whereNull('check_out')->orderBy('created_at','DESC')->distinct('room_num')->where('room_num', $room)->first();
    //     return response()->json([
    //         'userdatafood'=>$datalistgetuserdata,
    //     ]);
        
    // }
    
    // public function mobotpnew(Request $request)
    // {
    //     date_default_timezone_set("Asia/Kolkata");
    //     $mobile = $request->mobile;
    //     $otp = $request->otp;
    //     $fieldsnew = array(
    //         "variables_values" => $otp,
    //         "route" => "otp",
    //         "numbers" => $mobile,
    //     );
        
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //       CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
    //       CURLOPT_RETURNTRANSFER => true,
    //       CURLOPT_ENCODING => "",
    //       CURLOPT_MAXREDIRS => 10,
    //       CURLOPT_TIMEOUT => 30,
    //       CURLOPT_SSL_VERIFYHOST => 0,
    //       CURLOPT_SSL_VERIFYPEER => 0,
    //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //       CURLOPT_CUSTOMREQUEST => "POST",
    //       CURLOPT_POSTFIELDS => json_encode($fieldsnew),
    //       CURLOPT_HTTPHEADER => array(
    //         "authorization: ndP9f2cztvZrow6QS0GHOI8jsmxaFplg7RyDB1VqMeXNK34LkYqxCSzR6w8hgbrk4QDlp91aiYcAjVoT",
    //         "accept: */*",
    //         "cache-control: no-cache",
    //         "content-type: application/json"
    //       ),
    //     ));
        
    //     $response = json_decode(curl_exec($curl));
    //     // return $response;
        
    //     if($response->request_id != ""){
    //         $res = new Customerfoodorder;
    //         $res->mobile = $mobile;
    //         $res->otp = $otp;
    //         $res->save();
    //         return $response->request_id;
    //     }else{
    //         return $response;
    //     }
    //     $err = curl_error($curl);
    //     curl_close($curl);
    //     // return $response->status_code;
    // }
    
    // public function verifyotp(Request $request){
    //     $userotp = $request->enterotp;
    //     $usermob = $request->mobileno;
    //     // return $usermob;
    //     $data = Customerfoodorder::where('mobile',$usermob)->where('otp',$userotp)->first();
    //     if($userotp == $data->otp){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }
    
    // public function RazorThankYou()
    // {
    //     session()->forget('cart');
    //     return view('ordermenu/thankyou');
    // }
    
}