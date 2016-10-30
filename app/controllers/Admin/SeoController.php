<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.30.10
 * Time: 11:59
 */

namespace app\controllers\Admin;


use app\models\Languages;
use app\models\System;


class SeoController extends BaseController
{
    /**
     * @var System;
     */
    private $siteSettingsRow;


    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('js/admin-seo-settings.js');

        $this->siteSettingsRow = System::findFirst();

        if ($this->siteSettingsRow === false){
            $this->siteSettingsRow = new System();
        }

        $this->view->setVar('settings', $this->siteSettingsRow);
    }

    public function indexAction()
    {
        $visibleLanguages = Languages::find([
            'visible'   =>  'yes',
            'order'     =>  'id desc'
        ]);

        $this->view->setVar('languages', $visibleLanguages);
    }

    public function edit_site_languageAction()
    {
        $this->view->disable();

        if ($this->request->isPost() && $this->request->isAjax()) {
            $languageId = $this->request->getPost('langId');

            if ($this->siteSettingsRow !== false){
                $this->siteSettingsRow->defaultSiteLanguage = $languageId;
                $result = $this->siteSettingsRow->save();
                die(json_encode(['result'   =>  $result]));
            }
        }

    }
}