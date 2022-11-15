<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $temp_file = TemporaryFile::where('folder', $request->image)->first();
        if ($temp_file) {
            Storage::copy('posts/tmp/'.$temp_file->folder.'/'.$temp_file->file, 'posts/'.$temp_file->folder.'/'.$temp_file->file);

            Post::create([
                'title' => $request->title,
                'image' => $temp_file->folder.'/'.$temp_file->file,
            ]);
            Storage::deleteDirectory('posts/tmp/'.$temp_file->folder);
            $temp_file->delete();

            return redirect('/')->with('success', 'Post Created');
        } else {
            return redirect('/')->with('error', 'Please uplaod an image');
        }
    }

    public function tempUplaod(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();
            $folder = uniqid('post', true);
            $image->storeAs('posts/tmp/'.$folder, $file_name);
            TemporaryFile::create([
                'folder' => $folder,
                'file' => $file_name,
            ]);

            return $folder;
        } else {
            return '';
        }
    }

    public function tempDelete()
    {
    }
}
