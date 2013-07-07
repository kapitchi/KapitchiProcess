<?php

namespace KapitchiProcess\Job;

use Zend\ServiceManager\AbstractPluginManager;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Manager extends AbstractPluginManager
{
    public function validatePlugin($plugin)
    {
        if(!$plugin instanceof JobInterface) {
            throw new \Exception("Not JobInterface object");
        }
        
    }
}