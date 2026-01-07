<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Meu Blog')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/newsletter.css') }}">
</head>

@include('components.newsletter-modal')

<body>

<header>
    <h1>
        <a href="{{ route('home') }}">Meu Blog</a>
    </h1>

    <script src="{{ asset('js/newsletter.js') }}" defer></script>


    <nav>
        <button id="btn-newsletter">
            Newsletter
        </button>
    </nav>
</header>

<hr>

<main>
    @yield('content')
</main>

</body>
</html>
