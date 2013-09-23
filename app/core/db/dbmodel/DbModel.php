<?php

namespace App\Core\Db\Dbmodel;
use \App\Core\Db\DB as DB;
class DbModel {

    protected $_table;
    protected $_columns = array();
    protected $_validationErrors = array();

    protected function getAll()
    {
        return DB::getInstance()->sqlQuery('SELECT * FROM ' . $this->_table, array());
    }

    protected function getOne($id = 0)
    {
        return  DB::getInstance()->getObject('SELECT * FROM ' . $this->_table . ' WHERE id=:id', array(
            'id' => $id,
        ));
    }

    protected function update($params = array())
    {
        return DB::getInstance()->exec('UPDATE ' . $this->_table . ' SET ' . $this->_prepareColumnStr(false, true) . ' WHERE id=:id', $params);
    }

    protected function delete($id)
    {
        return DB::getInstance()->exec('DELETE FROM ' . $this->_table . ' WHERE id=:id', array(':id' => $id));
    }

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

    protected function create($params= array())
    {
        return DB::getInstance()->exec('INSERT INTO ' . $this->_table . $this->_prepareColumnStr() . 'VALUES ' . $this->_prepareColumnStr(true), $params);
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