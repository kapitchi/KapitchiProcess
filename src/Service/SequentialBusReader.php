<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess\Service;

use Zend\Session\Container as SessionContainer;
use KapitchiBase\Service\AbstractService;
use KapitchiProcess\Process\ProcessInterface;
use KapitchiProcess\Processor\SequentialBusReader as SequentialBusReaderModel;
use KapitchiProcess\Processor\Processor;

class SequentialBusReader extends AbstractService
{
    protected $namespace = __CLASS__;
    protected $processor;
    protected $sessionContainer;

    public function __construct(Processor $processor)
    {
        $this->setProcessor($processor);
    }
    
    public function readNext($processId) {
        $registry = $this->getProcessor()->getRegistry();
        $process = $registry->get($processId);
        
        $reader = $this->getBusReader($process);
        $data = $reader->readNext();
        $this->storeBusReader($reader);
        
        $executionTime = 0;
        $started = $process->getStarted();
        $finished = $process->getFinished();
        if($started) {
            if($finished) {
                $executionTime = $finished - $started;
            }
            else {
                $executionTime = time() - $started;
            }
        }
        
        return array(
            'processId' => $processId,
            'isFinished' => !empty($finished),
            'isStarted' => !empty($started),
            'startedTime' => $started,
            'runningTime' => $executionTime,
            'registry' => $process->getRegistry(),
            'data' => $data,
        );
    }
    
    protected function getBusReader(ProcessInterface $process)
    {
        $processId = $process->getId();
        $session = $this->getSessionContainer();
        $bus = $this->getProcessor()->getBus();
        
        $busReader = new SequentialBusReaderModel();
        $busReader->setProcessId($processId);
        $busReader->setBus($bus);
        
        if(!isset($session->$processId)) {
            $session->$processId = 0;
        }
        $busReader->setOffset($session->$processId);
        
        return $busReader;
    }
    
    protected function storeBusReader(SequentialBusReaderModel $reader)
    {
        $session = $this->getSessionContainer();
        $processId = $reader->getProcessId();
        $session->$processId = $reader->getOffset();
    }
    
    public function getSessionContainer()
    {
        if($this->sessionContainer === null) {
            $this->sessionContainer = new SessionContainer($this->namespace);
        }
        return $this->sessionContainer;
    }
    
    public function setSessionContainer($sessionContainer)
    {
        $this->sessionContainer = $sessionContainer;
    }
        
    public function getProcessor()
    {
        return $this->processor;
    }

    public function setProcessor($processor)
    {
        $this->processor = $processor;
    }

}