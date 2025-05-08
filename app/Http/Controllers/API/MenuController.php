<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
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

        $menu = Menu::create([
            'id' => uniqid(),
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'detail' => $validated['detail'],
            'status' => $validated['status'],
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
        $menus = Menu::where('category_id', $category)->get();

        return response()->json([
            'status' => 'success',
            'menus' => $menus
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, $id)
    {
        $validated = $request->validated();

        $menu = Menu::findOrFail($id);

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
        $menu = Menu::findOrFail($id);

        $menu->status = 0;
        $menu->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu deleted successfully',
            'menu' => $menu
        ]);
    }
}
