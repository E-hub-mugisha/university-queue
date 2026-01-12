<!DOCTYPE html>
<html>

<head>
    <title>All Office QR Codes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .qr-container {
            width: 50%;
            /* 2 per row */
            float: left;
            text-align: center;
            padding: 10px;
            box-sizing: border-box;
            page-break-inside: avoid;
        }

        .qr-container h5 {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .qr-container svg {
            width: 150px;
            height: 150px;
        }

        @media print {
            .qr-container {
                width: 50%;
            }
        }
    </style>
</head>

<body>
    @foreach($offices as $office)
    <div class="qr-container">
        <h5>{{ $office->name }}</h5>
        {!! $office->qrCode !!}
    </div>
    @endforeach
</body>

</html>