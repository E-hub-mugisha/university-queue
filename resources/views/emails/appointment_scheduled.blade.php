<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Appointment Scheduled</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f8f9fa; padding:20px;">

    <div style="max-width:600px; margin:auto; background:#ffffff; padding:20px; border-radius:6px;">

        <h2 style="color:#435ebe;">Appointment Scheduled</h2>

        <p>Hello <strong>{{ $serviceRequest->student->user->name }}</strong>,</p>

        <p>
            Your service request
            <strong>#{{ $serviceRequest->request_number }}</strong>
            has been scheduled for a physical appointment.
        </p>

        <hr>

        <p><strong>Date:</strong> {{ $serviceRequest->appointment->appointment_date }}</p>
        <p><strong>Time:</strong> {{ $serviceRequest->appointment->appointment_time }}</p>
        <p><strong>Location:</strong> {{ $serviceRequest->appointment->location ?? 'To be communicated' }}</p>

        <hr>

        <p>Please arrive at least <strong>10 minutes early</strong> and bring any required documents.</p>

        <p>
            If you are unable to attend, kindly reschedule through the system.
        </p>

        <p style="margin-top:30px;">
            Regards,<br>
            <strong>{{ config('app.name') }}</strong>
        </p>

    </div>

</body>

</html>