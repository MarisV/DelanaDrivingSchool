<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.16.11
 * Time: 02:18
 */

namespace app\models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email as EmailValidator;

class Support extends BaseModel
{
    /** @var  int */
    public $id;

    /** @var  string */
    public $firstname;

    /** @var  string */
    public $email;

    /** @var  string */
    public $content;

    /** @var  string */
    public $contactTime;


    public function columnMap() : array
    {
        return [
            'id'            =>  'id',
            'content'       =>  'content',
            'firstname'     =>  'firstname',
            'email'         =>  'email',
            'contact_time'  =>  'contactTime'
        ];
    }

    public function beforeValidationOnCreate()
    {
        $this->contactTime = date('d-m-y H:m:s');
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
            ['firstname', 'email', 'content'],
            new PresenceOf(
                [
                    'message' => [
                        'firstname' =>  'Введите имя',
                        'email'     =>  'Введите email',
                        'content'   =>  'Введите сообщение',
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