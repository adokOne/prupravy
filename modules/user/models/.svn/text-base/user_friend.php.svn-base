<?php 
class User_Friend_Model extends ORM{
	protected $has_one = array('user');
	
	public $_user;
	
	public function __construct($id=false){
		parent::__construct($id);
		
		$this->_user = new User_Model($this->friend_id);#ORM::factory("user",$this->friend_id)->find();

		
	}
	

	
	public function get_user(){
		
		return $this->_user;
	}
	
	
	
}
?>