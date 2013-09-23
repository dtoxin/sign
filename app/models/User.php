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
        // путь до изображения
        'img_path' => 'img_path',
        // Дополнительно поле для произвольной инофрмации (json)
        'addition'      => 'addition',
        // последний вход
        'last_login'    => 'last_login',
        // Дата регистрации
        'created_at'     => 'created_at',
        // Дата бновления профиля
        'updated_at'    => 'updated_at'
    );

    /**
     * @param $postData данные из _POST
     * @return bool|array true если валидация прошла успешно | array с ошибками
     */
    public function validate($postData)
    {
        // email обязателен
        $this->_validate('required', $postData['email'], 'E-mail', 'Not given');
        // корректный e-mail
        $this->_validate('email', $postData['email'], 'E-mail', 'E-mail is not valid');

        // Уникальный пользователь
        $this->_validate('unique', $postData['email'], 'E-mail', 'User already exists', array('field' => 'email'));

        // пароль обязателен
        $this->_validate('required', $postData['password'], 'Password', 'Not given');

        // подтверждение пароля обязательно
        $this->_validate('required', $postData['psw_confirm'], 'Confirm password', 'Not given');

        // пароли должны быть равны
        $this->_validate('confirmation', $postData['psw_confirm'], 'Confirm password', 'Password mismatch', array('forConfirm' => $postData['password']));

        // имя обязательно
        $this->_validate('required', $postData['name'], 'Name', 'Not given');

        // Фамилия обязательна
        $this->_validate('required', $postData['last_name'], 'Last name', 'Not given');

        if (count($this->getValidationErrors()) != 0) {
            return $this->getValidationErrors();
        }

        return true;
    }

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

    public function prepareValuesFromPost()
    {
        // Подготовим значения для записи в базу
        // email  в нижний регистер
        $_POST['User']['email'] = strtolower($_POST['User']['email']);
        // триммируем все
        foreach ($_POST['User'] as $key => $val) {
            $_POST['User'][$key] = trim($val);
        }
    }

    public function getImageFileExt($mimeType)
    {
        $fileExt = array(
            'image/png' => '.png',
            'image/jpg' => '.jpg',
            'image/gif' => '.gif',
        );
        if (isset($fileExt[$mimeType])) {
            return $fileExt[$mimeType];
        }
        return '.jpg';
    }

    public function authenticate($email, $hash)
    {
        return $this->getObject('SELECT * FROM ' . $this->_table . ' WHERE email=:email AND hash=:hash', array(
            ':email' => $email,
            ':hash' => $hash
        ));
    }

    public function execSql($sql)
    {

        return $this->rawSqlQuery($sql);
    }

    public function getTable()
    {
        return $this->_table;
    }
}