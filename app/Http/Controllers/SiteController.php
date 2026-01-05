<?php

namespace App\Http\Controllers;

use App\Models\WebPost;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index()
    {
        /*$posts = WebPost::where('status', 'published')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('site.index', compact('posts'));*/

        //TESTE
        dd(
            DB::connection()->getDatabaseName(),
            DB::connection()->getDriverName(),
            \Schema::hasTable('web_posts')
        );
    }

    public function show(string $slug)
    {
        $post = WebPost::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('site.show', compact('post'));
    }
}
