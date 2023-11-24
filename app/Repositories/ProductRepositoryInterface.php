<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface ProductRepositoryInterface
 * @package App\Repositories
 */
interface ProductRepositoryInterface
{
    /**
     * Get all products with pagination.
     *
     * @return LengthAwarePaginator
     */
    public function getAllProducts(): LengthAwarePaginator;

    /**
     * check if a product exists by name.
     *
     * @param string $name
     *
     * @return bool
     */
    public function existsByName(string $name): bool;

    /**
     * Create a new product.
     *
     * @param array $data
     *
     * @return Product
     */
    public function createProduct(array $data): Product;

    /**
     * First or create a product.
     *
     * @param array $data
     *
     * @return Product
     */
    public function firstOrCreateProduct(array $data): Product;
}
