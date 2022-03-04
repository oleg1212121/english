<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Translations</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@yield('styles')


<!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
{{--        <a class="navbar-brand" href="#">Navbar</a>--}}
{{--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">--}}
{{--            <span class="navbar-toggler-icon"></span>--}}
{{--        </button>--}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link @if(\Route::currentRouteName() == 'home') active @endif" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(\Route::currentRouteName() == 'words.index') active @endif" href="{{route('words.index')}}">Words</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(\Route::currentRouteName() == 'words.reverse') active @endif" href="{{route('words.reverse')}}">Words reverse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(\Route::currentRouteName() == 'statistic.index') active @endif" href="{{route('statistic.index')}}">Statistic</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">


@yield('content')
@yield('scripts')
</div>
</body>
</html>
