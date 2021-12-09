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
  <link rel='shortcut icon' type='image/jpeg' href='{{ asset("public/admin/assets") }}/img/logo.jpg' />
  <style>
.login-bg{
  border: 0px solid black;
  padding: 25px;
  background: url(public/admin/assets/img/bahrain.jpg);
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
                <h4>Login</h4>
              </div>
              <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" autocomplete="off" class="form-control @error('email') is-invalid @enderror" autocomplete="off" name="email" tabindex="1" required >
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                          <div class="d-block">
                            <label for="password"  class="control-label">Password</label>
                            @if (Route::has('password.request'))
                            <div class="float-right">
                              <a href="{{ route('password.request') }}" class="text-small">
                                Forgot Password?
                              </a>
                            </div>
                            @endif
                          </div>
                          <input id="password" autocomplete="off" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="2" required>
                          @error('password')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember-me">Remember Me</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                              Login
                            </button>
                        </div>
                    </form>
                    {{-- <div class="mt-5 text-muted text-center">
                        Don't have an account? <a href="{{ route('register') }}">Create One</a>
                      </div>
                    </div> --}}
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

