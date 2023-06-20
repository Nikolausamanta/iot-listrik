<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Register
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="">
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('/assets/img/plant-3.jpg'); background-position: top;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Welcome!</h1>
            <p class="text-lead text-white">Let's get started and register now, empowering you to have full control and analyze all your electrical devices.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-start pt-4">
              <h5>Register Now</h5>
            </div>
            
            <div class="card-body">
                <form action="{{url('sesi/create')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label opacity-6">Name</label>
                        {{-- <input type="text" name="name" class="form-control form-control-lg" value="{{ Session::get('name')}}" placeholder="Name"> --}}

                        <input type="text" name="name" class="form-control form-control-lg @if($errors->has('name') || old('name') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{ old('name') }}" placeholder="Name">
                        @if($errors->has('name') || old('name') === '')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') ?? 'The mac address field is required.' }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label opacity-6">Email</label>
                        {{-- <input type="email" name="email" class="form-control form-control-lg" value="{{ Session::get('email')}}" placeholder="Email"> --}}
                        
                        <input type="email" name="email" class="form-control form-control-lg @if($errors->has('email') || old('email') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{ old('email') }}" placeholder="Email">
                        @if($errors->has('email') || old('email') === '')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') ?? 'The mac address field is required.' }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label opacity-6">Password</label>
                        {{-- <input type="password" name="password" class="form-control form-control-lg" value="{{ Session::get('password')}}" placeholder="Password"> --}}

                        <input type="password" name="password" class="form-control form-control-lg @if($errors->has('password') || old('password') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{ old('password') }}" placeholder="Password">
                        @if($errors->has('password') || old('password') === '')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') ?? 'The mac address field is required.' }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label opacity-6">Repeat Password</label>
                        {{-- <input type="password" name="password_confirmation" class="form-control form-control-lg" value="{{ Session::get('password_confirmation')}}" placeholder="Password"> --}}
                   
                        <input type="password" name="password_confirmation" class="form-control form-control-lg @if($errors->has('password_confirmation') || old('password_confirmation') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{ old('password_confirmation') }}" placeholder="Password Confirmation">
                        @if($errors->has('password_confirmation') || old('password_confirmation') === '')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password_confirmation') ?? 'The mac address field is required.' }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="text-center">
                        <button   type="submit" name="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                    </div>
                    <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{url('sesi')}}" class="text-dark font-weight-bolder">Sign in</a></p>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> Soft by Nikolaus Samanta.
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>