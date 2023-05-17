<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
     public function roomlight(Request $request)
    {
        // print_r('hello');die;
         $hotels=DB::table('show_hotel')->select('*')->get();
          $room_no=DB::table('rooms')->select('*')->get();
        //  print_r($hotels);die;
        return view('room_light',compact('hotels','room_no'));
        // print_r('hello');die;
    }
    
    public function roomlight_action(Request $request)
    {
        // print_r('hello');die;
       
         $insert['room_no']=$request->room_no;
        $insert['light_on']=$request->oncode;
        $insert['light_off']=$request->offcode;
        
        $insert['ac_on']=$request->event_onac;
        $insert['ac_off']=$request->event_offac;
        $insert['bathroom_on']=$request->event_on_bathroom;
        $insert['bathroom_off']=$request->event_off_bathroom;
        $insert['tv_on']=$request->event_on_tv;
        $insert['tv_off']=$request->event_off_tv;
        $insert['table_lamp_on']=$request->event_on_lamp;
        $insert['table_lamp_off']=$request->event_off_lamp;
        // $insert['valid']=$request->valid;
        // print_r('hello');die;
        $res=DB::table('hotels_room_light')->insert($insert);
        if($res)
        {
            return response()->json(['status'=>'success','message'=>'Coupon Code Created']);
        }else
        {
            return response()->json(['status'=>'error','message'=>'Error !']);
        }
    }
    
       public function get_detail()
    {
        $res=DB::table('hotels_room_light')->get();
        $i=1;
        foreach($res as $v)
        {
            echo "<tr>
            <td>".$i++."</td>
           
            <td>".$v->room_no."</td>
            
            <td>".$v->light_on."</td>
            <td>".$v->light_off."</td>
            
             <td>".$v->ac_on."</td>
            <td>".$v->ac_off."</td>
             <td>".$v->bathroom_on."</td>
            <td>".$v->bathroom_off."</td>
             <td>".$v->tv_on."</td>
            <td>".$v->tv_off."</td>
             <td>".$v->table_lamp_on."</td>
            <td>".$v->table_lamp_off."</td>
            
            <td><button class='btn btn-danger' onClick='deleteCoupon(".$v->id.")'>Delete</td>
            </tr>";
        }
    }
     public function deleteCoupon(Request $request)
    {
        // print_r('hello');
        $id=$request->id;
        if(DB::table('hotels_room_light')->where('id',$id)->delete())
        {
           return response()->json(['status'=>'success','message'=>'Coupon Code Deleted']); 
        }else
        {
            return response()->json(['status'=>'error','message'=>'Error !']); 
        }
    }
    
}
