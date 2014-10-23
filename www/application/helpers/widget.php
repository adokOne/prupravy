<?php

class widget_Core {
	private static  $return;
	public static function render($className,$functionName,$parameters = null){
		$controllerName = ucfirst($className).'_Controller';
		$controller = new $controllerName;
		self::$return=$controller->$functionName($parameters);
		return self::$return;
	}
	public static function render2($className,$functionName,$parameters = null){
		$controllerName = ucfirst($className);
		$controller = new $controllerName;
		self::$return=$controller->$functionName($parameters);
		return self::$return;
	}


	public static function render_menu($array,$cls){
		$str = "<ul class=".$cls.">";
		foreach ($array as $link => $name) {
			$str.= "<li>";
			if(is_array($name))
				self::render_menu($name,"");
			else
				$str.= '<a href="'.$link.'">'.$name."</a>";
			
			$str.= "</li>";
		}

		$str.= "</ul>";

		return $str;
	}

}