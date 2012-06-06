Zend Framework 2 - Kapitchi Process module
=================================================
Version: 0.1    
Author:  Matus Zeman  
Website: http://kapitchi.com   


Introduction
============
Allows to run a process (shell, PHP, ...) while stdout is accessible to other processes.  
This can be used to run long shell command while updating web page about the progress.

Usage
=====

Run a job

```

$path = 'data/kapitchiprocess';
$processor = new \KapitchiProcess\Service\Processor();
$processor->setBus(new \KapitchiProcess\Processor\FileBus($path));
$processor->setRegistry(new \KapitchiProcess\Registry\FileRegistry($path));

$processor = $this->getProcessor();
$process = $processor->registerJob(new \KapitchiProcess\Job\ShellJob("ping -n 10 kapitchi.com"));
$processor->run($process);

```

Get updates

```

$service = new \KapitchiProcess\Service\SequentialBusReader();
$service->setProcessor($processor);
$update = $service->readNext($pid);

```
