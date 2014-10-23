<?php 
class Product_Model extends ORM{

	public function name(){
		$str = "name_".Router::$current_language;
		return $this->$str;
	}

	public function desc(){
		$str = "descr_".Router::$current_language;
		return $this->$str;
	}


	public function consist(){
		$str = "consist_".Router::$current_language;
		return $this->$str;
	}


}