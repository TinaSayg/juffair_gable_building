<tr>
    <td>Description</td>
    <td>{{ isset($service_contract->description) ? $service_contract->description: '' }}</td>
</tr>
<tr>
    <td>Cost</td>
    <td>{{ isset($service_contract->amount) ? $service_contract->amount: '' }} BD</td>
</tr>
<tr>
    <td>Frequency of pay</td>
    <td>{{ isset($service_contract->frequency_of_pay) ? $service_contract->frequency_of_pay: '' }}</td>
</tr>
<tr>
    <td>Invoice</td>
    <td><a href="{{ url('public/admin/assets/img/servicecontract') }}/{{ isset($service_contract->image)? $service_contract->image : '' }}" target="blank">view</a></td>
</tr>
<tr>
    <td>Renew Date</td>
    <td>{{ isset($service_contract->contract_renew_date) ? \Carbon\Carbon::parse($service_contract->contract_renew_date)->toFormattedDateString() : '' }}</td>
</tr>


    
