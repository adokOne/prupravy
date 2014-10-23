<?php defined('SYSPATH') or die('No direct script access.');

class Planes_Admin extends Constructor
{
    protected $item_table   = 'planes';
    protected $orderby      = 'id';
    protected $order_dir    = 'DESC';
    protected $use_tree     = FALSE;
    protected $use_form     = FALSE;
    protected $use_combo    = FALSE;
    protected $use_logo     = FALSE;
    protected $multi_lang   = FALSE;
	
   
    protected $grid_columns = array(
        "id",
    	"name",
    	"status",
    	"plane_type_id",
    	"manufacturer_id",
    	"plane_modification_id",
    );   
    
    
    public function types_list(){
    	$this->db->select('id','name','manufacturer_id')
    			->from('plane_types');
    	if($id = $this->input->post('id'))
    		$this->db->where('manufacturer_id',$id);
    	echo grid::get();
    }
    
    public function remove_types(){
    	
    	$data = json_decode($_POST['delete']);
    	
    	foreach($data[0] as $v){
    		$this->db->delete('plane_types',array('id'=>$v));
    		
    	}
    	$this->types_list();
    }
    
    public function save_types(){
    	$data = json_decode($_POST['save']);
    	foreach($data as $obj){
    		if(isset($obj->id)){
    			$this->db->update('plane_types',array('manufacturer_id'=>$obj->manufacturer_id,'name'=>$obj->name),array('id'=>$obj->id));
    			var_dump($this->db->last_query());
    		}
    		else{
    			$this->db->insert('plane_types',array('manufacturer_id'=>$obj->manufacturer_id,'name'=>$obj->name));
    		}
    	}
    	$this->types_list();
    }

    public function remove_mods(){
    	 
    	$data = json_decode($_POST['delete']);
    	 
    	foreach($data[0] as $v){
    		$this->db->delete('plane_modifications',array('id'=>$v));
    
    	}
    	$this->types_list();
    }
    
    public function save_mods(){
    	$data = json_decode($_POST['save']);
    	foreach($data as $obj){
    		if(isset($obj->id)){
    			$this->db->update('plane_modifications',array('manufacturer_id'=>$obj->manufacturer_id,'plane_type_id'=>$obj->plane_type_id,'name'=>$obj->name),array('id'=>$obj->id));
    			var_dump($this->db->last_query());
    		}
    		else{
    			$this->db->insert('plane_modifications',array('manufacturer_id'=>$obj->manufacturer_id,'plane_type_id'=>$obj->plane_type_id,'name'=>$obj->name));
    		}
    	}
    	$this->types_list();
    }  
    
	public function relink_mods(){
		$data = json_decode($_POST['relink']);
    	foreach($data as $obj){
    		if(isset($obj->id)){
				if( $obj->id != $obj->relink_to_id ){
					$this->db->update( 'planes', array( 'plane_modification_id' => $obj->relink_to_id ), array( 'plane_modification_id' => $obj->id ) );
					$this->db->delete( 'plane_modifications', array( 'id' => $obj->id ) );
				}
    		}
    	}
    	$this->types_list();
	}
	
	public function relink_types(){
		$data = json_decode($_POST['relink']);
    	foreach($data as $obj){
    		if(isset($obj->id)){
				if( $obj->id != $obj->relink_to_id ){
					$this->db->update( 'planes',              array( 'plane_type_id' => $obj->relink_to_id ), array( 'plane_type_id' => $obj->id ) );
					$this->db->update( 'plane_modifications', array( 'plane_type_id' => $obj->relink_to_id ), array( 'plane_type_id' => $obj->id ) );
					$this->db->delete( 'plane_types', array( 'id' => $obj->id ) );
				}
    		}
    	}
    	$this->types_list();
	}
    
    public function mod_list(){
    	
    	$this->db->select('id','name','plane_type_id','manufacturer_id')
    	->from('plane_modifications');
    	if($id = $this->input->post('id'))
    		$this->db->where('plane_type_id',$id);
    	echo grid::get();
    }
    
	
	public function mod_list_fullname(){
		Database_Core::instance()
								->select("plane_modifications.id as id",
										 "CONCAT(manufacturers.name, ' | ', plane_types.name, ' | ', plane_modifications.name) AS name")
								->from("plane_modifications")
								->join("plane_types",   'plane_types.id',  'plane_modifications.plane_type_id')
								->join("manufacturers", 'manufacturers.id','plane_modifications.manufacturer_id');
								
		$result = grid::get(FALSE,"ASC");
		echo $result;
    }
	
	public function types_list_fullname(){
		Database_Core::instance()
								->select("plane_types.id as id",
										 "CONCAT(manufacturers.name, ' | ', plane_types.name) AS name")
								->from("plane_types")
								->join("manufacturers", 'manufacturers.id', 'plane_types.manufacturer_id');
								
		$result = grid::get(FALSE,"ASC");
		echo $result;
    }
}