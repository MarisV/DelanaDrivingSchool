<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.13.9
 * Time: 18:10
 */

use Phalcon\Mvc\Model;
use Phalcon\Security;

class Administrators extends Model
{
    public $id;

    public $username;

    public $password;

    public $firstname;

    public $lastname;

    public $email;

    public function columnMap()
    {
        return [
            'id'                =>  'id',
            'username'          =>  'username',
            'password'          =>  'password',
            'firstname'         =>  'firstname',
            'lastname'          =>  'lastname',
            'email'             =>  'email'
        ];
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
}