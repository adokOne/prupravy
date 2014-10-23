<?php 
class District_Model extends ORM{
	protected $belongs_to = array('city');
	protected $has_many = array('problems');
	
}