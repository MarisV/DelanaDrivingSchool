<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.14.11
 * Time: 01:57
 */

namespace library\Components;

use library\SharedService;
use app\models\{Categories, Pages, Languages, System};


class TopPageNavigationComponent extends AbstractComponent 
{

    /**
     *  Render top page navigtion panel
     *
     * @return string
     */
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

        $view->setVars([
            'languages'             =>  $languagesWithIco,
            'selectedLanguageCode'  =>  $siteLanguage,
            'selectedLanguageData'  =>  $siteLanguageData,
            'categories'            =>  $this->getCategories(),
            'pages'                 =>  $this->getAnotherPagesLinks()
        ]);

        return $view->render('components/navigation/top_page_navigation_component');
    }

    /**
     * Get categories for top page navigation dropdown
     *
     * @return array
     */
    private function getCategories() : array
    {
        $categories = Categories::find();

        $result = [];

        if ($categories) {
            foreach ($categories as $category) {
                $result[] = [
                    'title' =>  $category->title,
                    'href'  =>  '/categories/'.$category->id . '/'.$category->uri
                ];
            }
        }

        return $result;
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