<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess\Processor;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class SequentialBusReader
{
    protected $bus;
    protected $processId;
    protected $offset = 0;

    public function reset()
    {
        $this->setOffset(0);
    }
    
    public function readNext()
    {
        $offset = $this->getOffset();
        $data = $this->getBus()->readStdout($this->getProcessId(), $offset);
        $offset += strlen($data);
        $this->setOffset($offset);
        
        return $data;
    }
    
    public function getProcessId()
    {
        return $this->processId;
    }

    public function setProcessId($processId)
    {
        $this->processId = $processId;
    }
        
    public function getBus()
    {
        return $this->bus;
    }

    public function setBus($bus)
    {
        $this->bus = $bus;
    }
    
    public function getOffset()
    {
        return $this->offset;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
}