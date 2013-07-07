<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess\Process;

/**
 * 
 * @author Matus Zeman <mz@kapitchi.com>
 */
class GenericProcess implements ProcessInterface {
    protected $id;
    protected $job;
    protected $jobName;
    protected $started;
    protected $finished;
    protected $registered;
    protected $registry;
    
    public function __construct($job = null)
    {
        if($job) {
            $this->setJob($job);
        }
    }

    public function getJob()
    {
        return $this->job;
    }

    public function setJob($job)
    {
        $this->job = $job;
    }
    
    public function getJobName()
    {
        return $this->jobName;
    }

    public function setJobName($jobName)
    {
        $this->jobName = $jobName;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
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

    public function getFinished() {
        return $this->finished;
    }

    public function setFinished($finished) {
        $this->finished = $finished;
    }
    
    public function getRegistry()
    {
        return (array)$this->registry;
    }

    public function setRegistry(array $registry)
    {
        $this->registry = $registry;
    }

}