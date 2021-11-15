<tr>
    <td>Tenant First Name</td>
    <td>{{ isset($tenant->tenant_first_name) ? $tenant->tenant_first_name: '' }}</td>
</tr>
<tr>
    <td>Tenant last Name</td>
    <td>{{ isset($tenant->tenant_last_name) ? $tenant->tenant_last_name: '' }}</td>
</tr>
<tr>
    <td>Tenant Email Address</td>
    <td>{{ isset($tenant->tenant_email_address) ? $tenant->tenant_email_address: '' }}</td>
</tr>
<tr>
    <td>Floor</td>
    <td>{{ isset($tenant->floor_id) ? $tenant->floor_id: '' }}</td>
</tr>
<tr>
    <td>unit </td>
    <td>{{ isset($tenant->unit) ? $tenant->unit->unit_number : '' }}</td>
</tr>
<tr>
    <td>Amount</td>
    <td>{{ isset($tenant->security_deposite) ? $tenant->security_deposite : '' }}</td>
</tr>