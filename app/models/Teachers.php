<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.11.11
 * Time: 16:41
 */

namespace app\models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\PresenceOf;

class Teachers extends  BaseModel
{
    /** @var  int */
    public $id;

    /** @var  string */
    public $firstname;

    /** @var  string */
    public $lastname;

    /** @var  int */
    public $age;

    /** @var  string */
    public $car;

    /** @var  int */
    public $languageId;

    /** @var  string */
    public $image;

    /** @var  string */
    public $profStatus;

    /** @var  string */
    public $phone;

    /** @var  string */
    public $about;

    /** @var  string */
    public $email;

    const STATUS_TEACHER = 'Преподаватель';

    const STATUS_INSTRUCTOR = 'Инструктор';


    public function columnMap() : array
    {
        return [
            'id'            =>  'id',
            'firstname'     =>  'firstname',
            'lastname'      =>  'lastname',
            'age'           =>  'age',
            'car'           =>  'car',
            'language_id'   =>  'languageId',
            'image'         =>  'image',
            'prof_status'   =>  'profStatus',
            'phone'         =>  'phone',
            'about'         =>  'about',
            'email'         =>  'email'
        ];
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            ['firstname', 'lastname', 'phone'],
            new PresenceOf(
                [
                    'message' => [
                        'firstname' =>  'Введите имя',
                        'lastname'  =>  'Введите фамилию',
                        'phone'     =>  'Введите номер телефона',
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
     * Get validation errors for Pages model
     *
     * @return mixed
     */
    public function getValidationMessages()
    {
        $errorMessages = $this->getMessages();

        foreach ($errorMessages as $message) {
            $result[$message->getField()] = $message->getMessage();
        }

        return $result;
    }

    /**
     *  Get professional status => translation list
     *
     * @return array
     */
    public static function getProfStatuses() : array
    {
        return [
            'teacher'       =>  self::STATUS_TEACHER,
            'instructor'    =>  self::STATUS_INSTRUCTOR
        ];
    }

    /**
     * Get professional status translation
     *
     * @param string $key
     * @return string mixed
     */
    public static function getStatusTranslation($key) : string
    {
        return self::getProfStatuses()[$key];
    }
}