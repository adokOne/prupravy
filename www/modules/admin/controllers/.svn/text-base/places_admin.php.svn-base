<?php defined('SYSPATH') or die('No direct script access.');

class Places_Admin extends Constructor
{
    protected $item_table     = 'airports';
    protected $orderby        = 'id';
    protected $order_dir      = 'DESC';
	protected $use_google_map = TRUE;
    protected $use_tree       = FALSE;
    protected $use_form       = TRUE;
    protected $use_combo      = FALSE;
    protected $use_logo       = FALSE;
    protected $buttons        = TRUE;
    protected $multi_lang     = TRUE;
	
    
    protected $grid_columns = array(
        "id",
    	"IATA",
    	"ICAO",
    	"country_id",
		"city_id",
   		"latitude",
     	"longitude",
    	"(SELECT name FROM cities_langs WHERE city_id = daddy.city_id AND id_lang=0) AS city_name",
    	"(SELECT name FROM countries_langs WHERE country_id = daddy.country_id AND id_lang=0) AS county_name",
        
    );
    
	public function airports_list() {
		Database_Core::instance()
						->select("airports.id",
								 "CONCAT('ID: ', airports.id, ' | ', airports_langs.name) AS name")
						->from("airports_langs")
						->where("id_lang",0)
						->join("airports", 'airports.id','airports_langs.airport_id');
		
    	$result = grid::get(FALSE,"ASC");   
    	echo $result; 
    }
    
    protected $lang_field = array (
    		'name'
    );
    
    public  function country_list(){
		Database_Core::instance()
								->select("countries.id","name")
								->from("countries_langs")
								->where("id_lang",0)
								->join("countries", 'countries.id','countries_langs.country_id');
    	$result = grid::get(FALSE,"ASC");   
    	echo $result; 
    }
    
    public  function city_list() {
    	
		Database_Core::instance()
								->select("cities.id","name")
								->from("cities_langs")
								->where("id_lang",0)
								->join("cities", 'cities.id','cities_langs.city_id');
		if($country_id=$this->input->post('country_id'))
			Database::instance()->where("cities.country_id",$country_id);
    	$result = grid::get(FALSE,"ASC");   
    	echo $result; 
    }
    
    public function save(){
    	$airport_id = $this->input->post('airport');
		
		if( ( ((int)$airport_id) > 0 ) AND ( $airport_id != $_POST['id'] ) ){
			$this->db->update( 'posts',          array( 'airport_id' => $airport_id ), array( 'airport_id'   => $_POST['id'] ) );
			$this->db->delete( 'airports_langs', array( 'airport_id' => $_POST['id'] ) );
			$this->db->delete( 'airports',       array( 'id'   	     => $_POST['id'] ) );
			
			$result = Database::instance()
						->from('airports')
						->select('id', 'latitude', 'longitude', 'IATA', 'ICAO', 'country_id', 'city_id')
						->where( array( 'id' => $airport_id ) )
						->get();
			$result = $result[0];
			
			$name_0 = Database::instance()->from('airports_langs')->select('name')->where( array( 'airport_id' => $airport_id, 'id_lang' => 0 ) )->get();
			$name_1 = Database::instance()->from('airports_langs')->select('name')->where( array( 'airport_id' => $airport_id, 'id_lang' => 1 ) )->get();
			$name_2 = Database::instance()->from('airports_langs')->select('name')->where( array( 'airport_id' => $airport_id, 'id_lang' => 2 ) )->get();
			
			$_POST['id'] 	   	 = $result->id;
			$_POST['latitude']   = $result->latitude;
			$_POST['longitude']  = $result->longitude;
			$_POST['name_0'] 	 = $name_0[0]->name;
			$_POST['name_1'] 	 = $name_1[0]->name;
			$_POST['name_2'] 	 = $name_2[0]->name;
			$_POST['IATA'] 		 = $result->IATA;
			$_POST['ICAO'] 		 = $result->ICAO;
			$_POST['country_id'] = $result->country_id;
			$_POST['city_id'] 	 = $result->city_id;
		}
		
		parent::save();
	}
}
