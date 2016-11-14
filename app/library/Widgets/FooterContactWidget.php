<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.10.11
 * Time: 16:46
 */

namespace library\Widgets;

use app\models\Contacts;
use library\SharedService;


class FooterContactWidget extends AbstractWidget
{
    public function getWidget()
    {
        $hasContactsData = Contacts::count() > 0;
        $this->simpleView->setVar('hasContactsData', $hasContactsData);

        return $this->simpleView->render('widgets/footer/footer_contact');
    }
}