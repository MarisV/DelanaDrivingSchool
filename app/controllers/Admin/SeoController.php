<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.30.10
 * Time: 11:59
 */

namespace app\controllers\Admin;

use app\models\{Languages, System, Seo};

class SeoController extends BaseController
{
    /**
     * @var Seo;
     */
    private $siteSeoSettingsRow;

    /**
     *  Default site language id
     *
     * @var int
     */
    private $defaultSiteLanguage;

    /**
     *  Current SEO settings language id
     *
     * @var int
     */
    private $languageId;

    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('js/admin-seo-settings.js');

        $this->defaultSiteLanguage = System::findFirst()->defaultSiteLanguage;

        $this->languageId = $this->dispatcher->getParam('languageId') ?? $this->defaultSiteLanguage;

        $this->siteSeoSettingsRow = Seo::findFirstByLanguageId($this->languageId);

        if ($this->siteSeoSettingsRow === false)
        {
            $this->siteSeoSettingsRow = new Seo();
        }

        $this->view->setVar('settings', $this->siteSeoSettingsRow);
        $this->view->setVar('languageId', $this->languageId);
        $this->view->setVar('defaultSiteLanguage', $this->defaultSiteLanguage);
    }

    public function indexAction()
    {
        $visibleLanguages = Languages::find("visible = 'yes'");

        $this->view->setVar('languages', $visibleLanguages);
    }

    public function edit_site_languageAction()
    {
        $this->view->disable();

        if ($this->request->isPost() && $this->request->isAjax()) {

            $languageId = $this->request->getPost('langId');

            $systemRecord = System::findFirst();

            if ($systemRecord === false){
                $systemRecord = new System();
            }

            $systemRecord->defaultSiteLanguage = $languageId;

            $result = $systemRecord->save();

            die(json_encode(['result'   =>  $result]));

        }
    }

    public function edit_main_seo_settingsAction()
    {
        if ($this->request->isPost()) {

            $new = false;

            $seoSetting = $this->request->getPost();

            $currentLanguageSeoSetting = Seo::findFirstByLanguageId($seoSetting['languageId']);

            if ($currentLanguageSeoSetting === false) {
                $new = true;
                $currentLanguageSeoSetting = new Seo();
            }

            foreach ($seoSetting as $field  =>  $value) {
                $currentLanguageSeoSetting->$field = $value;
            }

            if ($new === true) {
                $result = $currentLanguageSeoSetting->create();
            } else {
                $result = $currentLanguageSeoSetting->save();
            }

            if (!$result) {
                $this->flashSession->error('Произошла ошибка при сохранении');
            }
            return $this->response->redirect('/admin/seo');

        } else {
            return $this->response->redirect('/admin/seo');
        }
    }
}