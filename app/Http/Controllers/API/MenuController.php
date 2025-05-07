<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

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
    public function create(Request $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|decimal:0,2',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'detail' => 'nullable|string|max:1000',
            'status' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $menu = Menu::create([
            'id' => uniqid(),
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
            'detail' => $request->detail,
            'status' => $request->status,
            'category_id' => $request->category_id,
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $menu = Menu::findOrFail($id);

        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->description = $request->description;
        $menu->image = $request->image;
        $menu->detail = $request->detail;
        $menu->status = $request->status;
        $menu->category_id = $request->category_id;
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
