<?php

class Admin_core {
	
	public function __construct(){
		
	}
	
	static public function getModules(){
		
		$modules = ORM::factory('module')->find_all();

		$_modules = array();
		$_modules_tree = "[";
		$_modules_actions = array();
		
		$_modules = arr::ORM_object_to_array($modules);
		$_modules = arr::array_stack($_modules,'parent_id','children');
		
		
		
		foreach ($_modules as $module){
			
			if($module['parent_id'] == null){
				
				//$_modules_tree_array = ""	
				/*
				if(!empty($module['class'])){
					$view = new View('module_tree');
					$view->title = $module['class'];
					$_modules_actions[] = $view->render();
				}*/
				
				($_modules_tree == "[") or ($_modules_tree .= ", \n");
				
				$_modules_tree .= "{ title : '" . $module['name'] . "', iconCls : '" . $module['icon'] . "' ";
					
				if(!empty($module['children'])){
					
					$view = new View('module_tree');
					$view->title = $module['class'];
					
					$actions = array();
					
					foreach ($module['children'] as $child){
						if( !in_array( $child['class'] , array('districts')) ){  // hide modules
							$actions[] = array(
								'text'	=> $child['name'],
								'id'	=> $child['class'],
								'leaf'  => "true",
								'iconCls' => $child['icon']
							);
						}						
					}
					
					$view->actions = json_encode($actions);
					$_modules_actions[] = $view->render();
					
					$_modules_tree .= ", items : [ tree_" .$module['class']. " ]";
				
				}
				
				$_modules_tree .= " } ";
			}
			
		}
		
		$_modules_tree .= "]";
		
		
		return array(
			'modules'	=> $_modules_tree,
			'modules_action'	=> $_modules_actions
		);
		
		
	}
	
	
	
}