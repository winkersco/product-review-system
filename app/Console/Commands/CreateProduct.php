<?php

namespace App\Console\Commands;

use App\Models\Product;
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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        if (Product::where('name', $name)->exists()) {
            $this->error("Product '{$name}' already exists.");
            return;
        }

        Product::create([
            'name' => $name,
        ]);

        $this->info("Product '{$name}' created successfully.");
        return 0;
    }
}
