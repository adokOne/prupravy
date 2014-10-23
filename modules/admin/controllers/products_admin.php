<?php defined('SYSPATH') or die('No direct script access.');

class Products_Admin extends Constructor
{
    protected $item_table   = 'products';
    protected $orderby      = 'id';
    protected $order_dir    = 'DESC';
    protected $use_tree     = FALSE;
    protected $use_form     = true;
    protected $use_combo    = FALSE;
    protected $use_logo     = true;
    protected $multi_lang   = FALSE;
    private $lang = "ru";
    protected $logo_path = 'upload/products/';
    protected $logo_ext = '.jpg';
    protected $logo_prefix = '/pr_big';
   
    protected $grid_columns = array(
        "id",
    	"code",
        "weight",
        "has_logo",
        'name',
        'consist',
        "descr"
        
    );
      
    public function __construct()
    {
        parent::__construct();

        $this->lang = $this->input->post("lang","ru",true);
        View::set_global("lan",$this->lang);
        if ($this->use_tree)
            $this->tree = new Tree($this->item_table, '');
        
        $this->db = Database::instance();
        
        $keys1 = array();
        $keys2 = array();
        
        foreach ($this->grid_columns as $field) if ($field != 'id')
        {
            if($field == "name" || $field == "consist" || $field == "descr")
                $field = $field."_".$this->lang." AS ".$field;
            $as = strripos($field, 'AS ');
            if ($as)
            {
                // Определяем пользовательськие поля выборки
                $keys1[] = substr($field, $as + 3);
            }
            $this->user_fields[] = $field;
        }

        // Определяем поля таблицы
        $fields = Database::instance()->field_data($this->item_table);
        foreach($fields as $field)
            $keys2[] = $field->Field;
        // Определяем пользовательские поля выборки, имя которых не совпадает с существующими в таблице
        $this->phantom_fields = array_diff($keys1, $keys2);
    }


    protected function _list_items()
    {
        $sort = $this->input->post('sort', $this->orderby);
        $dir = $this->input->post('dir', $this->order_dir);
        unset($this->user_fields[4]);
        unset($this->user_fields[5]);
        unset($this->user_fields[6]);
        $this->db->select($this->user_fields)
            ->from("$this->item_table AS daddy");
        if(!is_null($this->where_statement))
            $this->db->where($this->where_statement);
  
        foreach (explode(',', $sort) as $k => $s)
            if ($k)
                $this->db->orderby(trim($s));
            else
                $this->db->orderby(trim($s), $dir);
            
           
        $this->_filter();

      #  $this->db->get();echo $this->db->last_query();die;

        return extOZ::grid();
    }
    protected function _save_all_items()
    {
        $records = $this->input->post('save');
        
        if (strlen($records))
        {

            $nodes = json_decode($records);;
            if ($nodes) foreach ($nodes as $n)
            {
                foreach ($n as $key=>$val){
                     $n->$key = $val;
                }
                $this->_todb($n, (isset($n->id)) ? $n->id : FALSE);
            }
        }
    }

    protected function _todb(&$data, $id = FALSE)
    {   $data_  = array();

        foreach($data as $k=>$v){

            if($k == "name" || $k == "consist" || $k == "descr")
                $k = $k."_".$this->lang;
            $data_[$k] = $v; 
        }
        if ($id == 0) {
            $id = $this->db->insert($this->item_table, (array)$data_)->insert_id();
        } else {
            $this->db->update($this->item_table, (array)$data_, "id = $id");
        }

        return $id;
    }












}