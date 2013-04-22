<?php
return array(
    'router' => array(
        'routes' => array(
            'process' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/process',
                    'defaults' => array(
                        '__NAMESPACE__' => 'KapitchiProcess\Controller',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'api' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/api',
                            'defaults' => array(
                                '__NAMESPACE__' => 'KapitchiProcess\Controller\Api',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'bus-reader' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/bus-reader/read-next/:id',
                                    'defaults' => array(
                                        'controller' => 'BusReader',
                                        'action' => 'readNext',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
