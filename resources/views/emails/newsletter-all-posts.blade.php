<!DOCTYPE html>
<html>
<body>
    <h2>Notícias publicadas</h2>

    @foreach ($posts as $post)
        <hr>
        <h3>{{ $post->title }}</h3>
        <p>{{ $post->excerpt }}</p>
        <a href="{{ url('/post/' . $post->slug) }}">
            Ler post
        </a>
    @endforeach

</body>
</html>
