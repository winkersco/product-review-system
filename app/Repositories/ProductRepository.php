<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ProductRepository
 * @package App\Repositories
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Get all products with pagination.
     *
     * @return LengthAwarePaginator
     */
    public function getAllProducts(): LengthAwarePaginator
    {
        return Product::with('comments')->paginate();
    }

    /**
     * check if a product exists by name.
     *
     * @param string $name
     *
     * @return bool
     */
    public function existsByName(string $name): bool
    {
        return Product::where('name', $name)->exists();
    }

    /**
     * Create a new product.
     *
     * @param array $data
     *
     * @return Product
     */
    public function createProduct(array $data): Product
    {
        return Product::create([
            'name' => $data['name'],
        ]);
    }

    /**
     * First or create a product.
     *
     * @param array $data
     *
     * @return Product
     */
    public function firstOrCreateProduct(array $data): Product
    {
        return Product::firstOrCreate([
            'name' => $data['name'],
        ]);
    }
}
