<?php

use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'on');

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . "/config/services.php";

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    // get application env from server variables
// if not available set default to production
    if (isset($_SERVER['APPLICATION_ENV'])) {
        switch($_SERVER['APPLICATION_ENV']) {
            case 'production':
                define('APPLICATION_ENV', 'production');
                break;
            case 'development':
                define('APPLICATION_ENV', 'development');
                break;

            case 'local':
                define('APPLICATION_ENV', 'local');
                break;
            default:
                define('APPLICATION_ENV', 'production');
                break;
        }
    }

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {

    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
