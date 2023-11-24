<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Interface CommentRepositoryInterface
 * @package App\Repositories
 */
interface CommentRepositoryInterface
{
    /**
     * Create a new comment for a product.
     *
     * @param Product $product
     * @param User $user
     * @param array $data
     *
     * @return Comment
     */
    public function createComment(Product $product, User $user, array $data): Comment;

    /**
     * Check if the user has reached the maximum comment limit for the product.
     *
     * @param User $user
     * @param Product $product
     * @param int $limit
     *
     * @return bool
     */
    public function hasReachedCommentLimit(User $user, Product $product, int $limit): bool;

    /**
     * get number of comments of product.
     *
     * @param Product $product
     *
     * @return int
     */
    public function getCommentsCount(Product $product): int;
}
