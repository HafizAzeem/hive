<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\EmailJob;
use App\Jobs\FoodOrderupdate;
use DB;
use Session;
use App\Reservation;
use Mail;
use App\Mail\ReportEmail;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\FoodOrderupdate::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $email=DB::table('emails')->first();
        $time=date('h:i',strtotime($email->time));
        $schedule->job(new EmailJob);
        //  $schedule->call(function () {
        //     return new EmailJob::class;
        // })->everyMinute();
        // $schedule->job(new FoodOrderupdate)->everyMinute();
        // $schedule->command('foodauto:update')->everyMinute();
        // $schedule->exec("wget https://pms.nextpro71.com/foodorderlist")->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
