<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Customerfoodorder;
use App\Reservation;
use Mail;
use App\Mail\ReportEmail;
use DB;
class FoodOrderupdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'foodauto:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Food order update';

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
        $todatorders = Customerfoodorder::where('order_date',date('Y-m-d'))->where('payment_done',1)->get();
        // return $todatorders;
        // return view('backend/new_dashboard',$this->data);
        
    }
}
