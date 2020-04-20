<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        $posts = Post::all();
        $somePost = Post::where('title', 'like', '%judul%')->get();

        $firstPost = Post::where('title', 'like', '%judul%')->first();

        return view('posts.index', ['postCollection' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string
     */
    public function create()
    {
        return View::make('posts.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->post('title'),
            'content' => $request->post('content'),
            'user_id' => 0,
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return Post
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return string
     */
    public function edit(Post $post)
    {
        return "Ceritanya nampilin form untuk edit data post ini: ".json_encode($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return Post
     */
    public function update(Request $request, Post $post)
    {
        $post->title = $request->input('title', $post->title);
        $post->content = $request->input('content', $post->content);
        $post->save();

        return $post->refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return string
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return 'Post sukses dihapus!';
    }
}
