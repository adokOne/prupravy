<?php 
class Page_Model extends ORM{

	public function title(){
		$str = "title_".Router::$current_language;
		return $this->$str;
	}

	public function desc(){
		$str = "desc_".Router::$current_language;
		return $this->$str;
	}


	public function keyw(){
		$str = "keyw_".Router::$current_language;
		return $this->$str;
	}
	
}