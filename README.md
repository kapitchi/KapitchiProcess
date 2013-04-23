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

Primary usage of this module is running long time operations "in background" and being able to receive progress updates.

Installation
============

TODO

Basic Usage
===========

1. Register a process/job you want to run - you get a process ID / pid.

```
$process = $processor->registerJob(new \KapitchiProcess\Job\ShellJob('ping -n 30 kapitchi.com'));
$pid = $process->getId();
```

2. Run a process using separate AJAX request as to get response will take as long as your process runs

```
$processor->run($pid);
```

3. Use /process/api/bus-reader/read-next/[pid] (AJAX every 1sec?) to request process updates in JSON format as an example below.

_stdoutDelta_ contains data written by the process to "stdOut" after the last progress request only.

```
{
    processId: "895472f28183dc67d39d9680d93c8e9a",
    isFinished: false,
    isStarted: true,
    startedTime: 1366660603,
    runningTime: 24,
    registry: [ ],
    stdoutDelta: "Reply from 176.74.179.134: bytes=32 time=415ms TTL=38 Reply from 176.74.179.134: bytes=32 time=416ms TTL=38 Reply from 176.74.179.134: bytes=32 time=415ms TTL=38 Reply from 176.74.179.134: bytes=32 time=416ms TTL=38 "
}
```

TODO