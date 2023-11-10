<?php

namespace App\Abstracts;

use Symfony\Component\Process\Process;

/**
 * Abstract class representing a file operation.
 *
 * @package App\Abstracts
 */
abstract class AbstractFileOperation
{
    protected $key;
    protected $value;
    protected $filepath;

    /**
     * Constructor for AbstractFileOperation.
     *
     * @param string $key      The key.
     * @param string $value    The value.
     * @param string $filepath The filepath.
     */
    public function __construct($key, $value, $filepath)
    {
        $this->key = escapeshellarg($key);
        $this->value = escapeshellarg($value);
        $this->filepath = escapeshellarg($filepath);
    }

    /**
     * Execute the file operation.
     */
    public function execute()
    {
        $command = $this->getCommand();
        $process = Process::fromShellCommandline($command);
        $process->run();
    }

    /**
     * Get the command for the file operation.
     *
     * @return string The command.
     */
    protected abstract function getCommand();
}
