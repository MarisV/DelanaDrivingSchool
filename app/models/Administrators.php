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
}