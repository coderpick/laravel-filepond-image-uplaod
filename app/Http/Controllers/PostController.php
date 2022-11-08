<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('post_create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();
            $folder = uniqid('post', true);
            $image->storeAs('posts/tmp/'.$folder, $file_name);
            Post::create([
                'title' => $request->title,
                'image' => $folder.'/'.$file_name,
            ]);

            return redirect('/')->with('success', 'Post Created');
        } else {
            return redirect('/')->with('error', 'Please uplaod an image');
        }
    }

    public function tempUplaod(Request $request)
    {
        $image = $request->file('image');
        $file_name = $image->getClientOriginalName();

        return $file_name;
    }

    public function tempDelete()
    {
    }
}
