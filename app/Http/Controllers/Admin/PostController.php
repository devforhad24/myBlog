<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        $objPost = new Post();

        $posts = $objPost->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'categories.name as category_name')
            ->get();

            // dd($posts);

        return view('admin.post', compact('categories', 'posts'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'sub_title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'status' => $request->status,
        ];

        if($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $file_name = time() . '.' . $extension;
            // $file->move(public_path('post_thumbnails'), $file_name);
            
            // Resize Image
            $thumbnail = Image::make($file);
            $thumbnail->resize(600,360)->save(public_path('post_thumbnails/' .$file_name));
            $data['thumbnail'] = $file_name;
        }

        Post::create($data);
        $notify = ['message' => 'Post created successfully!', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'sub_title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'status' => $request->status,
        ];

        if($request->hasFile('thumbnail')) {
            if($request->old_thumb) {
                File::delete(public_path('post_thumbnails/' . $request->old_thumb));
            }

            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $file_name = time() . '.' . $extension;
            // $file->move(public_path('post_thumbnails'), $file_name);
            // Resize Image
            $thumbnail = Image::make($file);
            $thumbnail->resize(600,360)->save(public_path('post_thumbnails/' .$file_name));
            $data['thumbnail'] = $file_name;
        }

        Post::where('id', $id)->update($data);
        $notify = ['message' => 'Post updated successfully!', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if($post->thumbnail) {
            File::delete(public_path('post_thumbnails/' . $post->thumbnail));
        }
        $post->delete();
        $notify = ['message' => 'Post deleted successfully!', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
    }
}
