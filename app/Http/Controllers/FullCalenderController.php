<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Callenderevent;
use DB;
  
class FullCalenderController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {
        //return $request;
        // date('Y-m-d')
  
        if($request->ajax()) {
            
            $event = Callenderevent::whereDate('check_in', '>=', date('Y-m-d'))->get(['id', 'customer_id', 'duration_of_stay', 'room_qty','payment', 'check_in', 'check_out','bookingstatus','paymenttype']);
            $data = [];
            foreach($event as $row){
                
                $data[] = [
                    'id' => $row->id,
                    'customer_id' => $row->customer_id,
                    'duration_of_stay' => $row->duration_of_stay,
                    'room_qty' => $row->room_qty,
                    'payment' => $row->payment,
                    'start' => date(DATE_ISO8601,strtotime($row->check_in)),
                    'end' => date(DATE_ISO8601,strtotime($row->check_out)),
                    'bookingstatus' => $row->bookingstatus,
                    'paymenttype' => $row->paymenttype
                ];
            }
                    //     $data = Callenderevent::whereDate('chek_in', '>=', date('Y-m-d'))
                    //   ->whereDate('chek_out',   '<=', date('Y-m-d',$request->end))
                    //   ->get(['id', 'customer_id', 'duration_of_stay', 'room_qty','payment', 'chek_in', 'chek_out','bookingstatus','paymenttype']);
            //print_r($data);
             return response()->json($data);
            // return response()->JSON.parse(data); 
        }
  
        return view('fullcalender');
    }
 
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ajax(Request $request)
    {
        $date = $request->eventdatemain;
        
        // $event = DB::select(DB::raw("SELECT id,customer_id,referred_by_name,check_in,check_out,DATEDIFF(date(check_out), date(check_in)) as duration_of_stay,room_qty,payment,paymenttype,bookingstatus FROM arrivals WHERE date(check_in) = '$date' "));
        $event = DB::select(DB::raw("SELECT arrivals.id,customer_id,referred_by_name,check_in,check_out,DATEDIFF(date(check_out), date(check_in)) as duration_of_stay,room_qty,payment,paymenttype,bookingstatus,customers.name,customers.mobile,customers.email FROM arrivals INNER JOIN customers ON arrivals.customer_id = customers.id WHERE date(check_in) = '$date'"));
        // $event = Callenderevent::whereDate('check_in',$date)->get(['id', 'customer_id', 'duration_of_stay', 'room_qty','payment', 'check_in', 'check_out','bookingstatus','paymenttype']);
        return response()->json($event);
        // print_r($request);
        // switch ($request->type) {
        //   case 'add':
        //       $event = Event::create([
        //           'title' => $request->title,
        //           'start' => $request->start,
        //           'end' => $request->end,
        //       ]);
 
        //       return response()->json($event);
        //      break;
  
        //   case 'update':
        //       $event = Event::find($request->id)->update([
        //           'title' => $request->title,
        //           'start' => $request->start,
        //           'end' => $request->end,
        //       ]);
 
        //       return response()->json($event);
        //      break;
  
        //   case 'delete':
        //       $event = Event::find($request->id)->delete();
  
        //       return response()->json($event);
        //      break;
             
        //   default:
        //      # code...
        //      break;
        // }
    }
}