
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>
    @section('title')
    AMS
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
  <link rel='shortcut icon' type='image/x-icon' href='{{ asset("public/admin/assets") }}/img/favicon.ico' />
  <link rel="stylesheet" href="{{ asset('public/admin/assets') }}/css/style.css">
  <style>
    /* .theme-white a:hover {
        color: #fff !important;
    } */
  </style>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <!-- top navbar -->
      @include('layouts.partials._navbar')
      <!-- End top Content -->

      <!-- Right sidebar -->
      @include('layouts.partials._main_sidebar')
      <!-- End Right sidebar -->
      
      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>
      <!-- End Main Content -->

      <!-- Footer -->
      @include('layouts.partials._footer')
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