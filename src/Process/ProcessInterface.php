<?php

namespace KapitchiProcess\Process;

use KapitchiProcess\Job\JobInterface;

interface ProcessInterface {
    public function getJob();
    public function setJob(JobInterface $job);
    public function getId();
    public function setId($pid);
    public function getRegistered();
    public function setRegistered($registered);
    public function getStarted();
    public function setStarted($started);
    public function getFinished();
    public function setFinished($finished);
}