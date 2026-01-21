<p>Hello,</p>

<p>A new service request has been submitted.</p>

<ul>
    <li><strong>Student:</strong> {{ $serviceRequest->student->user->name }}</li>
    <li><strong>Service:</strong> {{ $serviceRequest->serviceType->name }}</li>
    <li><strong>Description:</strong> {{ $serviceRequest->description }}</li>
</ul>

<p>Please log in to process the request.</p>
