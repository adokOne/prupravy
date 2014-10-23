<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package     Gallery
 * @author      Oleh Zamkovyi <oleh.zam@gmail.com>
 * @copyright   (c) 2011 Oleh Zamkovyi
 */
class Gallery_Admin extends Constructor
{

    protected $item_table   = 'ads';
    protected $tree_table   = 'categories';
    protected $orderby      = 'id';
    protected $sub_orderby  = 'order';
    protected $order_dir    = 'ASC';
    protected $tree_id      = 'category_id';
    protected $use_tree     = FALSE;
    protected $use_combo    = TRUE;
    
    protected $grid_columns = array(
        "id",
        "(SELECT name FROM cities WHERE id = daddy.city_id) AS city",
        "(SELECT name FROM districts WHERE id = daddy.district_id) AS district",
        "street",
        "building",
        "latitude",
        "longitude",
    );
    
    protected $sub_table = 'pictures';

    protected $sub_grid_columns = array(
        "id",
        "name",
        "ad_id",
        "order",
        //"width",
        //"height",        
    );

    protected $template = 'gallery_admin';
    protected $gallery_folder = 'upload/ads';
    protected $prefix = 'm';
    
    protected $image_types = array(
        'gif',
        'jpeg',
        'jpg',
        'png'
    );
    
    /**
     * Загрузка JS модуля
     */
    public function index()
    {
        parent::index();
        
        $this->view->sub_grid_record = extOZ::record($this->sub_table, $this->sub_grid_columns);
        $this->view->folder = $this->gallery_folder;
        $this->view->prefix = $this->prefix;
    }

    /**
     * Grid
     */
    protected function _sub_list_items()
    {
        $sort = $this->input->post('sort', $this->sub_orderby);
        $dir = $this->input->post('dir', "ASC");
        
        $album_id = (int)$this->input->post('node');
        
        $this->db->select($this->sub_grid_columns)
            ->from($this->sub_table)
            ->where('ad_id', $album_id)
            ->orderby($sort, $dir);
        return extOZ::grid();
    }

    public function sub_list_items()
    {
        $this->_sub_reorder();
        $this->_sub_save_all_items();
        $this->_sub_remove_all_items();

        echo json_encode($this->_sub_list_items());
    }

    protected function _sub_reorder()
    {
        if(!$reorder = json_decode($this->input->post('reorder')))
            return false;
            
        $source_id = $reorder->source[0];
        $target_id = $reorder->target;
        $parent_id = $this->input->post('node');
        
        $source_order = $this->db
            ->from($this->sub_table)
            //->where("ad_id", $parent_id)
            ->where("id", $source_id)
            ->get()
            ->order;
            
        $target_order = $this->db
            ->from($this->sub_table)
            //->where("ad_id", $parent_id);
            ->where("id", $target_id)
            ->get()
            ->order;
            
        $this->db->update($this->sub_table, array(
            'order' => $target_order
        ));
        
        //echo $source." <-> ".$target;
        
    }
    
    protected function _sub_remove_all_items()
    {
        if(!$album_id = $this->input->post('node'))
            return false;

        $ids = $this->input->post('remove');
        $folder = DOCROOT . $this->gallery_folder . "/" .$album_id . "/";

        if (strlen($ids))
        {        
            $nodes = json_decode(stripslashes($ids), TRUE);
            $this->db->delete($this->sub_table, 'id IN ('.implode($nodes[0], ', ').')');

            $this->db->query("UPDATE $this->item_table SET
                    has_pictures = (SELECT COUNT(*) FROM $this->sub_table WHERE ad_id = $album_id) > 0
                    WHERE id = $album_id
                    ");

            foreach (Kohana::config('pictures.sizes') as $param)
                foreach ($nodes[0] as $id)
                    @unlink($folder . $param['prefix'] . $id . ".jpg");
        }
    }

    protected function _sub_save_all_items()
    {
        $records = $this->input->post('save');
        $album_id = $this->input->post('node');
        if (strlen($records))
        {
            if (get_magic_quotes_gpc())
                $records = stripcslashes($records);
                
            $nodes = json_decode($records);

            if ($nodes) foreach ($nodes as $n)
            {
                unset($n->rowIndex);
                if (isset($n->id))
                    $this->db->update($this->sub_table, (array)$n, "id = $n->id");
                else
                    $this->db->insert($this->sub_table, (array)$n);
            }

            $this->db->query("UPDATE $this->item_table SET
                    has_pictures = (SELECT COUNT(*) FROM $this->sub_table WHERE ad_id = $album_id) > 0
                    WHERE id = $album_id
                    ");
        }
    }

    public function save_photo()
    {
        $id = (int)$this->input->post('id');
        
        $data = extOZ::get_form($this->sub_table);

        // Очистка данных
        foreach ($data as $key => $val)
        {
            $data[$key] = trim($val);
        }
        
        
        if ($id > 0)
            $this->db->update($this->sub_table, $data, "id = $id");

        $nodes = array(
            'list' => $this->_sub_list_items(),
            'success' => 'true'
        );
        echo json_encode($nodes);
    }

    //public function _upload_photos($name, $temp, $node)
    public function upload_photos()
    {

        $name = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];
        $temp = $_FILES['file']['tmp_name'];

        $node = $this->input->post('node');

        $ext = mb_strtolower(mb_substr(mb_strrchr($name, "."), 1));
        $name = mb_substr($name, 0, mb_strrpos($name, '.'));

        $album_id = (int)$node;
        
        if (!in_array($ext, $this->image_types)) {
            echo extOZ::json_response(FALSE, 'Файл не есть изображением');
        } elseif (is_uploaded_file($temp) || Kohana::config('upload.driver') == 'nginx') {
            
            $data = array(
                'name' => '',
                'ad_id' => $album_id
            );
            
            $id = $this->db->insert($this->sub_table, $data)->insert_id();
            $this->db->query("UPDATE $this->item_table SET
                    has_pictures = (SELECT COUNT(*) FROM $this->sub_table WHERE ad_id = $album_id) > 0
                    WHERE id = $album_id");
            //echo $this->db->last_query();
            picenigne::resize_picture(
                    $temp,
                    $this->gallery_folder."/".$album_id,
                    "$id.jpg",
                    Kohana::config('ads_pictures.sizes'),
                    TRUE
            );
                  
            echo extOZ::json_response(TRUE, 'Ok');
            
        } else {
            echo extOZ::json_response(FALSE, 'Ошибка загрузки');
        }
         
    }    

} // End Pages
