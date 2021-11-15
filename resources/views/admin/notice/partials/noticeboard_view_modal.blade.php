<tr>
    <td> Notice</td>
    <td>{{ isset($noticeboard->notice_text) ? $noticeboard->notice_text: '' }}</td>
</tr>
<tr>
    <td>Date</td>
    <td>{{ isset($noticeboard->notice_date) ? \Carbon\Carbon::parse($noticeboard->notice_date)->toFormattedDateString() : '' }}</td>
    
</tr>
<tr>
    <td>Status</td>
    <td>{{ isset($noticeboard->notice_status) ? $noticeboard->notice_status->notice_boardstatus_name : '' }}</td>
    
</tr>
