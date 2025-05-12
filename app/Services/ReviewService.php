<?php

namespace App\Services;

use App\Models\Reviews;

/**
 * Class ReviewService.
 */
class ReviewService
{
    /**
     * Get all reviews.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllReviews()
    {
        return Reviews::all();
    }

    /**
     * Create a new review.
     *
     * @param array $data
     * @return Reviews
     */
    public function createReview(array $data)
    {
        return Reviews::create($data);
    }

    /**
     * Find a review by ID.
     *
     * @param string $id
     * @return Reviews|null
     */
    public function findReviewById(string $id)
    {
        return Reviews::find($id);
    }
}
