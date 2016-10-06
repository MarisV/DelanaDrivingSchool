<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.12.9
 * Time: 19:13
 */

use Phalcon\Mvc\Model;

class Languages extends Model
{
    public $id;

    public $name;

    public $code;

    public $visible;

    public function columnMap()
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
        $this->belongsTo('id', 'News', 'language_id');
    }

    /**
     *  Map JSON decoded model data to normal model.
     *
     * @param JSON $rawNew
     */
    public function mapDataFromJsonToModel($rawNew)
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

}