<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $post = Post::count();

        return view('dashboard.dashboard', [
            'post' => $post,
        ]);
    }
}
