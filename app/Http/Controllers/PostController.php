<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Events\PostPublished;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('published', true)
            ->orderByDesc('created_at')
            ->get();

        return view('posts.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }

    // etapa 2
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . Str::random(5),
            'excerpt' => Str::limit(strip_tags($data['content']), 150),
            'content' => $data['content'],
            'published' => true,
        ]);

        // 🔔 dispara evento (email fica fora do controller)
        event(new PostPublished($post));

        return redirect()->route('home');
    }
}
