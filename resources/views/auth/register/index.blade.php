<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logos/lambang.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="wrapper">
        <h1>Sign Up</h1>
        <form action="{{ route('actionregister') }}" method="post">
            @if (session('error'))
                <div class="alert alert-danger text-center align-items-center">
                    <b>Opps! {{ session('error') }}</b>
                </div>
            @endif
            @csrf
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="text" name="name" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Sign Up</button>
            <div class="register-link">
                <p> have an account? <a href="{{ route('login') }}">Sign in</a></p>
            </div>
        </form>
    </div>
</body>

</html>
