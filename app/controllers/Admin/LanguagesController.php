<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.24.10
 * Time: 07:26
 */

namespace app\controllers\Admin;

use library\SharedService;

use app\models\Languages;


class LanguagesController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteroute();

        if(SharedService::isAdminLogged() == false) {
            $this->forwardTo404();
            return false;
        }
    }

    public function indexAction()
    {
        $this->assets->addJs('js/admin-languages.js');

        $allLanguagesList = Languages::find();

        $this->view->setVar('languages', $allLanguagesList);
    }

    public function addOrEditAction()
    {
        $this->view->disable();

        $newLanguage = $this->request->getPost('language');

        $newLanguage = json_decode($newLanguage, true);

        if ($newLanguage[0]['name'] == 'lstat' && !empty($newLanguage[0]['value'])){
            $langId = $newLanguage[0]['value'];

            $languageToSave = Languages::findFirst($langId);

            $languageToSave->mapDataFromJson($newLanguage);

            $createResult = $languageToSave->save();
        } else {
            $languageToSave = new Languages();

            $languageToSave->mapDataFromJson($newLanguage);

            $createResult = $languageToSave->create();
        }

        die(json_encode(['result' => $createResult]));
    }

    public function deleteAction()
    {
        $this->view->disable();

        $languageToDeleteId = $this->request->getPost('languageId');

        if ($languageToDeleteId) {

            $deleteResult = Languages::findFirst($languageToDeleteId)->delete();

            die(json_encode(['result'   =>  $deleteResult]));

        } else {
            die(json_encode(['result'   =>  'Invalid language id param']));
        }
    }
}