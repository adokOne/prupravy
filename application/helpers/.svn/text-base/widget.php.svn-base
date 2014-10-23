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
}