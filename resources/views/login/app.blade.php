<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="News365">
    <meta name="author" content="News365">
    <title>@yield('title')</title>

    <!-- App favicon -->
    <link rel="shortcut icon" class="favicon_show" href="{{ app_setting()->favicon }}">

    @stack('css')
    @include('login.assets.css')
</head>

<body class="bg-white">

    @yield('content')

    @include('login.assets.js')
    @stack('js')
</body>

</html>
