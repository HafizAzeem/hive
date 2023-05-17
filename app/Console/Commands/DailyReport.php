<?php

namespace App\Console\Commands;
use DB;
use Illuminate\Console\Command;

class DailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:report';

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
            $user_count = DB::table('users')->where('status', '1')->count();
            $noShow = DB::table('arrivals')->where('is_deleted', '1')->where('check_out', '>=', date('y-m-d'))->count();
            $police = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Management')->where('check_in', date('y-m-d'))->count();
            $ta_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'TA')->where('check_in', date('y-m-d'))->count();
            $corporate_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'Corporate')->where('check_in', date('y-m-d'))->count();
            $fit_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'FIT')->where('check_in', date('y-m-d'))->count();
            $ota_count = DB::table('reservations')->where('is_deleted', '0')->where('referred_by_name', 'OTA')->where('check_in', date('y-m-d'))->count();
            $room_count = DB::table('reservations')->where('is_deleted', '0')->where('status', '1')->count();

            $advance_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_cash FROM reservations WHERE payment_mode = 1 and DATE(`check_in`) = CURDATE() "));
            $advance_cash = $advance_cash_payment[0]->advance_cash;

            $due_cash_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_cash FROM reservations WHERE checkout_payment_mode = 1 and DATE(`check_out`) = CURDATE() "));
            $due_cash = $due_cash_payment[0]->due_cash;
            $cash = (is_null($advance_cash) == 1 ? 0 : $advance_cash)+(is_null($due_cash) ? 0 : $due_cash);

            $advance_debit_card_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_debit FROM reservations WHERE  payment_mode = 2 and DATE(`check_in`) = CURDATE() "));
            $advance_debit_card = $advance_debit_card_payment[0]->advance_debit;

            $due_debit_card_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_debit FROM reservations WHERE  checkout_payment_mode = 2 and DATE(`check_out`) = CURDATE() "));
            $due_debit_card = $due_debit_card_payment[0]->due_debit;
            $debit_card = (is_null($advance_debit_card) == 1 ? 0 : $advance_debit_card)+(is_null($due_debit_card) ? 0 : $due_debit_card);
        
            $advance_phone_pay_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_phone_pay FROM reservations WHERE payment_mode = 5 and DATE(`check_in`) = CURDATE() "));
            $advance_phone_pay = $advance_phone_pay_payment[0]->advance_phone_pay;

            $due_phone_pay_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_phone_pay FROM reservations WHERE checkout_payment_mode = 5 and DATE(`check_out`) = CURDATE() "));
            $due_phone_pay = $due_phone_pay_payment[0]->due_phone_pay;

            $phone_pay = (is_null($advance_phone_pay) == 1 ? 0 : $advance_phone_pay)+(is_null($due_phone_pay) ? 0 : $due_phone_pay);

            $advance_upi_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_upi FROM reservations WHERE payment_mode = 6 and DATE(`check_in`) = CURDATE()"));
            $advance_upi = $advance_upi_payment[0]->advance_upi;

            $due_upi_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_upi FROM reservations WHERE checkout_payment_mode = 6 and DATE(`check_out`) = CURDATE()"));
            $due_upi = $due_upi_payment[0]->due_upi;
            $upi = (is_null($advance_upi) == 1 ? 0 : $advance_upi)+(is_null($due_upi) == 1 ? 0 : $due_upi);

            $advance_google_pay_payment = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) AS advance_google_pay FROM reservations WHERE payment_mode = 3 and DATE(`check_in`) = CURDATE() "));
            $advance_google_pay = $advance_google_pay_payment[0]->advance_google_pay; 
            
            $due_google_pay_payment = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) AS due_google_pay FROM reservations WHERE checkout_payment_mode = 3 and DATE(`check_out`) =  CURDATE()"));
            $due_google_pay = $due_google_pay_payment[0]->due_google_pay;

            $google_pay = (is_null($advance_google_pay) == 1 ?  0 : $advance_google_pay) + (is_null($due_google_pay) == 1 ? 0 : $due_google_pay);

            $Continue1 = DB::table('reservations')->where('user_checkout', date('Y-m-d'))->count();
            $comming = DB::table('reservations')->where('user_checkout', "DATE_ADD(CURDATE(), INTERVAL 1 DAY)")->count();
            $occupied_rooms =DB::table('reservations')->where('room_num', '!=', '')->where('check_in', date('Y-m-d'))->count();

            $total_check_ins_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_ins FROM reservations WHERE  DATE(`check_in`) = CURDATE() "));
            $total_check_ins = $total_check_ins_arr[0]->total_check_ins;

            $total_check_out_arr = DB::select(DB::raw("SELECT COUNT(*) as total_check_out FROM reservations WHERE  DATE(`check_out`) = CURDATE() "));
            $total_check_out = $total_check_out_arr[0]->total_check_out;
            
            $total_expense_arr = DB::select(DB::raw("SELECT SUM(amount) AS total_expense FROM expenses WHERE DATE(`created_at`) = CURDATE()"));
            $total_expense_arr = $total_expense_arr[0]->total_expense;
            $total_expense = (is_null($total_expense_arr)== 1 ? 0 : $total_expense_arr);


            $total_checkin_arr = DB::select(DB::raw("SELECT SUM(IFNULL(advance_payment,0)+IFNULL(sec_advance_payment,0)+IFNULL(third_advance_payment,0)+IFNULL(fourth_advance_payment,0)+IFNULL(fifth_advance_payment,0)+IFNULL(sixth_advance_payment,0)) as tot_advanve_payment  FROM reservations WHERE booking_payment and DATE(`check_in`) = CURDATE()"));
            $total_checkin_amount = $total_checkin_arr[0]->tot_advanve_payment;
            
            $total_checkout_arr = DB::select(DB::raw("SELECT SUM(IFNULL(checkout_payment,0)) as tot_payable_payment  FROM reservations WHERE booking_payment and DATE(`check_out`) = CURDATE()"));
            $total_checkout_amount = $total_checkout_arr[0]->tot_payable_payment;
            $total_payments = $total_checkin_amount+$total_checkout_amount;
                 
            DB::table('daily_report')->insert(
                ["date" => date('y-m-d'),"corporate_count"=>$corporate_count,"noShow"=>$noShow,
                "police" =>$police,"ta_count"=>$ta_count,"ota_count"=>$ota_count,
                "fit_count"=>$fit_count,"total_check_outs"=>$total_check_out,"total_check_ins"=>$total_check_ins,
                "occupied_rooms"=>$occupied_rooms,"user_count"=>$user_count,"Continue1"=>$Continue1,
                "comming"=>$comming,"total_payment"=>$total_payments,"cash"=>$cash,"debit_card"=>$debit_card,
                "google_pay"=>$google_pay,"upi"=>$upi,"phone_pay"=>$phone_pay,"advance_payment"=>$total_checkin_amount, "total_expense" => $total_expense, "room_count" => $room_count]);   
                 
    }
}
