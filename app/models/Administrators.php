<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.13.9
 * Time: 18:10
 */

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\PresenceOf;


class Administrators extends BaseModel
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

    public function getValidationMessages()
    {
        $errorMessages = $this->getMessages();

        foreach ($errorMessages as $message) {
            $result[] = [
                'msg'   =>  $message->getMessage()
            ];
        }

        return $result;
    }


}