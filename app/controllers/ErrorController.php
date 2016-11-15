<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.12.9
 * Time: 22:25
 */

class ErrorController extends BaseController
{
    public function error404Action()
    {
        die('Test 404');
    }
}