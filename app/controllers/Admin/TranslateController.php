<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.14.2
 * Time: 17:42
 */

namespace app\controllers\Admin;

use app\models\Languages;
use app\models\Translates;


class TranslateController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('components/EditableTable/editable-table.js');
    }

    public function indexAction()
    {
        $languages = Languages::getActiveLanguages();

        $translations = (new Translates())->getTranslationsForEdit();

        die(var_dump($translations));



        $this->view->setVar('languages', $languages);
        $this->view->setVar('translations', $translations);
    }
}