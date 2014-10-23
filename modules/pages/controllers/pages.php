<?php 
class Pages_Controller extends Controller {


	 public function index($seo = false){
	 	$seo  = (string)mysql_escape_string($seo);
	 	$page = ORM::factory('page')->where("seo_name",$seo)->find();
	 	if(is_null($page->title))
	 		Kohana::show_404();
	 	$view = new View('page');
	 	$view->page = $page;
	 	$view->render(true);
	 }




	 public function contacts(){
	 	javascript::add(array(
	 		'controllers/form',
	 		'controllers/contacts'
	 		)
	 	);
	 	$view = new View('contacts');	
	 	$view->render(true);
	 }


	 public function about(){
	 	javascript::add(array(
	 		'controllers/about'
	 		)
	 	);
	 	$view = new View('about');	
	 	$view->members   = $this->get_memebers();
	 	$view->president = $this->get_president();
	 	$view->render(true);
	 }



	 public function problem($id){
	 	if(!is_numeric($id))
	 		Kohana::show_404();
		$problem = ORM::factory("problem")->find((int)$id);
		if(is_null($problem->description))
			Kohana::show_404();
	 	/*javascript::add(array(
	 		'controllers/problems'
	 		)
	 	);*/

	 	$view = new View('problem_show');
	 	$view->problem = $problem;
	 	$view->render(true);
	 }




	 public function send(){
	 	$db_post = ORM::factory("contact");
		$post = Validation::factory($_POST)
				->pre_filter('trim', TRUE)
				->add_rules('name', 'required','length[4,127]')
				->add_rules('email', 'required', 'valid::email')
                ->add_rules('phone','required','length[5,13]','valid::numeric')
				->add_rules('text','required','length[5,1000]','valid::standard_text');
		if($post->validate()){
			$db_post->name       = $post->name;
			$db_post->email      = $post->email;
			$db_post->phone      = $post->phone;
			$db_post->text       = $post->text;
			$db_post->created_at = date("Y-m-d H:i:s");
			$db_post->save();
			echo json_encode(array("success" => true ,"msg"=>Kohana::lang("main.contacts_success")));
		}

		else
			echo json_encode(array("success" => false ,"msg"=>Kohana::lang("main.contacts_failure"))) ;
	 }
	 	 
	private function get_memebers(){
		return ORM::factory("role",2)->where("show_on_main",1)->users;
	}
	private function get_president(){
		return ORM::factory("role",2)->where("id",10)->users->current();
	}


}