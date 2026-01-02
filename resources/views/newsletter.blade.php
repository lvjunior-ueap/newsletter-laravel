<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Newsletter</title>
</head>
<body>

<h1>Assinar Newsletter</h1>

@if (session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if ($errors->any())
    <ul style="color: red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('newsletter.subscribe') }}">
    @csrf

    <input
        type="email"
        name="email"
        placeholder="Seu email"
        required
    >

    <button type="submit">Assinar</button>
</form>

</body>
</html>
