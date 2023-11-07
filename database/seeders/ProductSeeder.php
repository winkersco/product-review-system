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
        Product::updateOrCreate(['name' => 'A']);
        Product::updateOrCreate(['name' => 'B']);
        Product::updateOrCreate(['name' => 'C']);
    }
}
