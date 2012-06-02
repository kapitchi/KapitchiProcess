<?php

namespace KapitchiProcess\Process;

use KapitchiProcess\Output\OutputInterface;

class ShellProcess extends AbstractProcess
{
    protected $command;

    public function __construct($command = null) {
        if($command !== null) {
            $this->setCommand($command);
        }
    }
    
    public function run(OutputInterface $output) {
        passthru($this->getCommand());
    }

    public function getCommand() {
        return $this->command;
    }

    public function setCommand($command) {
        $this->command = $command;
    }
    
    
}