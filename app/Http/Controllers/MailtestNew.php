<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class MailtestNew extends Controller
{
    // public function __construct()
    // {
    //     // $this->core=app(\App\Http\Controllers\CoreController::class);
    //     // $this->middleware('auth');
    // }

    public function index(Request $request) {
        
    //   $info = array(
    //         'name' => "Alex"
    //     );
    //   if(Mail::send(['text' => 'mail'], $info, function ($message)
    //     {
    //         $message->to('jatin.chauhan@corewebconnections.com', 'W3SCHOOLS')
    //             ->subject('Basic test eMail from W3schools.');
    //         $message->from('jatin.chauhan@corewebconnections.com', 'Alex');
            
    //     })){
    //       echo "Successfully sent the email"; 
    //     } else{
            
    //         echo "error";
    //     }
    //     die;


    }


}