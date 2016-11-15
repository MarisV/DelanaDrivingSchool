<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.15.11
 * Time: 00:11
 */

namespace library\Widgets;

use library\SharedService;

abstract class AbstractWidget
{
    /**
     * Simple view instance
     *
     * @var \Phalcon\Mvc\View\Simple
     */
    protected $simpleView;

    public function __construct()
    {
        $this->simpleView = SharedService::getSimpleView();
    }

    /**
     * Generate and render widget content
     *
     * @return mixed
     */
    public abstract function getWidget();
}