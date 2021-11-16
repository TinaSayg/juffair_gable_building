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

    
