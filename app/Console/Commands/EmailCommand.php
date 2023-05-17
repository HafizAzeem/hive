<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Reservation;
use Mail;
use App\Mail\ReportEmail;
use DB;
class EmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:bulk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dd("jj");
         $email=DB::table('emails')->first();
        $time=date('h:i',strtotime($email->time));
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
                     dump($email);
                      Mail::to($email)->send(new ReportEmail($this->data));
        }
    }
}
