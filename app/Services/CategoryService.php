<?php

namespace App\Services;

use App\Models\Category;

/**
 * Class CategoryService.
 */
class CategoryService
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * CategoryService constructor.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get all categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllCategories()
    {
        return $this->category->all();
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data)
    {
        return $this->category->create($data);
    }

    /**
     * Update an existing category.
     *
     * @param Category $category
     * @param array $data
     * @return bool
     */
    public function update(Category $category, array $data)
    {
        return $category->update($data);
    }

    /**
     * find a category by ID.
     */
    public function findById($id)
    {
        return $this->category->find($id);
    }

    /**
     * Find a category by slug.
     *
     * @param string $slug
     * @return Category|null
     */
    public function findBySlug($slug)
    {
        return $this->category->where('slug', $slug)->first();
    }

    /**
     * Delete a category.
     *
     * @param Category $category
     * @return bool|null
     */
    public function delete(Category $category)
    {
        return $category->delete();
    }
}
