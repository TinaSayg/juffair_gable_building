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
<tr>
  <td>Building</td>
  <td>{{ isset($maintenancecost->building) ? $maintenancecost->building->building_name : '' }}</td>
</tr>
  
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html"> <img alt="image" src="{{ asset('/public/admin/assets')}}/img/logo.png" class="header-logo" /> <span
            class="logo-name">AMS</span>
        </a>
      </div>
      <div class="sidebar-user">
        {{-- <div class="sidebar-user-picture">
          <img alt="image" src="{{ asset('public/admin/assets/img/user.png') }}">
        </div> --}}
        <div class="sidebar-user-details">
          <div class="user-name">{{ \Auth::user()->name }}</div>
          <div class="user-role">Administrator</div>
        </div>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
    
        <li class="dropdown   {!! (Request::is('dashboard') ? "active" : "") !!}">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-briefcase"></i><span>Buildings</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ url('/dashboard') }}">Building</a></li>
          </ul>
        </li>
        <li class="dropdown {!! (Request::is('owner/owner_list') ? "active" : "") !!}">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-briefcase"></i><span>Owners</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('owners.list') }}">Owner list</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-briefcase"></i><span>Roles & Permissions</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ url('/dashboard') }}">Role</a></li>
            <li><a class="nav-link" href="{{ url('/dashboard') }}">Module</a></li>
            <li><a class="nav-link" href="{{ url('/dashboard') }}">Permission</a></li>
          </ul>
        </li>
    </aside>
  </div>