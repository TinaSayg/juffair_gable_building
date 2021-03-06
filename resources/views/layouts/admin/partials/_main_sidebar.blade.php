<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html"> <img alt="image" style="height: 55px" src="{{ asset('/public/admin/assets')}}/img/juffair_gables_logo.png" class="header-logo" /> <span
            class="logo-name"></span>
        </a>
      </div>
      <div class="sidebar-user">
        {{-- <div class="sidebar-user-picture">
          <img alt="image" src="{{ asset('public/admin/assets/img/user.png') }}">
        </div> --}}
        <div class="text-white">{{ Auth::user()->userType}}</div>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        @if(request()->user()->can('view-dashboard'))
        <li class="dropdown  {!! (Request::is('dashboard') ? "active" : "") !!}">
          <a href="{{ route('dashboard')}}" class="nav-link"><i class="fas fa-desktop"></i><span>Dashboard</span></a>
        </li>
        @endif
        {{-- <li class="dropdown">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-building"
             ></i><span>Building Information</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('buildings.list') }}">Building List</a></li>
           
          </ul>
        </li> --}}
        
        @if(request()->user()->can('view-floor'))
        <li class="dropdown {!! (Request::is('floors/floor_list') ? "active" : "") !!}">
          <a href="{{ route('floors.list') }}" class="nav-link"><i class="fas fa-home"></i><span>Floors</span></a>
        </li>
        @endif

        @if(Auth::user()->userType == 'officer')
          <li class="dropdown {!! (Request::is('units/search_by_apartment*') ? "active" : "") !!}">
            <a href="{{ route('units.search_by_apartment_list') }}" class="nav-link"><span>Search by apartment</span></a>
          </li>
          <li class="dropdown {!! (Request::is('units/full_apartment*') ? "active" : "") !!}">
            <a href="{{ route('units.full_apartment.list') }}" class="nav-link"><span>Full apartment list</span></a>
          </li>
          <li class="dropdown {!! (Request::is('units/apartment_by_floor*') ? "active" : "") !!}">
            <a href="{{ route('units.apartment_by_floor.list') }}" class="nav-link"><span>Apartments by Floor</span></a>
          </li>
          <li class="dropdown {!! (Request::is('units/apartment_by_type*') ? "active" : "") !!}">
            <a href="{{ route('units.apartment_by_type.list') }}" class="nav-link"><span>Apartments by type</span></a>
          </li>
          <li class="dropdown {!! (Request::is('units/apartment_by_color*') ? "active" : "") !!}">
            <a href="{{ route('units.apartment_by_color.list') }}" class="nav-link"><span>Apartments by color</span></a>
          </li>
          <li class="dropdown {!! (Request::is('floors/floor_list') ? "active" : "") !!}">
            <a href="{{ route('tenants.list') }}" class="nav-link"><span>Add New Tenant</span></a>
          </li>
          <li class="dropdown {!! (Request::is('floors/floor_list') ? "active" : "") !!}">
            <a href="{{ route('floors.list') }}" class="nav-link"><span>Add a new service contract</span></a>
          </li>
          
          <li class="dropdown {!! (Request::is('floors/floor_list') ? "active" : "") !!}">
            <a href="{{ route('floors.list') }}" class="nav-link"><span>Reports</span></a>
          </li>
        @endif

        @if(Auth::user()->userType == 'employee')
        <li class="dropdown {!! (Request::is('units/rented_apartment*') ? "active" : "") !!}">
          <a href="{{ route('units.rented_apartment.list') }}" class="nav-link"><span>Rented Apartment</span></a>
        </li>
        <li class="dropdown {!! (Request::is('/leave*') ? "active" : "") !!}">
          <a href="{{ route('leave.list') }}" class="nav-link"><span>Apply Leave</span></a>
        </li>
        @endif

        @if(request()->user()->can('view-unit'))
        <li class="dropdown {!! (Request::is('units/*') ? "active" : "") !!}">
          <a href="{{ route('units.list') }}" class="nav-link"><i class="fas fa-door-open"></i><span>Apartments </span></a>
        </li>
        @endif

        @if(request()->user()->can('view-tenant'))
        <li class="dropdown {!! (Request::is('tenants/*') ? "active" : "") !!}">
          <a href="{{ route('tenants.list') }}" class="nav-link"><i class="fas fa-users"></i><span>Tenants </span></a>
        </li>
        @endif

        @if(request()->user()->can('view-staff'))
        <li class="dropdown {!! (Request::is('staff/*') ? "active" : "") !!} ">
          <a href="{{ route('staff.list') }}" class="nav-link"><i class="fas fa-user"></i><span>Staff </span></a>
        </li>
        @endif
        {{-- <li class="dropdown">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-user"></i><span>Owner Information </span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('owners.list') }}">Owner List</a></li>
          </ul>
        </li> --}}
        {{-- <li class="dropdown  {!! (Request::is('tenants/tenant_list') ? "active" : "") !!}">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-users"></i><span>Tenant Information</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('tenants.list') }}">Tenant List</a></li>
          </ul>
        </li> --}}
        {{-- 
        <li class="dropdown {!! (Request::is('employee/employee_list') ? "active" : "") !!}">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-address-card"></i><span>Employee Information</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('employee.list') }}">Employee List</a></li>
          </ul>
        </li>
        <li class="dropdown  {!! (Request::is('rent/rent_list') ? "active" : "") !!}">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-dollar-sign "></i><span>Rent Collection</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('rent.list') }}">Rent List</a></li>
          </ul>
        </li>
        --}}

        @if(request()->user()->can('view-utility-bill'))
        <li class="dropdown {!! (Request::is('utility_bill/*') ? "active" : "") !!}">
          <a href="{{ route('utility_bill.list') }}" class="nav-link"><i class="
            fas fa-money-bill-wave"></i><span>Utility Bill</span></a>
        </li>
        @endif
        
        @if(request()->user()->can('view-maintenance-cost'))
        <li class="dropdown {!! (Request::is('maintenancecost/*') ? "active" : "") !!}">
          <a href="{{ route('maintenancecosts.list') }}" class="nav-link"><i class="fas fas fa-toolbox"></i><span>Maintenance Costs</span></a>
        </li>
        @endif
        
        {{-- @if(request()->user()->can('view-security-deposit'))
        <li class="dropdown {!! (Request::is('securitydeposit/*') ? "active" : "") !!}">
          <a href="{{ route('securitydeposit.list') }}" class="nav-link"><i class="fas fa-money-bill-alt"></i><span>Security Deposits</span></a>
        </li>
        @endif --}}
        
        @if(request()->user()->can('view-task'))
        <li class="dropdown {!! (Request::is('tasks/*') ? "active" : "") !!}">
          <a href="{{ route('tasks.list') }}" class="nav-link"><i class="fas fa-book"></i>
            <span>
              @if(\Auth::user()->userType != 'employee')
              Tasks
              @else
              My Task
              @endif
            </span>
          </a>
        </li>
        @endif
        
        @if(request()->user()->can('view-employees-request'))
        <li class="dropdown {!! (Request::is('request/*') ? "active" : "") !!}">
          <a href="{{ route('request.list') }}" class="nav-link"><i class="fas fa-newspaper"></i><span>Employees Request</span></a>
        </li>
        @endif
        @if(Auth::user()->userType == 'general-manager')
        <li class="dropdown {!! (Request::is('complains/*') ? "active" : "") !!}">
          <a href="{{ route('complains.list')}}" class="nav-link">
            <i class="fas fa-comment-dots"></i>
            <span>General Request</span>
          </a>
        </li>
        @endif

        @if(request()->user()->can('view-visitor'))
        <li class="dropdown {!! (Request::is('visitor/*') ? "active" : "") !!}">
          <a href="{{ route('visitor.list') }}" class="nav-link"><i class="fas fa-user-friends"></i><span>Visitor List</span></a>
        </li>
        @endif

        @if(Auth::user()->userType == 'general-manager' || Auth::user()->userType == 'Admin')
        <li class="dropdown">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-check-square"></i><span>Reservations</span></a> 
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('reservation.list') }}">Reservation Details</a></li>
             <li><a class="nav-link" href="{{ route('room.list') }}">Add Rooms</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-chalkboard"></i><span>Approve Leaves</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('approveleave.list') }}">Approve Leaves List</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-chalkboard"></i><span>Notice Board</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('notice.list') }}">Notice List</a></li>
          </ul>
        </li>
        @endif
        {{--<li class="dropdown">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="far fa-user"></i><span>Complaints & Suggestions</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="">Complaint List</a></li>
          </ul>
        </li>
       
        
         <li class="dropdown">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-chalkboard"></i><span>Notice Board</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('notice') }}">Notice List</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-hands-helping"></i><span>Help Desk</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('helpdesk') }}">Helpdesk List</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="/" class="menu-toggle nav-link has-dropdown"><i class="fas fa-flag"></i><span>Reports</span></a>
         <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('rentreport') }}">Rental Report</a></li>
             <li><a class="nav-link" href="{{ route('visitorsreport') }}">Visitors Report</a></li>
              <li><a class="nav-link" href="{{ route('complaintreport') }}">Complaint Report</a></li>
             <li><a class="nav-link" href="{{ route('unitstatusreport') }}">Unit Status Report</a></li>

          </ul>
        </li> --}}
        @if(request()->user()->can('view-role-and-permission'))
        <li  class="dropdown {!! (Request::is('role/list') ? "active" : "") !!} {!! (Request::is('role/create') ? "active" : "") !!} {!! (Request::is('role/edit/*') ? "active" : "") !!} {!! (Request::is('module/list') ? "active" : "") !!} {!! (Request::is('module/create') ? "active" : "") !!} {!! (Request::is('module/edit/*') ? "active" : "") !!} {!! (Request::is('permission/list') ? "active" : "") !!} {!! (Request::is('permission/create') ? "active" : "") !!} {!! (Request::is('permission/edit/*') ? "active" : "") !!} {!! (Request::is('role/assign-permission/*') ? "active" : "") !!}" >
          <a href="#" class="menu-toggle nav-link has-dropdown role-permission-dropdown"><i class="fas fa-user-shield"></i><span>Roles & Permission</span></a>
          <ul class="dropdown-menu">
              <li><a class="nav-link" href="{{ route('role.list') }}">Roles</a></li>
              
              <li><a class="nav-link" href="{{ route('module.list')}} ">Modules</a></li>
              <li><a class="nav-link" href="{{ route('permission.list') }}">Permissions</a></li>
          </ul>
        </li>
        @endif
    </aside>
  </div>