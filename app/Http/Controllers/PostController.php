<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('post_create', compact('posts'));
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
        $validator = Validator::make($request->all(),[
            'title' => 'required'
        ]);
        $temp_file = TemporaryFile::where('folder', $request->image)->first();
        if ($validator->fails() && $temp_file) {
            Storage::deleteDirectory('posts/tmp/'.$temp_file->folder);
            $temp_file->delete();
            return redirect('/')->withErrors($validator)->withInput();

        }elseif ($validator->fails()){
            return redirect('/')->withErrors($validator)->withInput();
        }

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
        $temp_file =TemporaryFile::where('folder',request()->getContent())->first();
        if ($temp_file) {
            Storage::deleteDirectory('posts/tmp/'.$temp_file->folder);
            $temp_file->delete();
            return response('');
        }
    }
}
