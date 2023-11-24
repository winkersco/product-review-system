<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ProductCommentFileFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'product-comment-file';
    }
}
