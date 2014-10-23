<?php

class MOJOUser {
	
	/**
	 * get user statistics
	 * @param int $user_id	user id
	 * @return array()
	 */
	public static function user_statistic($user_id = false){
		if( ! $user_id) return false;
		
		$cache = Cache::instance();
		$user_stats = $cache->get("user_stat_" . $user_id);	
		if( !$user_stats){
			$was = ORM::factory('event')
					->join('events_users','events_users.event_id','events.id')
					->where(array('events_users.user_id' => $user_id,
								  'events.start_date <' => time(),
									'events.status' => 1))
					->orderby(array('events.start_date' => 'desc'))
					->count_all(); 
							
			$will = ORM::factory('event')
					->join('events_users','events_users.event_id','events.id')
					->where(array('events_users.user_id'=> $user_id,
								  'events.start_date >' => time(),
									'events.status' => 1))
					->orderby(array('events.start_date' => 'asc'))
					->count_all(); 
					
			$friends = ORM::factory('friendship')->where('user_id', $user_id)->count_all();
			
			$friends_requests = ORM::factory('friendship')
								->where(array('user_id'=>$user_id,'status' => 1))
								->count_all();
								
			$events = ORM::factory('event')->where('author_id', $user_id)->count_all();
			$user_stats = array
			(
				'was' => $was,
				'will' => $will,
				'friends' => $friends,
				'friends_requests' => $friends_requests,  
				'events' => $events
			);
			
			$cache->set('user_stat_' . $user_id, $user_stats, false, Kohana::config('user.statistic_lifetime'));
		}
		
		return $user_stats;
	}
	
	public static function upload_avatar($file, $user_id){
		$tmp_dir = '/tmp/';
		$tmp_file =  uniqid();
		
		$filename = $tmp_dir.$tmp_file;
		
		move_uploaded_file($file, $filename);
		
		self::processAvatar($filename, $user_id);
		
	}
	
	public static function processAvatar($filename, $user_id,$unlink=true,$folder='upload/avatars/'){
		$sizes = Kohana::config('user.avatars');

                if (!file_exists($filename))
                    return false;
                
		$image = Image::factory($filename);
		if(!file_exists(DOCROOT .$folder. $user_id))
			mkdir(DOCROOT . $folder.$user_id);
		
		$img_size=getimagesize($filename);
		$width=$img_size[0];
		$height=$img_size[1];
					
		foreach($sizes as $size){
				if($width > $size['width'] && $height > $size['height']){
					$image->resize($size['width'],$size['height'], (($width/$height) <= 1 ) ? (Image::WIDTH) : (Image::HEIGHT) );
					$image->crop($size['width'],$size['height']);
				}else {
					$image->center_image( $size['width'],$size['height'] );
				}
			
				$image->save(DOCROOT . $folder . $user_id . "/" . $size['prefix'] . ".jpg");
		}
		if($unlink)unlink($filename);	
	}
	
	public static function get_friends($user_id = false){
		if(! $user_id ) return false;
		
		$friends = ORM::factory('friendship')
			->select("users.*")
			->join("users","users.id", "friendships.user_id", "left")
			->where(array('friendships.friend_id' => $user_id, 'friendships.status' => 2))
			->find_all();
			
		return $friends;
	}
	
	public static function get_mutual_friends_count($user_id = false){
		if(! $user_id ) return false;
		$friend_id = Auth::instance()->get_user()->id;
		$friends_count = Database::instance()->query('SELECT COUNT(id) as cnt 
							FROM friendships fr
							WHERE fr.user_id = ' . $user_id . ' AND fr.status = 2 
							AND fr.friend_id IN (SELECT friend_id 
													FROM friendships 
													WHERE user_id = ' . $friend_id . '  AND `status` = 2)')
						->current();
		
		return $friends_count->cnt;
	}
	
	public static function count_online( &$users ){
		$count = 0;
		foreach($users as $user){
			if($user->last_login > (time() - 60 * 15) ){
				$count ++;
			}
		}
		return $count;
	}
	
}