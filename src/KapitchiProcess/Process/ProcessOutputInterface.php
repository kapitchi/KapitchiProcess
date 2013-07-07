<?php
namespace KapitchiProcess\Process;

/**
 * 
 * @author Matus Zeman <mz@kapitchi.com>
 */
interface ProcessOutputInterface {
    
    /**
     * @param string $data
     */
    public function writeStdout($data);
    public function setRegistryValue($registry, $value);
}