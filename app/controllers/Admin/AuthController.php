<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.19.10
 * Time: 22:31
 */

namespace app\controllers\Admin;

use library\SharedService;
use app\models\Administrators;
use Phalcon\Mvc\View;

class AuthController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->view->setLayout('admin');
        $this->view->setRenderLevel(View::LEVEL_LAYOUT);

    }

    public function loginAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        if (SharedService::isAdminLogged() === true) {
            $this->response->redirect('admin/news');
            return false;
        }
        
        if ($this->request->isPost()) {

            $errors = [];

            $userName = $this->request->getPost('username',['string', 'trim']);
            $password = $this->request->getPost('password', ['trim']);

            if (empty($userName)) {
                $errors['euname'] = 'Имя пользователя не может быть пустым';
            }
            if (empty($password)) {
                $errors['epassword'] = 'Пароль не может быть пустым';
            }

            if (empty($errors)) {

                $admin = Administrators::findFirstByUsername($userName);

                if ($admin !== false && $this->security->checkHash($password, $admin->password)) {
                    $this->session->set('logged_in_admin', $admin);
                    $this->response->redirect('admin/news');
                    return false;
                }
            }

            $this->view->setVar('error', $errors);
        }

    }

    public function logoutAction()
    {
        if (SharedService::isAdminLogged() === true) {

            $this->session->remove('logged_in_admin');
            $this->response->redirect('admin/auth/login');
            return false;
        }
    }

    public function testAction()
    {

    }
    
}