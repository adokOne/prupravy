<?php defined('SYSPATH') OR die('No direct access allowed.');

class IM_Admin extends Controller {

	
	/**
	 * Коренева директорія
	 *
	 */
	const root_folder = 'images';
	
	
    /**
     * Масив дозволених розширень для фотографій
     *
     * @var array
     */    
	protected $image_types = array(
	    'gif',
	    'jpeg',
	    'jpg',
	    'png'
	);
	
	
	/**
	 * Максимальна кількість рядків виборки при пошуку
	 *
	 */
	const count_max_search_rows = 200;
	
	
	/**
	 * Результат пошуку файлів
	 *
	 * @var array
	 */
	private $search_data = array();
	
	
	/**
	 * Директорії менеджеру зображень
	 *
	 * @var array
	 */
	private $nodes_dir = array();
	
	
	private $nodes_dir_id = 0;
	

	
	
	/**
    * Видалення папки
    */
    public function remove_folder()
    {
        $path = $this->input->post('path','',true);
        
        if($path == self::root_folder){
            echo $this->_jsonResponse(FALSE, 'Неможливо видалити кореневу папку');
            return;        	        	
        	
        }
        
        if(!is_dir(DOCROOT.$path)){
            echo $this->_jsonResponse(FALSE, 'Невірна директорія: ' . DOCROOT.$path);
            return;        	
        	
        }
        
        if (!@rmdir(DOCROOT.$path))
        {
            echo $this->_jsonResponse(FALSE, 'Папка не пуста або відсутні права на видалення...');
            return;
        }
        echo $this->_jsonResponse(true);
    }

    /**
    * Створення папки
    */     
    public function add_folder()
    {
        $name = $this->input->post('name');
        $path = $this->input->post('path');
        echo $this->_jsonResponse(mkdir(DOCROOT.$path.'/'.$name));
    }
    
    /**
     * Перейменування папки
     *
     */
    public function rename_folder(){
        $name = $this->input->post('name');
        $path = $this->input->post('path');    	
    	     
        
        if($path == self::root_folder){
            echo $this->_jsonResponse(FALSE, 'Неможливо перейменувати кореневу папку');
            return;        	        	
        	
        }        
           
        if(empty($name)){
        	 echo $this->_jsonResponse(false, 'Незадана нова папка');
        	 return;
        	
        }        
        
        
        $newDir = str_replace('/'.basename($path), '/'.$name, $path);
        if(is_dir(DOCROOT . $newDir)){
        	 echo $this->_jsonResponse(false, 'Папка ' . $newDir . ' вже існує');
        	 return;
        	
        }
        
        if(!rename(DOCROOT . $path, DOCROOT . $newDir)){
        	 echo $this->_jsonResponse(false, 'Помилка перейменування');
        	 return;        	
        	
        }
        
        echo $this->_jsonResponse(true);
        
    	
    }
    
    
    /**
    * Видалення фотографій
    */ 
    public function remove_items()
    {

        $path = $this->input->post('path');
        $images = json_decode($this->input->post('delete'));

        foreach ($images[0] as $image) {
            if(file_exists($path.'/'.$image)) {
                @unlink($path.'/'.$image);
            }
        }
        echo $this->_jsonResponse(TRUE);
    }
    
    
    
    /**
     * Перейменування файлу зображення
     *
     */
    public function rename_image(){
    	
    	 $newname = $this->input->post('newname');
    	 $oldname = $this->input->post('oldname');
    	 $path = $this->input->post('path');
    	
    	 $ext = utf8::strtolower(utf8::substr($newname,utf8::strrpos($newname, ".")+1));    	 
         if (!in_array($ext, $this->image_types)) {
            echo $this->_jsonResponse(false, "Невірне розширення файлу: " . $ext);
            return;
         }    	     	 
    	 
    	 if(!file_exists(DOCROOT . $path . '/' . $oldname)){
    	 	echo $this->_jsonResponse(false, 'Відсутній файл: ' . $path . '/' . $oldname);
    	 	return;
    	 }
    	 
    	 rename(DOCROOT . $path . '/' . $oldname, DOCROOT . $path . '/' . $newname);
    	 echo $this->_jsonResponse(true);
    	
    }    
    
