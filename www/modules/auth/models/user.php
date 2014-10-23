<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_Model extends Auth_User_Model {
	
	// This class can be replaced or extended
	protected $has_many = array('pictures','messages','posts',"user_friends");
	protected $has_and_belongs_to_many = array('roles');
	protected $sorting = array();

	
	public function getAge(){
		$this->age = self::modifier_getAge($this->birthday); 	
	}
	
	/**
	 * 
	 * @param $birthday
	 * @return unknown_type
	 */
	static public function modifier_getAge($birthday){
		
		$dob = date("Y-m-d",$birthday);
    	$ageparts = explode("-",$dob);
    	$age = date("Y-m-d")-$dob;
	
		return (date("nd") < $ageparts[1].str_pad($ageparts[2],2,'0',STR_PAD_LEFT)) ? $age-=1 : $age;
	}
	
	
	public function sorting($sortby = array()){
		
		$this->sorting = $sortby;
		
		return $this;
		
	}
	
	
	public function update($data){
		$this->has_logo  = empty($data["image_name"]) ? 0 : 1;
		foreach ($data as $k=>$v){
			if(isset($this->table_columns[$k])){
				$this->$k = $v;
			}
				
		}
		$this->save();
		return $this;
	}
	
	
	public function count_new_messages($data){
		$c = 0;
		foreach($data as $item){
			if(strtotime($item->date) > $this->cabinet_visit)
				$c++;
			
		}
		
		return $c;
	} 
	
	
	
	/**
	 * Видалення користувача
	 *
	 * @param integer $user_id - ID учетной записи пользователя
	 */
	public function delete_user($user_id){
		
		//Database::instance()->_reset_select();		

		// will be autodeleted by database (cascade delete)
		//Удаление связаных ролей пользователей
		//Database::instance()->delete('roles_users', array('user_id'=> $user_id));		
	
		
		//Удаление учетной записи пользователя
		$user = ORM::factory('user',$user_id);
		$user->delete();				
		
		return true;		
		
	}
	/**
	 * Check if user exists in blacklist
	 * @param string $username
	 * @param string $email
	 * @param string $ip
	 * @return bool
	 */
	public static function _blacklist_check($username = null, $email = null, $ip=null){
		
		$where_options = array();
		
		if($username)
			$where_options[] = "(LOWER('$username') LIKE REPLACE( LOWER(block_string), '*', '%') AND TYPE='login')";

		if($email)
			$where_options[] = "(LOWER('$email') LIKE CONCAT('%',LOWER(block_string),'%') AND TYPE='email')";
		
		if($ip)
			$where_options[] = "(".ip2long($ip)." BETWEEN ip_start AND ip_end AND TYPE='ip')"; 
			
		if(!count($where_options))
			return false;

		$blockQuery = "SELECT COUNT(1) cnt
					   FROM blacklists
					   WHERE active=1 AND ( " . implode(" OR ", $where_options) . " ) ";

		if( Database::instance()->query($blockQuery)->current()->cnt > 0 )
			return true;
		
		return false;
	} 
	
} // End User Model