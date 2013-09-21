<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dtoxin
 * Date: 9/21/13
 * Time: 2:51 PM
 * To change this template use File | Settings | File Templates.
 */

namespace App\Models;

use App\Core\Db\Dbmodel\DbModel as DbModel;

class User  extends DbModel
{
    //Таблица
    protected $_table = 'users';

    //Поля (fields)
    protected $_columns = array(
        'name' => 'name',
        'psw' => 'psw'
    );

    public static function m($class =__CLASS__)
    {
        return new $class();
    }

    public function getAll()
    {
        return parent::getAll();
    }

    public function getOne($id)
    {
        return parent::getOne($id);
    }

    public function create($params)
    {
        return parent::create($params);
    }

    public function update($params)
    {
        return parent::update($params);
    }

    public function delete($id)
    {
        return parent::delete($id);
    }
}