Zend Framework 2 - Kapitchi Process module
==============================================

__Version:__ 0.1-dev  
__Author:__  [Kapitchi Team](http://kapitchi.com/team)  
__Website:__ [http://kapitchi.com](http://kapitchi.com)  
__Demo:__    [http://kapitchi.com/showcase](http://kapitchi.com/showcase)  

__README.md status:__ INCOMPLETE  

Licence
=======

![LGPLv3](http://www.gnu.org/graphics/lgplv3-88x31.png)  
[The GNU Lesser General Public License, version 3.0](LICENSE.txt)


Introduction
============

Allows to run a process (shell, PHP, ...) while stdout is accessible to other processes.  
This can be used to run long shell command while updating web page about the progress.


Installation
============

TODO

Basic Usage
===========

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

