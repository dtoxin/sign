<?php

/**
 * Class D
 * Форматирование дат
 * @author dtoxin <dtoxin10@gmail.com>
 */
class D {
    static public function formatRu($srcDate, $dtFormat = 'd/m/Y (H:i:s)')
    {
        if ($srcDate == '0000-00-00 00:00:00'){
            return 'N/A';
        }
        $dateTime = new DateTime($srcDate);
        try{
            $resDateTime = $dateTime->format($dtFormat);
        } catch(Exception $e){
            $resDateTime = 'Ошибка при конвертировании даты';
        }

        return $resDateTime;
    }
}