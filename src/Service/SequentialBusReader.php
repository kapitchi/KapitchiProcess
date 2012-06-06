<?php

namespace KapitchiProcess\Service;

use Zend\Session\Container as SessionContainer,
    ZfcBase\Service\ServiceAbstract,
    KapitchiProcess\Processor\SequentialBusReader as SequentialBusReaderModel;

class SequentialBusReader extends ServiceAbstract
{
    protected $namespace = __CLASS__;
    protected $processor;
    protected $sessionContainer;

    public function readNext($processId) {
        $reader = $this->get($processId);
        $data = $reader->readNext();
        $this->store($reader);
        
        $registry = $this->getProcessor()->getRegistry();
        $process = $registry->get($processId);

        $executionTime = 0;
        $started = $process->getStarted();
        $finished = $process->getFinished();
        if($started) {
            if(!$finished) {
                $finished = time();
            }
            
            $executionTime = $finished - $started;
        }
        
        return array(
            'is_finished' => !empty($finished),
            'is_started' => !empty($started),
            'excecution_time' => $executionTime,
            'data' => $data,
        );
    }
    
    public function get($processId)
    {
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
    
    public function store(SequentialBusReaderModel $reader)
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