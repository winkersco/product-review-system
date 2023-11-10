<?php

namespace App\Factories;

use App\Abstracts\AbstractFileOperation;

class AppendFileOperationFactory extends AbstractFileOperation
{
    /**
     * Get the command for replacing a specific key in a file.
     *
     * @return string
     */
    protected function getCommand()
    {
        return "echo {$this->key}:{$this->value} >> {$this->filepath}";
    }
}
