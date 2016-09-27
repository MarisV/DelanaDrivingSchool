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

        die(var_dump(($new)));
    }

}