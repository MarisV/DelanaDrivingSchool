<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.11.9
 * Time: 15:44
 */

use Phalcon\Mvc\Router;

// Create the router
$router = new Router();

$router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);

//
// +++++ NOT FOUND +++++
//

$router->notFound(
    array(
        "controller" => "error",
        "action"     => "error404"
    )
);

//
// +++++ DEFAULT +++++
//

$router->add('/', array(
    'controller'  => 'index',
    'action'      => 'index'
));

$router->add('/:controller', array(
    'controller'  => 1,
    'action'      => 'index'
));

$router->add('/:controller/:action', array(
    'controller'  => 1,
    'action'      => 2
));

$router->add('/admin', array(
    'controller'    =>  'admin',
    'action'        =>  'news'
));

return $router;