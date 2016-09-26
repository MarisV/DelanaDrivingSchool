<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'library'   => $config->application->libraryDir
], true)->register();



/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->libraryDir
    ]
)->register();
