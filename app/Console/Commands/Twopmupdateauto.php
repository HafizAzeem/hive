<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Reservation;
use Mail;
use App\Mail\ReportEmail;
use DB;
class Twopmupdateauto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twopmauto:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Two PM Auto update duration';

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
        $testtwopmupdate = DB::select(DB::raw("SELECT id as jidnew,user_checkout as uc,check_in,duration_of_stay,DATEDIFF(CURDATE(), date(check_in)) as df FROM reservations WHERE check_out IS NULL and is_deleted='0' and status='1' and room_num != '' and user_checkout < CURRENT_DATE"));
        foreach($testtwopmupdate as $dttwopm){
            $datatwopm = DB::select(DB::raw("UPDATE reservations SET user_checkout = CURDATE(), duration_of_stay = '$dttwopm->df' WHERE id = '$dttwopm->jidnew'"));
        }
        
    }
}
