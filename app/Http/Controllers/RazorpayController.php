<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Redirect,Response;
use App\Customerfoodorder;
class RazorpayController extends Controller
{
    public function razorpay()
    {        
        return view('index');
    }

    public function payment(Request $request)
    {        
        
        date_default_timezone_set("Asia/Kolkata");
        $input = $request->all();
        //return $input;
        $res_id = rand(0000000,9999999);
        
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        
        if(count($input)  && !empty($input['razorpay_payment_id'])) 
        {
            try 
            {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                
                $mobnum = $input['mobileno'];
                $enterotp = $input['enterotp'];
             
                $arrayall = [
                    'name' => $input['allfoodname'],
                    'quantity' => $input['foodquantity'],
                    'unitprice' => $input['unitprice'],
                    'roomnumber' => $input['roomnumber'],
                    'order_id' => $res_id,
                    'discount' => $input['discount'],
                    'amount' => $input['amount'],
                    'payment_id' => $input['razorpay_payment_id'],
                    'payment_done' => 1,
                    'order_date' => date("Y-m-d")
                ];
                
                $dataupdate = Customerfoodorder::where(['mobile'=>$mobnum,'otp'=>$enterotp])->update($arrayall);
                if($dataupdate == 1){
                    session()->forget('cart');
                    // return $roomforextra;
                }
                
                $fields = array(
                    "message" => "Thank you for your Order. Your order id is '".$res_id."' and you ordered '".$input['allfoodname']."' ",
                    "language" => "english",
                    "route" => "q",
                    "numbers" => $mobnum,
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
                  CURLOPT_POSTFIELDS => json_encode($fields),
                  CURLOPT_HTTPHEADER => array(
                    "authorization: ndP9f2cztvZrow6QS0GHOI8jsmxaFplg7RyDB1VqMeXNK34LkYqxCSzR6w8hgbrk4QDlp91aiYcAjVoT",
                    "accept: */*",
                    "cache-control: no-cache",
                    "content-type: application/json"
                  ),
                ));
        
                $response = json_decode(curl_exec($curl));
                $err = curl_error($curl);
                curl_close($curl);
                
            } 
            catch (\Exception $e) 
            {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }            
        }
        
        return redirect()->back();
        
    }
    
    
    
}
