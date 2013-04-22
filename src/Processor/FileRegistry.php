<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess\Processor;

use KapitchiProcess\Process\ProcessInterface;

class FileRegistry implements RegistryInterface
{
    protected $registryPath;
    
    public function __construct($registryPath = null)
    {
        if($registryPath !== null) {
            $this->setRegistryPath($registryPath);
        }
    }
    
    public function listProcessIds()
    {
        $path = $this->getRegistryPath();
        $files = glob($path . '/*');
        array_walk($files, function(&$item, $key) use ($path) {
            $item = str_replace($path . '/', '', $item);
        });
        return $files;
    }

    /**
     * 
     * @param type $pid
     * @return \KapitchiProcess\Process\ProcessInterface
     * @throws \Exception
     */
    public function get($pid)
    {
        if(!$this->has($pid)) {
            throw new \Exception("Pid '$pid' does not exist");
        }
        
        $str = file_get_contents($this->getProcessFilePath($pid));
        $process = unserialize($str);
        if(!$process instanceof ProcessInterface) {
            throw new \Exception("Can't retrieve process object");
        }
        
        return $process;
    }
    
    public function has($pid)
    {
        return is_readable($this->getProcessFilePath($pid));
    }
    
    public function register(ProcessInterface $process)
    {
        $pid = md5(uniqid());
        
        $process->setId($pid);
        $process->setRegistered(time());
        
        $this->store($process);
    }
    
    public function store(ProcessInterface $process)
    {
        $str = serialize($process);
        file_put_contents($this->getProcessFilePath($process->getId()), $str);
    }

    public function unregister(ProcessInterface $process)
    {
        $path = $this->getProcessFilePath($process->getId());
        if(!is_readable($path)) {
            throw new \Exception("Process file '$path' does not exist");
        }
        unlink($path);
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

    protected function getProcessFilePath($pid) {
        return $this->getRegistryPath() . '/' . $pid . '.pid';
    }

}