    /**
    * Завантаження фотографій
    */ 
    public function upload()
    {
        $node = $this->input->post('node');
        
        $name = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];
        $temp = $_FILES['file']['tmp_name'];
        $ext = utf8::strtolower(utf8::substr($name,utf8::strrpos($name, ".")+1));
        $name = utf8::substr($name, 0, utf8::strrpos($name, '.'));
          
        if (!in_array($ext, $this->image_types)) {
            echo $this->_jsonResponse(false, "Файл не є зображенням");
        } elseif (is_uploaded_file($temp)) {
        	
        	$resize_upload = $this->input->post('resize_upload', false, true);
        	        	        	
        	if(strlen($resize_upload) > 0){
        		$resize_upload = json_decode($resize_upload);

         		$thumb = new Image($temp);
         		
	          	if($thumb->__get('width') > $resize_upload->width || $thumb->__get('height') > $resize_upload->height){
	          		
                    if (($thumb->__get('height')/$thumb->__get('width')) < ($resize_upload->height/$resize_upload->width)) {
                        $thumb->resize( $resize_upload->width, $resize_upload->height, Image::HEIGHT);
                    } else {
                        $thumb->resize( $resize_upload->width, $resize_upload->height, Image::WIDTH);
                    }	   
                    
                          		
	          		$thumb->crop($resize_upload->width, $resize_upload->height, 'center', 'center');	          			
	          		$thumb->sharpen(20)->quality(100)->save(DOCROOT . $node . '/' . $name . ".$ext");
	          		  
	          	} else {
	          		move_uploaded_file($temp, DOCROOT . $node . '/' . $name . ".$ext");
	          		
	          	}
	
        	}else{
           		move_uploaded_file($temp, DOCROOT . $node . '/' . $name . ".$ext");
           		
           		
        	}

            
            echo $this->_jsonResponse(true, 'Ok');
        } else {
            echo $this->_jsonResponse(false, "Помилка загрузки");
        }

    }
    

    /**
    * Дерево папок
    */ 
	public function load_tree() {

		$node = $this->input->post('node');
		if(utf8::strpos($node, '..') !== false){
			die('Nice try buddy.');
		}

		$nodes = array();
        if (file_exists($node) and is_dir($node) and is_readable($node)) {
            $d = dir($node);
		    while($f = $d->read()){		    	
			    if($f == '.' || $f == '..' || substr($f, 0, 1) == '.'){
                    continue;
                }
			    if(is_dir($node.'/'.$f)){
				    $nodes[] = array('text'=>$f, 'id'=>$node.'/'.$f);
			    }
		    }
		    $d->close();
        }
		echo json_encode($nodes);

	}


    /**
    * Список фотографій
    */ 
	public function list_items() {

        $limit = $this->input->post('limit', 10);
        $start = $this->input->post('start', 0 );
        

		$folder = $this->input->post('node','images');
		$fileName = $this->input->post('filename', false );

		$nodes['items'] = array();
		$nodes['total'] = 0;		
		
		
		$listFiles = scandir(DOCROOT.$folder);	
		if($listFiles !== false){
			foreach ($listFiles as $file){
				
				if(empty($fileName) || !empty($fileName) && $file === $fileName){
						
					$imgext = utf8::strtolower(utf8::substr($file,utf8::strrpos($file, ".")+1));			
					if (in_array($imgext, $this->image_types)) {
					
						$image = @getImageSize($folder.'/'.$file);
						if (in_array(str_replace('image/', '', $image['mime']), $this->image_types)) {
		
							$width = $image[0];
							$height = $image[1];
		
							$time = filemtime($folder.'/'.$file);
							$size = filesize($folder.'/'.$file);
							
							
							$nodes['items'][] = array(
								'name'=>$file,
								'size'=>$size,
								'lastmod'=>$time,
								'url'=>$folder.'/'.$file,
								'width'=>$width,
								'height'=>$height,
								'rand'=> uniqid()
							);
						}
					}
				}				
				
				
			}
			$nodes['total'] = count($nodes['items']);
			$nodes['items'] = array_slice($nodes['items'], $start, $limit);			
			
			
		}
		
		
		echo json_encode($nodes);

	}
	
	public function _jsonResponse($success, $message='ok') {
        if ($success) $success = 'true';else $success = 'false';
        return '{"success": '.$success.', "msg": "'.$message.'"}';
    }

    
    
    /**
     * Накладання текстової мітки на зображення
     *
     */
    public function save_watermark(){

    	
		$marker_text = $this->input->post('marker_text');
		$images = $this->input->post('images');
		
		$is_new_file = (int)$this->input->post('is_new_file', 0);
		$new_file = $this->input->post('new_file');
		$new_dir = $this->input->post('new_dir');
				
		if(empty($marker_text) || empty($images)){
			return print (ext::json_response(false, 'Незадані обов`язкові параметри'));
			
		}
				
		if(!file_exists(DOCROOT . $images)){
			return print (ext::json_response(false, 'Відсутній файл рисунка: ' . DOCROOT . $images));
			
		}		
		
		
		if($is_new_file == 1){
			
			if(empty($new_file) || empty($new_dir)){
				return print (ext::json_response(false, 'Незадані обов`язкові параметри (директорія або назва файла)'));
			}
						
			if(!is_dir(DOCROOT . $new_dir)){
				return print (ext::json_response(false, 'Невірна директорія: ' . $new_dir));
				
			}
			
			if(file_exists(DOCROOT . $new_dir . '/' . $new_file)){
				return print (ext::json_response(false, 'Такий файл вже існує: ' . $new_dir . '/' . $new_file));
				
			}			
			
		}		
		
		
		$img = new Image(DOCROOT . $images);
		$img->writeText($marker_text, 
			Kohana::config('watermark.font_path'),
			Kohana::config('watermark.font_size'),
			Kohana::config('watermark.color'),
			Kohana::config('watermark.position_x'),
			Kohana::config('watermark.position_y')
		);
		
		if($is_new_file == 1){ //пишемо в новий файл			
			$img->save(DOCROOT . $new_dir . '/' . $new_file, false);					
			
		} else{//накладаємо текст в файл оригіналу
			$img->save(DOCROOT . $images, false);					
			
		}
		
		
		echo ext::json_response(true);
    }


    /**
     * Формування результату пошуку
     *
     */
    public function list_search(){
    	
    	$params = array();
    	$params['patern'] = $this->input->post('patern');
    	$params['path'] = $this->input->post('path');
    	$params['start_date'] = intval($this->input->post('start_date'));
    	$params['end_date'] = intval($this->input->post('end_date'));
    	
    	$resultData['items'] = array();
    	
    	if(is_dir(DOCROOT . $params['path'])){
	    	$this->search_data = array();    		    	
	    	$this->searchFiles($params['path'], $params);
	    	$resultData['items'] = $this->search_data;      		
    		
    	}
  	
    	echo json_encode($resultData);
    	    	
    }
    
    /**
     * Пошук фалів
     *
     * @param string $outerDir - директорія сканування
     * @param string $params - параметри виборки
     */
	private function searchFiles($outerDir, $params){ 
		
		if(count($this->search_data) >= self::count_max_search_rows){
			return;
			
		}
		
	    $dirs = array_diff( scandir( $outerDir ), Array( ".", "..", '.svn' ) ); 
	    $dir_array = Array(); 
	    foreach( $dirs as $d ){ 
	    	$path = $outerDir."/".$d;
	    	$fileTime = filemtime($path);
	    	
	        if( is_dir($path) ){
	        	$this->searchFiles($path, $params); 
	        	
	        } elseif (is_file($path) 
		        	&& $this->fnmatch(strtolower($params['patern']), strtolower($d))
		        	&& $this->checkBetweenDates($fileTime, $params['start_date'], $params['end_date'])
	        	){	  
				if(count($this->search_data) >= self::count_max_search_rows){
					return;
					
				}	        	
	        	
	        	$image = @getImageSize($path);
	        	
		        $this->search_data[] = array(
		        	'path' => str_replace(DOCROOT, '', $outerDir),
		        	'filename' => $d,
		        	'filetime' => date('Y-m-d H:i', $fileTime),
		        	'filesize' => round(filesize($path)/1024, 1),
		        	'image_size' => $image[0] . 'x' . $image[1]
		        );
	        }
	        
	    } 
	}    

	/**
	 * Перевірка по масці
	 *
	 * @param string $pattern - Маска пошуку
	 * @param string $string - Назва файла
	 * @return bool
	 */
    function fnmatch($pattern, $string) {
        return @preg_match('/^' . strtr(addcslashes($pattern, '\\.+^$(){}=!<>|'), array('*' => '.*', '?' => '.?')) . '$/i', $string);
    }

    
    /**
     * Перевірка входження між двома датами
     *
     * @param int $fileDate - дата зміни файлу
     * @param int $startDate - початкова дата діапазону
     * @param int $endDate - кінцева дата діапазону
     */
    private function checkBetweenDates($fileDate, $startDate, $endDate){
    	if($startDate==0 && $endDate==0){
    		return true;
    		
    	}elseif ($startDate > 0 && $endDate == 0 && $fileDate>=$startDate){
    		return true;
    		
    	}elseif ($startDate == 0 && $endDate > 0 && $fileDate<=$endDate){
    		return true;
    		
    	}elseif ($startDate > 0 && $endDate > 0 && $fileDate>=$startDate && $fileDate<=$endDate){
    		return true;
    		
    	}
    	
    	return false;
    	
    	
    }
    
    
    
	/**
	 * Загрузка дерева директорій
	 *
	 */
	public function load_tree_dir(){

		$this->nodes_dir['rows'] = array();
		$this->nodes_dir_id = 0;
		
		if(is_dir(DOCROOT . self::root_folder)){
			$this->scanDir(DOCROOT . self::root_folder, $this->nodes_dir_id++);		
			
		}
		
		echo json_encode($this->nodes_dir);
	}
		


	/**
	 * Сканування директорії
	 *
	 * @param string $dirName - шлях до диреторії
	 */
	private function scanDir($dirName, $parentID){
	
		if(is_dir($dirName)){
		
		    $temp = opendir($dirName);
		    
		    $dirID = $this->nodes_dir_id++;
		    $this->nodes_dir['rows'][] = array('id'=>$dirID, 'text'=> basename($dirName), 'parent_id' => ($parentID == 0 ? null : $parentID), 'full_path'=>str_replace(DOCROOT, '', $dirName));	    
		    while ($file = readdir($temp)) {
		    	
		        if ($file == '.' || $file == '..'  || $file == '.svn'){
		        	continue;
		        	
		        }
	
		    	$fileName = $dirName . '/' . $file;
			    if (is_dir($fileName)) {
			    	$this->scanDir($fileName, $dirID);
	
		    	}
		    }
		    closedir($temp);	
		}	
	}    
    
	
	/**
	 *Збереження данних кропера
	 *
	 */		
	public function save_crop_image(){
		
		$originalImage = $this->input->post('original_image');
		$newFileName = $this->input->post('new_file_name');
		
		if(!file_exists(DOCROOT . $originalImage)){			
			return print (ext::json_response(false,'Відсутній оригінальний файл зображення'));
			
		}
		
		
		if(!empty($newFileName)){			
	    	 $ext = utf8::strtolower(utf8::substr($newFileName,utf8::strrpos($newFileName, ".")+1));    	 
	         if (!in_array($ext, $this->image_types)) {
	          	return print ($this->_jsonResponse(false, "Невірне розширення файлу: " . $ext));
	           
	         } 
	         $savePath = str_replace('/'.basename($originalImage), '/'.$newFileName, $originalImage);		
			
		}else{
			$savePath = $originalImage;
			
		}
		
		
		$newSize = array(
			'width' => $this->input->post('width'),
			'height' => $this->input->post('height'),
			'top' => $this->input->post('top'),
			'left' => $this->input->post('left')
		
		);		
		
		
	    $image = new Image(DOCROOT . $originalImage);
	    $image->crop($newSize['width'],$newSize['height'],$newSize['top'], $newSize['left']);		
	    $image->sharpen(20)->quality(100)->save(DOCROOT . $savePath);
		
		echo ext::json_response(true);
	
		
	}	
	
    
	/**
	 * Копіювання зображень в вибрану директорію
	 *
	 */
	public function copy_images(){
		$images = $this->input->post('images', false, true);
		$new_dir = $this->input->post('new_dir', false, true);
		
		if(!$images || !$new_dir){
			return print ($this->_jsonResponse(false, "Відсутні обов`язкові параметри"));
			
		}
		
		if(!is_dir($new_dir)){
			return print ($this->_jsonResponse(false, "Неіснуюча папка: " . $new_dir));
			
		}

		$images = json_decode($images);
		foreach ($images[0] as $image){
			if(!file_exists($image)){
				return print ($this->_jsonResponse(false, "Відсутній файл зображення: " . $image));
				
			}
			
			$newFile = DOCROOT . $new_dir . '/' . basename($image);
			if(file_exists($newFile)){
				unlink($newFile);
				
			}
			copy($image, $newFile);
			
		}
		return print ($this->_jsonResponse(true));
	}
	
}