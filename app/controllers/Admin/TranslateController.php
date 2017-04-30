<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.14.2
 * Time: 17:42
 */

namespace app\controllers\Admin;

use app\models\LanguageKeywords;
use app\models\Languages;
use app\models\LanguageTranslate;
use app\models\Translates;


class TranslateController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('components/EditableTable/editable-table.js');
        $this->assets->addJs('js/admin-translates.js');
    }

    public function indexAction()
    {
        $languages = Languages::getActiveLanguages();

        $translates = [];

        $keywords = LanguageKeywords::find()->toArray();

        foreach (array_keys($languages) as $languageId) {
            $translates[$languageId] = (new LanguageTranslate())->loadTranslates($languageId);
        }

        $this->view->setVars([
            'languages'     =>  $languages,
            'translates'    =>  $translates,
            'keywords'      =>  $keywords
        ]);
    }

    public function updateTranslateAction()
    {
        $this->view->disable();

        $keywordId = $this->request->getPost('keywordId', ['trim', 'string']);
        $languageId = $this->request->getPost('languageId', ['trim', 'string']);
        $newTranslate = $this->request->getPost('translate', ['trim', 'string']);

        $result = (new LanguageTranslate())->updateTranslate($keywordId, $languageId, $newTranslate);

        die(json_encode([
            'result'    =>  $result
        ]));
    }
}