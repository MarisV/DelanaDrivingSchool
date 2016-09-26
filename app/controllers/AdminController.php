<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.12.9
 * Time: 21:17
 */
use Phalcon\Mvc\View;
use library\SharedService;

class AdminController extends ControllerBase
{
    private $cache;

    private $admin;

    public function beforeExecuteRoute(){

        parent::beforeExecuteroute();

        if(SharedService::isAdminLogged() !== true && $this->dispatcher->getActionName() != 'adminlogin' ){
            $this->response->redirect('/admin/adminlogin');
            return false;
        }

        $this->view->setLayout('admin');
        $this->view->setRenderLevel(View::LEVEL_LAYOUT);

        $this->cache = SharedService::getCache();
        $this->view->setVar('admin', SharedService::getLoggedInAdmin());

    }

    public function indexAction()
    {




    }

    public function newsAction()
    {


    }


    public function adminloginAction()
    {
        if(SharedService::isAdminLogged() === true){
            $this->response->redirect('admin/index');
            return false;
        }

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        if($this->request->isPost()){

            $errors = [];

            $userName = $this->request->getPost('username',['string', 'trim']);
            $password = $this->request->getPost('password', ['trim']);

            if(empty($userName)){
                $errors['euname'] = 'Lietotājvārds nevar būt tukšs';
            }
            if(empty($password)){
                $errors['epassword'] = 'Parole nevar būt tukša';
            }

            if(empty($errors)){
                $admin = Administrators::findFirstByUsername($userName);

                if($admin !== false && $admin->password == $password){
                    $this->session->set('logged_in_admin', $admin);
                    $this->response->redirect('admin/index');
                    return false;
                }
            }

            $this->view->setVar('error', $errors);
        }

    }

    public function logoutadminAction()
    {
        if($this->isAdminLoggedIn() === true){
            $this->session->remove('logged_in_admin');
            $this->response->redirect('admin/adminlogin');
            return false;
        }
    }


}