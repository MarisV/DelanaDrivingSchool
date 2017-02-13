<?php

use Phalcon\Di\FactoryDefault;

ini_set('display_errors', 1);
error_reporting(~0);

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'on');

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

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


    if (APPLICATION_ENV == 'production') {
        error_reporting(E_ALL | E_STRICT);
        ini_set('display_errors', 'on');
    }

    try{

        require APP_PATH . '/Bootstrap.php';

        $di = new FactoryDefault();

        $config = require APP_PATH . '/config/config.php';

        $bootstrap = new Bootstrap($di, $config);
        $application = new \Phalcon\Mvc\Application($bootstrap->bootstrap());

        echo $application->handle()->getContent();

    } catch (Exception $e) {

        if (APPLICATION_ENV == 'production') {

            header('HTTP/1.1 503 Service Temporarily Unavailable');
            header('Status: 503 Service Temporarily Unavailable');
            echo 'Something went wrong. Try again later.<br>';
            exit;

        } else {
            echo $e->getMessage() . '<br>';
            echo '<pre>' . $e->getTraceAsString() . '</pre>';
        }
        throw $e;
    }


