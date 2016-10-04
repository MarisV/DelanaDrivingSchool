<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.4.10
 * Time: 22:25
 */

use library\SharedService;

class LanguagesController extends ControllerBase
{
    public function beforeExecuteroute()
    {
        parent::beforeExecuteroute();

        if(SharedService::isAdminLogged() == false) {
            $this->forwardTo404();
            return false;
        }

    }

    public function deleteAction()
    {
        $languageToDeleteId = $this->dispatcher->getParam('languageId');

        if ($languageToDeleteId) {

            $deleteResult = Languages::findFirst($languageToDeleteId)->delete();

            die(json_encode(['result'   =>  $deleteResult]));
        } else {
            die(json_encode(['result'   =>  'Invalid language id param']));
        }

    }

}