<?php

class Controller extends Controller_Core {
	
	public    $logged_in = false;
	public    $user = null;
	protected $title = null;
	private $s_db;
	
	public function __construct(){
		$this->_set_user();
		$this->_prepare_layout();
		$this->db = Database::instance();
		$this->lang_id = 0;
		$this->_set_meta();

		parent::__construct();
	}

	
	
	private function _prepare_layout(){
		stylesheet::add(array(
			'reset',
			'style',
			'jquery_ui'
			)
		);

		javascript::add(array(
				'jquery',
				'jqueryui',
				'cufon/cufon-yui',
				'cufon/cufon-settings',
				'cufon/OfficinaSansC_700.font',
				'custom'

			)
		);

		View::set_global('langs_ids',Kohana::config('locale.lang_ids'));
		
		#javascript::add(array('translations_' . Kohana::$lang_code )); 
		
	
	}
	private function _set_user(){
		if( $this->logged_in = Auth::instance()->logged_in() ) {
			$this->user = Auth::instance()->get_user();
			View::set_global('user',$this->user);
		}
	
		View::set_global('logged_in', $this->logged_in);
	}
	
	protected  function _set_meta($name = false,$desc=false,$keywords=false){
		if(!$name){
			$title = Kohana::config('core.sitename');
		} else {
			$title = $name ;
		}
		if(!$desc){
			$meta_desc = Kohana::config('core.meta_desc');
		} else {
			$meta_desc = $desc ;
		}
		if(!$keywords){
			$meta_keywords = Kohana::config('core.meta_keywords');
		} else {
			$meta_keywords = $keywords ;
		}

		View::set_global('title', $title);	
		View::set_global('meta_desc', $meta_desc);
		View::set_global('meta_keywords', $meta_keywords);
	}
	
	
	
	

}