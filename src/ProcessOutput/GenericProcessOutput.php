<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess\ProcessOutput;

use KapitchiProcess\Process\ProcessInterface,
    KapitchiProcess\Processor\BusInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class GenericProcessOutput implements ProcessOutputInterface
{
    protected $process;
    protected $processorBus;
    
    public function getProcess()
    {
        return $this->process;
    }

    public function setProcess(ProcessInterface $process)
    {
        $this->process = $process;
    }
 
    public function getProcessorBus()
    {
        return $this->processorBus;
    }

    public function setProcessorBus(BusInterface $processorBus)
    {
        $this->processorBus = $processorBus;
    }

    public function writeStdout($data)
    {
        $this->getProcessorBus()->writeStdout($this->getProcess()->getId(), $data);
    }
}