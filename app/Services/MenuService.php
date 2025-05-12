<?php

namespace App\Services;

use App\Models\Menu;

/**
 * Class MenuService.
 */
class MenuService
{
    /**
     * Get all menu items.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllMenus()
    {
        return Menu::all();
    }
    /**
     * Get a single menu item by Category ID.
     */
    public function getMenuByCategoryId($categoryId)
    {
        return Menu::where('category_id', $categoryId)->get();
    }
    /**
     * Get a single menu item by ID.
     *
     * @param int $id
     * @return Menu|null
     */
    public function getMenuById($id): ?Menu
    {
        return Menu::find($id);
    }
    /**
     * Create a new menu item.
     *
     * @param array $data
     * @return Menu
     */
    public function create(array $data): Menu
    {
        return Menu::create($data);
    }

    /**
     * Update an existing menu item.
     *
     * @param Menu $menu
     * @param array $data
     * @return Menu
     */
    public function update(Menu $menu, array $data): Menu
    {
        $menu->update($data);
        return $menu;
    }

    /**
     * Delete a menu item.
     *
     * @param Menu $menu
     * @return bool|null
     */
    public function delete(Menu $menu): ?bool
    {
        return $menu->delete();
    }
}
