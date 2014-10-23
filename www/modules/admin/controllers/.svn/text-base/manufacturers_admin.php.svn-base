<?php defined('SYSPATH') or die('No direct script access.');

class Manufacturers_Admin extends Constructor
{
    protected $item_table   = 'manufacturers';
    protected $orderby      = 'id';
    protected $order_dir    = 'DESC';
    protected $use_tree     = FALSE;
    protected $use_form     = TRUE;
    protected $use_combo    = FALSE;
    protected $use_logo     = TRUE;
    protected $multi_lang   = FALSE;
    protected $logo_path = 'upload/manufacturers/';
    protected $logo_ext = '.jpg';
    protected $logo_prefix = '/pic_320';
	
   
    protected $grid_columns = array(
        "id",
    	"status",
    	"name",
    	"has_logo",
    	"(SELECT COUNT(id) FROM planes WHERE manufacturer_id = daddy.id) AS planes_count"
        
    );
	
	public function manufacturers_list() {
		Database_Core::instance()
						->select("id", "name")
						->from("manufacturers");
		
    	$result = grid::get(FALSE,"ASC");   
    	echo $result; 
    }
	
	public function save(){
		$manufacturer_id = $this->input->post('manufacturer');
		
		if( ( ((int)$manufacturer_id) > 0 ) AND ( $manufacturer_id != $_POST['id'] ) ){
			$this->db->update( 'plane_modifications', array( 'manufacturer_id' => $manufacturer_id ), array( 'manufacturer_id' => $_POST['id'] ) );
			$this->db->update( 'plane_types',         array( 'manufacturer_id' => $manufacturer_id ), array( 'manufacturer_id' => $_POST['id'] ) );
			$this->db->update( 'planes',              array( 'manufacturer_id' => $manufacturer_id ), array( 'manufacturer_id' => $_POST['id'] ) );
			$this->db->delete( 'manufacturers', 	  array( 'id'   	       => $_POST['id'] ) );
			
			$result = Database::instance()
						->from('manufacturers')
						->select('id', 'name', 'status', 'has_logo')
						->where( array( 'id' => $manufacturer_id ) )
						->get();
			$result = $result[0];
			
			$_POST['id'] 	   = $result->id;
			$_POST['name']     = $result->name;
			$_POST['status']   = $result->status;
			$_POST['has_logo'] = $result->has_logo;
		}
		
		parent::save();
	}
}