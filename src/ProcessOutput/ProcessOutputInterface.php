<?php
namespace KapitchiProcess\ProcessOutput;

/**
 * 
 * @author Matus Zeman <mz@kapitchi.com>
 */
interface ProcessOutputInterface {
    
    /**
     * @param string $data
     */
    public function writeStdout($data);
}