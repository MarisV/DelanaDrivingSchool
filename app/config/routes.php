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

$router->add('/([a-z]{2})/', array(
    'namespace'     =>  'app\controllers',
    'language'      =>  1,
    'controller'    =>  'index',
    'action'        =>  'index'
));

$router->add('/([a-z]{2})/admin', array(
    'namespace'     =>  'app\controllers\Admin',
    'controller'    =>  'news',
    'action'        =>  'index'
));


$router->add('/admin/:controller', [
    'namespace'     => 'app\controllers\Admin',
    'controller'    => 1,
    'action'        =>  'index'
]);


$router->add('/([a-z]{2})/:controller', array(
    'namespace'     =>  'app\controllers',
    'language'      =>  1,
    'controller'    =>  2,
    'action'        =>  'index'
));

$router->add('/([a-z]{2})/:controller/:action', array(
    'namespace'     => 'app\controllers',
    'language'      =>  1,
    'controller'    =>  2,
    'action'        =>  3
));

$router->add('/([a-z]{2})/:controller/:action/:int', array(
    'namespace'     => 'app\controllers',
    'language'      =>  1,
    'controller'    =>  2,
    'action'        =>  3,
    'id'            =>  4
));

/**
 * Route for read actions
 * Accepts only GET http requests.
 */
$router->addGet('/([a-z]{2})/:controller/:int/:params', array(
    'namespace'     => 'app\controllers',
    'language'      =>  1,
    'controller'    =>  2,
    'action'        => 'read',
    'id'            =>  3,
    'uri'           =>  4
));

$router->addGet('/([a-z]{2})/instructors/:int/:params', array(
    'namespace'     => 'app\controllers',
    'language'      =>  1,
    'controller'    =>  2,
    'action'        =>  'read',
    'id'            =>  3,
    'uri'           =>  4
));


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
    'namespace'     => 'app\controllers\Admin',
    'controller'    => 'categories',
    'action'        => 'edit',
    'categoryId'    => 1,
]);

$router->add('/admin/instructors/edit/:int', [
    'namespace'     => 'app\controllers\Admin',
    'controller'    => 'instructors',
    'action'        => 'edit',
    'teacherId'     => 1,
]);

$router->add('/admin/seo/lang/{languageId}', [
    'namespace'     => 'app\controllers\Admin',
    'controller'    => 'seo',
    'action'        => 'index',
    'languageId'    => 1,
]);

$router->add('/admin/polls/edit/:int', [
    'namespace'     => 'app\controllers\Admin',
    'controller'    => 'polls',
    'action'        => 'edit',
    'pollId'     => 1,
]);

$router->add('/admin/polls/statistics/:int', [
    'namespace'     => 'app\controllers\Admin',
    'controller'    => 'polls',
    'action'        => 'statistics',
    'id'     => 1,
]);


return $router;