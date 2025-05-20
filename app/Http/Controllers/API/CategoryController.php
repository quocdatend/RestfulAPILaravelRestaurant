<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * CategoryController constructor.
     *
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return CategoryResource::collection($categories);
        // return response()->json([
        //     'status' => 'success',
        //     'categories' => $categories
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategoryRequest $request)
    {
        $imagePath = null;

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $category = $this->categoryService->create([
            'id' => uniqid(),
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'image' => $imagePath,
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
     * Display the specified resource by slug.
     */
    public function findBySlug($slug)
    {
        $category = $this->categoryService->findBySlug($slug);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryRequest $request, $id)
    {
        $validated = $request->validated();

        $category = $this->categoryService->findById($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        $this->categoryService->update($category, [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = $this->categoryService->findById($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }
        // image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = $category->image;
        }

        // if name is not empty
        if ($request->name) {
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
        }

        $this->categoryService->update($category, [
            'name' => $category->name,
            'slug' => $category->slug,
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = $this->categoryService->findById($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        $this->categoryService->delete($category);

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
}
