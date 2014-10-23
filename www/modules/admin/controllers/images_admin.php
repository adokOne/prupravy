<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package     Pages
 * @author      Oleh Zamkovyi <oleh.zam@gmail.com>
 * @copyright   (c) 2009 Oleh Zamkovyi
 */
class Images_Admin extends Controller
{

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

    public function index()
    {
        $view = new View('images_admin');
        
        $view->list_photos = json_encode($this->_list_photos());
        $view->tree_category = json_encode($this->_load_tree('images'));
        
        $view->render(TRUE);        
    }
    
    /**
     * Render the loaded template.
     */
    public function _render()
    {
        $this->view->render(TRUE);
    }

    
    /**
    * Дерево папок
    */ 
    public function load_tree() {
        $node = $this->input->post('node', 'images');
        if(utf8::strpos($node, '..') !== false){
            die('Nice try buddy.');
        }
        echo json_encode($this->_load_tree($node));
        
    }

    public function _load_tree($node) {
        $nodes = array();
        if (file_exists($node) and is_dir($node) and is_readable($node)) {
            $d = dir($node);
            while($f = $d->read()){
                if($f == '.' || $f == '..' || utf8::substr($f, 0, 1) == '.'){
                    continue;
                }
                if(is_dir($node.'/'.$f)){
                    
                    $nodes[] = array(
                        'text' => $f,
                        'id' => $node.'/'.$f,
                        'children' => $this->_load_tree($node.'/'.$f)
                    );
                }
            }
            $d->close();
        }
        
        return $nodes;
    }

    public function list_photos() {
        $this->save_all_items();
        $this->remove_all_items();
                
        echo json_encode($this->_list_photos());
    }
    
    /**
    * Список фотографій
    */ 
    public function _list_photos() {

        $limit = $this->input->post('limit', 10);
        $start = $this->input->post('start', 0 );

        $folder = $this->input->post('node', 'images');

        $temp = @opendir(DOCROOT.$folder);
        if (!$temp) die();
        
        $nodes['items'] = array();
        $nodes['total'] = 0;

        while ($file = readdir($temp)) {
            $ext = utf8::strtolower(utf8::substr($file, utf8::strrpos($file, ".") + 1));

            if (in_array($ext, $this->image_types)) {
                $image = @getImageSize($folder.'/'.$file);
                if (in_array(str_replace('image/', '', $image['mime']), $this->image_types)) {

                    $width = $image[0];
                    $height = $image[1];

                    $time = filemtime($folder.'/'.$file);
                    $size = filesize($folder.'/'.$file);

                    $name = utf8::substr($file, 0, utf8::strrpos($file, '.'));

                                        
                    $nodes['items'][] = array(
                        'name' => $name,
                        'ext' => $ext,
                        'size' => $size,
                        'id' => $folder.'/'.$file,
                        'width' => $width,
                        'height' => $height
                    );
                }
            }
        }
        closedir($temp);

        $nodes['total'] = count($nodes['items']);
        $nodes['items'] = array_slice($nodes['items'], $start, $limit);
        return $nodes;

    }
    
    /**
    * Завантаження фотографій
    */ 
    public function upload_photos()
    {
        $node = $this->input->post('node');
        
        $name = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];
        $temp = $_FILES['file']['tmp_name'];
        
        
        $ext = utf8::strtolower(utf8::substr($name, utf8::strrpos($name, ".") + 1));
        $name = utf8::substr($name, 0, utf8::strrpos($name, '.'));
        
        if (!in_array($ext, $this->image_types)) {
            echo ext::json_response(FALSE, "Файл не есть изображением");
        } elseif (is_uploaded_file($temp)) {
            move_uploaded_file($temp, DOCROOT . $node . '/' . $name . ".$ext");
            echo extOZ::json_response(TRUE, 'Ok');
        } else {
            echo extOZ::json_response(FALSE, "Ошибка загрузки");
        }

    }
    
    
    public function remove_all_items()
    {
        $ids = $this->input->post('remove');
        if (strlen($ids))
        {        
            $nodes = json_decode(stripslashes($ids), TRUE);
            $nodes = $nodes[0];
            if ($nodes) foreach ($nodes as $file)
            {
                unlink(DOCROOT.$file);
            }
        }
    }

    public function save_all_items()
    {
        $records = $this->input->post('save');
        if (strlen($records))
        {
            $nodes = json_decode($records);
            if ($nodes) foreach ($nodes as $n)
            {
                $pathinfo = pathinfo($n->id);
                $dir = $pathinfo['dirname'];

                $old_name = str_replace('\\', '/', DOCROOT.$n->id);
                $new_name = str_replace('\\', '/', DOCROOT.$dir.'/'.$n->name.'.'.$n->ext);
                rename($old_name, $new_name);
            }
        }
    }
    
    /**
    * Удаление папки
    */
    public function remove_folder()
    {
        $path = $this->input->post('path', '');
        echo extOZ::json_response(@rmdir(DOCROOT.$path));
    }

    /**
    * Создание папки
    */     
    public function add_folder()
    {
        $name = $this->input->post('name');
        $path = $this->input->post('path');
        echo extOZ::json_response(@mkdir(DOCROOT.$path.'/'.$name));
    }
} // End Pages
