<!DOCTYPE html>
<html>
<body>
    <h2>Novo post publicado</h2>

    <h3>{{ $post->title }}</h3>

    <p>{{ $post->excerpt }}</p>

    <p>
        <a href="{{ url('/post/' . $post->slug) }}">
            Ler o post completo
        </a>
    </p>
</body>
</html>
