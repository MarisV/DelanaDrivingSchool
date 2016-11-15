<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.15.11
 * Time: 00:12
 */

namespace library\Widgets;

class MainPageBannerWidget extends AbstractWidget 
{
    public function getWidget()
    {
        return $this->simpleView->render('widgets/mainpage/main_page_banner');
    }
}