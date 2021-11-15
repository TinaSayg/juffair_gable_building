<tr>
    <td>Bill Type</td>
    <td>{{ isset($utility_bill->utility_bill_type) ? $utility_bill->utility_bill_type->utility_bill_type_name : '' }}</td>
</tr>
<tr>
    <td>Bill Month</td>
    <td>{{ isset($utility_bill->utility_bill_month) ? $utility_bill->utility_bill_month : '' }}</td>
</tr>
<tr>
    <td>Bill Year</td>
    <td>{{ isset($utility_bill->utility_bill_year) ? $utility_bill->utility_bill_year : '' }}</td>
</tr>
<tr>
    <td>Bill Date</td>
    <td>{{ isset($utility_bill->utility_bill_date) ? \Carbon\Carbon::parse($utility_bill->utility_bill_date)->toFormattedDateString() : '' }}</td>
</tr> 
<tr>
    <td>Total Amout</td>
    <td>{{ isset($utility_bill->utility_bill_total_amount) ? $utility_bill->utility_bill_total_amount : '' }}</td>
</tr>

<tr>
    <td>Description</td>
    <td>{{ isset($utility_bill) ? $utility_bill->utility_bill_description : '' }}</td>
</tr> 

<tr>
    <td>Bill Image</td>
    <td><a target="_blank" href="{{ url('public/admin/assets/img/utility_bills').'/'}}{{ isset($utility_bill->utility_bill_image) ? $utility_bill->utility_bill_image : '' }}">click here to view bill</a></td>
</tr> 

