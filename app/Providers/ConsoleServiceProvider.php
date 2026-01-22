<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ArchiveOldServiceRequests;

class ConsoleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            ArchiveOldServiceRequests::class,
        ]);
    }

    public function boot()
    {
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('requests:archive-old')->daily();
        });
    }
}

