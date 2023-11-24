<?php

namespace App\Providers;

use App\Services\ProductCommentFileService;
use Illuminate\Support\ServiceProvider;

class ProductCommentFileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('product-comment-file', function () {
            return new ProductCommentFileService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
