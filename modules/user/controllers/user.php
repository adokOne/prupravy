<?php

class User_Controller extends Controller {
	
	
	public function __construct(){
		parent::__construct();
		$this->session = Session::instance();
		if($this->logged_in){
			$messages = ORM::factory("message")->where(array("user_id_2"=>$this->user->id))->find_all();
			View::set_global("new_m",$this->user->count_new_messages($messages));
		}
	}
	
	
	
	
	public function profile(){
		
		if(!$this->logged_in)
			url::redirect("/");
			
        javascript::add(array(
        
        	'controllers/register_controller',
        	'controllers/user_cabinet_controller',
        	'fileuploader.min'
        	)
        );
        stylesheet::add(array(
        	'uploadify'
        	)
        );
			
			
		$view = new View('cabinet');
		$view->lang = Kohana::lang("login");
		$view->render(true);
		
	}
	
		
	
	public function messages($type="input"){

		
		if(!$this->logged_in)
			url::redirect("/");
			
        javascript::add(array(
        	'controllers/user_messages_controller',
        	)
        );
        
        $user_type = "user_id_2";
        $delete    = "recepient_delete";
        if($type === "output"){
        	$user_type = "user_id";
        	$delete    = "sender_delete";
        }
        
        
        
        
        
        
        $this->user->cabinet_visit = time();
		$this->user->save();
		$messages = ORM::factory("message")->where(array($delete=>0,$user_type=>$this->user->id))->orderby("date","desc")->find_all();
		$view           = new View('cabinet_messages');
		$view->lang     = Kohana::lang("cabinet");
		$view->messages = $messages;
		$view->pagination = $this->_set_pagination();
		$view->render(true);
		
		
	}
	
	
	
	public function friends(){
		if(!$this->logged_in)
			url::redirect("/");
			
        javascript::add(array(
        	'controllers/user_friends_controller',
        	)
        );	
			
			
		$view = new View('friends');
		$view->render(true);
	}
	
	
	public function delete_friend($id){
		if(!request::is_ajax()){
			url::redirect("/");
			die;
		}
		
		elseif(!$this->logged_in){
			$json = array( "status" => false);
		}
		else{
			$friend = ORM::factory("user_friend")->where(array("friend_id"=>(int)$id,"user_id"=>$this->user->id))->find();
			$friend->delete();
			$json = array( "status" => true);
		}
		echo json_encode($json);
	}
	
	
	
	public function upload_avatar(){

		$extensions = array("jpeg", "png", "gif" , "jpg");
		$uploader   = new Uploader($extensions);
		$result     = $uploader->handleUpload(DOCROOT.'/upload/tmp');

		
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		
	}

	
	public function register(){
		
		if($this->logged_in){
			url::redirect("/user/profile/", 301);
			exit;
		}
        javascript::add(array(
        	'controllers/register_controller',
        	'fileuploader.min'
        	)
        );
        stylesheet::add(array(
        	'uploadify'
        	)
        );
		$token = text::random($type = 'alnum', $length = 20); 
		$this->session->set('token', $token);
		
		$view        = new View('register_form');
        $view->lang  = Kohana::lang('login');
        $view->token = $token;
		$view->render(true);
	}

	public function get_login_form(){
			$view = new View('login_form');
			echo json_encode(array("status"=>true,"html"=>$view->render(false)));
	}
	
	public function create_user(){
		
		$data = $this->input->post();
		$data = (object)$data;
        $token_check = false;
		if(isset($data->token) && $data->token == $this->session->get('token') ){
			$token_check = true;					      
		}

		$post = Validation::factory($_POST)
				->pre_filter('trim', TRUE)
				->add_rules('username', 'required','length[3,127]')
				->add_rules('email', 'required', 'valid::email')
                ->add_rules('password','required','length[5,127]','matches[password_confirm]')
				->add_rules('password_confirm','required','length[5,127]','matches[password]');
		
		$post->add_callbacks('email', array($this, '_unique_email'));

		if(!$post->validate() || !$token_check){
			$form = $post->as_array();
			echo "error";die;
			/*if(!request::is_ajax()){
				echo json_encode(array('success'=>false, 'errors'=>"wefwe" ));
				return;
			}*/
		}else{
			$user = ORM::factory('user');
			$user->username   = $data->username;
			$user->email      = mysql_real_escape_string($data->email);
			$user->about      = mysql_real_escape_string($data->about);
			$user->name       = mysql_real_escape_string($data->username);
			$user->nick       = mysql_real_escape_string($data->nick);
			$user->created_at = date("Y-m-d",time());
			$user->has_logo   = empty($data->image_name) ? 0 : 1;
			$user->password   = $data->password;//Auth::instance()->hash_password($data->password);
			$user->add(ORM::factory('role', 'login'));
			$user->cabinet_visit = time();
			$user->save();
			Auth::instance()->force_login($user);
			$this->_send_register_email($data->password,$user);
			$this->user = $user;
			if($user->has_logo){
				$this->save_image();
			}
			url::redirect('/' ,301);

		}

		
		
		
				
	}
	
