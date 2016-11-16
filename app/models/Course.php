<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.16.11
 * Time: 03:17
 */

namespace app\models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email as EmailValidator;

class Course extends BaseModel
{
    /** @var  int */
    public $id;

    /** @var  string */
    public $firstname;

    /** @var  string */
    public $lastname;

    /** @var  string */
    public $email;

    /** @var  string */
    public $phone;

    /** @var  int */
    public $categoryId;

    /** @var  string */
    public $timeRequested;

    /** @var  string */
    public $comment;

    public function columnMap() : array
    {
        return [
            'id'            =>  'id',
            'firstname'     =>  'firstname',
            'lastname'      =>  'lastname',
            'email'         =>  'email',
            'phone'         =>  'phone',
            'category_id'   =>  'categoryId',
            'time_requested'=>  'timeRequested',
            'comment'       =>  'comment'
        ];
    }

    public function beforeValidationOnCreate()
    {
        $this->timeRequested = date('d-m-y H:m:s');
    }

    public function initialize()
    {
        $this->hasOne('categoryId', 'Categories', 'id');
    }

    /**
     *  Validation rules for Pages model
     *
     * @return bool
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            ['firstname', 'lastname', 'email', 'phone', 'categoryId'],
            new PresenceOf(
                [
                    'message' => [
                        'firstname'     =>  'Введите имя',
                        'lastname'      =>  'Введите фамилию',
                        'email'         =>  'Введите email',
                        'phone'         =>  'Введите номер телефона',
                        'categoryId'    =>  'Пожалуйста выберите категорию',
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

        return $this->validate($validator);
    }

    /**
     * Get validation errors for Support model
     *
     * @return array
     */
    public function getValidationMessages() : array
    {
        $errorMessages = $this->getMessages();

        $result = [];

        foreach ($errorMessages as $message) {
            $result[$message->getField()] = $message->getMessage();
        }

        return $result;
    }
}