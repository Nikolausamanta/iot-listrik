<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Login
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
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your email and password to sign in</p>
                </div>
                <div class="card-body">
                  <form action="{{ url('sesi/login') }}" method="POST">
                      @csrf
                      <div class="mb-3">
                          <label for="email" class="form-label opacity-6">Email</label>
                          <input type="text" name="email" class="form-control form-control-lg @if($errors->has('invalid_credentials')) is-invalid @elseif($errors->has('email')) is-invalid @endif" value="{{ old('email') }}" placeholder="Email">
                          @if($errors->has('invalid_credentials'))
                              <div class="invalid-feedback">
                                  {{ $errors->first('invalid_credentials') }}
                              </div>
                          @elseif($errors->has('email'))
                              <div class="invalid-feedback">
                                  {{ $errors->first('email') }}
                              </div>
                          @endif
                      </div>
                      <div class="mb-3">
                          <label for="password" class="form-label opacity-6">Password</label>
                          <input type="password" name="password" class="form-control form-control-lg @if($errors->has('invalid_credentials')) is-invalid @elseif($errors->has('password')) is-invalid @endif" placeholder="Password">
                          @if($errors->has('invalid_credentials'))
                              <div class="invalid-feedback">
                                  {{ $errors->first('invalid_credentials') }}
                              </div>
                          @elseif($errors->has('password'))
                              <div class="invalid-feedback">
                                  {{ $errors->first('password') }}
                              </div>
                          @endif
                      </div>
                      <div class="text-center">
                          <button type="submit" name="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                      </div>
                  </form>
              </div>
              
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="{{url('sesi/register')}}" class="text-primary text-gradient font-weight-bold">Sign up</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('/assets/img/plant-1.jpg');
          background-size: cover;">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Analyzing, Monitoring, and Controlling Electronic Devices for Efficiency."</h4>
                <p class="text-white position-relative">Analyzing and monitoring electronic devices enables efficient performance and functionality.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  
  
  
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