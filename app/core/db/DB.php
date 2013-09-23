<?php

namespace App\Core\Db;


use ___PHPSTORM_HELPERS\object;

class DB {

    protected static $_instance;

    protected $_dsn; //строка подключения к базе
    protected $_db_user;
    protected $_db_psw;
    protected $_db;

    private function __construct() {}

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        self::$_instance->_setDsn();
        return self::$_instance;
    }

    private function __clone() {
    }

    private function __wakeup() {
    }

    /**
     * Установка параметров соединения
     */
    private function _setDsn()
    {
        $cfg_dsn = \Config::get('db', 'dsn', '', true);
        $this->_db_user = \Config::get('db', 'db_user', '', true);
        $this->_db_psw = \Config::get('db', 'db_psw', '', true);
        $this->_dsn = $this->_prepareDsn($cfg_dsn);
    }

    /**
     * Подготовка строки подключения
     * @param $srcDsn строка с параметрами
     * @return mixed готовая строка для PDO
     */
    private function _prepareDsn($srcDsn)
    {
        $cfg_host = \Config::get('db', 'hostname', 'localhost', true);
        $cfg_database = \Config::get('db', 'database', '', true);
        $realDsn = str_replace('#hostname', $cfg_host, $srcDsn);
        $realDsn = str_replace('#database', $cfg_database, $realDsn);
        return $realDsn;
    }

    /**
     * Подключение к DB
     * @throws PDO exeption
     */
    protected function _connect()
    {
        try {
            $this->_db = new \PDO($this->_dsn, $this->_db_user, $this->_db_psw, array(
                \PDO::ATTR_PERSISTENT => true
            ));
        } catch (\PDOException $e) {
            die($e->getMessage());
        }

    }

    /**
     * Выполнение запроса с параметрами для выборки всех записей
     * @param $sql Запос
     * @param array $params параметры
     * @return array массив stdClasses
     */
    public function sqlQuery($sql, $params= array())
    {
        $this->_connect();
        $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $result = $this->_db->prepare($sql);
        $status = $result->execute($params);
        $data = array();
        while ($row = $result->fetch(\PDO::FETCH_OBJ)){
            array_push($data, $row);
        }
        return $data;
    }

    /**
     * @param $sql запос
     * @param array $params параметры
     * @return mixed 1 объект stdClass
     */
    public function getObject($sql, $params= array())
    {
        $this->_connect();
        $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $result = $this->_db->prepare($sql);
        $status = $result->execute($params);
        return $result->fetch(\PDO::FETCH_OBJ);
    }

    public function exec($sql, $params = array())
    {
        $this->_connect();
        $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        try{
            $result = $this->_db->prepare($sql);
            /*var_dump($result); die();*/
            return $status = $result->execute($params);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }

    }

    /**
     * Если где-то понадобится pdo
     * @return mixed PDO obj
     */
    public function getDB()
    {
        $this->_connect();
        return $this->_db;
    }

}