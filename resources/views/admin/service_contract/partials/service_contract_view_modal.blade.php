<tr>
    <td>Title</td>
    <td>{{ isset($service_contract->Title) ? $service_contract->Title: '' }}</td>
</tr>
<tr>
    <td>Description</td>
    <td>{{ isset($service_contract->description) ? $service_contract->description: '' }}</td>
</tr>
<tr>
    <td>Cost Per Period</td>
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
    <td>Contract Start Date</td>
    <td>{{ isset($service_contract->contract_start_date) ? \Carbon\Carbon::parse($service_contract->contract_start_date)->toFormattedDateString() : '' }}</td>
</tr>
<tr>
    <td>Contract Close Date</td>
    <td>{{ isset($service_contract->contract_end_date) ? \Carbon\Carbon::parse($service_contract->contract_end_date)->toFormattedDateString() : '' }}</td>
</tr>
<tr>
    <td>Auto Renewal</td>
    <td>
        <span class="badge btn-warning">
            @if(isset($service_contract) && $service_contract->auto_renewal == '1')
            Yes
            @else
            No
            @endif
        </span>
    </td>
</tr>


    