	public function forgot_pass(){
			$post = Validation::factory($_POST)->pre_filter('trim', TRUE)
				->add_rules('email', 'required', 'length[5,45]')
				->add_callbacks('email', array($this, '_unique_email'));
		    if(!$post->validate()){
		    	$view = new View('alert_message');
		    	$view->text = Kohana::lang("login.pass_rec_true");
		    	echo json_encode(array("status"=>true,"html"=>$view->render(false)));
		    	$new_pass = substr(md5(rand()), 0, 8);
		    	$this->_change_pass($_POST['email'],$new_pass);
		    	
		    }
		    else 
		    	echo json_encode(array("status"=>false,"text"=>Kohana::lang('login.email_fail')));
	}
	public function password_recovery(){
			$view = new View('forgot_pass');
			echo json_encode(array("status"=>true,"html"=>$view->render(false)));
	
	}
	
	
	public function password_update(){
		if(!request::is_ajax()){
			url::redirect('/' ,301);
			die;
		}
		elseif (!$this->logged_in){
			echo json_encode(array("status"=>true,"text"=>Kohana::lang("login.error_pwd_cng")));
		}
		else{
			echo json_encode(array("status"=>true,"text"=>Kohana::lang("login.suces_pwd_cng")));
			$this->_change_pass($this->user->email,$this->input->post("password"),false);
		}
	}
	
	
	public function update(){
		if(!request::is_ajax()){
			url::redirect('/' ,301);
			die;
		}
		elseif (!$this->logged_in){
			echo json_encode(array("status"=>true,"text"=>Kohana::lang("login.error_inf_cng")));
		}
		else{
			$this->user->update($this->input->post());
			if($this->user->has_logo)
				$this->save_image();
			
			echo json_encode(array("status"=>true,"text"=>Kohana::lang("login.suces_inf_cng")));
			
		}
	}
	
	
	
	public function login(){
		if($this->logged_in){
			url::redirect('/' ,301);
		}
		else{
			$post = Validation::factory($_POST)->pre_filter('trim', TRUE)
				->add_rules('email', 'required', 'length[4,45]')
				->add_rules('pass', 'required', 'length[5,45]')
				->add_callbacks('email', array($this, 'loginCheck'));
			if(!$post->validate())	
				echo json_encode(array("status"=>false,"text"=>Kohana::lang('login.default_error')));
			else{
				$this->user->last_login = time();
				echo json_encode(array("status"=>true));
			}
		}
	}
	
	public function logout(){
		Auth::instance()->logout(true);
		url::redirect("/",301);
	}
	
	public function save_image(){
		$file = DOCROOT.'/upload/tmp/'.$this->input->post('image_name');
		MOJOUser::processAvatar($file , $this->user->id);
		
	}
	
	
	public function _unique_email(Validation $array, $field){
		
		$email_exists = (bool) ORM::factory('user')->where('email', $array[$field])->count_all();
		if($email_exists){
			$array->add_error($field, 'email_exists');
		}
	}
	
	public function loginCheck(Validation $post){
		$user = ORM::factory('user', $post->email);
				
		$ip = Input::instance()->ip_address();		
		
		if(empty($user->id)){
			
			$post->add_error('login', 'default');
		}	
		elseif ( !Auth::instance()->login($user, $post->pass, false ) ){
			
			$post->add_error('login', 'default');
		}
		
	}
	
	private function _set_pagination(){
			
			$pagination_config = array(
				"base_url"			=> "/",
				"total_items"		=>  $this->db->count_last_query(),
				"items_per_page"	=>  2,
				'style'          	=> "spotters",
				"auto_hide"         => true
			);
			
			return
				new Pagination($pagination_config);
	}
	
	
	private function _send_register_email($pass,$user){
		$email = new View('email_registration');
		$email->user = $user;
		$email->pass = $pass;
		email::send(
			$user->email,
			Kohana::config('config.site_email'),
			Kohana::config('config.sitename') . " | " . Kohana::lang('email.register_subject'),
			$email->render(false),
			TRUE
		);
	}

	private function _send_recovery_email($pass,$user){
		$email = new View('email_recovery');
		$email->user = $user;
		$email->pass = $pass;
		email::send(
			$user->email,
			Kohana::config('config.site_email'),
			Kohana::config('config.sitename') . " | " . Kohana::lang('email.recovery_subject'),
			$email->render(false),
			TRUE
		);
	}
	
	
	private function _change_pass($email,$new_pass,$send_mail = true){
		
	    $user = ORM::factory('user')->where('email',$email)->find();
		$user->password = $new_pass;
		$user->save();
		if($send_mail)
			$this->_send_recovery_email($new_pass,$user);
	}
	
}