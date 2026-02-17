<?php

namespace App\Exports;

use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ServiceRequestsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithCustomCsvSettings
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return ServiceRequest::with(['office', 'serviceType', 'student.user'])
            ->when($this->request->office_id, fn ($q) =>
                $q->where('office_id', $this->request->office_id)
            )
            ->when($this->request->service_type_id, fn ($q) =>
                $q->where('service_type_id', $this->request->service_type_id)
            )
            ->when($this->request->status, fn ($q) =>
                $q->where('status', $this->request->status)
            )
            ->when($this->request->from && $this->request->to, fn ($q) =>
                $q->whereBetween('created_at', [$this->request->from, $this->request->to])
            )
            ->get()
      ->map(function ($r) {

    $studentName = optional($r->student?->user)->name ?? 'Unknown Student';

    return [
        $studentName,
        $r->office->name ?? '-',
        $r->serviceType->name ?? '-',
        $r->status,
        ucfirst($r->priority),
        $r->created_at->format('Y-m-d'), // ✅ NO ##### in Excel
    ];
});
    }

    public function headings(): array
    {
        return [
            'Student',
            'Office',
            'Service',
            'Status',
            'Priority',
            'Date',
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => PHP_EOL,
            'use_bom' => true, // Excel-safe
        ];
    }
}