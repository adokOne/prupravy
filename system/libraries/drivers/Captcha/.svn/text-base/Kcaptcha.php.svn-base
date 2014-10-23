<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Captcha driver for "kcaptcha" style.
 *
 * $Id$
 *
 * @package    Captcha
 * @author     Dmitry Prymachenko <dem.prof@gmail.com>
 */
class Captcha_Kcaptcha_Driver extends Captcha_Driver {
	
	/**
	 * Generates a new Captcha challenge.
	 *
	 * @return  string  the challenge answer
	 */
	public function generate_challenge()
	{
		// Complexity setting is used as character count
		return text::random('kcaptcha', max(1, Captcha::$config['complexity']));
	}
	
	public function render($html){

		$fonts=array();
		//var_dump(Captcha::$config);
		$fontsdir_absolute=Kohana::config('captcha.kcaptcha.fontsdir');
		
		if ($handle = opendir($fontsdir_absolute)) {
			while (false !== ($file = readdir($handle))) {
				if (preg_match('/\.png$/i', $file)) {
					$fonts[]=$fontsdir_absolute.'/'.$file;
				}
			}
		    closedir($handle);
		}	
	
		$alphabet_length = strlen(Kohana::config('captcha.kcaptcha.alphabet'));
		$alphabet = Kohana::config('captcha.kcaptcha.alphabet');
		$allowed_symbols = Kohana::config('captcha.kcaptcha.allowed_symbols');
		$width = Kohana::config('captcha.kcaptcha.width');
		$height = Kohana::config('captcha.kcaptcha.height');
		$background_color = Kohana::config('captcha.kcaptcha.background_color');
		$foreground_color = Kohana::config('captcha.kcaptcha.foreground_color');
		$fluctuation_amplitude = Kohana::config('captcha.kcaptcha.fluctuation_amplitude');
		$no_spaces = Kohana::config('captcha.kcaptcha.no_spaces');
		$length = Kohana::config('captcha.kcaptcha.length');
		$jpeg_quality = Kohana::config('captcha.kcaptcha.jpeg_quality');
		
		do {
			
			// generating random keystring
			while(true){
				$this->keystring='';
				for($i=0;$i<$length;$i++){
					$this->keystring.=$allowed_symbols{mt_rand(0,strlen($allowed_symbols)-1)};
				}
				if(!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $this->keystring)) break;
			}
			
			
			$this->keystring = strtolower($this->response);
			
			$font_file=$fonts[mt_rand(0, count($fonts)-1)];
			$font=imagecreatefrompng($font_file);
			imagealphablending($font, true);
			$fontfile_width=imagesx($font);
			$fontfile_height=imagesy($font)-1;
			$font_metrics=array();
			$symbol=0;
			$reading_symbol=false;
		
			// loading font
			for($i=0;$i<$fontfile_width && $symbol<$alphabet_length;$i++){
				$transparent = (imagecolorat($font, $i, 0) >> 24) == 127;

				if(!$reading_symbol && !$transparent){
					$font_metrics[$alphabet{$symbol}]=array('start'=>$i);
					$reading_symbol=true;
					continue;
				}

				if($reading_symbol && $transparent){
					$font_metrics[$alphabet{$symbol}]['end']=$i;
					$reading_symbol=false;
					$symbol++;
					continue;
				}
			}
			

			
			$img=imagecreatetruecolor($width, $height);
			imagealphablending($img, true);
			$white=imagecolorallocate($img, 255, 255, 255);
			$black=imagecolorallocate($img, 0, 0, 0);
			
			imagefilledrectangle($img, 0, 0, $width-1, $height-1, $white);
			

			
			// draw text
			$x=1;
			for($i=0;$i<strlen($this->keystring);$i++){
				$m=$font_metrics[$this->keystring{$i}];

				$y=mt_rand(-$fluctuation_amplitude, $fluctuation_amplitude)+($height-$fontfile_height)/2+2;

				if($no_spaces){
					$shift=0;
					if($i>0){
						$shift=10000;
						for($sy=7;$sy<$fontfile_height-20;$sy+=1){
							for($sx=$m['start']-1;$sx<$m['end'];$sx+=1){
				        		$rgb=imagecolorat($font, $sx, $sy);
				        		$opacity=$rgb>>24;
								if($opacity<127){
									$left=$sx-$m['start']+$x;
									$py=$sy+$y;
									if($py>$height) break;
									for($px=min($left,$width-1);$px>$left-12 && $px>=0;$px-=1){
						        		$color=imagecolorat($img, $px, $py) & 0xff;
										if($color+$opacity<190){
											if($shift>$left-$px){
												$shift=$left-$px;
											}
											break;
										}
									}
									break;
								}
							}
						}
						if($shift==10000){
							$shift=mt_rand(4,6);
						}

					}
				}else{
					$shift=1;
				}
				imagecopy($img, $font, $x-$shift, $y, $m['start'], 1, $m['end']-$m['start'], $fontfile_height);
				$x+=$m['end']-$m['start']-$shift;
				
			} 
			
			
			
				
		} while($x>=$width-10); // while not fit in canvas
		
		$center=$x/2;
		//$img2=imagecreatetruecolor($width, $height);
		$this->image_create(Captcha::$config['background']);
		
		$foreground=imagecolorallocate($this->image, $foreground_color[0], $foreground_color[1], $foreground_color[2]);
		$background=imagecolorallocate($this->image, $background_color[0], $background_color[1], $background_color[2]);
		imagefilledrectangle($this->image, 0, 0, $width-1, $height-1, $background);		
		
