<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess\Process;

use KapitchiProcess\Job\JobInterface;

interface ProcessInterface {
    public function getJob();
    public function setJob(JobInterface $job);
    public function getId();
    public function setId($pid);
    public function getRegistered();
    public function setRegistered($registered);
    public function getStarted();
    public function setStarted($started);
    public function getFinished();
    public function setFinished($finished);
}