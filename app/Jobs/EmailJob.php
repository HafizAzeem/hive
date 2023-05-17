<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Reservation;
use Mail;
use App\Mail\ReportEmail;
use DB;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
     $this->data['datalist']=DB::select(DB::raw("SELECT             
                (SELECT COUNT(*) FROM users WHERE status = 1) as user_count,
                (SELECT COUNT(*) FROM reservations WHERE referred_by_name = 'TA' and DATE(`check_in`) = CURDATE()) as ta_count,
                (SELECT COUNT(*) FROM reservations WHERE referred_by_name = 'Corporate' and DATE(`check_in`) = CURDATE()) as corporate_count,
                (SELECT COUNT(*) FROM reservations WHERE referred_by_name = 'FIT' and DATE(`check_in`) = CURDATE()) as fit_count,
                (SELECT COUNT(*) FROM reservations WHERE referred_by_name = 'OTA' and DATE(`check_in`) = CURDATE()) as ota_count,
                (SELECT COUNT(*) FROM rooms WHERE status = 1) as room_count,
                (SELECT COUNT(*) FROM reservations WHERE  room_num and DATE(`check_in`) = CURDATE()) as occupied_rooms,
                (SELECT COUNT(*) FROM reservations WHERE  DATE(`check_in`) = CURDATE()) as total_check_ins,
                (SELECT COUNT(*) FROM reservations WHERE  DATE(`check_out`) = CURDATE()) as total_check_outs,
                (SELECT COUNT(*) FROM reservations WHERE booking_payment and DATE(`check_in`) = CURDATE()) as total_payment" )        
                );
        $emails=DB::table('emails')->pluck('email');
        foreach ($emails as $key => $email) {
            return Mail::to($email)->send(new ReportEmail($this->data));
        }
     
   
    }
    
}