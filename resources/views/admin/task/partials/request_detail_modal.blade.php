@php
if(isset($request))
{
    $user = \App\Models\User::with('roles')->where('id' , $request->assigned_id)->first();
    $name = $user->name;
    $designation = $user->roles()->first()->name;
}
@endphp
<tr>
    <td>Title</td>
    <td>{{ isset($request->title) ? $request->title : '' }}</td>
</tr>
<tr>
    <td>Description</td>
    <td>{{ isset($request->description) ? $request->description : '' }}</td>
</tr>
<tr>
    <td>Assigned to</td>
    <td>{{ isset($name) ? $name : '' }}</td>
</tr>
<tr>
    <td>Designation</td>
    <td>{{ isset($designation) ? $designation : '' }}</td>
</tr>
<tr>
    <td>Date</td>
    <td>{{ isset($request->date) ? \Carbon\Carbon::parse($request->date)->toFormattedDateString() : '' }}</td>
</tr>
<tr>
    <td>Status</td>
    <td>{{ isset($request->request_status) ? $request->request_status->request_status_name : ''}}</td>
</tr> 


