<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.27.11
 * Time: 22:08
 */

namespace library\Widgets;

use app\models\Polls;
use library\Helpers\Locale;

class SidebarPollsWidget extends AbstractWidget 
{
    public function getWidget() : string
    {
        $oneRandomActivePoll = Polls::findFirst([ // TODO: Get poll by language too
            'conditions'    =>  'languageId IN (' . Locale::getCurrentAndAllId() . ')',
            'order' =>  'RAND()',
            'limit' =>  1
        ]);

        $this->simpleView->setVar('poll', $oneRandomActivePoll);

        return $this->simpleView->render('widgets/mainpage/sidebar-polls');
    }
}