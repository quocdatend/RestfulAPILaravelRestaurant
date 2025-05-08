<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'status' => 'success',
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategoryRequest $request)
    {
        $validated = $request->validated();

        $category = Category::create([
            'id' => uniqid(),
            'name' => $validated['name'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'category' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryRequest $request, $id)
    {
        $validated = $request->validated();

        $category = Category::findOrFail($id);

        $category->name = $validated['name'];
        $category->save();

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
}
