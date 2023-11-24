<?php

namespace App\Services;

use App\Factories\AppendFileOperationFactory;
use App\Factories\ReplaceFileOperationFactory;

class ProductCommentFileService
{
    public function updateFile($key, $value, $filepath, $newItem = true)
    {
        if ($newItem) {
            $factory = new AppendFileOperationFactory($key, $value, $filepath);
        } else {
            $factory = new ReplaceFileOperationFactory($key, $value, $filepath);
        }
        $factory->execute();
    }
}
