<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\PostResource;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function create()
    {
        return view('posts/create', [
            "title" => "Create a Post - LaraGram"
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "body" => "required|max:500",
            "files" => "required",
            "files.*" => "image|mimes:jpeg,jpg,png,bmp,gif,svg|max:2042"
        ], [
            "files.*.image" => "The files must be an image.",
            "files.*.mimes" => "The files must be an image."
        ]);

        $post = $request->user()->posts()->create([
            "body" => $request->body
        ]);

        $files = [];
        foreach ($request->file('files') as $file) {
            $files[] = [
                "user_id" => $post->user_id,
                "post_id" => $post->id,
                "path_resource" => Str::remove('public/', $file->store('public/files')),
                "created_at" => \Carbon\Carbon::now()->toDateTimeString(),
                "updated_at" => \Carbon\Carbon::now()->toDateTimeString()
            ];
        }
        PostResource::insert($files);

        return redirect()->route('home')->with('message', ['type' => 'success', 'text' => 'Post has successfully created!']);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        Post::destroy($post->id);
        return redirect()->route('home')->with('message', ["type" => "success", "text" => "Post has successfully deleted!"]);
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', [
            'post' => $post,
            'title' => 'Edit Post - LaraGram',
        ]);
    }

    public function update(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $photo_validation = '';
        if ($user->username !== $request->username) {
            $username_validation = '|unique:users,username';
        }
        if ($request->file('photo')) {
            $photo_validation = 'image|mimes:jpeg,jpg,png,bmp,gif,svg|max:512';
        }

        $this->validate($request, [

            "photo" => $photo_validation
        ]);

    }
}
