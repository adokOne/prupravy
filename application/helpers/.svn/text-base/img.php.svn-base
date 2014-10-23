<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Img helper class.
 */
class img_Core {
	
	public static  function _get($src,$size,$pref="pic",$ext="jpg")
	{	$file  = DOCROOT.$src."/".$pref."_".$size.".".$ext;
	#var_dump($file);die;
		$image = "/images/default/".$pref."_".$size.".".$ext;
		if(file_exists($file))
			$image = $src."/".$pref."_".$size.".".$ext;
		return $image;
	}

}