<?php
/**
 * Модуль управления статическими страницами
 * 
 * @author Vitaliy Zavadovskyy
 */
class Pages_Admin extends Controller {
	
	/**
	 * Страница управления статическими страницами
	 */
	public function index(){
		$view = new View('page_admin');
		$view->lang = Kohana::lang('page_admin');
		$view->render(true);
	}
	
	/**
	 * Возвращает список всех страниц (в JSON формате), 
	 * отсортированых по заданым параметрам и разбивкой на страницы
	 * @return JSON
	 */
	public function pages_list(){
		$page = ORM::factory('page');
		$limit 		 = (int) $this->input->post('limit', 25 ,true); 
        $start 		 = (int) $this->input->post('start', 0  ,true);
		$query		 = $this->input->post('query',''   ,true);
        $direction   = $this->input->post('dir',  'asc',true);
		$ordercolumn = $this->input->post('sort', 'pg_id' ,true);		
		
		$pages = $page->sorting( array( $ordercolumn=>$direction ) );
		
		if($query){
			$pages->orlike( array('pg_title' => $query) );
		}
		
		$data = $pages->find_all($limit, $start);

		$pages = array();
		foreach ($data as $row){
			$pages[] = $row->as_array();
		}
		
		
		echo  json_encode(array('pages'=> $pages,
							    'totalCount'=> Database::instance()->count_last_query() )) ;
	}
	
	/**
	 * Достаем страницу новостей из БД для редактирования
	 * @return JSON
	 */
	public function edit(){
		$id = (int) $this->input->post('id', null ,true);
		if(!$id){
			return print ( $this->_jsonResponse(false) );
		}
		
		$page = ORM::factory('page');
		echo json_encode( array( $page->orderby('pg_id')->find(array('pg_id' => $id))->as_array()) );
	}
	
	/**
	 * Запись отредактированой или новой страницы в БД
	 * @return JSON
	 */
	public function save(){
		$id = (int) $this->input->post('pg_id', null ,true);
		
		
		$page = ORM::factory('page', $id);
		$page->pg_text = $this->input->post('pg_text', null ,true); 
		$page->pg_title = $this->input->post('pg_title', null ,true);	
		$page->pg_seo_name = $this->input->post('pg_seo_name', null ,true);
		$page->pg_date = time();
		
		$page->save();
		
		 echo  $this->_jsonResponse(true);
	}
	
	/**
	 * Удалить страницу из БД
	 * @return JSON
	 */
	public function delete(){
		$ids = $this->input->post('delete', null ,true);
		if(!$ids){
			return print ( $this->_jsonResponse(false) );
		}
        $nodes = json_decode($ids, TRUE);
        $foter=ORM::factory('page')->where('pg_seo_name','footer')->find();
        if($nodes[0]!=$foter->pg_id){
        	$page = ORM::factory('page')->delete_all($nodes[0]);
        	echo  $this->_jsonResponse(true);
        }
        else
       		return print ( $this->_jsonResponse(false) );
	}
	
	/**
	 * Формирует JSON ответ для отправки статуса выполнения в формате
	 * необходимом для понимания в Ext.js
	 * 
	 * @param $success bool статус выполнения true/false
	 * @param $message sring информация об ошибке
	 * @return JSON
	 */
	public function _jsonResponse($success, $message='ok') {
        if ($success) $success = 'true';else $success = 'false';
        return '{"success": '.$success.', "msg": "'.$message.'"}';
    }
}