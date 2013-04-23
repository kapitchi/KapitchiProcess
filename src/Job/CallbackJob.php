<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess\Job;

use KapitchiProcess\Process\ProcessOutputInterface;

class CallbackJob implements JobInterface
{
    protected $callbackHandler;
    protected $name;
    
    public function __construct($callback, $name = null)
    {
        $this->callbackHandler = new \Zend\Stdlib\CallbackHandler($callback);
        $this->name = $name;
    }
            
    public function run(ProcessOutputInterface $output, $data)
    {
        $this->callbackHandler->call(array($output, $data));
    }

    public function __toString()
    {
        if($this->name) {
            return __CLASS__ . ': ' . $this->name;
        }
        return __CLASS__;
    }
}