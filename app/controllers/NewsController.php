<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.27.9
 * Time: 20:04
 */

use Phalcon\Mvc\View;
use library\SharedService;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class NewsController extends \ControllerBase
{

    public function addAction()
    {
        $this->view->disable();

        if (!SharedService::isAdminLogged()) {
            $this->forwardTo404();
            return false;
        }

        $new = $this->request->getPost('new');

        if ($new && $this->request->isAjax()) {

            if ($this->isNewForEdit($new)){

                $newId = $new['nstat'];

                $newToUpdate = News::findFirst($newId);

                $newToUpdate->mapDataFromArray($new);

                $newToUpdate->prepareAuthorAndStatusFields();

                $createResult = $newToUpdate->save();

            } else {

                $newToSave = new News();

                $newToSave->mapDataFromArray($new);

                $newToSave->prepareAuthorAndStatusFields();

                $createResult = $newToSave->create();
            }

           die(json_encode(['result' => $createResult]));
        }
    }

    public function deleteAction()
    {
        $this->view->disable();

        if(!SharedService::isAdminLogged()){
            $this->forwardTo404();
            return false;
        }

        $newId = $this->request->get('newId');

        if($newId && $this->request->isAjax()) {

            $newToDelete = News::findFirst($newId);

            if (!$newToDelete) {
                $deleteResult = 'Извините, произошла ошибка в процессе удаления!';
            } else {
                $newToDelete->deleteNewImage($newToDelete->image);
                $deleteResult = $newToDelete->delete();
            }

            die(json_encode(['result'   =>  $deleteResult]));
        }

    }

    public function getAction()
    {
        $this->view->disable();

        $newId = $this->request->getPost('id');

        $new = News::findFirst($newId);

        die(json_encode(['newresult' => $new]));
    }

    /**
     *  Check whether received new is for editing or adding
     *
     * @param $new
     * @return bool
     */
    private function isNewForEdit(&$new)
    {
        return !empty($new['nstat']);
    }

}