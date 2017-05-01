<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.16.11
 * Time: 01:13
 */

namespace app\controllers;

use app\models\Categories;
use app\models\Contacts;
use app\models\Course;
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

            $resultMessage = '';

            if ($result === false) {
                $resultMessage = $this->translate->_('Произошла ошибка, попробуйте еще раз!');
                $this->view->setVar('errors', $resultMessage);
            } else {
                $resultMessage = $this->translate->_('Сообщение успешно отправлено');
                $this->view->setVar('success', $resultMessage);
            }

            if (!strstr($this->request->getHTTPReferer(), 'support')){
                $this->session->set('msg', $resultMessage);
                $this->response->redirect($this->request->getHTTPReferer());
                return false;
            }

        }
    }

    public function courseAction() // TODO: Add working course category select validation
    {
        $availableCategories = Categories::find([
            'columns'  =>  'id, title'
        ]);

        if ($this->request->isPost()) {

            $applicationData = $this->request->getPost();

            $applicationForCourse = new Course();

            $applicationForCourse->initFromArray($applicationData);

            $result = $applicationForCourse->create();

            if ($result === false) {
                $errors = $applicationForCourse->getValidationMessages();
                $this->view->setVar('errors', $errors);
            } else {
                $this->view->setVar('success', 'Заявка успешно оставлена ');
            }
        }

        $this->view->setVar('categories', $availableCategories);
    }
}