<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(User $user)
    {
        return view('users.index', [
            "title" => $user->username . " | LaraGram",
            "user"  => $user
        ]);
    }

    public function show(User $user, Post $post)
    {
        return view('users.show', [
            "title" => $user->username . '\'s' . " Posts | LaraGram",
            "user"  => $user,
            "post"  => $post
        ]);
    }
}
