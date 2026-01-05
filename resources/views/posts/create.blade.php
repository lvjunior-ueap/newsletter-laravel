@extends('layouts.app')

@section('title', 'Novo Post')

@section('content')
    <h2>Novo Post</h2>

    <form method="POST" action="/admin/posts">
        @csrf

        <div>
            <input
                type="text"
                name="title"
                placeholder="Título"
                required
            >
        </div>

        <div>
            <textarea
                name="content"
                rows="10"
                placeholder="Conteúdo"
                required
            ></textarea>
        </div>

        <button type="submit">
            Publicar e enviar email
        </button>
    </form>
@endsection
