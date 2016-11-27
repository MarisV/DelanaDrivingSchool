<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.27.11
 * Time: 22:07
 */

namespace library\Widgets;

use app\models\Polls;
use library\Widgets\SidebarCategoriesWidget;

class SidebarWidget extends AbstractWidget 
{
    public function getWidget()
    {
        $categoriesWidget = (new SidebarCategoriesWidget())->getWidget();


        $pollsCount = Polls::count();

        $this->simpleView->setVar('hasActivePolls', $pollsCount > 0);

        $pollsWidget = (new SidebarPollsWidget())->getWidget();

        $this->simpleView->setVar('categoriesWidget', $categoriesWidget);
        $this->simpleView->setVar('pollsWidget', $pollsWidget);

        return $this->simpleView->render('widgets/mainpage/sidebar');
    }
}