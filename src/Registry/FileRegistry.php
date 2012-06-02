<?php

namespace KapitchiProcess\Registry;

use KapitchiProcess\Process\ProcessInterface;

class FileRegistry implements RegistryInterface
{
    protected $registryPath;
    
    public function __construct($registryPath = null) {
        if($registryPath !== null) {
            $this->setRegistryPath($registryPath);
        }
    }

    public function get($pid)
    {
        if(!$this->isRegistered($pid)) {
            throw new \Exception("Not so easy man! Pid '$pid' does not exist");
        }
        
        $str = file_get_contents($this->getProcessFilePath($pid));
        $process = unserialize($str);
        if(!$process instanceof ProcessInterface) {
            throw new \Exception("Can't retrieve process object");
        }
        
        return $process;
        
    }
    
    public function isRegistered($pid) {
        return is_readable($this->getProcessFilePath($pid));
    }
    
    public function register(ProcessInterface $process)
    {
        $pid = md5(uniqid());
        
        $process->setPid($pid);
        $process->setRegistered(time());
        
        $str = serialize($process);
        file_put_contents($this->getProcessFilePath($pid), $str);
    }

    public function unregister($pid)
    {
        $path = $this->getProcessFilePath($pid);
        if(!is_readable($path)) {
            throw new \Exception("Process file '$path' does not exist");
        }
        unlink($path);
    }
    
    protected function getProcessFilePath($pid) {
        return $this->getRegistryPath() . '/' . $pid;
    }
    
    public function getRegistryPath() {
        return $this->registryPath;
    }

    public function setRegistryPath($registryPath) {
        if(!is_writable($registryPath)) {
            throw new \Exception("Not writable path '$registryPath'");
        }
        
        $this->registryPath = $registryPath;
    }

}