		// Add a few random circles
		for ($i = 0, $count = mt_rand(10, Captcha::$config['complexity'] * 3); $i < $count; $i++)
		{
			$color = imagecolorallocatealpha($this->image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255), mt_rand(40, 120));
			$size = mt_rand(5, Captcha::$config['height'] / 3);
			imagefilledellipse($this->image, mt_rand(0, Captcha::$config['width']), mt_rand(0, Captcha::$config['height']), $size, $size, $color);
			imageline($this->image,mt_rand(0, Captcha::$config['width']), mt_rand(0, Captcha::$config['height']),mt_rand(0, Captcha::$config['width']), mt_rand(0, Captcha::$config['height']),$color);
		}
		$color_limit = mt_rand(96, 160);
		$chars = 'ABEFGJKLPQRTVY1234567890';
		$default_size = min(Captcha::$config['width'], Captcha::$config['height'] * 2) / strlen($this->response);
		// Background alphabetic character attributes
		for ($i = 0, $strlen = strlen($this->response); $i < $strlen; $i++)
		{
			$_font = Captcha::$config['fontpath'].Captcha::$config['fonts'][array_rand(Captcha::$config['fonts'])];
			$spacing = (int) (Captcha::$config['width'] * 0.9 / strlen($this->response));
			$angle = mt_rand(-40, 20);
			// Scale the character size on image height
			$size = $default_size / 10 * mt_rand(8, 12);
			$box = imageftbbox($size, $angle, $_font, $this->response[$i]);

			// Calculate character starting coordinates
			$x = $spacing / 4 + $i * $spacing;
			$y = Captcha::$config['height'] / 2 + ($box[2] - $box[5]) / 4;
			
			$text_color = imagecolorallocatealpha($this->image, mt_rand($color_limit + 8, 255), mt_rand($color_limit + 8, 255), mt_rand($color_limit + 8, 255), mt_rand(70, 120));
			$char = substr($chars, mt_rand(0, 14), 1);
			imagettftext($this->image, $size * 2, mt_rand(-45, 45), ($x - (mt_rand(5, 10))), ($y + (mt_rand(5, 10))), $text_color, $_font, $char);
		}
		
		
		//imagefilledrectangle($img2, 0, $height, $width-1, $height+12, $foreground);
		//$credits=empty($credits)?$_SERVER['HTTP_HOST']:$credits;
		//imagestring($img2, 2, $width/2-imagefontwidth(2)*strlen($credits)/2, $height-2, $credits, $background);
		

		// periods
		$rand1=mt_rand(750000,1200000)/10000000;
		$rand2=mt_rand(750000,1200000)/10000000;
		$rand3=mt_rand(750000,1200000)/10000000;
		$rand4=mt_rand(750000,1200000)/10000000;
		// phases
		$rand5=mt_rand(0,31415926)/10000000;
		$rand6=mt_rand(0,31415926)/10000000;
		$rand7=mt_rand(0,31415926)/10000000;
		$rand8=mt_rand(0,31415926)/10000000;
		// amplitudes
		$rand9=mt_rand(330,420)/110;
		$rand10=mt_rand(330,450)/110;
		
		//wave distortion

		for($x=0;$x<$width;$x++){
			for($y=0;$y<$height;$y++){
				$sx=$x+(sin($x*$rand1+$rand5)+sin($y*$rand3+$rand6))*$rand9-$width/2+$center+1;
				$sy=$y+(sin($x*$rand2+$rand7)+sin($y*$rand4+$rand8))*$rand10;

				if($sx<0 || $sy<0 || $sx>=$width-1 || $sy>=$height-1){
					continue;
				}else{
					$color=imagecolorat($img, $sx, $sy) & 0xFF;
					$color_x=imagecolorat($img, $sx+1, $sy) & 0xFF;
					$color_y=imagecolorat($img, $sx, $sy+1) & 0xFF;
					$color_xy=imagecolorat($img, $sx+1, $sy+1) & 0xFF;
				}

				if($color==255 && $color_x==255 && $color_y==255 && $color_xy==255){
					continue;
				}else if($color==0 && $color_x==0 && $color_y==0 && $color_xy==0){
					$newred=$foreground_color[0];
					$newgreen=$foreground_color[1];
					$newblue=$foreground_color[2];
				}else{
					$frsx=$sx-floor($sx);
					$frsy=$sy-floor($sy);
					$frsx1=1-$frsx;
					$frsy1=1-$frsy;

					$newcolor=(
						$color*$frsx1*$frsy1+
						$color_x*$frsx*$frsy1+
						$color_y*$frsx1*$frsy+
						$color_xy*$frsx*$frsy);

					if($newcolor>255) $newcolor=255;
					$newcolor=$newcolor/255;
					$newcolor0=1-$newcolor;

					$newred=$newcolor0*$foreground_color[0]+$newcolor*$background_color[0];
					$newgreen=$newcolor0*$foreground_color[1]+$newcolor*$background_color[1];
					$newblue=$newcolor0*$foreground_color[2]+$newcolor*$background_color[2];
				}

				imagesetpixel($this->image, $x, $y, imagecolorallocate($this->image, $newred, $newgreen, $newblue));
			}
		}
		
		return $this->image_render($html);
		
		//$this->image_create(Captcha::$config['background']);	
		
		
		
		
		
	}
	
}