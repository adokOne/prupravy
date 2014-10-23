<?php

class Tree_Core extends Database {
    
    protected $db;
	protected $table;
    public $t_id;
    public $t_left;
    public $t_right;
    public $t_level;
    public $t_parent;
        
    function __construct($table, $prefix) {
        $this->table = $table;
        $this->t_id = $prefix.'id';
        $this->t_left = $prefix.'left_key';
        $this->t_right = $prefix.'right_key';
        $this->t_level = $prefix.'level';
        $this->t_parent = $prefix.'parent_id';
        if ( ! is_object($this->db))
        {
            // Load the default database
            $this->db = Database::instance('default');
        }
        return $this;
    }

    public function get_node($id){
        return $this->db->select('*')->from($this->table)->where($this->t_id, $id)->get()->current();
    }
    
    public function add_node($id, $data) {
    	$node = $this->get_node($id);
        if(!($node)) {
            $right = (integer)$this->db->query("SELECT MAX($this->t_right)+1 AS root FROM $this->table WHERE $this->t_level = 1")
                               ->current()
                               ->root;
            $left = 0;
			$level = 0;
        } else {
        	$right = $node->{$this->t_right};
            $left = $node->{$this->t_left};
			$level = $node->{$this->t_level};
        }
        
        $data += array(
            $this->t_left => $right,
            $this->t_right => $right + 1,
            $this->t_level => $level + 1,
            $this->t_parent => $id

        );
        $sql = "UPDATE $this->table SET 
				$this->t_right = $this->t_right + 2,
                $this->t_left = CASE
                    WHEN $this->t_left > $right
                        THEN $this->t_left + 2
                        ELSE $this->t_left
                END
			  WHERE
    			$this->t_right >= $right";
        
        $this->db->query($sql);

        $insertedId = $this->db->insert($this->table, $data)->insert_id();
        
        return $insertedId;
    }

    public function del_branch($id) {
    	$node = $this->get_node($id);
        
        if (!$node) return FALSE;
        
        $right = $node->{$this->t_right};
		$left = $node->{$this->t_left};
        
        $sql1="DELETE FROM $this->table WHERE $this->t_left BETWEEN $left AND $right";
        
        $delta = (($right - $left) + 1);
  
        $sql2="UPDATE $this->table SET
                $this->t_left = CASE WHEN $this->t_left > $left THEN $this->t_left - $delta ELSE $this->t_left END,
                $this->t_right = CASE WHEN $this->t_right > $left THEN $this->t_right - $delta ELSE $this->t_right END
			  WHERE
				$this->t_right > $right";
        
        $this->db->query($sql1);
        $this->db->query($sql2);
        
        return TRUE;
    }
    

