<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from radixtouch.in/templates/admin/zivi/source/light/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 13 Oct 2020 12:31:31 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Juffair Gable - Dashboard</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('public/admin/assets')}}/css/app.min.css">
  <link rel="stylesheet" href="{{ asset('public/admin/assets')}}/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('public/admin/assets')}}/css/style.css">
  <link rel="stylesheet" href="{{ asset('public/admin/assets')}}/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('public/admin/assets')}}/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='{{ asset('public/admin/assets')}}/img/favicon.ico' />
  <style>
.login-bg{
  border: 0px solid black;
  padding: 25px;
  background: url(../public/admin/assets/img/bahrain.jpg);
  background-repeat: no-repeat;
  background-size: 100%;
}

</style>
</head>

<body class="login-bg">
  {{-- <div>
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{ url('/') }}"> <img alt="image" style="height: 55px !important" src="{{ asset('/public/admin/assets')}}/img/juffair_gables_logo.png" class="header-logo" /> <span
          class="logo-name"></span>
        </a>
      </div>
  </div> --}}

  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Reset Password</h4>
              </div>
              <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate="" autocomplete="off">
                        @csrf

                        {{-- <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" name="email" value="{{ old('email') }}" tabindex="1" required autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </form>
                    
                  </div>
                </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('public/admin/assets')}}/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="{{ asset('public/admin/assets')}}/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('public/admin/assets')}}/js/custom.js"></script>
</body>


<!-- Mirrored from radixtouch.in/templates/admin/zivi/source/light/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 13 Oct 2020 12:31:31 GMT -->
</html>


