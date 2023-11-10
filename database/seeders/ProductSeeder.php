<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->create(['name' => 'A']);
        Product::factory()->create(['name' => 'B']);
        Product::factory()->create(['name' => 'C']);
    }
}
