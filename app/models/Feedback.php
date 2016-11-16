<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.16.11
 * Time: 19:22
 */

namespace app\models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email as EmailValidator;

class Feedback extends BaseModel
{
    public $id;

    public $firstname;

    public $lastname;

    public $email;

    public $comment;

    public $commentDate;

    public function columnMap() : array
    {
        return [
            'id'            =>  'id',
            'firstname'     =>  'firstname',
            'lastname'      =>  'lastname',
            'email'         =>  'email',
            'comment'       =>  'comment',
            'comment_date'  =>  'commentDate'
        ];
    }

    public function beforeValidationOnCreate()
    {
        $this->commentDate = date('d-m-y H:m:s');
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
            ['firstname', 'lastname', 'email', 'comment'],
            new PresenceOf(
                [
                    'message' => [
                        'firstname' =>  'Введите Ваше имя',
                        'lastname'  =>  'Введите Вашу фамилию',
                        'email'     =>  'Введите Ваш email',
                        'content'   =>  'Введите Ваше сообщение',
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
}