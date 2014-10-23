<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Ext helper class.
 *
 * @package    Core
 * @author     Oleh Zamkovyi <oleh.zam@gmail.com>
 */
class ext_Core {

    /**
     * Form data
     * @return array
     */
    public static function get_form($table, $isKey = false)
    {
        $data = array();

        $fields = Database::instance()->field_data($table);
        foreach($fields as $field)
            $fields[$field->Field] = array_shift($fields);
		
        foreach(array_intersect_key($fields, $_POST) as $key => $val)
        {
        	$post = $key=="video" ? $_POST[$key] : stripslashes(Input::instance()->post($key));
			
            if (! $val->Key || $isKey)
                $data[$key] = $post;
            if (substr($val->Type, 0, 10) == 'tinyint(1)')
                $data[$key] = (empty($post))? 0 : 1;                 
                
                
                
        }
        return $data;
    }
    
    /**
     * Формирует JSON ответ для отправки статуса выполнения в формате
     * необходимом для понимания в Ext.js
     * 
     * @param $success bool статус выполнения true/false
     * @param $message sring информация об ошибке
     * @return JSON
     */
    public static function json_response($success, $message = 'ok') {
        if ($success) $success = true;else $success = false;
        return '{"success": '.$success.', "msg": "'.$message.'"}';
    }    

} // End ext