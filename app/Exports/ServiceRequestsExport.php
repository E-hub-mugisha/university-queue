<?php

namespace App\Exports;

use App\Models\ServiceRequest;
use Maatwebsite\Excel\Concerns\FromCollection;

class ServiceRequestsExport implements FromCollection
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return ServiceRequest::with(['office', 'serviceType', 'student'])
            ->when($this->request->office_id, fn($q) => $q->where('office_id', $this->request->office_id))
            ->when($this->request->service_type_id, fn($q) => $q->where('service_type_id', $this->request->service_type_id))
            ->when($this->request->status, fn($q) => $q->where('status', $this->request->status))
            ->get()
            ->map(function ($r) {
                return [
                    'Student' => $r->student->name,
                    'Office' => $r->office->name,
                    'Service' => $r->serviceType->name,
                    'Status' => $r->status,
                    'Priority' => $r->priority,
                    'Date' => $r->created_at->format('Y-m-d')
                ];
            });
    }
}
