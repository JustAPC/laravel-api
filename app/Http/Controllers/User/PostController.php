<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $id = Auth::user()->id;
        $currentUser = Auth::user();

        if ($request->has('title')) {

            $title = $request->query('title');

            $posts = Post::where('title', 'like', '%' . $title . '%')->get();
        } else {
            // $posts = Post::where('user_id', '=', $id)->orderBy('updated_at', 'DESC')->paginate(5);
            $posts = $currentUser->posts()->orderBy('updated_at', 'DESC')->paginate(5);
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
        $currentUserId = Auth::id();

        $new_post = new Post();
        if (array_key_exists('image', $data)) {
            $image_url = Storage::put('post_images', $data['image']);
            $data['image'] = $image_url;
        }
        $new_post->fill($data);
        $new_post->user_id = $currentUserId;
        $new_post->slug = Str::slug($request->title, '-');
        $new_post->save();

        if (array_key_exists('tags', $data) && array_key_exists('categories', $data)) {
            $new_post->Tags()->attach($data['tags']);
            $new_post->Categories()->attach($data['categories']);
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
        $selectedCategories = $post->categories->pluck('id')->toArray();

        return view('user.posts.edit', compact('post', 'categories', 'tags', 'selectedTags', 'selectedCategories'));
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

        if (!array_key_exists('tags', $data)) {
            $post->Tags()->detach();
        } else {
            $post->Tags()->sync($data['tags']);
        }

        if (!array_key_exists('categories', $data)) {
            $post->Categories()->detach();
        } else {
            $post->Categories()->sync($data['categories']);
        }
        $post->update($data);

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
