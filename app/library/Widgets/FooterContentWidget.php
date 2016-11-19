<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.20.11
 * Time: 00:30
 */

namespace library\Widgets;

use app\models\Feedback;


class FooterContentWidget extends AbstractWidget 
{
    public function getWidget()
    {
        return $this->simpleView->render('widgets/footer/footer_content');
    }
}