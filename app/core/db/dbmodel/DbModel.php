<?php

namespace App\Core\Db\Dbmodel;
use \App\Core\Db\DB as DB;

/**
 * Class DbModel
 * Базовая модель для DB
 * @package App\Core\Db\Dbmodel
 */
class DbModel {

    // таблица
    protected $_table;
    // поля
    protected $_columns = array();
    // ошибки валидации
    protected $_validationErrors = array();

    /**
     * Получить все записи
     * @return array
     */
    protected function getAll()
    {
        return DB::getInstance()->sqlQuery('SELECT * FROM ' . $this->_table, array());
    }

    /**
     * Получить одну в виде stdClass
     * @param int $id primary key
     * @return mixed
     */
    protected function getOne($id = 0)
    {
        return  DB::getInstance()->getObject('SELECT * FROM ' . $this->_table . ' WHERE id=:id', array(
            'id' => $id,
        ));
    }

    /**
     * Обновление записи
     * @param array $params параметры
     * @return mixed
     */
    protected function update($params = array())
    {
        return DB::getInstance()->exec('UPDATE ' . $this->_table . ' SET ' . $this->_prepareColumnStr(false, true) . ' WHERE id=:id', $params);
    }

    /**
     * Удаление по Id
     * @param $id
     * @return mixed
     */
    protected function delete($id)
    {
        return DB::getInstance()->exec('DELETE FROM ' . $this->_table . ' WHERE id=:id', array(':id' => $id));
    }

    /**
     * Проверяет наличие строки в базе по полю указанному в массиве параметров
     * @param $field поле
     * @param array $params параметры
     * @return bool false - нет записи
     */
    protected function exists($field, $params = array())
    {
        $db = DB::getInstance();
        $_field = $db->getDB()->quote($field);
        // Странно но после экранирования выборка ничего не возвращает...
        // Поэтому кавычки после экранирования я заменил на `
        $_field = str_replace('\'', '`', $_field);
        $result = $db->sqlQuery('SELECT * FROM ' . $this->_table . ' WHERE ' . $_field . '=:value LIMIT 1', $params);
        if (!empty($result)) {
            //Запись есть вернем ёё как экземпляр класса stdClass
            return $result[0];
        }
        return false; // Записи нет
    }

    /**
     * Добавление записи
     * @param array $params
     * @return mixed
     */
    protected function create($params= array())
    {
        return DB::getInstance()->exec('INSERT INTO ' . $this->_table . $this->_prepareColumnStr() . 'VALUES ' . $this->_prepareColumnStr(true), $params);
    }

    /**
     * Получение stdClass объекта (или массива таких объектов)
     * @param $sql
     * @param array $params
     * @return mixed
     */
    protected function getObject($sql, $params = array())
    {
        return DB::getInstance()->getObject($sql, $params);
    }

    /**
     * Подготовка строки содержащей столбцы таблицы
     * @param bool $asParam есили true то сделать строку вида (:field1, :field2) иначе (field1, field2)
     * @param bool $crossParam если true то создать строку вида filed=:field где позже :field заменится на param
     * @return string готовая строка для вставки в sql зарос
     */
    private function _prepareColumnStr($asParam = false, $crossParam = false)
    {
        $resultStr = '';

        if ($crossParam) {
            foreach ($this->_columns as $field => $param) {
                if ($param != end($this->_columns)){
                    $resultStr .= $field . '=:' . $param . '%';
                } else {
                    $resultStr .= $field . '=:' . $param;
                }
            }
            return str_replace("%", ', ', $resultStr);
        }

        if ($asParam) {
            foreach ($this->_columns as $field) {
                $resultStr .= ', :'. $field;
            }
            // Убрать мусор вначале строки
            $resultStr[0] = '(';

            return $resultStr . ') ';
        } else {
            $resultStr = implode(' ,', $this->_columns);
            return ' (' . $resultStr . ') ';
        }
    }

    /**
     * Возвращает массив ошибок валидации
     * @return array массив с ошибками
     */
    public function getValidationErrors()
    {
        return $this->_validationErrors;
    }

    /**
     * Выполнение запроса (RAW без подстановки параметром и эеранирования)
     * @param $sql
     * @return mixed
     */
    protected function rawSqlQuery($sql)
    {
        return DB::getInstance()->rawSql($sql);
    }


    /**
     * Проводит валидацию строки на выходе в классе модели имеем массив где для каждого поля вложенный массив ошибок
     *
     * @param $validator  метод в классе Validator
     * @param $strForValidation строка для валидации
     * @param $fieldName имя поля (из _POST например) станет ключом в асс. массиве ошибок
     * @param $errorMessage текст сообщения об ощибке
     * @param array $params параметры (зависят от валидатора)
     * @return bool  true
     * @throws \Exception Отсутствует метод в классе Validator
     */
    protected function _validate($validator, $strForValidation, $fieldName, $errorMessage, $params = array())
    {
        if (method_exists('Validator', $validator)) {
            $result = \Validator::$validator($strForValidation, $params);
            if ($result) {
                return true;
            } else {
                if (isset($this->_validationErrors[$fieldName])){
                    array_push($this->_validationErrors[$fieldName], $errorMessage);
                } else {
                    $this->_validationErrors[$fieldName] = array($errorMessage);
                }
            }
            return true;
        } else {
            throw new \Exception ('Validator not found');
        }
    }


}