<p>Hello {{ $serviceRequest->student->user->name }},</p>

<p>Your service request has been successfully submitted.</p>

<ul>
    <li><strong>Office:</strong> {{ $serviceRequest->office->name }}</li>
    <li><strong>Service:</strong> {{ $serviceRequest->serviceType->name }}</li>
    <li><strong>Status:</strong> {{ $serviceRequest->status }}</li>
</ul>

@if(strtolower($serviceRequest->office->name) === 'student affairs')
<p style="margin-top:10px; color:#b45309;">
    <strong>Important Notice:</strong><br>
    The <strong>Student Affairs Office</strong> attends to requests
    <strong>only on Tuesdays and Thursdays</strong>.
    Please plan accordingly.
</p>
@endif

<p>We will notify you once it is processed.</p>

<p>Thank you.</p>