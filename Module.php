<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess;

use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use KapitchiBase\ModuleManager\AbstractModule;

class Module extends AbstractModule implements ControllerProviderInterface, ServiceProviderInterface
{
    public function getControllerConfig()
    {
        return array(
            'invokables' => array(
                //'KapitchiIdentity\Controller\Identity' => 'KapitchiIdentity\Controller\IdentityController',
            ),
            'factories' => array(
                'KapitchiProcess\Controller\Api\BusReader' => function($sm) {
                    $cont = new Controller\Api\BusReaderController(
                        $sm->getServiceLocator()->get('KapitchiProcess\Service\SequentialBusReader')
                    );
                    return $cont;
                },
            )
        );
    }
    
        public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'KapitchiProcess\Processor\Registry' => 'KapitchiProcess\Processor\FileRegistry',
                'KapitchiProcess\Processor\Bus' => 'KapitchiProcess\Processor\FileBus',
            ),
            'invokables' => array(
            ),
            'factories' => array(
                'KapitchiProcess\Service\SequentialBusReader' => function ($sm) {
                    $ins = new Service\SequentialBusReader(
                        $sm->get('KapitchiProcess\Processor\Processor')
                    );
                    return $ins;
                },
                'KapitchiProcess\Processor\Processor' => function ($sm) {
                    $ins = new Processor\Processor(
                        $sm->get('KapitchiProcess\Processor\Registry'),
                        $sm->get('KapitchiProcess\Processor\Bus'),
                        $sm->get('KapitchiProcess\Job\Manager')
                    );
                    return $ins;
                },
                'KapitchiProcess\Job\Manager' => function ($sm) {
                    $ins = new Job\Manager();
                    return $ins;
                },
                'KapitchiProcess\Processor\FileRegistry' => function ($sm) {
                    $ins = new Processor\FileRegistry('./data/process/registry');
                    return $ins;
                },
                'KapitchiProcess\Processor\FileBus' => function ($sm) {
                    $ins = new Processor\FileBus('./data/process/bus');
                    return $ins;
                },
            )
        );
    }
    
    public function getDir() {
        return __DIR__;
    }

    public function getNamespace() {
        return __NAMESPACE__;
    }

}