    public function change_parent_node($id_s, $id_d) {
        $node_s = $this->get_node($id_s);
        if (!$node_s) return FALSE;

        $left_s = $node_s->{$this->t_left};
        $right_s = $node_s->{$this->t_right};
        $level_s = $node_s->{$this->t_level};

        if ($id_d != 0) {        
            $node_d = $this->get_node($id_d);
            if (!$node_d) return FALSE;
            
            $left_d = $node_d->{$this->t_left};
            $right_d = $node_d->{$this->t_right};
            $level_d = $node_d->{$this->t_level};
            
        } else {
            $root = $this->db->query("SELECT MAX($this->t_right)+1 AS root FROM $this->table WHERE $this->t_level = 1")
                               ->current()
                               ->root;
            
            $left_d = $root;
            $right_d = $root;
            $level_d = 0;
        }
       
        if ($id_s == $id_d || $left_s == $left_d || ($left_d >= $left_s && $left_d <= $right_s) ||
            ($level_s == $level_d+1 && $left_s > $left_d && $right_s < $right_d)) {
            return FALSE;
        }

        if ($left_d < $left_s && $right_d > $right_s && $level_d < $level_s - 1) {
            $sql = "UPDATE $this->table SET
                        $this->t_level = CASE 
                            WHEN $this->t_left BETWEEN $left_s AND $right_s
                                THEN $this->t_level ".sprintf('%+d', -($level_s-1)+$level_d)."
                                ELSE $this->t_level
                        END,
                        $this->t_right = CASE
                            WHEN $this->t_right BETWEEN ".($right_s+1)." AND ".($right_d-1)."
                                THEN $this->t_right-".($right_s-$left_s+1)."
                            WHEN $this->t_left BETWEEN $left_s AND $right_s
                                THEN $this->t_right+".((($right_d-$right_s-$level_s+$level_d)/2)*2+$level_s-$level_d-1)."
                                ELSE $this->t_right
                        END,
                        $this->t_left = CASE
                            WHEN $this->t_left BETWEEN ".($right_s+1)." AND ".($right_d-1)."
                                THEN $this->t_left-".($right_s-$left_s+1)."
                            WHEN $this->t_left BETWEEN $left_s AND $right_s
                                THEN $this->t_left+".((($right_d-$right_s-$level_s+$level_d)/2)*2+$level_s-$level_d-1)."
                                ELSE $this->t_left
                        END,
                        $this->t_parent = CASE
                            WHEN $this->t_id = $id_s
                            THEN $id_d
                            ELSE $this->t_parent
                        END
                        WHERE $this->t_left BETWEEN ".($left_d+1)." AND ".($right_d-1);
                        
        } elseif ($left_d < $left_s) {
            $sql = "UPDATE $this->table SET
                        $this->t_level = CASE
                            WHEN $this->t_left BETWEEN $left_s AND $right_s
                                THEN $this->t_level ".sprintf('%+d', -($level_s-1)+$level_d)."
                                ELSE $this->t_level
                        END,
                        $this->t_left = CASE
                            WHEN $this->t_left BETWEEN $right_d AND ".($left_s-1)."
                                THEN $this->t_left+".($right_s-$left_s+1)."
                            WHEN $this->t_left BETWEEN $left_s AND $right_s
                                THEN $this->t_left-".($left_s-$right_d)."
                                ELSE $this->t_left
                        END,
                        $this->t_right = CASE
                            WHEN $this->t_right BETWEEN $right_d AND $left_s
                                THEN $this->t_right+".($right_s-$left_s+1)."
                            WHEN $this->t_right BETWEEN $left_s AND $right_s
                                THEN $this->t_right-".($left_s-$right_d)."
                                ELSE $this->t_right
                        END,
                        $this->t_parent = CASE
                            WHEN $this->t_id = $id_s
                            THEN $id_d
                            ELSE $this->t_parent
                        END                        
                        WHERE ($this->t_left BETWEEN $left_d AND $right_s
                           OR $this->t_right BETWEEN $left_d AND $right_s)";
                        
        } else {
            $sql = "UPDATE $this->table SET
                        $this->t_level = CASE
                            WHEN $this->t_left BETWEEN $left_s AND $right_s
                                THEN $this->t_level ".sprintf('%+d', -($level_s-1)+$level_d)."
                                ELSE $this->t_level
                        END,
                        $this->t_left = CASE
                            WHEN $this->t_left BETWEEN $right_s AND $right_d
                                THEN $this->t_left-".($right_s-$left_s+1)."
                            WHEN $this->t_left BETWEEN $left_s AND $right_s
                                THEN $this->t_left+".($right_d-1-$right_s)."
                                ELSE $this->t_left
                        END,
                        $this->t_right = CASE
                            WHEN $this->t_right BETWEEN ".($right_s+1)." AND ".($right_d-1)."
                                THEN $this->t_right-".($right_s-$left_s+1)."
                            WHEN $this->t_right BETWEEN $left_s AND $right_s
                                THEN $this->t_right+".($right_d-1-$right_s)." ELSE $this->t_right
                        END,
                        $this->t_parent = CASE
                            WHEN $this->t_id = $id_s
                            THEN $id_d
                            ELSE $this->t_parent
                        END                        
                        WHERE ($this->t_left BETWEEN $left_s AND $right_d
                           OR $this->t_right BETWEEN $left_s AND $right_d)";
                        
        }
        
        $result = $this->db->query($sql);
        return (boolean)$result;
    }
    
    
    
