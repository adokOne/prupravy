<?php defined('SYSPATH') or die('No direct script access.');


abstract class Constructor extends Controller
{
	
	protected $langs = array('ru','ua','en');

    /**
     * Grid Таблица
     *
     * @var string
     */
    protected $item_table;
    
    protected $where_statement;
    /**
     * Tree Таблица
     *
     * @var string
     */
    protected $tree_table;
    
    protected $options =FALSE;
    /**
     * Имя шаблона
     *
     * @var string
     */
    protected $template = 'list_admin';
    
    /**
     * Поле сортировки по умолчанию
     *
     * @var string
     */
    protected $orderby;
    protected $order_dir = 'ASC';

    /**
     * Поле связка с деревом
     *
     * @var string
     */
    protected $tree_id;
    
    /**
     * Пользовательские поля выборки
     *
     * @var array
     */ 
    protected $user_fields = array("SQL_CALC_FOUND_ROWS id");
    
    /**
     * Пользовательские поля выборки, имя которых не совпадает с существующими
     *
     * @var array
     */    
    protected $phantom_fields = array();
    
    /**
     * Массив полей редктируемых в форме ExtJS
     *
     * @var array
     */
    protected $form_columns = array('*');
       
    /**
     * Массив полей редктируемых в Grid ExtJS
     *
     * @var array
     */
    protected $grid_columns = array();

    /**
     * Выводить ли панель-дерево
     *
     * @var boolean
     */
    protected $use_tree = FALSE;

    /**
     * Выводить ли панель-форму
     *
     * @var boolean
     */
    protected $use_form = TRUE;
        
    /**
     * Разрешить ли Drag & Drop узлов дерева
     *
     * @var boolean
     */
    protected $enable_DD = FALSE;

    /**
     * Используется ли логотип
     *
     * @var boolean
     */
    protected $use_logo = FALSE;

    /**
     * Используется ли адресную форму
     *
     * @var boolean
     */
    protected $use_location = FALSE;
    
    /**
     * Используется ли карта (ТОЛЬКО УРАИНА)
     *
     * @var boolean
     */
    protected $use_map = FALSE;
    protected $use_lines = FALSE;

    /**
     * Используется ли карта (GOOGLE)
     *
     * @var boolean
     */
   /**
     * Используется ли многоязычность
     *
     * @var boolean
     */ 
    protected $multi_lang     = FALSE;
    
    protected $use_google_map = FALSE;
    /**
     * Используется ли Combo
     *
     * @var boolean
     */
    protected $use_combo = FALSE;

    /**
     * Используется ли логотип
     *
     * @var string
     */
    protected $logo_path;
    
    /**
     * Тип изображения (.jpg, .png, .gif)
     *
     * @var string
     */
    protected $logo_ext = '.jpg';

    /**
     * Префикс изображения
     *
     * @var string
     */
    protected $logo_prefix = '';
    
    /**
     * Размеры логотипа (Если пусто сохраняется как есть)
     *
     * @var array(width => w, height=>h)
     */
    protected $logo_size = array(200, 200);
    
    /**
     * Ресайсинг логотипа относительно ширины
     *
     * @var array(width => w, height=>h)
     */
    protected $logo_by_width = TRUE;

    /**
     * Stores
     *
     * @var array
     */
    protected $stores = array(
    );
    protected $Stores = array(
    );
    
    protected $fileds =array();
    
