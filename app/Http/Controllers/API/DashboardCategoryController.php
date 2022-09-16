<?php

namespace App\Http\Controllers\API;

use App\Helpers\APIFormatter;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class DashboardCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return APIFormatter::make(Response::HTTP_OK, 'OK', ['categories' => $categories]);
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
            'name' => ['required'],
            'slug' => ['required', 'unique:categories']
        ]);
        if ($validator->fails()) {
            $error = $validator->errors();
            return APIFormatter::make(Response::HTTP_UNAUTHORIZED, 'category failed to add', ['error' => $error]);
        }
        Category::create($request->all(), [
            'name' => $request->name,
            'slug' => $request->slug
        ]);
        return APIFormatter::make(Response::HTTP_OK, 'OK', ['message' => 'category has been added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return APIFormatter::make(Response::HTTP_OK, 'OK', $category);
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
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'slug' => ['required', 'unique:post']
        ]);
        if ($validator->fails()) {
            $error = $validator->errors();
            return APIFormatter::make(Response::HTTP_UNAUTHORIZED, 'category failed to add', ['error' => $error]);
        }
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->save();

        return APIFormatter::make(Response::HTTP_OK, 'OK', ['message' => 'data has been updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Category::destroy($category->id);
        return APIFormatter::make(Response::HTTP_OK, 'OK', ['message' => 'category has been deleted']);
    }
}