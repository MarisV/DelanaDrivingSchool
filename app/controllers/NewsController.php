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

        $new = $this->request->getPost('new');

        if(!SharedService::isAdminLogged()){
            $this->forwardTo404();
            return false;
        }

        if($new && $this->request->isAjax()){

           $addingNew = new News();

           $fields =  $addingNew->getModelsMetaData()->getReverseColumnMap($addingNew);

           $new = json_decode($new, true);

           foreach ($new as $value) {

                $fieldName = $value['name'];
                $fieldValue = $value['value'];

                if(array_key_exists($fieldName, $fields)) {
                    $addingNew->$fieldName = $fieldValue;
                }
           }

           $addingNew->author = SharedService::getLoggedInAdmin()->username;

           $createResult = $addingNew->create();

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
                $deleteResult = $newToDelete->delete();
            }

            die(json_encode(['result'   =>  $deleteResult]));
        }

    }

}