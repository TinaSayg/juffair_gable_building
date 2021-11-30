<tr>
    <td>Title</td>
    <td>{{ isset($maintenance_request->title) ? $maintenance_request->title: '' }}</td>
</tr>
<tr>
    <td>Description</td>
    <td>{{ isset($maintenance_request->description) ? $maintenance_request->description: '' }}</td>
</tr>
<tr>
    <td>Location</td>
    <td>
        @if($maintenance_request->location_id == 1)
        @php
          $floor_number = \App\Models\FloorDetail::where('id', $maintenance_request->floor_id)->first()->number;
          $apartment_number = \App\Models\Unit::where('id', $maintenance_request->unit_id)->first()->unit_number;
        @endphp
        Floor {{ $floor_number }}, Apartment {{ $apartment_number }}
      @endif

      @if($maintenance_request->location_id == 2)
        @php
          $location_area = \App\Models\CommonArea::where('id', $maintenance_request->common_area_id)->first()->area_name;
        @endphp
        {{ $location_area }}
      @endif

      @if($maintenance_request->location_id == 3)
      @php
        $floor_number = \App\Models\FloorDetail::where('id', $maintenance_request->floor_id)->first()->number;
      @endphp
      Floor {{ $floor_number }}
      @endif

      @if($maintenance_request->location_id == 4)
        @php
          $location_area = \App\Models\ServiceArea::where('id', $maintenance_request->service_area_id)->first()->service_area_name;
        @endphp
        {{ $location_area }} Area
      @endif
    </td>
</tr>

<tr>
    <td>Status</td>
    <td>
        @php
        $class = '';
        switch ($maintenance_request->maintenance_request_status_code) {
            case 1:
            $class = 'badge-warning';
            break;
            case 2:
            $class = 'badge-success';
            break;
            case 3:
            $class = 'badge-warning';
            break;
            default:
            $class = 'badge-success';
            break;
        }
        @endphp
        <span class="badge {{ $class }}">
        {{ isset($maintenance_request->maintenance_request_status) ? $maintenance_request->maintenance_request_status->maintenance_request_status_name : '' }}
        </span>
    </td>
</tr>
@if(Auth::user()->userType == 'general-manager' || Auth::user()->userType == 'Admin')
<tr>
    <td colspan="2"><h5>Reported Request Person Details</h5></td>
</tr>

@php
    $user = \App\Models\User::where('id', $maintenance_request->user_id)->first();
@endphp

<tr>
    <td>Name</td>
    <td>{{ isset($user) ? $user->name : '' }}</td>
</tr>

<tr>
    <td>Email Address</td>
    <td>{{ isset($user) ? $user->email  : '' }}</td>
</tr>

<tr>
    <td>Mobile Phone</td>
    <td>{{ isset($user) ? $user->number  : '' }}</td>
</tr>

@endif