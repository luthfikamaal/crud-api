<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return APIFormatter::make(Response::HTTP_OK, 'OK', ['posts' => $posts]);
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
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'category_id' => ['required'],
            'body' => ['required']
        ]);
        if ($validator->fails()) {
            $error = $validator->errors();
            return APIFormatter::make(Response::HTTP_UNAUTHORIZED, 'data failed to add', ['error' => $error]);
        }
        $posts = Post::all();
        $slug = Str::slug($request->title, '-');
        foreach ($posts as $post) {
            if ($post->slug == $slug) {
                return APIFormatter::make(Response::HTTP_UNAUTHORIZED, 'data failed to add', ['error' => ['slug' => 'The slug has already been taken.']]);
            }
        }

        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'body' => $request->body
        ]);

        return APIFormatter::make(Response::HTTP_OK, 'OK', ['message' => 'data has been added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return APIFormatter::make(Response::HTTP_OK, 'OK', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return APIFormatter::make(Response::HTTP_OK, 'OK', ['post' => $post]);
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
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'category_id' => ['required'],
            'body' => ['required']
        ]);
        if ($validator->fails()) {
            $error = $validator->errors();
            return APIFormatter::make(Response::HTTP_UNAUTHORIZED, 'data failed to update', ['error' => $error]);
        }
        $posts = Post::all();
        $slug = Str::slug($request->title, '-');
        foreach ($posts as $post) {
            if ($post->slug == $slug) {
                return APIFormatter::make(Response::HTTP_UNAUTHORIZED, 'data failed to add', ['error' => ['slug' => 'The slug has already been taken.']]);
            }
        }
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->slug = Str::slug($request->title, '-');
        $post->body = $request->body;
        $post->save();

        return APIFormatter::make(Response::HTTP_OK, 'OK', ['message' => 'data has been updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return APIFormatter::make(Response::HTTP_OK, 'OK', ['message' => 'data has been deleted']);
    }
}