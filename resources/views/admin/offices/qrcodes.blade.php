@extends('layouts.app')

@section('title', 'Office QR Codes')

@section('content')
<div class="container py-4">

    <!-- Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h3 class="mb-3 mb-md-0">Office QR Codes</h3>
        <div class="btn-group">
            <a href="{{ route('admin.offices.qrcodes.downloadAllPdf') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-pdf"></i> Download PDF
            </a>
            <a href="{{ route('admin.offices.qrcodes.downloadAllSvgZip') }}" class="btn btn-info">
                <i class="bi bi-archive"></i> Download All SVGs
            </a>
        </div>
    </div>

    <!-- QR Codes Table -->
    <div class="card card-bordered card-preview">
        <div class="card-inner">
        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist"
                            data-auto-responsive="true">
            <thead>
                <tr class="nk-tb-item nk-tb-head">
                    <th class="nk-tb-col">#</th>
                    <th class="nk-tb-col">Office</th>
                    <th class="nk-tb-col">QR Code</th>
                    <th class="nk-tb-col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($offices as $index => $office)
                <tr class="nk-tb-item">
                    <td class="nk-tb-col">{{ $index + 1 }}</td>
                    <td class="nk-tb-col">{{ $office->name }}</td>
                    <td class="nk-tb-col">{!! $office->qrCode !!}</td>
                    <td class="nk-tb-col">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.offices.qrcodes.download', $office->id) }}" class="btn btn-sm btn-success">
                                <i class="bi bi-download"></i>Download
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
    function printQRCode(officeName, qrCodeHtml) {
        const myWindow = window.open('', 'Print QR Code', 'width=400,height=500');
        myWindow.document.write(`
        <html>
        <head><title>${officeName}</title></head>
        <body style="text-align:center; font-family: Arial, sans-serif;">
            <h3>${officeName}</h3>
            ${qrCodeHtml}
        </body>
        </html>
    `);
        myWindow.document.close();
        myWindow.focus();
        myWindow.print();
        myWindow.close();
    }
</script>

@endsection