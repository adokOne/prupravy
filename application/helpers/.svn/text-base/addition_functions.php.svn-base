<?php

class addition_functions{

	public static function addSuffix($filename, $suffix){	
		$last_point = strrpos($filename, ".");
		$extension = end(explode(".", $filename));
		$res = substr($filename, 0, $last_point);
		$res = $res . $suffix . '.' . $extension;
		
		return $res;
	}

}