<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\Task;
use App\Console\Commands\Power;
use App\Notifications\TaskScheduleNotify;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands=[
        Power::class
    ];
    
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function(){
            $tasks=Task::all();
            foreach ($tasks as $key => $task) {
                $endDate=Carbon::createFromFormat('Y-m-d',$task->endDate);
                if($endDate->isPast()){
                    $task->status="Reject";
                    $task->save();
                    $test['user_id']=$task->user_id;
                     Notification::route('mail',$task->user->email)->notify(new TaskScheduleNotify($test));
                }
            }
        })->everyMinute();
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
