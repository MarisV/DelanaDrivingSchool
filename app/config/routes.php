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
    'namespace'   =>  'app\controllers',
    'controller'  => 'index',
    'action'      => 'index'
));

$router->add('/:controller', array(
    'namespace'   => 'app\controllers',
    'controller'  => 1,
    'action'      => 'index'
));

$router->add('/:controller/:action', array(
    'namespace'   => 'app\controllers',
    'controller'  => 1,
    'action'      => 2
));



// ADMIN ROUTES //

$router->add('/admin', array(
    'namespace'     =>  'app\controllers\Admin',
    'controller'    =>  'news',
    'action'        =>  'index',
    'page'          =>  1
));

$router->add('/admin/:controller', [
    'namespace'  => 'app\controllers\Admin',
    'controller' => 1
]);

$router->add('/admin/:controller/:action/:params', [
    'namespace'  => 'app\controllers\Admin',
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
]);

$router->add('/admin/news/page/:int', array(
    'namespace'     => 'app\controllers\Admin',
    'controller'    =>  'news',
    'action'        =>  'index',
    'page'          =>  1
));


$router->add('/admin/pages/edit/{pageid}', [
    'namespace'  => 'app\controllers\Admin',
    'controller' => 'pages',
    'action'     => 'edit',
    'pageid'     => 1,
]);

$router->add('/admin/categories/edit/{categoryId}', [
    'namespace'  => 'app\controllers\Admin',
    'controller' => 'categories',
    'action'     => 'edit',
    'categoryId'     => 1,
]);

$router->add('/admin/instructors/edit/{teacherId}', [
    'namespace'  => 'app\controllers\Admin',
    'controller' => 'instructors',
    'action'     => 'edit',
    'teacherId'     => 1,
]);

$router->add('/admin/seo/lang/{languageId}', [
    'namespace'     => 'app\controllers\Admin',
    'controller'    => 'seo',
    'action'        => 'index',
    'languageId'    => 1,
]);

return $router;