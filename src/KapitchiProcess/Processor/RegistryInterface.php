<?php

namespace KapitchiProcess\Processor;

use KapitchiProcess\Process\ProcessInterface;

interface RegistryInterface
{
    public function listProcessIds();
    public function register(ProcessInterface $process);
    public function store(ProcessInterface $process);
    public function get($pid);
    public function has($pid);
    public function unregister(ProcessInterface $process);
}