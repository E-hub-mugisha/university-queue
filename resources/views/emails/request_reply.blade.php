<p>Hello {{ $request->student->user->name }},</p>

<p>Your service request <strong>{{ $request->request_number }}</strong> has been updated.</p>

<p><strong>Status:</strong> {{ $request->status }}</p>

<p>Please log in to view details.</p>

<p>University Service Desk</p>
