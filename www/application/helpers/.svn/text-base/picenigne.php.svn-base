<?php

class picenigne {

	/** 
	 * Process uploaded file using config parameters ...
	 * @param string $in_file - input file
	 * @param stringe $destination_dir - where to put processed files
	 * @param string $out_file - base filename for processed images
	 * @param array $config - array with configuration options
	 * @return boolean
	 */
	public static function process_picture($in_file, $destination_dir, $out_file, $config, $drop_original = true){
	
		
		$filename = $destination_dir . $out_file;
		
		if(!file_exists(DOCROOT . $destination_dir ))
			mkdir(DOCROOT . $destination_dir , 0777, true);
		
		if(is_uploaded_file($in_file))
			move_uploaded_file($in_file, $filename);
		else
			rename($in_file, $filename);
		
		$sizes = is_array($config) ? $config : Kohana::config('pictures.sizes');

		$image = Image::factory($filename);

 		foreach($sizes as $size){
			$img_size=getimagesize($filename);
			$width=$img_size[0];
			$height=$img_size[1];
			
			if($size['crop']){
				$image->resize($size['width'],$size['height'], ( ($width/$height) <= ($size['width']/$size['height']) ) ? (Image::WIDTH) : (Image::HEIGHT));
				$image->crop($size['width'],$size['height']);
			}else {
				if($width > $size['width'] || $height > $size['height']){
					$image->resize($size['width'],$size['height'], ( ($width/$height) >= ($size['width']/$size['height']) ) ? (Image::WIDTH) : (Image::HEIGHT));
				}
			}
            if(!empty($size['watermark'])){
                $image->watermark(new Image('img/watermark.png'), 100, $size['width']-80, $size['height']-28);
                $image->textWatermark($user->username, 16, 20, $size['height']-28);
            }
						
			$image->save(DOCROOT . $destination_dir . addition_functions::addSuffix($out_file, $size['suffix']) );
		}
		
		#if($drop_original)
		#	unlink($filename);	
		
		return true;
	}

	/**
	 * Process uploaded file using config parameters ...
	 * @param string $in_file - input file
	 * @param stringe $destination_dir - where to put processed files
	 * @param string $out_file - base filename for processed images
	 * @param array $config - array with configuration options
	 * @return boolean
	 */

	public static function save_picture($in_file, $destination_dir, $out_file){

		$filename = $destination_dir.$out_file;

		if(!file_exists(DOCROOT . $destination_dir ))
			mkdir(DOCROOT . $destination_dir , 0777, true);

		if(is_uploaded_file($in_file)){
			move_uploaded_file($in_file, $filename);
			return true;
		}

		else{

			if(isset($filename) && file_exists($filename))
				unlink($filename);
				rename($in_file, $filename);
				return true;
		}

	}
	public static function resize_picture($in_file, $destination_dir, $out_file, $config, $drop_original = false){
		if(!file_exists(DOCROOT . $destination_dir ))
                    mkdir(DOCROOT . $destination_dir , 0777, true);

		$sizes = is_array($config) ? $config : Kohana::config('pictures.sizes');
		$filename=$in_file;
		$image = Image::factory($filename);

                $img_size = getimagesize($filename);
		$width = $img_size[0];
		$height = $img_size[1];

 		foreach($sizes as $size){
			if($size['crop']){
                            $image->resize($size['width'],$size['height'], ( ($width/$height) <= ($size['width']/$size['height']) ) ? (Image::WIDTH) : (Image::HEIGHT));
                            $image->crop($size['width'],$size['height']);
			} else {
                            if($width > $size['width'] || $height > $size['height']) {
                                $image->resize(
                                        $size['width'],
                                        $size['height'],
                                        (($width/$height) >= ($size['width'] / $size['height'])) ? (Image::WIDTH) : (Image::HEIGHT)
                                );
                            }
                        }
                        if(!empty($size['watermark'])) {
                            $image->watermark(new Image('img/watermark.png'), 100, $size['width']-80, $size['height']-28);
                            $image->textWatermark($user->username, 16, 20, $size['height']-28);
                        }
                        $image->save(DOCROOT . $destination_dir . '/' . $size['prefix'] . $out_file );
		}

		if($drop_original)
			unlink($filename);

		return true;
	}
	
	/*
	public static function deletePicture($event_id, $u_id){
		$sizes = Kohana::config('pictures.sizes');
		$error = false;
		foreach($sizes as $size){
			@unlink (DOCROOT . 'img/pictures/' . $event_id  . '/' . $u_id. "/" . $size['prefix'] . ".jpg");
		}

		@rmdir(DOCROOT . 'img/pictures/' . $event_id  . '/' . $u_id ) ;

		return true;
	}
	*/
}