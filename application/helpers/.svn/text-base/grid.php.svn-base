<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Grid helper class.
 */
class grid_Core {

    /**
     * JSON data to Grid
     * 
     * @param  string $sort - название поля сортировки
     * @param  string $sort_dir - тип сортировки (DESC/ASC)
     * @param  bool  - возвращать JSON 
     * @param bool | integer - общее кол-во выборки
     * @return JSON
     */
    public static function get($sort = FALSE, $sort_dir = 'ASC', $return_json = TRUE, $cntTotal = true)
    {
    	
        $start = (int)Input::instance()->post('start');
        $limit = (int)Input::instance()->post('limit');
                        
        $db = Database::instance();
        
        
       self::like();
        
        
        if($limit){
        	$db->limit($limit, $start);
        	
        }
        
        if($sort !== FALSE){
        	$db->orderby($sort, $sort_dir);
        	
        }
        
        
        $nodes['items'] = $db->get()->as_array();
        
        //echo Database_Core::instance()->last_query();                
        $nodes['total'] = ($cntTotal === true ? $db->count_last_query() : $cntTotal);

                
        if($return_json)
        	return json_encode($nodes);
        else 
        	return $nodes;
    }
    
    
    
    public static function like(){
    	 $db = Database::instance();
    	
		//Поиск по ключевым словам
        $search = addslashes(Input::instance()->post('search'));
        $fields = json_decode(stripslashes(Input::instance()->post('fields')), TRUE);        
        if ($search and $fields)
        {
            $search = utf8::strtolower($search);
            $where = '(';
            foreach ($fields as $key => $field)
            {
                if ($key)
                {
                    $where .= ' OR ';
                }
                $where .= "LOWER($field) LIKE '%$search%'";
            }
            $where .= ')';
            $db->where($where);
        }     	
    	
        return $db;
    }

} // End num