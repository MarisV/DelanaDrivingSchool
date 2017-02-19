<?php

namespace app\controllers;

use Phalcon\Mvc\Controller;
use library\Traits\BaseUrl;

class BaseController extends Controller
{
    use BaseUrl;

    public function beforeExecuteroute()
    {
        $this->assets
            ->addCss('css/style.css')
            ->addCss('components/materialize/dist/css/materialize.min.css');

        $this->assets
            ->addJs('components/jquery/dist/jquery.js')
            ->addJs('components/materialize/dist/js/materialize.min.js')
            ->addJs('js/init.js');
    }


    public function forwardTo404() : bool
    {
        $this->request;
        $this->getDI()->get('dispatcher')->forward(
            array(
                'namespace'     => 'app\controllers',
                'controller'    => 'error',
                'action'        => 'error404'
            )
        );

        return false;
    }
}
