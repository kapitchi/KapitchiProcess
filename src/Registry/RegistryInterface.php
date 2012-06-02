<?php

namespace KapitchiProcess\Registry;

use KapitchiProcess\Process\ProcessInterface;

interface RegistryInterface
{
    public function register(ProcessInterface $process);
    public function unregister($pid);
    public function get($pid);
}