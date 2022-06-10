<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('title')) {

            $title = $request->query('title');

            $posts = Post::where('title', 'like', '%' . $title . '%')->get();
        } else {
            $posts = Post::orderBy('updated_at', 'DESC')->paginate(5);
        }

        return view('user.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('user.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $new_post = new Post();
        $new_post->fill($data);
        $new_post->slug = Str::slug($request->title, '-');
        $new_post->save();

        if (array_key_exists('tags', $data)) {
            $new_post->Tags()->attach($data['tags']);
        }

        return redirect()->route('user.posts.index', $new_post)->with('message-create', "$new_post->title");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('user.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        $selectedTags = $post->tags->pluck('id')->toArray();

        return view('user.posts.edit', compact('post', 'categories', 'tags', 'selectedTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->all();
        $post['slug'] = Str::slug($request->title, '-');
        $post->update($data);

        if (!array_key_exists('tags', $data)) {
            $post->Tags()->detach();
        } else {
            $post->Tags()->sync($data['tags']);
        }

        return redirect()->route('user.posts.show', $post)->with('message-edit', "$post->title");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('user.posts.index', compact('post'))->with('message-delete', "$post->title");
    }
}
