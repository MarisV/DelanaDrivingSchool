<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.13.9
 * Time: 18:10
 */

namespace app\models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\PresenceOf;


class Administrators extends BaseModel
{
    /** @var  int */
    public $id;

    /** @var  string */
    public $username;

    /** @var  string */
    public $password;

    /** @var  string */
    public $firstname;

    /** @var  string */
    public $lastname;

    /** @var  string */
    public $email;

    public function columnMap() : array
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

    public function initialize(){
        $this->setup(
            array('notNullValidations'=>false)
        );
    }


    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            ['firstname', 'lastname', 'email', 'password'],
            new PresenceOf(
                [
                    'message' => [
                        'firstname' =>  'Введите имя',
                        'lastname'  =>  'Введите фамилию',
                        'email'     =>  'Введите e-mail',
                        'password'  =>  'Введите пароль'
                    ]
                ]
            )
        );


        $validator->add(
            'email',
            new EmailValidator(
                [
                    'message' => 'Неправльный e-mail адрес'
                ]
            )
        );

        $validator->add(
            'email',
            new UniquenessValidator(
                [
                    'model'     =>  new Administrators(),
                    'message'   =>  'Извините, Данный e-mail уже зарегистрирован'
                ]
            )
        );

        $validator->add(
            'username',
            new UniquenessValidator(
                [
                    'model'     =>  new Administrators(),
                    'message'   =>  'Извините, данное имя пользователя уже занято'
                ]
            )
        );

        return $this->validate($validator);
    }

}