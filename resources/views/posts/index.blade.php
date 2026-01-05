@extends('layouts.app')

@section('title', 'Últimos posts')

@section('content')
    <h2>Últimos posts</h2>

    @forelse ($posts as $post)
        <article>
            <h3>
                <a href="{{ route('post.show', $post->slug) }}">
                    {{ $post->title }}
                </a>
            </h3>

            <p>{{ $post->excerpt }}</p>
        </article>
        <hr>
    @empty
        <p>Nenhum post publicado ainda.</p>
    @endforelse
@endsection
