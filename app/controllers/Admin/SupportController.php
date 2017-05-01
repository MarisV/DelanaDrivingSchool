<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.1.5
 * Time: 16:51
 */

namespace app\controllers\Admin;

use app\models\Support;

class SupportController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('js/admin-support.js');
    }

    public function indexAction()
    {
        $supports = Support::find();

        $this->view->setVar('messages', $supports);
    }

    public function deleteAction()
    {
        $this->view->disable();

        if ($this->request->isPost() && $this->request->isAjax()) {
            $messageId = $this->request->getPost('messageId', ['int']);

            $result = Support::find($messageId)->delete();

            die(json_encode(['result'   =>  $result]));
        }
    }
}