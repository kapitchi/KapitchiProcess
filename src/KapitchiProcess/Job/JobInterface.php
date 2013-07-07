<?php

namespace KapitchiProcess\Job;

use KapitchiProcess\Process\ProcessOutputInterface;

interface JobInterface
{
    public function run(ProcessOutputInterface $output, $data);
    public function __toString();
}