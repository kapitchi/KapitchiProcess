<?php

namespace KapitchiProcess\Job;

use KapitchiProcess\ProcessOutput\ProcessOutputInterface;

interface JobInterface
{
    public function run(ProcessOutputInterface $output);
}