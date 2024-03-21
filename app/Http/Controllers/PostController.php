<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::orderBy('name', 'asc')->get();

        return view('post.post', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.post-add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:post',
        
            'content' => 'required',
        
        ]);

        $post = Post::create($request->all());

        Alert::success('Success', 'Post has been saved !');
        return redirect('/post');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_post)
    {
        $post = Post::findOrFail($id_post);

        return view('post.post-edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_post)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:post,name,' . $id_post . ',id_post',
            'content' => 'required',

        ]);

        $post = Post::findOrFail($id_post);
        $post->update($validated);

        Alert::info('Success', 'post has been updated !');
        return redirect('/post');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_post)
    {
        try {
            $deletedpost = post::findOrFail($id_post);

            $deletedpost->delete();

            Alert::error('Success', 'post has been deleted !');
            return redirect('/post');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, post already used !');
            return redirect('/post');
        }
    }
}
