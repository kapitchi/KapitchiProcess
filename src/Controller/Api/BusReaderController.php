<?php

/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiProcess\Controller\Api;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class BusReaderController extends AbstractActionController
{
    protected $sequentialBusReaderService;
    
    public function __construct(\KapitchiProcess\Service\SequentialBusReader $sequentialBusReaderService)
    {
        $this->setSequentialBusReaderService($sequentialBusReaderService);
    }
    
    public function readNextAction()
    {
        $processId = $this->getEvent()->getRouteMatch()->getParam('id');
        if(empty($processId)) {
            throw new \RuntimeException("No process id");
        }
        
        $service = $this->getSequentialBusReaderService();
        $data = $service->readNext($processId);
        return new JsonModel($data);
    }
    
    /**
     * 
     * @return \KapitchiProcess\Service\SequentialBusReader
     */
    public function getSequentialBusReaderService()
    {
        return $this->sequentialBusReaderService;
    }

    public function setSequentialBusReaderService($sequentialBusReaderService)
    {
        $this->sequentialBusReaderService = $sequentialBusReaderService;
    }

}