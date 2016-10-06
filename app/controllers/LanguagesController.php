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

    public function addAction()
    {
        $this->view->disable();

        $newLanguage = $this->request->getPost('language');

        $newLanguage = json_decode($newLanguage, true);

        $languageToSave = new Languages();

        $languageToSave->mapDataFromJsonToModel($newLanguage);

        $createResult = $languageToSave->save();

        die(json_encode(['result' => $createResult]));
    }

    public function deleteAction()
    {
        $languageToDeleteId = $this->request->getPost('languageId');

        if ($languageToDeleteId) {

            $deleteResult = Languages::findFirst($languageToDeleteId)->delete();

            die(json_encode(['result'   =>  $deleteResult]));

        } else {
            die(json_encode(['result'   =>  'Invalid language id param']));
        }

    }

    public function editAction()
    {
        $languageToEditId = $this->dispatcher->getParam('languageId');

        if ($languageToEditId) {

        }
    }

}