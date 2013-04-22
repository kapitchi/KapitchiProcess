<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

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
        $path = $this->getFilePath($pid);
        if(!is_readable($path)) {
            throw new \RuntimeException("Not readable bus '$path'");
        }
        
        if($offset === null) {
            return file_get_contents($path);
        }
        
        $handle = fopen($path, 'r');
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