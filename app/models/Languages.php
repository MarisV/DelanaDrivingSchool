<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.12.9
 * Time: 19:13
 */

namespace app\models;

use Phalcon\Mvc\Model;

class Languages extends Model
{
    /** @var  int */
    public $id;

    /** @var  string */
    public $name;

    /** @var  string */
    public $code;

    /** @var  string */
    public $visible;

    public function columnMap() : array
    {
        return [
            'id'                =>  'id',
            'name'              =>  'name',
            'code'              =>  'code',
            'visible'           =>  'visible'
        ];
    }

    public function initialize()
    {
        $this->belongsTo('id', 'System', 'default_site_language');
    }

    /**
     *  Map JSON decoded model data to normal model.
     *
     * @param JSON $rawNew
     */
    public function mapDataFromJson($rawNew)
    {
        $fields = $this->getModelsMetaData()->getReverseColumnMap($this);

        foreach ($rawNew as $value) {
            $fieldName = $value['name'];
            $fieldValue = $value['value'];

            if(array_key_exists($fieldName, $fields)) {
                $this->$fieldName = $fieldValue;
            }
        }
    }

    /**
     *  Return active languages [ code => id]
     *
     * @return array
     */
    public static function getActiveLanguagesCodes()
    {
        $tmp =  self::find(
          [
            'columns' => 'id, code',
            'conditions' => 'code != "all" AND visible = "yes"'
          ])->toArray();

        $langs = [];
        if ($tmp) {
            foreach ($tmp as $key => $lang) {
                $langs[$lang['code']] = $lang['id'];
            }
        }
        return $langs;
    }

    public static function getActiveLanguages()
    {
        $assocLanguages = [];

        $tmp =  self::find(
            [
                'columns' => 'id, name',
                'conditions' => 'code != "all" AND visible = "yes"'
            ])->toArray();

        if ($tmp) {
            foreach ($tmp as $id => $lang) {
                $assocLanguages[$lang['id']] = $lang['name'];
            }

            return $assocLanguages;
        }
    }

}