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

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'firstname',
            new PresenceOf([
                'Введите имя'
            ]));

        $validator->add(
            'lastname',
            new PresenceOf([
                'Введите фамилию'
            ]));

        $validator->add(
            'email',
            new EmailValidator([
                'message' => 'Неправльный e-mail адрес'
            ]));
        $validator->add(
            'email',
            new UniquenessValidator([
                'message' => 'Извините, Данный e-mail уже зарегистрирован'
            ]));
        $validator->add(
            'username',
            new UniquenessValidator([
                'message' => 'Извините, данное имя пользователя уже занято'
            ]));


        return $this->validate($validator);
    }
}