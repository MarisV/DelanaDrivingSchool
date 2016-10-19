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

    public function addOrEditAction()
    {
        $this->view->disable();

        $user = $this->request->getPost('user');

        if ($this->isUserForEdit($user)) {

            $userForEditId = $user['ustat'];

            $userToUpdate = Administrators::findFirst($userForEditId);

            $userToUpdate->mapDataFromArray($user);

            $result = $userToUpdate->save();

            if ($result === false) {
                $result = $userToUpdate->getValidationMessages();
            }


        } else {

            $userToSave = new \Administrators();

            $userToSave->mapDataFromArray($user);

            $userToSave->password = $this->security->hash($userToSave->password);

            $result = $userToSave->create();

            if ($result === false) {
                $result = $userToSave->getValidationMessages();
            }
        }

        die(json_encode(['result' => $result]));
    }

    public function deleteAction()
    {
        $this->view->disable();

        $userId = $this->request->getPost('userId');

        if ($userId) {
            $deleteResult = \Administrators::findFirst($userId)->delete();
        } else {
            $deleteResult = 'Произошла ошибка при удалении пользователя.';
        }

        die(json_encode(['result' => $deleteResult]));
    }

    public function getUserAction()
    {
        $this->view->disable();

        $userId = $this->request->getPost('userId');

        $user =  Administrators::findFirst($userId);

        die(json_encode(['result' => $user]));

    }

    public function isUserForEdit(&$user)
    {
        return !empty($user['ustat']);
    }
}