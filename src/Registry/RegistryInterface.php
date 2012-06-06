<?php

namespace KapitchiProcess\Registry;

use KapitchiProcess\Process\ProcessInterface;

interface RegistryInterface
{
    public function listProcessIds();
    public function register(ProcessInterface $process);
    public function unregister($pid);
    public function start(ProcessInterface $process);
    public function finish(ProcessInterface $process);
    public function get($pid);
}