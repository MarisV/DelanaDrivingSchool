<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.17.10
 * Time: 18:13
 */

namespace app\models;

use Phalcon\Mvc\Model;

class BaseModel extends Model
{
    /**
     *  Map data array to model object
     *
     * @param array $dataAsArray
     */
    public function initFromArray($dataAsArray)
    {
        $fields =  $this->getModelsMetaData()->getReverseColumnMap($this);

        foreach ($dataAsArray as $field => $value) {

            if (array_key_exists($field, $fields)) {
                $this->$field = $value;
            }
        }
    }
}