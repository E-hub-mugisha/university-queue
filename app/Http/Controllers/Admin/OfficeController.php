<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ZipArchive;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::with('staff')->get();

        return view('admin.offices.index', compact('offices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:offices,name',
            'description' => 'nullable|string',
        ]);

        Office::create($request->only('name', 'description'));

        return redirect()->back()->with('success', 'Office created successfully.');
    }

    public function update(Request $request, Office $office)
    {
        $request->validate([
            'name' => 'required|unique:offices,name,' . $office->id,
            'description' => 'nullable|string',
        ]);

        $office->update($request->only('name', 'description'));
        return redirect()->back()->with('success', 'Office updated successfully.');
    }

    public function destroy(Office $office)
    {
        $office->delete();
        return redirect()->back()->with('success', 'Office deleted successfully.');
    }

    public function qrCodes()
    {
        // Get all offices
        $offices = Office::all();

        // Prepare QR codes
        $offices->map(function ($office) {
            // Generate route to service request form filtered by office
            $url = route('student.requests.create', ['office_id' => $office->id]);
            $office->qrCode = QrCode::size(200)->generate($url);
            $office->url = $url;
            return $office;
        });

        return view('admin.offices.qrcodes', compact('offices'));
    }

    // Download QR code as svg
    public function download(Office $office)
    {
        $url = route('student.requests.create', ['office_id' => $office->id]);
        $fileName = $office->name . '-QR.svg';

        $svg = QrCode::format('svg')->size(300)->generate($url);

        return response($svg)
            ->header('Content-Type', 'image/svg')
            ->header('Content-Disposition', "attachment; filename={$fileName}");
    }

    public function downloadAllPdf()
    {
        $offices = Office::all();

        foreach ($offices as $office) {
            $office->url = route('student.requests.create', ['office_id' => $office->id]);
            $office->qrCode = QrCode::size(200)->generate($office->url);
        }

        $pdf = Pdf::loadView('admin.offices.qrcodes-pdf', compact('offices'))
            ->setPaper('a4', 'portrait'); // Optional: set page size and orientation

        return $pdf->download('All-Office-QR-Codes.pdf');
    }

    public function downloadAllSvgZip()
    {
        $offices = Office::all();
        $zipFileName = 'All-Office-QR-Codes.zip';
        $zip = new ZipArchive;

        $tmpFile = tempnam(sys_get_temp_dir(), 'qrzip');

        if ($zip->open($tmpFile, ZipArchive::CREATE) === TRUE) {
            foreach ($offices as $office) {
                $url = route('student.requests.create', ['office_id' => $office->id]);
                $svg = QrCode::format('svg')->size(300)->generate($url);
                $fileName = $office->name . '-QR.svg';
                $zip->addFromString($fileName, $svg);
            }

            $zip->close();
        }

        return response()->download($tmpFile, $zipFileName)->deleteFileAfterSend(true);
    }
}
