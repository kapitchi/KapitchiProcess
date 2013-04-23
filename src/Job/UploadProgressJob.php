<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess\Job;

use KapitchiProcess\Process\ProcessOutputInterface;

class UploadProgressJob implements JobInterface, SerializableJobInterace
{
    protected $maxWaitTime = 5;
    protected $uploadName;
    
    public function __construct($uploadName)
    {
        $this->uploadName = $uploadName;
    }
    
    public function run(ProcessOutputInterface $output, $data) {
        if(!ini_get('session.upload_progress.enabled')) {
            throw new \RuntimeException("session.upload_progress.enabled not enabled");
        }
        
        try {
            $output->setRegistryValue('status', 'waiting');
            $progress = $this->waitForProgress();
            
            $output->setRegistryValue('status', 'started');
            $output->setRegistryValue('startedTime', $progress['start_time']);
            $output->setRegistryValue('contentLength', $progress['content_length']);
            while(true) {
                if($progress['done']) {
                    break;
                }
                
                $output->setRegistryValue('bytesProcessed', $progress['bytes_processed']);

                $files = array();
                foreach($progress['files'] as $file) {
                    $files[$file['field_name']] = array(
                        'name' => $file['name'],
                        'error' => $file['error'],
                        'startTime' => $file['start_time'],
                        'done' => $file['done'],
                        'bytesProcessed' => $file['bytes_processed'],
                    );
                }
                sleep(1);
            }
            
            $output->setRegistryValue('status', 'done');
        } catch(\RuntimeException $e) {
            $output->setRegistryValue('status', 'timeout');
        }
    }
    
    protected function waitForProgress($sec = 0)
    {
        $progress = $this->getProgress();
        if($progress) {
            return $progress;
        }
        
        if(++$sec > $this->maxWaitTime) {
            throw new \RuntimeException("Can't wait any longer");
        }
        
        sleep(1);
        return $this->waitForProgress($sec);
    }
    
    protected function getProgress()
    {
        $key = ini_get("session.upload_progress.prefix") . $this->uploadName;
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    public function __toString()
    {
        return __CLASS__;
    }
    
}