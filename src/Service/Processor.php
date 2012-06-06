<?php

namespace KapitchiProcess\Service;

use KapitchiBase\Stdlib\Options,
    KapitchiProcess\Process\ProcessInterface,
    KapitchiProcess\Process\GenericProcess,
    KapitchiProcess\Job\JobInterface,
    KapitchiProcess\ProcessOutput\GenericProcessOutput;

class Processor
{
    protected $bus;
    protected $registry;
    protected $maxExecutionTime;
    protected $runningProcess;
    
    public function __construct($options = null)
    {
        if($options instanceof Options) {
            $this->setRegistry($options->getRegistry());
            $this->setBus($options->getBus());
        }
    }
    
    public function registerJob(JobInterface $job) {
        $process = new GenericProcess();
        $process->setJob($job);
        
        $this->registerProcess($process);
        
        return $process;
    }
    
    public function registerProcess(ProcessInterface $process) {
        $this->getRegistry()->register($process);
    }

    public function run($process) {
        if($this->runningProcess !== null) {
            throw new \Exception("Can't run multiple processes at the same time from same thread");
        }
        
        $registry = $this->getRegistry();
        if(!$process instanceof ProcessInterface) {
            $process = $registry->get($process);
        }
        
        $job = $process->getJob();
        if(!$job instanceof JobInterface) {
            throw new \Exception("Process has got no job. Can't run this!");
        }
        
        if($process->getStarted()) {
            throw new \Exception("Can't run process which has been started once");
        }
                
        $registry->start($process);
        $this->runningProcess = $process;
        
        //TODO - getter/setter
        $processOutput = new GenericProcessOutput();
        $processOutput->setProcess($process);
        $processOutput->setProcessorBus($this->getBus());
        
        //http://php.net/manual/en/function.ob-start.php
        //"Prior to PHP 5.4.0, the value 1 was a special case value that set the chunk size to 4096 bytes."
        //ob_start(array($this, 'writeStdoutOutput'), 2);
        $job->run($processOutput);
        //ob_end_flush();
        
        $registry->finish($process);
        $this->runningProcess = null;
    }

    /**
     * @param string $pid
     * @return KapitchiProcess\Process\ProcessInterface
     */
    public function getProcess($pid)
    {
        return $this->getRegistry()->get($pid);
    }
    
    /**
     * @return KapitchiProcess\Process\ProcessInterface
     */
    public function getRunningProcess()
    {
        return $this->runningProcess;
    }

    public function writeStdoutOutput($data)
    {
        $this->getProcessor()->writeStdout($this->getRunningProcess()->getId(), $data);
        //return $data;
    }
    
    public function getMaxExecutionTime()
    {
        if($this->maxExecutionTime === null) {
            $this->maxExecutionTime = ini_get('max_execution_time');
        }
        return $this->maxExecutionTime;
    }

    public function setMaxExecutionTime($maxExecutionTime)
    {
        $this->maxExecutionTime = $maxExecutionTime;
    }
    
    /**
     * @return KapitchiProcess\Registry\RegistryInterface
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    public function setRegistry($registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return KapitchiProcess\Processor\BusInterface
     */
    public function getBus()
    {
        return $this->bus;
    }

    public function setBus($bus)
    {
        $this->bus = $bus;
    }
    
}