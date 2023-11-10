<?php

namespace App\Abstracts;

use Symfony\Component\Process\Process;

abstract class AbstractFileOperation
{
    protected $key;
    protected $value;
    protected $filepath;

    public function __construct($key, $value, $filepath)
    {
        $this->key = escapeshellarg($key);
        $this->value = escapeshellarg($value);
        $this->filepath = escapeshellarg($filepath);
    }

    public function execute()
    {
        $command = $this->getCommand();
        $process = Process::fromShellCommandline($command);
        $process->run();
    }

    protected abstract function getCommand();
}
