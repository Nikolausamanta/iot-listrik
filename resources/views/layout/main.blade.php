<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>{{$title}}</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href={{ url('assets/css/nucleo-icons.css') }} rel="stylesheet" />
    <link href={{ url('assets/css/nucleo-svg.css') }} rel="stylesheet" />
    <!-- Font Awesome Icons -->
    {{-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> --}}
    <link href={{ url('assets/css/nucleo-svg.css') }} rel="stylesheet" />
    
    <!-- CSS Files -->
    <link id="pagestyle" href={{ url('assets/css/argon-dashboard.css?v=2.0.4') }} rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link id="pagestyle" href={{ url('assets/css/main.css') }} rel="stylesheet" />
    <link id="pagestyle" href={{ url('assets/icon/fontawesome-free/css/all.min.css') }} rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-200">
    <div class="min-height-300 position-absolute w-100"></div>

    @if (Auth::check())  
        @include('partials.sidebar')
    @endif


    {{--? Start Main Content --}}
    <main class="main-content position-relative border-radius-lg ">
       {{-- @include('partials.navbar') --}}
        
        
        @yield('content')
        @include('partials.footer')
        </div>
    </main>
    {{--? End Main Content  --}}
    
    <!--   Core JS Files   -->
    <script src={{ url('assets/js/collect.min.js') }}></script>
    <script src={{ url('assets/js/core/popper.min.js') }}></script>
    <script src={{ url('assets/js/core/bootstrap.min.js') }}></script>
    <script src={{ url('assets/js/plugins/perfect-scrollbar.min.js') }}></script>
    <script src={{ url('assets/js/plugins/smooth-scrollbar.min.js') }}></script>
    <script src={{ url('assets/js/plugins/chartjs.min.js') }}></script>
    <script src={{ url('assets/js/chart/chart.js') }}></script>

   
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
    <script src={{ url('assets/js/argon-dashboard.min.js?v=2.0.4') }}></script>
    <script src={{ url('assets/js/main.js') }}></script>
    

    
    </body>
</html>