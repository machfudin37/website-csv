<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logos/lambang.png') }}" />
    <!--font awesome-->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <!--css file-->
    @yield('css')
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="stylesheet" href="https://code.highcharts.com/dashboards/css/dashboards.css">
</head>

<body>
    @yield('sidebar')
    <section class="content">
        <nav>
            <i class="fas fa-bars menu-btn"></i>
            <a href="#" class="nav-link"></a>

            <input type="checkbox" hidden id="switch-mode" />
            <label for="switch-mode" class="switch-mode"></label>

            <a href="#" class="profile">
                <span>{{ Auth::user()->name }}</span>
                <img src="{{ asset('assets/img/profile/user-1.jpg') }}" alt="" />
            </a>
        </nav>
        @yield('konten')
    </section>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @yield('js')
</body>

</html>
