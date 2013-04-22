<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess\Job;

use KapitchiProcess\Process\ProcessOutputInterface;
use RuntimeException as CommandEmptyException;

class ShellJob implements JobInterface, SerializableJobInterace
{
    protected $command;

    public function __construct($command = null) {
        if($command !== null) {
            $this->setCommand($command);
        }
    }
    
    public function run(ProcessOutputInterface $output) {
        $cmd = $this->getCommand();
        if(empty($cmd)) {
            throw new CommandEmptyException("Command is empty");
        }
        
        //passthru($cmd);
        $handle = popen($cmd, "r");
        if($handle === false) {
            throw new \Exception("Problem executing popen($cmd)");
        }
        
        while(!feof($handle)) {
            $data = fgets($handle);
            $output->writeStdout($data);
        }
        
        pclose($handle);
    }

    public function getCommand() {
        return $this->command;
    }

    public function setCommand($command) {
        $this->command = $command;
    }
    
    
}