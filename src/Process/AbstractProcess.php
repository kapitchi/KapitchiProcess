<?php

namespace KapitchiProcess\Process;

abstract class AbstractProcess implements ProcessInterface
{
    protected $pid;
    protected $started;
    protected $registered;

    public function getPid() {
        return $this->pid;
    }

    public function setPid($pid) {
        $this->pid = $pid;
    }

    public function getStarted() {
        return $this->started;
    }

    public function setStarted($started) {
        $this->started = $started;
    }
    
    public function getRegistered() {
        return $this->registered;
    }

    public function setRegistered($registered) {
        $this->registered = $registered;
    }

}