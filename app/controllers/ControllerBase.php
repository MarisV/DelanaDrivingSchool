<?php

namespace app\controllers;

use Phalcon\Mvc\Controller;
use library\Traits\BaseUrl;

class ControllerBase extends Controller
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
        $this->getDI()->get('dispatcher')->forward(
            array(
                'controller' => 'error',
                'action'     => 'error404'
            )
        );

        return false;
    }
}
