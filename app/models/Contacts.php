<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.31.10
 * Time: 20:01
 */

namespace app\models;

class Contacts extends BaseModel
{
    /** @var  int */
    public $id;

    /** @var  string */
    public $contactType;

    /** @var  string */
    public $contactValue;

    const CONTACT_TYPE_ADDRESS  = 'address';

    const CONTACT_TYPE_EMAIL    = 'email';

    const CONTACT_TYPE_PHONE    = 'phone';

    const CONTACT_TYPE_SKYPE    = 'skype';

    public function columnMap() : array
    {
        return [
            'id'            =>  'id',
            'contact_type'  =>  'contactType',
            'contact_value' =>  'contactValue'
        ];
    }

    /**
     *  Map page data array to contact model object
     *
     * @param array $contactAsArray
     */
    public function initFromArray($contactAsArray)
    {
        foreach ($contactAsArray as $key  =>  $value) {
            $this->$key = $value;
        }
    }

    /**
     *  Return address types and their translations to RU
     * @todo Add other languages support
     *
     * @return array
     */
    public static function getContactTypesAndTranslations() : array
    {
        return [
            self::CONTACT_TYPE_ADDRESS  =>  'Адрес',
            self::CONTACT_TYPE_EMAIL    =>  'Э-майл',
            self::CONTACT_TYPE_PHONE    =>  'Телефон',
            self::CONTACT_TYPE_SKYPE    =>  'Скайп'
        ];
    }

    /**
     * Get address
     *
     * @todo Add cache
     * @return array
     */
    public static function getAddress() : array
    {
        $addresses = self::find([
            "conditions" => "contactType = ?1",
            "bind"       => [
                1 => self::CONTACT_TYPE_ADDRESS,
            ]
        ]);

        $result = [];

        if ($addresses) {
            foreach ($addresses as $contact) {
                $result[] = $contact->contactValue;
            }
        }

        return $result;
    }

    /**
     * Get email
     *
     * @todo Add cache
     * @return array
     */
    public static function getEmail() : array
    {
        $emails = self::find([
            "conditions" => "contactType = ?1",
            "bind"       => [
                1 => self::CONTACT_TYPE_EMAIL,
            ]
        ]);

        $result = [];

        if ($emails) {
            foreach ($emails as $contact) {
                $result[] = $contact->contactValue;
            }
        }

        return $result;
    }

    /**
     *Get phone
     *
     * @todo Get phone
     * @return array
     */
    public static function getPhone() : array
    {
        $phones = self::find([
            "conditions" => "contactType = ?1",
            "bind"       => [
                1 => self::CONTACT_TYPE_PHONE,
            ]
        ]);

        $result = [];

        if ($phones) {
            foreach ($phones as $contact) {
                $result[] = $contact->contactValue;
            }
        }

        return $result;
    }

    /**
     * Get skype address
     *
     * @todo Add cache
     * @return array
     */
    public static function getSkype() : array
    {
        $skypes = self::find([
            "conditions" => "contactType = ?1",
            "bind"       => [
                1 => self::CONTACT_TYPE_SKYPE,
            ]
        ]);

        $result = [];

        if ($skypes) {
            foreach ($skypes as $contact) {
                $result[] = $contact->contactValue;
            }
        }

        return $result;
    }

}