<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.15.10
 * Time: 21:57
 */

namespace app\controllers;

use library\SharedService;

class UploadsController extends ControllerBase
{
    const ARTICLE_IMAGES_DIR = 'uploads/news/';

    const PAGE_IMAGES_DIR = 'uploads/pages/';

    public function beforeExecuteroute()
    {
        parent::beforeExecuteroute();

        if (SharedService::isAdminLogged() === false) {
            $this->forwardTo404();
            return false;
        }
    }

    public function uploadArticleImageAction()
    {
        $this->view->disable();

        $this->createArticlesImagesDirIfNotExists();

        if ($this->request->isAjax() === true && $this->request->hasFiles()) {

            $file = $this->request->getUploadedFiles()[0];

            $newFileName = md5($file->getName() . date('d-m-y H:m:s')) . '.' .  $file->getExtension();

            $uploadResult = $file->moveTo(self::ARTICLE_IMAGES_DIR . $newFileName);

            $resultToReturn = '/'.self::ARTICLE_IMAGES_DIR . $newFileName;

            if ($uploadResult === false) {
                $resultToReturn = false;
            }

            die(json_encode(['filepath' =>  $resultToReturn]));
        }
    }


    /**
     * Check whether articles images dir exists.
     * If not exists - create it.
     *
     */
    public function createArticlesImagesDirIfNotExists()
    {
        if (!is_dir(self::ARTICLE_IMAGES_DIR)) {
            mkdir(self::ARTICLE_IMAGES_DIR, 0755);
        }
    }


    /**
     * Check whether pages images dir exists.
     * If not exists - create it.
     *
     */
    public function createPagesImagesDirIfNotExists()
    {
        if (!is_dir(self::ARTICLE_IMAGES_DIR)) {
            mkdir(self::ARTICLE_IMAGES_DIR, 0755);
        }
    }

    /**
     *  Delete article image, if article wasn't submitted;
     */
    public function deleteNewsImageIfNotSubmittedAction()
    {
        $this->view->disable();

        if ($this->request->isAjax() && $this->request->isPost()) {

            $filepath = $this->request->getPost('filepath');

            $result = (new News())->deleteNewImage($filepath);

            die(json_encode(['result' => $result]));
        }
    }

    public function uploadPageImageAction()
    {
        $this->view->disable();

        $this->createPagesImagesDirIfNotExists();

        if ($this->request->hasFiles()) {

            $file = $this->request->getUploadedFiles()[0];

            $newFileName = md5($file->getName() . date('d-m-y H:m:s')) . '.' .  $file->getExtension();

            $uploadResult = $file->moveTo(self::PAGE_IMAGES_DIR . $newFileName);

            $uri = $this->getBaseUrl().'/'.self::PAGE_IMAGES_DIR . $newFileName;

            if ($uploadResult === false) {
                $uri = false;
            }

            $resultToReturn =  "<script type='text/javascript'>
                window.parent.CKEDITOR.tools.callFunction('1', '$uri', '');
            </script>";

            die($resultToReturn);
        }
    }

}