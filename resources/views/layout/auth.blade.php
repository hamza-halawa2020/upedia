<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Upedia</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo-icon.png') }}" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        html,
        body {
            overflow-x: hidden;
            width: 100%;
        }

        body {
            font-family: Inter, Arial, sans-serif;
        }

        img,
        svg {
            max-width: 100%;
            height: auto;
        }

        .auth-page {
            background: #f8fafc;
        }

        .auth-logo {
            display: inline-block;
        }
    </style>

    @stack('styles')
</head>

<body class="auth-page">
    <main>
        @yield('content')
    </main>

    @stack('scripts')
    @yield('scripts')
</body>

</html>
