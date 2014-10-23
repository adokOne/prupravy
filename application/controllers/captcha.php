<?php

class Captcha_Controller extends Controller {

	function index() {
		Captcha::factory('kcaptcha')->render(false);
	}

	function kcaptcha(){
		self::index();
	}

	function listen(){
		 
	}

	function audio(){
		 
		//var_dump(Session::instance()->get('captcha_response'));exit;
		 
		// save the  $_SESSION cookie into
		$captcha = Session::instance()->get('captcha_response');
		$captcha = strtolower($captcha);

		$order = array();

		for($i=0;$i<strlen($captcha);$i++){
				
			array_push($order,$captcha{$i});
				
		}

		foreach($order as $key => $value) {
			$audio[] = self::_get_audio("$value.mp3",SYSPATH.'mp3/');
		}

		$mp3 = ""; $size = "";


		// Parse the soundfiles and sum the filesize
		foreach ($audio as $key => $value) {
			$mp3 .= $audio[$key]['mp3'];
			$size += $audio[$key]['size'];
		}

		unset($order, $audio); // Free up some memory by removing the arrays, we dont need them anymore ;)

		// Send the generated mp3 file
		header("Pragma: no-cache");
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Type: audio/mepeg');
		header("Content-Disposition: attachment; filename=\"validate.mp3\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-length: $size");
		 
		echo $mp3;
		 
	}

	function _get_audio($file, $dir = 'mp3/'){

		$file = strtolower($file); // make sure the filename is lowercase or the fileload might fail...
		$handle = fopen($dir . $file, "rb"); // Read as binary
		$size = filesize($dir . $file);

		// If PHP5 is being used, use stream_get_line() function, else use fread()
		if (function_exists('stream_get_line')) {

			$load = stream_get_line($handle, $size);  // Reads files faster than fread and fgets! ;)

		} else {

			$load = fread($handle, $size);

		}

		fclose($handle);

		return array("mp3" => $load, "size" => $size);

	}

}