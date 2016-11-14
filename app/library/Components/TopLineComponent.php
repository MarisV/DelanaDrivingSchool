<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.14.11
 * Time: 02:36
 */

namespace library\Components;

use library\SharedService;
use app\models\Languages;
use app\models\System;

class TopLineComponent extends AbstractComponent 
{
    public function getContent()
    {
        $view = SharedService::getSimpleView();

        $activeLanguages = Languages::find("visible = 'yes'");

        $languagesWithIco = [];

        $siteLanguage = System::getSelectedBeforeOrDefaultSiteLanguage();

        $siteLanguageData = [];

        foreach ($activeLanguages as $language) {
            $languagesWithIco[] = [
                'name'  =>  $language->name,
                'href'      =>  SharedService::getBaseUrl().$language->code,
                'img'       =>  '/img/flags/'.strtolower($language->code) . '.ico'
            ];

            if ($language->code == $siteLanguage) {
                $siteLanguageData = [
                    'name'  =>  $language->name,
                    'href'      =>  SharedService::getBaseUrl().$language->code,
                    'img'       =>  '/img/flags/'.strtolower($language->code) . '.ico'
                ];
            }
        }

        $view->setVar('languages', $languagesWithIco);
        $view->setVar('selectedLanguageCode', $siteLanguage);
        $view->setVar('selectedLanguageData', $siteLanguageData);
        return $view->render('components/navigation/top_line_component');
    }
}