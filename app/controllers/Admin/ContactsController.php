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

            $contactModel = ($this->isDataForEdit($data)) ? Contacts::findFirst($data['id']) : new Contacts();

            $contactModel->initFromArray($data);

            $result = ($this->isDataForEdit($data)) ? $contactModel->save() : $contactModel->create();

            die(json_encode(['result'   =>  $result]));
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

    /**
     *  Check whether data received from user is for edit or not
     *
     * @param array $data
     * @return bool
     */
    private function isDataForEdit(&$data)
    {
        if (!empty($data['id'])) {
            return true;
        } else  {
            return false;
        }
    }
}