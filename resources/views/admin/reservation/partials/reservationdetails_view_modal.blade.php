<tr>
    <td> Reservation ID</td>
    <td>{{ isset($reservation->reservation_id) ? $reservation->reservation_id: '' }}</td>
</tr>
<tr>
    <td>Reservation Date</td>
    <td>{{ isset($reservation->reservation_date) ? \Carbon\Carbon::parse($reservation->reservation_date)->toFormattedDateString() : '' }}</td>
    
</tr>
<tr>
    <td>Start Time</td>
    <td>{{ isset($reservation->start_time) ? $reservation->start_time: '' }}</td>
</tr>
<tr>
    <td>End Time</td>
    <td>{{ isset($reservation->end_time) ? $reservation->end_time: '' }}</td>
</tr>
<tr>
    <td>Tenant Name</td>
    <td>{{ isset($reservation->tenant_name) ? $reservation->tenant_name: '' }}</td>
</tr>