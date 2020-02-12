<?php
/**
 * Module.php - Module Class
 *
 * Module Class File for Contact Request Plugin
 *
 * @category Config
 * @package Contact\Request
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Contact\Request;

use Application\Controller\CoreEntityController;
use Laminas\Mvc\MvcEvent;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\EventManager\EventInterface as Event;
use Laminas\ModuleManager\ModuleManager;
use OnePlace\Contact\Request\Controller\RequestController;
use OnePlace\Contact\Request\Model\RequestTable;
use OnePlace\Contact\Model\ContactTable;

class Module {
    /**
     * Module Version
     *
     * @since 1.0.0
     */
    const VERSION = '1.0.1';

    /**
     * Load module config file
     *
     * @since 1.0.0
     * @return array
     */
    public function getConfig() : array {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(Event $e)
    {
        // This method is called once the MVC bootstrapping is complete
        $application = $e->getApplication();
        $container    = $application->getServiceManager();
        $oDbAdapter = $container->get(AdapterInterface::class);
        $tableGateway = $container->get(RequestTable::class);

        # Register Filter Plugin Hook
        CoreEntityController::addHook('contact-view-before',(object)['sFunction'=>'attachRequestForm','oItem'=>new RequestController($oDbAdapter,$tableGateway,$container)]);
        CoreEntityController::addHook('contactrequest-add-before-save',(object)['sFunction'=>'attachRequestToContact','oItem'=>new RequestController($oDbAdapter,$tableGateway,$container)]);
    }

    /**
     * Load Models
     */
    public function getServiceConfig() : array {
        return [
            'factories' => [
                # Request Plugin - Base Model
                Model\RequestTable::class => function($container) {
                    $tableGateway = $container->get(Model\RequestTableGateway::class);
                    return new Model\RequestTable($tableGateway,$container);
                },
                Model\RequestTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Request($dbAdapter));
                    return new TableGateway('contact_request', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    } # getServiceConfig()

    /**
     * Load Controllers
     */
    public function getControllerConfig() : array {
        return [
            'factories' => [
                Controller\RequestController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    $tableGateway = $container->get(RequestTable::class);

                    # hook start
                    # hook end
                    return new Controller\RequestController(
                        $oDbAdapter,
                        $tableGateway,
                        $container
                    );
                },
                # Installer
                Controller\InstallController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\InstallController(
                        $oDbAdapter,
                        $container->get(Model\RequestTable::class),
                        $container
                    );
                },
            ],
        ];
    } # getControllerConfig()
}
