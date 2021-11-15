<tr>
    <td>Maintenance Title</td>
    <td>{{ isset($maintenancecost->maintenance_title) ? $maintenancecost->maintenance_title: '' }}</td>
</tr>
<tr>
    <td>Description</td>
    <td>{{ isset($maintenancecost->maintenance_description) ? $maintenancecost->maintenance_description: '' }}</td>
</tr>
<tr>
    <td>Date</td>
    <td>{{ isset($maintenancecost->maintenance_date) ? \Carbon\Carbon::parse($maintenancecost->maintenance_date)->toFormattedDateString() : '' }}</td>
</tr>
<tr>
    <td>Total Amount</td>
    <td>{{ isset($maintenancecost->maintenance_cost_total_amount) ? $maintenancecost->maintenance_cost_total_amount: '' }}</td>
</tr>

    
