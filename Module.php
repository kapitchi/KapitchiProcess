<?php

namespace KapitchiProcess;

use KapitchiBase\ModuleManager\AbstractModule;

class Module extends AbstractModule
{
    public function getDir() {
        return __DIR__;
    }

    public function getNamespace() {
        return __NAMESPACE__;
    }

}