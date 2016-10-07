<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.6.10
 * Time: 21:42
 */

use library\SharedService;

class UsersController extends ControllerBase
{
    public function beforeExecuteRoute(){

        parent::beforeExecuteroute();

        if(SharedService::isAdminLogged() !== true && $this->dispatcher->getActionName() != 'adminlogin' ){
            $this->response->redirect('/admin/adminlogin');
            return false;
        }
    }

    public function addAction()
    {

        $newUser = $this->request->getPost('user');

        $newUser = json_decode($newUser, true);

        $userToSave = new \Administrators();

        $userToSave->mapDataFromJson($newUser);

        $userToSave->password = $this->security->hash($userToSave->password);
        $createResult = $userToSave->create();

        die(json_encode(['result' => $createResult]));
    }

    public function deleteAction()
    {
        $userId = $this->request->getPost('userId');

        $deleteResult = false;

        if ($userId) {
            $deleteResult = \Administrators::findFirst($userId)->delete();
        } else {
            $deleteResult = 'Произошла ошибка при удалении пользователя.';
        }

        die(json_encode(['result' => $deleteResult]));
    }
}