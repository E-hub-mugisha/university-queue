<?php

namespace App\Http\Controllers\Admin;
use Maatwebsite\Excel\Excel as ExcelWriter;
use App\Exports\ServiceRequestsExport;
use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\ServiceRequest;
use App\Models\ServiceType;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceRequest::with(['office', 'serviceType', 'student']);

        if ($request->office_id) {
            $query->where('office_id', $request->office_id);
        }

        if ($request->service_type_id) {
            $query->where('service_type_id', $request->service_type_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->from && $request->to) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $requests = $query->latest()->paginate(20);

        return view('admin.reports.index', [
            'requests' => $requests,
            'offices' => Office::all(),
            'serviceTypes' => ServiceType::all()
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $data = $this->filteredData($request);

        $pdf = Pdf::loadView('admin.reports.pdf', compact('data'));
        return $pdf->download('service-requests-report.pdf');
    }

    public function downloadExcel(Request $request)
{
    return Excel::download(
        new ServiceRequestsExport($request),
        'service-requests-report.xlsx',
        ExcelWriter::XLSX
    );
}

public function downloadCsv(Request $request)
{
    return Excel::download(
        new ServiceRequestsExport($request),
        'service-requests-report.csv',
        ExcelWriter::CSV
    );
}

    private function filteredData(Request $request)
    {
        return ServiceRequest::with(['office', 'serviceType', 'student'])
            ->when($request->office_id, fn($q) => $q->where('office_id', $request->office_id))
            ->when($request->service_type_id, fn($q) => $q->where('service_type_id', $request->service_type_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->from && $request->to, fn($q) =>
                $q->whereBetween('created_at', [$request->from, $request->to])
            )->get();
    }
}
