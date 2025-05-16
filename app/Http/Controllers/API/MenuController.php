<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Services\MenuService;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = $this->menuService->getAllMenus();
        return response()->json([
            'status' => 'success',
            'menus' => $menus
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(MenuRequest $request)
    {
        $imagePath = null;

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $menu = $this->menuService->create([
            'id' => uniqid(),
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'detail' => $validated['detail'],
            'status' => 1,
            'category_id' => $validated['category_id'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Menu created successfully',
            'menu' => $menu
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
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Find menus by category.
     */
    public function findByCategory($category)
    {
        $menus = $this->menuService->getMenuByCategoryId($category);

        return response()->json([
            'status' => 'success',
            'menus' => $menus
        ]);
    }

    /**
     * Find menu by ID.
     */
    public function findById($id)
    {
        $menu = $this->menuService->getMenuById($id);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'menu' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, $id)
    {
        $validated = $request->validated();

        $menu = $this->menuService->getMenuById($id);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu not found'
            ], 404);
        }

        $menu->name = $validated['name'];
        $menu->price = $validated['price'];
        $menu->description = $validated['description'];
        $menu->image = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : $menu->image;
        $menu->detail = $validated['detail'];
        $menu->status = $validated['status'];
        $menu->category_id = $validated['category_id'];
        $menu->save();

        return response()->json([
            'message' => 'Menu updated successfully',
            'menu' => $menu
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $menu = $this->menuService->getMenuById($id);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu not found'
            ], 404);
        }

        $this->menuService->update($menu, [
            'status' => 0
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Menu deleted successfully',
            'menu' => $menu
        ]);
    }
}
