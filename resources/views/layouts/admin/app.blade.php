<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>
    @section('title')
    Juffair Gable
    @show
</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('public/admin/assets') }}/css/app.min.css">
  <!-- page level css -->
  @yield('header_styles')
  <!-- page level css -->
  <!-- Template CSS -->
  {{-- <link rel="stylesheet" href="{{ asset('public/admin/assets') }}/css/components.css"> --}}
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{asset('public/admin/assets')}}/css/toastr.css">
  <link rel="stylesheet" href="{{ asset('public/admin/assets') }}/css/custom.css">
  <link rel='shortcut icon' type='image/jpeg' href='{{ asset("public/admin/assets") }}/img/logo.jpg' />
  <link rel="stylesheet" href="{{ asset('public/admin/assets') }}/css/style.css">
  <style>
    .user-img-radious-style
    {
      box-shadow: unset !important;
    }
    .sidebar-mini .main-sidebar a img
    {
        height: 30px !important;
    }
    .buttons-excel
    {
      background-color: #59bf70 !important;
      color: #fff !important;
      border-radius: 5px !important;
      border: 0 !important;
      width: 60px;
      margin: 0px 5px 0px 5px;
    }

    .buttons-pdf
    {
      background-color: #e91e63 !important;
      color: #fff !important;
      border-radius: 5px !important;
      border: 0 !important;
      width: 60px;
      margin: 0px 5px 0px 5px;
    }

    .main-sidebar .sidebar-menu li ul.dropdown-menu li a:hover .main-sidebar .sidebar-menu li a
    {
      background-color: #f5f5f5 !important;
      border-radius: 20px !important;
      color:white !important
    }

    .buttons-print
    {
      background-color: #6563ef  !important;
      color: #fff !important;
      border-radius: 5px !important;
      border: 0 !important;
      width: 60px;
      margin: 0px 5px 0px 5px;
    }

    .main-sidebar
    {
      background-color: #180b57 !important;
    }
    .main-sidebar .sidebar-menu li ul.dropdown-menu
    {
      background-color: #180b57 !important;

    }

    .main-sidebar .sidebar-menu li.active a
    {
      color: #000000;
      background-color:#fff !important;
    }

    .main-sidebar .sidebar-menu li ul.dropdown-menu li a:hover .role-permission-dropdown{
        background-color: #f5f5f5 !important;
       
    }
    .main-sidebar .sidebar-menu li ul.dropdown-menu li a
    {
      color:#fff !important;
    }
    .main-sidebar .sidebar-menu li a:hover {
        background-color: #f5f5f5;
        color:black;
        border-radius: 20px;
    }
    .light-sidebar:not(.sidebar-mini) .sidebar-style-2 .sidebar-menu > li.active ul.dropdown-menu li a
    {
      background-color: #180b57 !important;
    }
    .main-sidebar .sidebar-menu li a
    {
      color:#fff;
    }
    .sidebar-mini .main-sidebar .sidebar-menu > li:hover
    {
      padding: 10px !important;
    }

    .main-sidebar .sidebar-menu li {
        margin-bottom: 5px !important;
    }

    .light-sidebar.sidebar-mini .main-sidebar::after
    {
      background-color: #180b57 !important;
    }
    .light-sidebar.sidebar-mini .main-sidebar .sidebar-menu
    {
      background-color: #180b57 !important;
    }
    .light-sidebar.sidebar-mini .main-sidebar .sidebar-user {
      background-color: #180b57 !important;
    }
    /* .main-footer
    {
      position: absolute;
      bottom: 0 !important;
      text-transform: unset !important;
    } */

    .bootstrap-timepicker-widget table td input {
      width: 35px !important;
    }

    textarea.form-control {
        height: 130px;
    }

    .main-sidebar .sidebar-menu li a span {
        margin-top: 1px !important;
    }
    
  </style>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <!-- top navbar -->
      @include('layouts.admin.partials._navbar')
      <!-- End top Content -->

      <!-- Right sidebar -->
      @include('layouts.admin.partials._main_sidebar')
      <!-- End Right sidebar -->
      
      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>
      <!-- End Main Content -->

      <!-- Footer -->
      @include('layouts.admin.partials._footer')
      <!-- End Footer -->

    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('public/admin/assets/js') }}/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="{{ asset('public/admin/assets/bundles') }}/apexcharts/apexcharts.min.js"></script>
  <script src="{{ asset('public/admin/assets/bundles') }}/amcharts4/core.js"></script>
  <script src="{{ asset('public/admin/assets/bundles') }}/amcharts4/charts.js"></script>
  <script src="{{ asset('public/admin/assets/bundles') }}/amcharts4/animated.js"></script>
  <script src="{{ asset('public/admin/assets/bundles') }}/jquery.sparkline.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="{{ asset('public/admin/assets/js') }}/page/index.js"></script>
  <!-- Template JS File -->
  <script src="{{ asset('public/admin/assets/js') }}/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('public/admin/assets/js') }}/custom.js"></script>
  <script src="{{asset('public/admin/assets')}}/js/sweet_alert.js"></script>
  <script src="{{asset('public/admin/assets')}}/js/toastr.js"></script>
  {!! Toastr::message() !!}

  @if ($errors->any())
      <script>
          @foreach($errors->all() as $error)
          toastr.error('{{$error}}', Error, {
              CloseButton: true,
              ProgressBar: true
          });
          @endforeach
      </script>
  @endif

  <script>
    function form_alert(id, message) {
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $('#'+id).submit()
            }
        })
    }
  </script>
  
  <!-- page level js -->
  @yield('footer_scripts')
  <!-- end page level js -->
</body>


<!-- Mirrored from radixtouch.in/templates/admin/zivi/source/light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 13 Oct 2020 12:28:57 GMT -->
</html>