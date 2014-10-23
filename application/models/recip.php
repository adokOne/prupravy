<?php 
class Recip_Model extends ORM{

	public function name(){
		$str = "name_".Router::$current_language;
		return $this->$str;
	}

	public function prepare(){
		$str = "prepare_".Router::$current_language;
		return $this->$str;
	}


	public function consist(){
		$str = "consist_".Router::$current_language;
		return $this->$str;
	}
	
}