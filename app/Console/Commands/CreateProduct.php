<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Console\Command;

class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new product';

    protected $productRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        if ($this->productRepository->existsByName($name)) {
            $this->error("Product '{$name}' already exists.");
            return;
        }

        $this->productRepository->createProduct([
            'name' => $name,
        ]);

        $this->info("Product '{$name}' created successfully.");
        return 0;
    }
}
