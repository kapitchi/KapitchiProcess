<?php

namespace KapitchiProcess\Process;

use KapitchiProcess\Output\OutputInterface;

interface ProcessInterface
{
    public function run(OutputInterface $output);
    public function getPid();
    public function setPid($pid);
    public function getRegistered();
    public function setRegistered($registered);
    public function getStarted();
    public function setStarted($started);
}