<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess\Process;

use KapitchiProcess\Processor\Processor;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class GenericProcessOutput implements ProcessOutputInterface
{
    protected $process;
    protected $processor;
    
    public function __construct(Processor $processor, ProcessInterface $process)
    {
        $this->setProcessor($processor);
        $this->setProcess($process);
    }
    
    public function writeStdout($data)
    {
        $this->getProcessorBus()->writeStdout($this->getProcess()->getId(), $data);
    }

    public function setRegistryValue($registry, $value)
    {
        $process = $this->getProcess();
        $values = $process->getRegistry();
        $values[$registry] = $value;
        $process->setRegistry($values);
        
        $this->getProcessor()->getRegistry()->store($process);
    }

    /**
     * 
     * @return ProcessInterface
     */
    protected function getProcess()
    {
        return $this->process;
    }

    protected function setProcess(ProcessInterface $process)
    {
        $this->process = $process;
    }
    
    /**
     * 
     * @return Processor
     */
    protected function getProcessor()
    {
        return $this->processor;
    }

    protected function setProcessor($processor)
    {
        $this->processor = $processor;
    }
    
    protected function getProcessorBus()
    {
        return $this->getProcessor()->getBus();
    }
    
}