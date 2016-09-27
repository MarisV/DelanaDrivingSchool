<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.12.9
 * Time: 19:13
 */

use Phalcon\Mvc\Model;

class Languages extends Model
{
    public $id;

    public $name;

    public $code;

    public $visible;

    public function initialize()
    {
        $this->belongsTo('id', 'News', 'language_id');
    }

}