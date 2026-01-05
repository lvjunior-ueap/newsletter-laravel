<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Meu Blog')</title>
</head>
<body>

<header>
    <h1>
        <a href="{{ route('home') }}">Meu Blog</a>
    </h1>

    <nav>
        <a href="{{ route('newsletter.form') }}">Newsletter</a>
    </nav>
</header>

<hr>

<main>
    @yield('content')
</main>

</body>
</html>
