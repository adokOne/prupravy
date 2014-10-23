<?php defined('SYSPATH') or die('No direct script access.');

class Actualtopics_Admin extends Constructor
{
	public function __construct(){
		parent::__construct();
		$this->config = Kohana::config('admin.actual_topic');
	}
	
    protected $item_table     = 'actual_topics';
    protected $orderby        = 'id';
    protected $order_dir      = 'ASC';
	protected $use_google_map = FALSE;
    protected $use_tree       = FALSE;
    protected $use_form       = TRUE;
    protected $use_combo      = FALSE;
    protected $use_logo       = FALSE;
    protected $buttons        = TRUE;
    protected $multi_lang     = FALSE;
	    
    protected $grid_columns = array(
        "id",
    	"type",
    	"item_id",
    	"(SELECT name FROM albums WHERE daddy.type='album' AND id=daddy.item_id) AS album_name",
    	"(SELECT title FROM news_langs WHERE daddy.type='news' AND news_id = daddy.item_id AND id_lang=0) AS news_name",
    	"(SELECT IF(daddy.type='photo',
    				 item_id,
    				 
    				 IF(daddy.type='video',
    					item_id,
    					
    					IF(daddy.type='album',
    					   album_name,
    					   
    					   IF(daddy.type='news',
    					      news_name,
    					      ''
    					   )
    					)
    			   	 )
    			   )
    	 ) AS item_name",
    	"status"
    );
        
    protected $lang_field = array (
    		'name'
    );
    
	public function types_list(){
		$arr = array( array('id' => '1', 'name' => 'photo'),
    				  array('id' => '2', 'name' => 'video'),
    				  array('id' => '3', 'name' => 'album'),
    				  array('id' => '4', 'name' => 'news')
					);
		$list = array( "items" => $arr,
					   "total" => count($arr)
					 );
		
		echo json_encode($list);
    }
	
    public  function item_list() {
    	$type = $this->input->post('type_id');
    	
		if($type == 1){ // 'photo'
			Database_Core::instance()
								->select("id", "id as name")
								->from("pictures")
								->limit($this->config['photo_limit']);
		}
		elseif ($type == 2){ // 'video'
			Database_Core::instance()
								->select("id", "id as name")
								->from("videos")
								->limit($this->config['video_limit']);
		}
		elseif ($type == 3){ // 'album'
			Database_Core::instance()
								->select("id", "name")
								->from("albums")
								->limit($this->config['albums_limit']);
		}
		elseif ($type == 4){ // 'news'
			Database_Core::instance()
								->select("news_id as id", "title as name")
								->from("news_langs")
								->where("id_lang", 0)
								->join("news", 'news.id','news_langs.news_id')
								->limit($this->config['news_limit']);
		}
		
    	$result = grid::get(FALSE,"ASC");   
    	echo $result; 
    }  
}
