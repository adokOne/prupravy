<?php defined('SYSPATH') or die('No direct script access.');

class Comments_Admin extends Constructor
{
	protected $item_table   = 'comments';
	protected $orderby      = 'id';
	protected $order_dir    = 'ASC';
	protected $multi_lang   = FALSE;
	protected $use_form     = TRUE;
	protected $use_map      = FALSE;

	protected $grid_columns = array(
			"id",
	        "active",
	        "item_type",
	    	'(SELECT username FROM users WHERE id = daddy.user_id) AS user',
	    	'item_id',
			"(SELECT CONCAT(item_type,'/',item_id)) AS link",
			"text",
			"date"
	);

}

