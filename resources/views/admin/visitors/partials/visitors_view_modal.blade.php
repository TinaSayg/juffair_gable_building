<tr>
    <td>Visitors Name</td>
    <td>{{ isset($visitor->visitor_full_name) ? $visitor->visitor_full_name: '' }}</td>
</tr>
<tr>
    <td>Date of visit</td>
    <td>{{ isset($visitor->visitor_entry_date) ? \Carbon\Carbon::parse($visitor->visitor_entry_date)->toFormattedDateString() : '' }}</td>
</tr>
<tr>
    <td>Phone No.</td>
    <td>{{ isset($visitor->visitor_phone_number) ? $visitor->visitor_phone_number: '' }}</td>
</tr>
<tr>
    <td>Floor</td>
    <td>{{ isset($visitor->floor_id) ? $visitor->floor_id: '' }}</td>
</tr>
<tr>
    <td>unit </td>
    <td>{{ isset($visitor->unit) ? $visitor->unit->unit_number : '' }}</td>
</tr>
<tr>
    <td>IN</td>
    <td>{{ isset($visitor->visitor_in_time) ? $visitor->visitor_in_time : '' }}</td>
</tr>
<tr>
    <td>Out</td>
    <td>{{ isset($visitor->visitor_out_time) ? $visitor->visitor_out_time : '' }}</td>
</tr>
