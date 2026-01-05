@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <article>
        <h2>{{ $post->title }}</h2>

        <p>
            <em>
                Publicado em {{ $post->created_at->format('d/m/Y') }}
            </em>
        </p>

        <div>
            {!! nl2br(e($post->content)) !!}
        </div>
    </article>

    <hr>

    <p>
        <a href="{{ route('newsletter.form') }}">
            Receba novos posts por email
        </a>
    </p>
@endsection
