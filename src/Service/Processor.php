<?php

namespace KapitchiProcess\Service;

use KapitchiProcess\Process\ProcessInterface,
    KapitchiProcess\Output\OutputInterface;

class Processor
{
    protected $output;
    protected $registry;
    protected $runningProcess;

    public function registerProcess(ProcessInterface $process) {
        $this->getRegistry()->register($process);
    }

    public function run($pid) {
        if($this->runningProcess !== null) {
            throw new \Exception("Can't run multiple processes at the same time from same thread");
        }
        
        $process = $this->getRegistry()->get($pid);
        $this->runningProcess = $process;
        
        //http://php.net/manual/en/function.ob-start.php
        //"Prior to PHP 5.4.0, the value 1 was a special case value that set the chunk size to 4096 bytes."
        ob_start(array($this, 'writeStdoutOutput'), 2);
        $process->run($this->getOutput());
        ob_end_flush();
        
        $this->runningProcess = null;
    }

    public function getProcess($pid)
    {
        return $this->getRegistry()->get($pid);
    }
    
    public function getRunningProcess()
    {
        return $this->runningProcess;
    }

    public function writeStdoutOutput($data)
    {
        $this->getOutput()->writeStdout($this->getRunningProcess()->getPid(), $data);
        return $data;
    }

    public function getRegistry()
    {
        return $this->registry;
    }

    public function setRegistry($registry)
    {
        $this->registry = $registry;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput($output)
    {
        $this->output = $output;
    }
    
}