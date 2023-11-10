<?php

namespace App\Factories;

use App\Abstracts\AbstractFileOperation;

class ReplaceFileOperationFactory extends AbstractFileOperation
{
    /**
     * Get the command for replacing a specific key in a file.
     *
     * @return string
     */
    protected function getCommand()
    {
        return "sed -i 's/^{$this->key}:.*/{$this->key}:{$this->value}/g' {$this->filepath}";
    }
}
