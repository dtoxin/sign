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
    //Таблица (не хватает префиксов но в тестовом приложении обойдусь без них)
    protected $_table = 'users';

    //Поля (fields)
    protected $_columns = array(
        // email пользователя он-же логин
        'email'         => 'email',
        // хэшированный пароль
        'hash'          => 'hash',
        // имя пользователя
        'name'          => 'name',
        // фамилия
        'last_name'     => 'last_name',
        // Отчество
        'mid_name'      => 'mid_name',
        // Дополнительно поле для произвольной инофрмации (json)
        'addition'      => 'addition',
        // последний вход
        'last_login'    => 'last_login',
        // Дата регистрации
        'create_at'     => 'create_at',
        // Дата бновления профиля
        'updated_at'    => 'updated_at'
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

    public function exists($field, $params)
    {
        return parent::exists($field, $params);
    }
}