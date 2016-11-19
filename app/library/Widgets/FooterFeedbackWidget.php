<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.20.11
 * Time: 00:39
 */

namespace library\Widgets;

use app\models\Feedback;

class FooterFeedbackWidget extends AbstractWidget 
{
    public function getWidget() // TODO: Add cache
    {
        $randomFeedbackMessage = Feedback::findFirst([
            'order' =>  'RAND()',
            'limit' =>  1
        ]);
        $this->simpleView->setVar('feedbackMessage', $randomFeedbackMessage);

        return $this->simpleView->render('widgets/footer/footer_feedback');
    }
}