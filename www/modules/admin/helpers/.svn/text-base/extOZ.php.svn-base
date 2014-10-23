<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Ext helper class.
 *
 * @package    Core
 * @author     Oleh Zamkovyi <oleh.zam@gmail.com>
 */
class extOZ_Core {

    public $enum_store = '';
    /**
     * Form data
     * @return array
     */
    public static function get_form($table)
    {
        $data = array();

        $fields = Database::instance()->field_data($table);
        foreach($fields as $field)
            $fields[$field->Field] = array_shift($fields);
            
        $fields = array_intersect_key($fields, $_POST);
        foreach($fields as $key => $val)
        {
        	$post = $key=="video" ? $_POST[$key] : stripslashes(Input::instance()->post($key));
        	
            if ($val->Key != 'PRI')
            {
                $data[$key] = $post;
                
                //unset($_POST[$key]);
            }
                            
            if (substr($val->Type, 0, 10) == 'tinyint(1)')
                $data[$key] = (empty($post))? 0 : 1;

        }

        return $data;
    }

    public static function record($table, $columns)
    {
        foreach ($columns as $key => $val)
        {
            $as = strripos($val, 'AS ');
            $columns[$key] = ($as) ? substr($val, $as + 3) : $val;
        }
        $fields = Database::instance()->field_data($table);
               
        foreach($fields as $field)
            $fields[$field->Field] = array_shift($fields);
        
        $result = array();
        foreach($columns as $key)
        {
            if (isset($fields[$key]))
            {
                $val = $fields[$key];
                $isset_length = strripos($val->Type, '(');
                $type = ($isset_length) ? substr($val->Type, 0, $isset_length) : $val->Type;
                switch ($type)
                {
                case 'varchar':
                case 'text':
                case 'tinytext':
                case 'mediumtext':
                case 'longtext':
                case 'enum':                
                    $type = 'string';
                break;
                case 'int':
                case 'tinyint':
                case 'mediumint':
                case 'smallint':
                    $type = 'int';
                break;
                case 'float':
                case 'real':
                case 'double':
                    $type = 'float';
                break;
                case 'datetime':
                    $type = 'xdatetime';
                break;
                case 'date':
                    $type = 'date';
                break;              
                default:
                    $type = 'string';
                }
                if ($key=="active_until")
                $type = 'string';                   
                $result[] = "{name: '$key', type: '$type'}";
            }
            else
            {
                $result[] = "{name: '$key'}";
            }
        }
        return implode(",\n", $result);       
    }    

    /**
     * Создание Store-объектов для enum-полей
     * @return JSON
     */
    public static function enum_store($table)
    {
        $fields = Database::instance()->field_data($table);
        $enum_store = array();
        foreach($fields as $field)
        {
            if(substr($field->Type, 0, 4) == 'enum')
            {
                $enum = explode("','", substr($field->Type, 6, strlen($field->Type)-8));
                $enum = "['".implode("'],['", $enum)."']";
                $enum_store[] = "var enumStore_$field->Field = new Ext.data.SimpleStore({fields:['text'],data:[$enum]});";
            }
        }
        return implode("\n\n", $enum_store);
    }

    
    public static function store($table, $columns)
    {
        $data = Database::instance()
            ->select($columns)
            ->from("$table AS daddy")
            ->limit(1)
            ->get()
            ->current();
            
        return "'".implode("','", array_keys((array)$data))."'";
    }
    /**
     * JSON data to Grid
     * @return JSON
     */
    public static function grid()
    {
        $offset = (int)Input::instance()->post('start', 0);
        $limit = (int)Input::instance()->post('limit', 20);

        $nodes['items'] = Database::instance()
            ->limit($limit, $offset)
            ->get()
            ->as_array();
        

       foreach ($nodes['items'] as $k=>$v){
       	if( isset($nodes['items'][$k]->description) ){
       		preg_match_all('/[a-zA-Zа-яА-Яії0-9 ,\.:\(\)\/@!;]/u', $nodes['items'][$k]->description, $matches);
       		$nodes['items'][$k]->description = implode('', $matches[0] );
       	}
       }
        		
        //echo Database::instance()->last_query();die();
        //$nodes['total'] = Database::instance()->count_last_query();
        $nodes['total'] = Database::instance()->query("SELECT FOUND_ROWS() AS total")->current()->total;
        //echo $nodes['total'];die();
        //print_r($nodes);die;
        return $nodes;
    }
    
    /**
     * Формирует JSON ответ для отправки статуса выполнения в формате
     * необходимом для понимания в Ext.js
     * 
     * @param $success bool статус выполнения true/false
     * @param $message sring информация об ошибке
     * @return JSON
     */
    public static function json_response($success, $message = '') {
        if ($success) $success = true;else $success = false;
        return '{"success": '.$success.', "msg": "'.$message.'"}';
    }    

} // End ext