<?php

class Main_Controller extends Controller {



	public function index() {
		#$this->load_price();
		$this->set_meta("main");
		$view = new View("main");
		$view->lang    =  Kohana::lang("main") ;
		$view->render(true);
	}
	public function collection() {
		$this->set_meta("collection");
		stylesheet::add(array("fancybox"));
		$view = new View("collection");
		$view->collection = $this->get_collection();
		$view->lang    =  Kohana::lang("main") ;
		$view->render(true);
	}
	public function recipes() {
		$this->set_meta("recipes");
		stylesheet::add(array("fancybox"));
		$view = new View("recipes");
		$view->collection = $this->get_recipes();
		$view->lang    =  Kohana::lang("main") ;
		$view->render(true);
	}

	public function partners() {
		$this->set_meta("partners");
		$view = new View("partners");
		$view->collection = $this->get_collection();
		$view->lang    =  Kohana::lang("main") ;
		$view->render(true);
	}

	public function contacts(){
		$this->set_meta("contacts");
		$view = new View("contacts");
		$view->lang    =  Kohana::lang("main") ;
		$view->render(true);
	}


	public function load_price(){
		include SYSPATH."vendor/PHPExcel.php";
		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 
    
		$rowCount = 1; 
		$objPHPExcel->getActiveSheet()->SetCellValue('A1','Назва SKU');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1','Вага');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1','Штрих-код');

		$i = 2;
		foreach($this->get_collection() as $product){
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $product->name());
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $product->weight." ".Kohana::lang("main.g"));
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $product->code);
			$i++;

		}

		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="price.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save(DOCROOT."/tmp/test1.xls");
		echo file_get_contents(__DIR__."/test1.xls");



	}


	private function set_meta($seo){
		$page = ORM::factory("page")->where("seo_name",$seo)->find();
		Router::$site_title = $page->title();
		Router::$site_description = $page->desc();
		Router::$site_keywords = $page->keyw();
	}



	public function get_product_desc($id){
		$product = ORM::factory("product")->find($id);
		$view = new View("product_box");
		$view->product = $product;
		$view->lang    =  Kohana::lang("main") ;
		echo json_encode(array("success"=>true,"html"=>$view->render()));
	}
	public function get_recept_desc($id){
		$product = ORM::factory("recip")->find($id);
		$view = new View("recept_box");
		$view->recept = $product;
		$view->lang    =  Kohana::lang("main") ;
		echo json_encode(array("success"=>true,"html"=>$view->render()));
	}



	private function get_collection(){
		return ORM::factory("product")->find_all();
	}
	private function get_recipes(){
		return ORM::factory("recip")->find_all();
	}



	
}