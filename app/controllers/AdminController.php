<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.12.9
 * Time: 21:17
 */
use Phalcon\Mvc\View;
use library\SharedService;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class AdminController extends ControllerBase
{
    private $cache;

    const NEWS_PER_PAGE = 40;

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
        $this->dispatcher->forward(['controller' => 'admin', 'action' => 'news']);
        return false;
    }

    public function newsAction()
    {
        $this->assets->addJs('components/ckeditor/ckeditor.js');
        $this->assets->addJs('js/admin-news.js');

        $page = $this->dispatcher->getParam('page');

        $latestNews = News::find([
            'order'     =>  'dateAdded desc',
        ]);

        $visibleLanguages = Languages::find([
            'visible'   =>  'yes',
            'order'     =>  'id desc'
        ]);

        $paginator = new PaginatorModel([
            'data'  =>  $latestNews,
            'limit' =>  self::NEWS_PER_PAGE,
            'page'  =>  $page
        ]);

        $news = $paginator->getPaginate();

        $this->view->setVar('news', $news);
        $this->view->setVar('languages', $visibleLanguages);
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
                $errors['euname'] = 'Имя пользователя не может быть пустым';
            }
            if(empty($password)){
                $errors['epassword'] = 'Пароль не может быть пустым';
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

    public function languagesAction()
    {
        $allLanguagesList = Languages::find();

        $this->view->setVar('languages', $allLanguagesList);
    }

    public function usersAction()
    {

        $administrators = Administrators::find();

        $this->view->setVar('administrators', $administrators);

    }


}