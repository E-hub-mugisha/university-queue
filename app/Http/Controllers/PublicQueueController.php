<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class PublicQueueController extends Controller
{
    public function show(Office $office)
    {
        $current = ServiceRequest::where('office_id', $office->id)
            ->where('status', 'In Review')
            ->whereNull('archived_at')
            ->orderBy('queued_at')
            ->first();

        $next = ServiceRequest::where('office_id', $office->id)
            ->whereIn('status', ['Submitted', 'Awaiting Student Response'])
            ->whereNull('archived_at')
            ->orderByRaw("FIELD(priority, 'urgent', 'normal')")
            ->orderBy('queued_at')
            ->limit(5)
            ->get();

        return view('public.queue-display', compact('office', 'current', 'next'));
    }
}