    protected $lang_field = array();
    /**
     * Конструктор
     */
    public function __construct()
    {
        parent::__construct();
		
        if ($this->use_tree)
            $this->tree = new Tree($this->item_table, '');
        
        $this->db = Database::instance();
        if($this->multi_lang)
        foreach($this->langs as $k=>$lang)
        	foreach ($this->lang_field as $filed)
	    		array_push($this->grid_columns,"(SELECT ".$filed." FROM ".$this->item_table."_langs WHERE ".inflector::singular($this->item_table)."_id = daddy.id AND id_lang={$k}) AS ".$filed."_{$k}");
        $keys1 = array();
        $keys2 = array();
        
        foreach ($this->grid_columns as $field) if ($field != 'id')
        {
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

    /**
     * Загрузка JS модуля
     */
    public function index()
    {
        $class = strtolower(get_class($this));
        
        $this->template = (Kohana::find_file('views', $class, FALSE, 'php')) ? $class : $this->template;
        
        $this->class = substr($class, 0, strrpos($class, '_'));
        $this->view = new View($this->template);

        $this->view->dir = MODPATH.'admin/views/constructor';
        $this->view->use_form = $this->use_form;
        $this->view->use_tree = $this->use_tree;
        $this->view->enable_DD = $this->enable_DD;
        $this->view->use_logo = $this->use_logo;
        $this->view->use_location = $this->use_location;
        $this->view->use_map = $this->use_map;
        $this->view->use_google_map = $this->use_google_map;
        $this->view->use_lines = $this->use_lines;
        $this->view->use_combo = $this->use_combo;
        $this->view->logo_path = $this->logo_path;
        $this->view->logo_ext = $this->logo_ext;
        $this->view->logo_prefix = $this->logo_prefix;
        $this->view->tree_id = $this->tree_id;
        $this->view->langs   = $this->langs;
        $this->view->fileds   = $this->fileds;

          
       
        if ($this->use_tree)
            $this->view->tree = json_encode($this->_load_tree());

        $stores = array();
        foreach($this->stores as $key)
        {
            $func = "_load_treecombo_$key";
            $stores[$key] = json_encode($this->$func());
        }
        $this->view->stores = $stores;
        $this->view->Stores = $this->Stores;
        unset($stores);

        $this->view->class = $this->class;
         
        $this->url = '/admin/'.$this->view->class;
        $this->view->url = $this->url;
      
        $this->view->list_items = json_encode($this->_list_items());
		
		
        $this->view->grid_record = extOZ::record($this->item_table, $this->grid_columns);
        #var_dump($this->view->grid_record);exit();
        $this->view->form_columns = extOZ::store($this->item_table, $this->form_columns);
        $this->view->enum_store = extOZ::enum_store($this->item_table);
       #var_dump($this->form_columns);exit();
        if (file_exists($this->view->dir."/inc/$this->class.php"))
           $this->view->include = TRUE;
        else
           $this->view->include = FALSE;

        if (file_exists($this->view->dir."/buttons/$this->class.php"))
           $this->view->buttons = TRUE;
        else
           $this->view->buttons = FALSE;
       
       //if (Kohana::find_file('views', "stores/$this->class", FALSE, 'php'))
       //    $this->view->stores = TRUE;

        $this->view->lang = Kohana::lang($class);
        
        Event::add("system.post_controller", array($this, '_render'));
        //$this->view->render(true);
    }

    /**
     * Render the loaded template.
     */
    public function _render()
    {
        //echo "<script type='text/javascript'>\n";
        $this->view->render(TRUE);
        //echo "\n</script>";
    }
    /**
     * Фильтрация
     */
    protected function _filter()
    {        
        // Поиск
        $search = $this->input->post('search');
        $fields = json_decode(stripslashes($this->input->post('fields')), TRUE);

        $search = preg_replace("~\s+~", " ", trim($search));
        
        if ($search and $fields)
        {
            $temp = array();
            foreach ($fields as $field)
            {
                $sub_temp = array();
                foreach (explode(" ", $search) as $word)
                {
                    $sub_temp[] = $field." LIKE '%$word%'";
                }
                $temp[] = "(".implode(" OR ", $sub_temp).")";
            }
            $where = implode(" OR \n", $temp);
            $this->db->where('('.$where.')');
        }
        
        if ($tree_id = explode('_', $this->input->post('node')))
        {
            $tree_id = $tree_id[0];
            if ($tree_id)
                $this->db->where("`$this->tree_id` = '".$tree_id."'");
        }
    }

    /**
     * Grid
     */
    protected function _list_items()
    {
        $sort = $this->input->post('sort', $this->orderby);
        $dir = $this->input->post('dir', $this->order_dir);

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

        //$this->db->get();echo $this->db->last_query();die;

        return extOZ::grid();
	}

    public function list_items()
    {
        $this->_save_all_items();
        $this->_remove_all_items();
        
        echo json_encode($this->_list_items());
    }

    public function action_list_items()
    {
        $nodes = array(
            'list' => $this->_list_items(),
            'success' => true
        );
        echo json_encode($nodes);
    }

    protected function _remove_all_items()
    {
        $ids = $this->input->post('remove');
        if (strlen($ids))
        {        
            $nodes = json_decode(stripslashes($ids), TRUE);
            $this->db->delete($this->item_table, 'id IN ('.implode($nodes[0], ', ').')');
        }
    }

    protected function _todb(&$data, $id = FALSE)
    {	$iD=0;
       
        if ($id > 0)
            $this->db->update($this->item_table, (array)$data, "id = $id");
        else
            $iD = $this->db->insert($this->item_table, (array)$data)->insert_id();
        
         if($this->multi_lang)
			$this->_to_lang_db($id,$iD);
        
        return ($iD<1) ? $id :$iD;
    }
    protected function _to_lang_db($id = FALSE,$insert_id)
    {	
    	$this->db->delete($this->item_table."_langs",array(inflector::singular($this->item_table)."_id"=>$id));
    	$id = $id > 0 ? $id : $insert_id;
    	if(count($this->lang_field)<2){	
		        foreach($_POST as $key=>$val){
		        	foreach ($this->lang_field as $f){
			        	if(preg_match("/{$f}_(\d)/i", $key,$lang)>0){
					        $this->db->insert($this->item_table."_langs", array($f=>$val,"id_lang"=>$lang[1],inflector::singular($this->item_table)."_id"=>$id));
			    		}
		        	}
		    	}
    	}else{
	    	    $data = array();
		        foreach($_POST as $key=>$val){
		        	foreach ($this->lang_field as $f){
			        	if(preg_match("/{$f}_(\d)/i", $key,$lang)>0){
			        		if(strlen($val)>0){
				        		$data[$lang[1]][$f] = $val;
				        	    if(count($data[$lang[1]]) == count($this->lang_field)){
					        		$data[$lang[1]]["id_lang"] = $lang[1];
					        		$data[$lang[1]][inflector::singular($this->item_table)."_id"] = $id;
					        		if(!isset($r[$lang[1]]))
				        		   		$r[$lang[1]] = $this->db->insert($this->item_table."_langs", $data[$lang[1]]);
			        			}
			        		}
			    		}

		        	}
			
		    	}
	    	}

    }
    protected function _save_all_items()
    {
        $records = $this->input->post('save');
        
        if (strlen($records))
        {
            /* WHT?
            if (get_magic_quotes_gpc())
                $records = stripcslashes($records);
            */    
            $nodes = json_decode($records);;
            if ($nodes) foreach ($nodes as $n)
            {
                foreach ($n as $key=>$val){
                	 $n->$key = $val;
                }
                
 
                
                // Не учитываем фантомные поля
                
                foreach ($this->phantom_fields as $key){
                	if($this->multi_lang==TRUE){
                		foreach ($this->lang_field as $f){
	                		 if(preg_match("/{$f}_(\d)/i", $key,$lang)>0){
	                		 	$_POST[$key]= (isset($n->$key)) ? $n->$key : "";
	                		 }
                		}
                	}
                	
                		if(isset($n->$key)) unset($n->$key);
                		#var_dump($n);
                }
                
                if($this->multi_lang && count((array)$n)==0 && !isset($n->id))
                	$n->id=null;
                $this->_todb($n, (isset($n->id)) ? $n->id : FALSE);
            }
        }
    }

    protected function _logo($id = 0, $has_logo = 0) 
    {	
        if (!$id)
            return FALSE;

        // Создание логотипа или удаление существующего        
        //$file = $this->logo_path.$id.$this->logo_ext;
        if ($has_logo == 1)
        {
        	
            picenigne::save_picture($_FILES['logo']['tmp_name'], $this->logo_path, $id.$this->logo_prefix.$this->logo_ext);
            
            /*
            $thumb = Image::factory($logo);
            if ($this->logo_size)
            {
                $w = $this->logo_size[0];
                $h = $this->logo_size[1];
                if ($this->logo_by_width) {
                    $thumb->resize($w, $h, Image::WIDTH);
                } else {
                    $thumb->resize($w, $h, Image::AUTO); //->crop($w, $h, 'top', 'center');
                }
            }
                
            $a = $thumb->save($file);
             *
             */
        }
        elseif($has_logo=="user"){
        	
        $filename=$_FILES['logo']['tmp_name'];
        $out= DOCROOT.'/tmp/'.$id.".jpg";
        move_uploaded_file($filename, $out);
        
        MOJOUser::processAvatar($out, $id,true,$this->logo_path);
                 
        }
        elseif (($has_logo != '0') && ($has_logo != '1') && (file_exists($file)) && $has_logo !="user")
        {
            unlink($file);
        }
    }
    
    public function save()
    {   $options = array();
        $data = extOZ::get_form($this->item_table);
        if($this->options)
	        foreach ($_POST as $k=>$v){
	        	$r=preg_replace("~(\d+)~", "", $k);
	        	 
	        	if($r=="f" && $v=="on")
	        	array_push($options,preg_replace("~(f)~", "", $k));
	        }
        
        // Очистка данных
        foreach ($data as $key => $val)
        {
            //$data[$key] = preg_replace("~( +)~", " ", htmlspecialchars_decode(strip_tags($val)));
            $data[$key] = preg_replace("~( +)~", " ", $val);
            $data[$key] = str_replace("&nbsp;", " ", $data[$key]);
            $data[$key] = trim($data[$key]);
            
        }
        $p_id = (int)$this->input->post('id');
        $id = $this->_todb($data, $p_id);
        
        if($this->options)
        	$this->db->delete($this->item_table.'_options',array($this->item_table.'_id'=>$id));
        if(count($options) > 0)
          foreach ($options as $o)
          	$this->db->insert($this->item_table.'_options',array("options_id"=>$o,$this->item_table.'_id'=>$id));
        if ($this->use_logo)
          $this->_logo($id, 'user');
        $this->action_list_items();
        
    }    
    
    public function edit()
    {
        $id = (int)$this->input->post('id');

        $data = $this->db->select($this->form_columns)
            ->from("$this->item_table AS daddy")
            ->where('id', $id)
            ->get()
            ->current();
            
        echo json_encode(array($data));
    }
    


    protected function _load_treecombo_category()
    {
        $this->db
            ->select(
                "id",
                "title_ru AS text",
                "IF(parent_id, parent_id, null) AS parent_id"
            )
            ->from($this->tree_table)
            ->orderby('left_key');

        $nodes['items'] = $this->db->get()->as_array();
        return $nodes;
    }

    
    public function load_treecombo_category()
    {
        echo json_encode($this->_load_treecombo_category());
    }
    
    private function _level($level = 1, $start = 0)
    {
        $key = $start;
        $sub_key = 0;
        $nodes = array();
        
        while ($key < count($this->data) and $level == $this->data[$key]->level)
        {
            $node = $this->data[$key];
            
            $has_childs = (floor(($node->right_key - $node->left_key - 1) / 2));
            $nodes[$sub_key] = array(
                'id' => $node->id,
                'text' => $node->title_ru,
                'iconCls' => 'ico_page'
            );
            if ($has_childs) {
                $nodes[$sub_key]['children'] = $this->_level($node->level + 1, $key + 1);
                $key += $has_childs;
            } else {
                $nodes[$sub_key]['children'] = array();
            }
            $key++;
            $sub_key++;
        }        
        return $nodes;
    }
    

    protected function _load_tree() {
        $this->data = $this->db
        ->from($this->tree_table)
        ->orderby('left_key')
        ->get();
        
        return $this->_level();
    }    

    public function load_tree() {
        echo json_encode($this->_load_tree());
    }
    
    public function move()
    {
        $node = (int)$this->input->post('node');
        $target = (int)$this->input->post('target');
        $point = $this->input->post('point');

        echo extOZ::json_response($this->tree->move_node($node, $target, $point));
    }
    
    protected function _add_null_parent_id()
    {
        $data = $this->db->get()->as_array();
        foreach($data as $key => $val)
        {
            $val = (array)$val;
            $val['parent_id'] = NULL;
            $data[$key] = $val;
        }
        return $data;    
    }
    
    
    public function translate()
    {
        $source = $this->input->post('source');
        $source = ($source == 'ua') ? 'uk' : $source;
        $target = $this->input->post('target');
        $target = ($target == 'ua') ? 'uk' : $target;
            
        $values = array(
            'key'    => 'AIzaSyCS3C4ZJrn4WYKyvGEAujwu7DPrvZCs7PY',
            'target' => $target,
            'q'      => nl2br($this->input->post('text'))
        );
 
        if (strlen($source) > 0) {
            $values['source'] = $source;
        }
 
        $formData = http_build_query($values);
        $ch = curl_init('https://www.googleapis.com/language/translate/v2');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: GET'));
        $json = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($json, true);
        
        if (!is_array($data) || !array_key_exists('data', $data))
            die('Unable to find data key');
 
        if (!array_key_exists('translations', $data['data']))
            die('Unable to find translations key');
 
        if (!is_array($data['data']['translations']))
            die('Expected array for translations');
 
        $result = "";
        foreach ($data['data']['translations'] as $translation) {
            $result .= $translation['translatedText'];
        }
        $result = str_replace('&#39;', "'", $result);
        $result = str_replace('&quot;', "\"", $result);
            
        echo str_replace(' <br />', "\n", str_replace('<br /> ', "\n", $result));
    }
    
    private function get_streets($id)
    {
        $rows = array();  
        $data = Database::instance()
            ->select("DISTINCT title_ua AS title")
            ->from("streets")
            ->where("title_ua <> ''")
            ->where("city = '$id'")
            ->orderby("CAST(title_ua AS CHAR CHARACTER SET cp1251)")
            ->get();

        foreach ($data as $row)  
            $rows[] = array('id' => $row->title, 'name' => $row->title);
            
        return $rows;
    }
    
    private function get_buildings($id)
    {
        $rows = array();  
        $data = Database::instance()
            ->select("title")
            ->from('buildings')
            ->where("street_ua = '".$id."'")
            //->where("city = '".$city."'")
            ->orderby('CAST(title AS SIGNED)')
            ->orderby('title')
            ->get();

        foreach ($data as $row)  
            $rows[] = array('id' => $row->title, 'name' => $row->title);
            
        return $rows;
    }
        
    public function location()
    {
         if ($this->input->post('street') && $this->input->post('building')){  
             $street = $this->input->post('street');
             $building = $this->input->post('building');
             /*
             $result = array(  
                 'street' => $location->get_sublocations($countryId),  
                 'building' => $location->get_sublocations($regionId)  
             );
             */  
             $result = array(  
                 'street' => $this->get_streets($this->input->post('city')),  
                 'building' => $this->get_buildings($this->input->post('street'))
             ); 
             echo json_encode(array('rows' => $result));  
         } else {  
             $id = $this->input->post('parentId', '0');
             if ($id === '0') {
                 $rows = array();
                 foreach ($this->cities as $key => $val)
                    $rows[] = array('id' => $key, 'name' => $val);
                    
                 echo json_encode(array('rows' => $rows));

             } else if (array_key_exists($id, $this->cities)) {
  

                 echo json_encode(array('rows' => $this->get_streets($id)));
             } else {
  

                 echo json_encode(array('rows' => $this->get_buildings($id)));
             }
         }
    }    

    
    	
} // End List
