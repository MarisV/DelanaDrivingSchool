<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.15.11
 * Time: 00:45
 */

namespace library\Widgets;

use app\models\Categories;

class SidebarCategoriesWidget extends AbstractWidget 
{
    public function getWidget()
    {
        $this->simpleView->setVar('categories', Categories::getCategoriesForMainPageWidgets());

        return $this->simpleView->render('widgets/mainpage/sidebar-categories');
    }
}