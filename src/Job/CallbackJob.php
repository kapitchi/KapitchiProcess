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
    
    public function __construct($callback)
    {
        $this->callbackHandler = new \Zend\Stdlib\CallbackHandler($callback);
    }
            
    public function run(ProcessOutputInterface $output)
    {
        $this->callbackHandler->call(array($output));
    }

}