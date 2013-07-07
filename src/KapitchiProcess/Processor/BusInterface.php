<?php

namespace KapitchiProcess\Processor;

interface BusInterface
{
    public function writeStdout($pid, $data);
    public function readStdout($pid, $offset = null);
}