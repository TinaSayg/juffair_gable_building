<tr>
    <td>Title</td>
    <td>{{ isset($complaint->complain_title) ? $complaint->complain_title: '' }}</td>
</tr>
<tr>
    <td>Description</td>
    <td>{{ isset($complaint->complain_description) ? $complaint->complain_description: '' }}</td>
</tr>
<tr>
    <td>Posted By</td>
    <td>{{ \Auth::user()->name }}</td>
</tr>
<tr>
    <td>Complaint Date</td>
    <td>{{ isset($complaint->complain_date) ? \Carbon\Carbon::parse($complaint->complain_date)->toFormattedDateString() : '' }}</td>
</tr>
<tr>
    <td>Status</td>
    <td>{{ isset($complaint->complain_status) ? $complaint->complain_status->complain_status_name : '' }}</td>
</tr>

<tr>
    <td colspan="2"><h5>Complain Person Details</h5></td>
</tr>

@php
    $user = \App\Models\User::where('id', $complaint->complain_person_id)->first();
@endphp

<tr>
    <td>Name</td>
    <td>{{ isset($user) ? $user->name : '' }}</td>
</tr>

<tr>
    <td>Email Address</td>
    <td>{{ isset($user) ? $user->email  : '' }}</td>
</tr>

<tr>
    <td>Mobile Phone</td>
    <td>{{ isset($user) ? $user->number  : '' }}</td>
</tr>

<tr>
    <td colspan="2"><h5>Solution</h5></td>
</tr>

<tr>
    <td colspan="2">{{isset($complaint->complain_solution) ? $complaint->complain_solution->solution : ''}}</td>
</tr>