    public function move_node($id_s, $id_d, $point = 'above') {
        if ('append' == $point) {
                return $this->change_parent_node($id_s, $id_d);
        }

        $node_s = $this->get_node($id_s);
        if (!$node_s) return FALSE;

        $node_d = $this->get_node($id_d);
        if (!$node_d) return FALSE;
            
        $left_s = $node_s->{$this->t_left};
        $right_s = $node_s->{$this->t_right};
        $level_s = $node_s->{$this->t_level};
        $parent_s = $node_s->{$this->t_parent};
            
        $left_d = $node_d->{$this->t_left};
        $right_d = $node_d->{$this->t_right};
        $level_d = $node_d->{$this->t_level};
        $parent_d = $node_d->{$this->t_parent};

        if ($parent_s <> $parent_d) {
            if ($this->change_parent_node($id_s, $parent_d)) {
                return $this->move_node($id_s, $id_d, $point);
            } else {
                return FALSE;
            }
        }
        
        if ('above' == $point) {
            if ($left_s > $left_d) {
                $sql = "UPDATE $this->table SET
                            $this->t_right = CASE
                                WHEN $this->t_left BETWEEN $left_s AND $right_s
                                    THEN $this->t_right - ".($left_s - $left_d)."
                                WHEN $this->t_left BETWEEN $left_d AND ".($left_s - 1)."
                                    THEN $this->t_right + ".($right_s - $left_s + 1)."
                                    ELSE $this->t_right
                            END,
                            $this->t_left = CASE
                                WHEN $this->t_left BETWEEN $left_s AND $right_s
                                    THEN $this->t_left - ".($left_s - $left_d)."
                                WHEN $this->t_left BETWEEN $left_d AND ".($left_s - 1)."
                                    THEN $this->t_left + ".($right_s - $left_s + 1)."
                                    ELSE $this->t_left
                            END
                            WHERE $this->t_left BETWEEN $left_d AND $right_s";
            } else {
                $sql = "UPDATE $this->table SET
                            $this->t_right = CASE
                                WHEN $this->t_left BETWEEN $left_s AND $right_s
                                    THEN $this->t_right + ".(($left_d - $left_s) - ($right_s - $left_s + 1))."
                                WHEN $this->t_left BETWEEN ".($right_s + 1)." AND ".($left_d - 1)."
                                    THEN $this->t_right - ".(($right_s - $left_s + 1))."
                                    ELSE $this->t_right
                            END,
                            $this->t_left = CASE
                                WHEN $this->t_left BETWEEN $left_s AND $right_s
                                    THEN $this->t_left + ".(($left_d - $left_s) - ($right_s - $left_s + 1))."
                                WHEN $this->t_left BETWEEN ".($right_s + 1)." AND ".($left_d - 1)."
                                    THEN $this->t_left - ".($right_s - $left_s + 1)."
                                ELSE $this->t_left
                            END
                            WHERE $this->t_left BETWEEN $left_s AND ".($left_d - 1);
            }
        }
        if ('below' == $point) {
            if ($left_s > $left_d) {
                $sql = "UPDATE $this->table SET
                            $this->t_right = CASE
                                WHEN $this->t_left BETWEEN $left_s AND $right_s
                                    THEN $this->t_right - ".($left_s - $left_d - ($right_d - $left_d + 1))."
                                WHEN $this->t_left BETWEEN ".($right_d + 1)." AND ".($left_s - 1)."
                                    THEN $this->t_right + ".($right_s - $left_s + 1)."
                                    ELSE $this->t_right
                            END,
                            $this->t_left = CASE
                                WHEN $this->t_left BETWEEN $left_s AND $right_s
                                    THEN $this->t_left - ".($left_s - $left_d - ($right_d - $left_d + 1))."
                                WHEN $this->t_left BETWEEN ".($right_d + 1)." AND ".($left_s - 1)."
                                    THEN $this->t_left + ".($right_s - $left_s + 1)."
                                    ELSE $this->t_left
                            END
                            WHERE $this->t_left BETWEEN ".($right_d + 1)." AND $right_s";
            } else {
                $sql = "UPDATE $this->table SET
                            $this->t_right = CASE
                                WHEN $this->t_left BETWEEN $left_s AND $right_s
                                    THEN $this->t_right + ".($right_d - $right_s)."
                                WHEN $this->t_left BETWEEN ".($right_s + 1)." AND $right_d
                                    THEN $this->t_right - ".(($right_s - $left_s + 1))."
                                    ELSE $this->t_right
                            END,
                            $this->t_left = CASE
                                WHEN $this->t_left BETWEEN $left_s AND $right_s
                                    THEN $this->t_left + ".($right_d - $right_s)."
                                WHEN $this->t_left BETWEEN ".($right_s + 1)." AND $right_d
                                    THEN $this->t_left - ".($right_s - $left_s + 1)."
                                    ELSE $this->t_left
                            END
                            WHERE $this->t_left BETWEEN $left_s AND $right_d";
            }
        }

        $result = $this->db->query($sql);
        return (boolean)$result;
    }    
    
}

?>