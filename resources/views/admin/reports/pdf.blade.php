<h3>Service Requests Report</h3>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Student</th>
            <th>Office</th>
            <th>Service</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $r)
        <tr>
            <td>{{ $r->student->user->name }}</td>
            <td>{{ $r->office->name }}</td>
            <td>{{ $r->serviceType->name }}</td>
            <td>{{ $r->status }}</td>
            <td>{{ $r->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
