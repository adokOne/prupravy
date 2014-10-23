<?php

class Messages_Controller extends Controller {
	

	
	
	
	
	public function delete($id){
		
		if(!request::is_ajax()){
			url::redirect("/");
			die;
		}
		elseif(!$this->logged_in){
			$json    = array( "status" => false);
		}
		else{
			$type = explode("/", request::referrer());
			$type = $type[(count($type)-1)] == "output" ? "sender_delete"  : "recepient_delete" ;
			$message = ORM::factory("message",(int)$id);
			$message->$type = 1;
			#var_dump($message);die;
			$message->save();
			#$message->delete();
			$json    = array( "status" => true);
		}
		echo json_encode($json);     
	}
	
		
		
		
	public function ad_to_spam($id){
		
		if(!request::is_ajax()){
			url::redirect("/");
			die;
		}
		
		elseif(!$this->logged_in){
			$json    = array( "status" => false);
		}
		
		else{
			
			$message = ORM::factory("message",((int)$id - 1));
			$spam    = ORM::factory("spam")->where("user_id",$message->user_id)->find();
			if(!$spam->count_all())
				$spam->user_id = $message->user_id;
			$spam->spam_count ++;
			$spam->save();
			$json    = array( "status" => true);
		}
		echo json_encode($json);     
	}
		
		
		
	public function answer(){
		if(!request::is_ajax()){
			url::redirect("/");
			die;
		}
		elseif(!$this->logged_in){
			
			$json   		= array( "status" => false);
			$view = new View('alert_message');
		    $view->text = Kohana::lang("cabinet.message_not_send");
		}
		else{
			
			$message            = ORM::factory("message");
			$message->user_id   = $this->user->id;
			$message->date      = date("Y-m-d H:i:s");
			$message->theme     = $this->input->post("theme");
			$message->text      = strip_tags(mysql_real_escape_string($this->input->post("text")));
			$message->user_id_2 = (int)$this->input->post("user_id");
			$message->save();
		    $view = new View('alert_message');
		    $view->text = Kohana::lang("cabinet.message_send");
		    $json = array("status"=>true, "html" => $view->render(false));
		}
			
		echo json_encode($json);
		
	}	
	
	public function get_message_form($id){
		if(!request::is_ajax()){
			url::redirect("/");
			die;
		}
		
		elseif(!$this->logged_in){
			$json   		= array( "status" => false);
		}
		else{
			$message         = ORM::factory("message",$id);
			$view            = new View('message_form');
			$view->id        = (int)$id;
			$view->recepient = $message->user_id;
			$view->theme     = $message->theme;
			$view->t_present = true;
			$view->lang      = Kohana::lang("cabinet");	
		}
			
		echo json_encode(array("status"=>true, "html" => $view->render(false)));
		
		
		
	}
	
	
	public function get_message_form_2($id){
		if(!request::is_ajax()){
			url::redirect("/");
			die;
		}
		
		elseif(!$this->logged_in){
			$json   		= array( "status" => false);
		}
		else{
			$message         = ORM::factory("message",$id);
			$view            = new View('message_form');
			$view->id        = (int)$id;
			$view->recepient = (int)$id;
			$view->theme     = $this->input->post("theme","",true);
			$view->t_present = $this->input->post("t_present",false,true);
			$view->lang      = Kohana::lang("cabinet");	
		}
			
		echo json_encode(array("status"=>true, "html" => $view->render(false)));
		
		
		
	}
	
	
	
	
	public function view_message($id){
		if(!request::is_ajax()){
			url::redirect("/");
			die;
		}
		
		elseif(!$this->logged_in){
			$json   		= array( "status" => false);
		}
		else{
			$message         = ORM::factory("message",$id);
			$view            = new View('message_read_form');
			$view->message   = $message;
			$view->lang      = Kohana::lang("cabinet");	
		}
			
		echo json_encode(array("status"=>true, "html" => $view->render(false)));
	}
	
	
	

	
}