<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.13.9
 * Time: 18:10
 */

use Phalcon\Mvc\Model;

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
     *  Map array with user data to user model object
     *
     * @param array $userAsArray
     */
    public function mapDataFromArray($userAsArray)
    {
        $fields = $this->getModelsMetaData()->getReverseColumnMap($this);

        foreach ($userAsArray as $field => $value) {

            if (array_key_exists($field, $fields)) {
                $this->$field = $value;
            }
        }
    }
}