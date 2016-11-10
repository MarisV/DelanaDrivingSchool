<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.10.11
 * Time: 16:46
 */

namespace library\Components;

use app\models\Contacts;
use library\SharedService;


class FooterContactComponent extends AbstractComponent 
{
    public function getContent()
    {
        $view = SharedService::getSimpleView();

        $hasContactsData = Contacts::count() > 0;
        $view->setVar('hasContactsData', $hasContactsData);

        return $view->render('components/footer/footer_contact');
    }
}