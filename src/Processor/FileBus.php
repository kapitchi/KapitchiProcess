<?php

namespace KapitchiProcess\Processor;

class FileBus implements BusInterface
{
    protected $path;
    
    public function __construct($path = null) {
        if($path !== null) {
            $this->setPath($path);
        }
    }
    
    public function writeStdout($pid, $data) {
        file_put_contents($this->getFilePath($pid), $data, FILE_APPEND);
    }
    
    public function readStdout($pid, $offset = null) {
        if($offset === null) {
            return file_get_contents($this->getFilePath($pid));
        }
        
        $handle = fopen($this->getFilePath($pid), 'r');
        fseek($handle, $offset);
        $data = fread($handle, 10000);
        return $data;
    }    
    
    protected function getFilePath($pid) {
        return $this->getPath() . '/' . $pid . '.output';
    }
    
    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }

}