<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'library'               =>  $config->application->libraryDir,
    'app\controllers'       =>  $config->application->controllersDir,
    'app\controllers\Admin' =>  $config->application->adminControllersDir,
    'app\models'            =>  $config->application->modelsDir

], true)->register();



/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->libraryDir,
        $config->application->adminControllersDir
    ]
)->register();
