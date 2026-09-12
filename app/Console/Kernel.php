<?php

namespace App\Console;
use App\Models\Customer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    // app/Console/Kernel.php

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $customers = Customer::where('auto_installment_status', 'on')->get();
            foreach ($customers as $customer) {
                $customer->total_will_be_paid += $customer->auto_installment_amount;
                $customer->save();
            }
        })->monthly();
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
