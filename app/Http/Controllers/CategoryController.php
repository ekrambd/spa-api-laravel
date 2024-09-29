<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try
        {
            $categories = Category::latest()->get();
            return response()->json(['success'=>count($categories)>0, 'data'=>$categories]);
        }catch(Exception $e){
            return response()->json(['success'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()]);
        }
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
        try
        {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|string|unique:categories',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was Invalid', 'data'=>$validator->errors()],422);  
            }

            $category = new Category();
            $category->category_name = $request->category_name;
            $category->save();

            return response()->json(['success'=>true, 'category_id'=>intval($category->id), 'message'=>'Successfully a category has been added']);

        }catch(Exception $e){
            return response()->json(['success'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json(['success'=>true, 'data'=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|string|max:50|unique:categories,category_name,' . $category->id,
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was Invalid', 'data'=>$validator->errors()],422);  
            }


            $category->category_name = $request->category_name;
            $category->update();

            return response()->json(['success'=>true, 'category_id'=>intval($category->id), 'message'=>'Successfully the category has been updated']);

        }catch(Exception $e){
            return response()->json(['success'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try
        {
            $category->delete();
            return response()->json(['success'=>true, 'message'=>'Successfully the category has been deleted']);
        }catch(Exception $e){
            return response()->json(['success'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()]);
        }
    }
}
