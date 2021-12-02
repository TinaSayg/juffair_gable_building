@php
$staff_id = $employeeleave->staff_id;
$employee_name = \App\Models\User::where('id', $staff_id)->first()->name;
@endphp
<tr>
    <td>Employee Name</td>
    <td>{{ isset($employee_name) ? $employee_name : '' }}</td>
</tr>
@php
    $email = \App\Models\User::where('id', $employeeleave->staff_id)->first()->email;
    $employee_detail = \App\Models\Employee::where('employee_email_address', $email)->first();

    $employee_contract_start_date = \Illuminate\Support\Carbon::parse($employee_detail->employee_start_datetime);
    $employee_contract_end_date = Illuminate\Support\Carbon::parse($employee_detail->employee_end_datetime);
    $annual_leaves = $employee_detail->annual_leaves;
    
    //leave taken contract years
    $leave_contract_years = Illuminate\Support\Carbon::parse($employee_contract_start_date)->format('Y'). '-'. Illuminate\Support\Carbon::parse($employee_contract_end_date)->format('Y');
    $leaves_taken = 0;
    $leaves = \App\Models\EmployeeLeaves::where('staff_id', $employeeleave->staff_id)->where('leaves_taken_year', $leave_contract_years)->pluck('leaves_taken');
    
    if($leaves->count() > 0)
    {
        $leaves_taken = array_sum($leaves->toArray());
    }
    
@endphp
<tr>
    <td>Leaves Taken</td>
    <td>{{ $leaves_taken }}</td>
</tr>
<tr>
    <td>Remaining Earned Leaves</td>
    <td>{{ $annual_leaves-$leaves_taken }}</td>
</tr>
<tr>
    <td>Leave Start Date</td>
    <td>{{ isset($employeeleave->leave_start_date) ? \Carbon\Carbon::parse($employeeleave->leave_start_date)->toFormattedDateString() : '' }}</td>
</tr>
<tr>
    <td>Leave End Date</td>
    <td>{{ isset($employeeleave->leave_end_date) ? \Carbon\Carbon::parse($employeeleave->leave_end_date)->toFormattedDateString() : '' }}</td>
</tr>
<tr>
    <td>Apply Date</td>
    <td>{{ isset($employeeleave->apply_date) ? \Carbon\Carbon::parse($employeeleave->apply_date)->toFormattedDateString() : '' }}</td>
</tr>
<tr>
    <td>Leave Type</td>
    <td>{{ isset($employeeleave->leave_types) ? $employeeleave->leave_types->leave_type_name : '' }}</td>
</tr>

@if($employeeleave->leave_type_code == 1)
<tr>
    <td>Medical Certificate</td>
    <td><a href="{{ url('public/admin/assets/img/documents') }}/{{ isset($employeeleave->leave_document)? $employeeleave->leave_document : '' }}" target="blank">view</a></td>
</tr>
@endif

<tr>
    <td>Leave Status</td>
    <td>
        @php
        $class = '';
        switch ($employeeleave->leave_status_code) {
          case 1:
            $class = 'badge-success';
            break;
          case 2:
            $class = 'badge-warning';
            break;
          default:
            $class = 'badge-danger';
            break;
        }
      @endphp
        <span class="badge {{ $class }}">{{ isset($employeeleave->leaveStatus) ? $employeeleave->leaveStatus->leave_status_name : '' }}</span>
    </td>
</tr>

<tr>
    <td>Reason</td>
    <td>{{ isset($employeeleave->leave_reason)? $employeeleave->leave_reason : '' }}</td>
</tr>

    
