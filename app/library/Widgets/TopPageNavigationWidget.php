<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.14.11
 * Time: 01:57
 */

namespace library\Widgets;

use library\SharedService;
use app\models\{Categories, Pages, Languages, System};

class TopPageNavigationWidget extends AbstractWidget
{
    /**
     *  Render top page navigtion panel widget
     *
     * @return string
     */
    public function getWidget()
    {
        $activeLanguages = Languages::find("visible = 'yes'");

        $languagesWithIco = [];

        $siteLanguage = System::getSelectedBeforeOrDefaultSiteLanguage();

        $siteLanguageData = [];

        foreach ($activeLanguages as $language) {
            $languagesWithIco[] = [
                'name'  =>  $language->name,
                'href'      =>  SharedService::getBaseUrl().$language->code . '/',
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

        $this->simpleView->setVars([
            'languages'             =>  $languagesWithIco,
            'selectedLanguageCode'  =>  $siteLanguage,
            'selectedLanguageData'  =>  $siteLanguageData,
            'categories'            =>  Categories::getCategoriesForMainPageWidgets(),
            'pages'                 =>  $this->getAnotherPagesLinks()
        ]);

        return $this->simpleView->render('widgets/mainpage/navigation/top_page_navigation');
    }


    /**
     * Get links to another pages for top page navigation dropdown
     *
     * @return array
     */
    private function getAnotherPagesLinks() : array
    {
        $pages = Pages::find();

        $result = [];
        if ($pages) {
            foreach ($pages as $page) {
                $result[] = [
                    'title' =>  $page->title,
                    'href'  =>  '/pages/'.$page->id . '/'.$page->uri
                ];
            }
        }

        return $result;
    }
}