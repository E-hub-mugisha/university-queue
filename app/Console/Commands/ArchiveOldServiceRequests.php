<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServiceRequest;
use Carbon\Carbon;

class ArchiveOldServiceRequests extends Command
{
    protected $signature = 'requests:archive-old';
    protected $description = 'Archive resolved or closed service requests older than one month';

    public function handle()
    {
        $count = ServiceRequest::archivable()->update([
            'status' => 'Archived',
            'archived_at' => now(),
        ]);

        $this->info("Archived {$count} resolved/closed service requests.");
    }
}
