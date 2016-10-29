<?php

namespace app\controllers;

use Phalcon\Mvc\Controller;
use library\Traits\BaseUrl;

class ControllerBase extends Controller
{

    use BaseUrl;

    public function beforeExecuteroute()
    {

        $this->assets->addCss('css/style.css')
            ->addCss('components/materialize/dist/css/materialize.min.css');

        $this->assets->addJs('components/jquery/dist/jquery.js')->addJs('js/init.js')
            ->addJs('components/materialize/dist/js/materialize.min.js');
    }


    public function forwardTo404()
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
