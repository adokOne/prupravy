<?php defined('SYSPATH') or die('No direct script access.');

class Rules_Admin extends Constructor
{
	protected $item_table   = 'rules';
	protected $orderby      = 'id';
	protected $order_dir    = 'ASC';
	protected $multi_lang   = TRUE;
	protected $use_form     = False;
	protected $use_map      = FALSE;

	protected $grid_columns = array(
			"id",
	        "status",
			"(SELECT title FROM rules_langs WHERE id_lang=0 AND rules_id = daddy.id) AS name"
	);

	protected $lang_field = array(
			'title',
			'text'
	);


	public function edit_page(){
		$id  = $this->input->post('id');
		$this->index(true);
		$dat = implode(",",$this->grid_columns);
		$data = $this->db->query("SELECT ".$dat." FROM ".$this->item_table." AS daddy WHERE id=".$id);
		foreach ($data as $k=>$v)
			foreach ($v as $key=>$value)
			$n->$key=$value;

		echo json_encode(array($n));
	}

	public function index($type=false){
		$fileds = "";
		foreach ($this->langs as $k=>$v)
			foreach ($this->lang_field as $f)
			$fileds .= '"'.$f.'_'.$k.'",';
		$fileds .= '"id",';
		$fileds .= '"status"';
		if(!$type)
			parent::index();
		$this->view->fileds = $fileds;

	}
	 
}

