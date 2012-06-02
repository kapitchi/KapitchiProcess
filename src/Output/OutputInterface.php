<?php

namespace KapitchiProcess\Output;

interface OutputInterface
{
    public function writeStdout($pid, $data);
    public function readStdout($pid, $offset = null);
}