<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.31.10
 * Time: 20:00
 */

namespace app\controllers\Admin;



use app\models\Contacts;
use Phalcon\Mvc\View;

class ContactsController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('js/admin-contacts.js');
    }

    public function indexAction()
    {
        $this->view->setVar('contacts', Contacts::find());
        $this->view->setVar('contactTypes', Contacts::getContactTypesAndTranslations());
    }

    public function addAction()
    {
        $this->view->disable();

        if ($this->request->isAjax() && $this->request->isPost()) {
            $data = $this->request->getPost();

            $contact = new Contacts();

            foreach ($data as $key  =>  $value) {
                $contact->$key  =   $value;
            }

            $saveResult = $contact->save();

            die(json_encode(['result'   =>  $saveResult]));
        }
    }

    public function deleteAction()
    {
        $this->view->disable();

        if ($this->request->isAjax() && $this->request->isPost()) {

            $contactIdToDelete = $this->request->getPost('contactId');

            $result =  Contacts::find($contactIdToDelete)->delete();

            die(json_encode(['result'   =>  $result]));
        }
    }
}