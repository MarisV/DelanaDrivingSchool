<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.16.11
 * Time: 01:13
 */

namespace app\controllers;


use app\models\Contacts;
use app\models\Support;

class ContactsController extends BaseController
{
    public function indexAction()
    {
        $isContactsExist = Contacts::count() > 0;

        $this->view->setVar('contactsExist', $isContactsExist);
    }

    /**
     *  Send message to support
     */
    public function supportAction() // TODO : Add spam protection
    {
        if ($this->request->isPost()) {

            $supportData = $this->request->getPost();

            $supportMessage = new Support();

            $supportMessage->initFromArray($supportData);

            $result = $supportMessage->create();

            if ($result === false) {
                $errors = $supportMessage->getValidationMessages();
                $this->view->setVar('errors', $errors);
            } else {
                $this->view->setVar('success', 'Сообщение успешно отправлено');
            }
        }
    }
}