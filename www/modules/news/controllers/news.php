<?php 
class News_Controller extends Controller {


	public function index($seo_name = false){
		
		if($seo_name === false)
			$this->all_news();
		else
			$this->item($seo_name);
	}


	private function all_news(){
		$news = ORM::factory("news")->find_all();
		$view = new View("news_index");
		$view->news = $news;
		$view->render(true);
	}
	private function item($seo_name){
		$seo_name = (string)mysql_escape_string($seo_name);
		$news = ORM::factory("news")->where("seo_name",$seo_name)->find();
		if(is_null($news->title))
			Kohana::show_404();
		$view = new View("news_show");
		$view->news = $news;
		$view->render(true);

	}

}