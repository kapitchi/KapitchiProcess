<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess\Processor;

use KapitchiProcess\Process\ProcessInterface;
use KapitchiProcess\Process\GenericProcess;
use KapitchiProcess\Job\JobInterface;
use KapitchiProcess\Job\SerializableJobInterace;
use KapitchiProcess\Job\Manager as JobManager;
use KapitchiProcess\Process\GenericProcessOutput;

class Processor
{
    protected $bus;
    protected $registry;
    protected $jobManager;
    protected $maxExecutionTime;
    protected $runningProcess;
    
    public function __construct(RegistryInterface $registry, BusInterface $bus, JobManager $jobManager)
    {
        $this->setRegistry($registry);
        $this->setBus($bus);
        $this->setJobManager($jobManager);
    }
    
    public function registerJob($job)
    {
        $process = new GenericProcess($job);
        $this->registerProcess($process);
        
        return $process;
    }
    
    public function registerProcess(ProcessInterface $process) {
        $job = $process->getJob();
        
        if($job instanceof JobInterface) {
            if(!$job instanceof SerializableJobInterace) {
                throw new \RuntimeException("Job object can't be registered as it's not serializable");
            }
        }
        else {
            if(!$this->getJobManager()->has($job)) {
                throw new \RuntimeException("Job '$job' is not registered with job manager");
            }
        }
        
        $this->getRegistry()->register($process);
        $this->getBus()->writeStdout($process->getId(), '');//init the bus
    }

    public function run($process) {
        if($this->runningProcess !== null) {
            throw new \Exception("Can't run multiple processes at the same time from same thread");
        }
        
        $registry = $this->getRegistry();
        if(!$process instanceof ProcessInterface) {
            $process = $registry->get($process);
        }
        
        if($process->getStarted()) {
            throw new \Exception("Can't run process which has been started once");
        }
        
        $job = $process->getJob();
        if(!$job instanceof SerializableJobInterace) {
            $jobHandle = $job;
            $job = $this->getJobManager()->get($jobHandle);
            if(!$job instanceof JobInterface) {
                throw new \Exception("Job '$jobHandle' is not registered with job manager");
            }
        }
        
        $process->setStarted(time());
        $registry->store($process);
        $this->runningProcess = $process;
        
        //TODO - getter/setter
        $processOutput = new GenericProcessOutput($this, $process);
        
        //http://php.net/manual/en/function.ob-start.php
        //"Prior to PHP 5.4.0, the value 1 was a special case value that set the chunk size to 4096 bytes."
        //ob_start(array($this, 'writeStdoutOutput'), 2);
        $job->run($processOutput);
        //ob_end_flush();
        
        $process->setFinished(time());
        $registry->store($process);
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
    
    public function getJobManager()
    {
        return $this->jobManager;
    }

    public function setJobManager($jobManager)
    {
        $this->jobManager = $jobManager;
    }
}