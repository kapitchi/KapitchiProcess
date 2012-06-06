<?php

namespace KapitchiProcess\Job;

use KapitchiProcess\ProcessOutput\ProcessOutputInterface,
    RuntimeException as CommandEmptyException;

class ShellJob implements JobInterface
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