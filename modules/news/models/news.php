<?php 
class News_Model extends ORM{
	#protected $has_one  = array('user');	
	protected $has_many = array('news_langs');
}