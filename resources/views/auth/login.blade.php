<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/stylelogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<body>
    <div class="video-container">
        <video autoplay muted loop id="background-video">
            <source src="{{ asset('Gambar&Video/144588-785095793.mp4') }}" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
        <div class="content animate__animated animate__backInUp">
            <div class="login-container">
                <div class="logo">
                    <img src="{{ asset('Gambar&Video/MoneyUp-removebg-preview.png') }}" alt="Logo">
                </div>
                <form class="login-form" id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="error-message">
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <h2>Login</h2>
                    <div class="input-group">
                        <input type="text" id="login" name="login" value="{{ old('login') }}" required>
                        <label for="login">Email</label>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" name="password" required>
                        <label for="password">Password</label>
                    </div>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
 