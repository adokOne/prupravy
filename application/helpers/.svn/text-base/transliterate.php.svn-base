<?php
class transliterate_Core {
	public static function render($st, $level=0){
		if ($level) $st = preg_replace('/^.*::/Us', '', $st);
	    $st = trim($st);
			
		$st = preg_replace('/ий(?=\s)/Us', 'y', $st);
	
		$cyr = array("а","б","в","г","д","е","ж","з","и","й","к","л","м","н","о","п","р","с","т","у","ф","ы","э","А","Б","В","Г","Д","Е","Ж","З","И","Й","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Ы","Э");
		$eng = array("a","b","v","g","d","e","g","z","i","y","k","l","m","n","o","p","r","s","t","u","f","i","e","A","B","V","G","D","E","G","Z","I","Y","K","L","M","N","O","P","R","S","T","U","F","I","E");
		$st = str_replace($cyr, $eng, $st);
			
		$trn = array(
	    	'ё' => "yo",
	        'х' => "h",
	        'ц' => "ts",
	        'ч' => "ch",
	        'ш' => "sh",
	        'щ' => "shch",
	        'ъ' => '',
	        'ь' => '',
	        'ю' => "yu",
	        'я' => "ya",
	        'Ё' => "YO",
	        'Х' => "H",
	        'Ц' => "TS",
	        'Ч' => "CH",
	        'Ш' => "SH",
	        'Щ' => "SHCH",
	        'Ъ' => '',
	        'Ь' => '',
	        'Ю' => "YU",
	        'Я' => "YA",
			' ' => '-'
		);
		$st = str_replace(array_keys($trn), array_values($trn) ,$st);
		$st = mb_strtolower($st);
		$st = preg_replace('/[^a-z0-9-_+]+/U', ' ', $st);
		$st = preg_replace('/^ +| +$/Us', '', $st);
		$st = str_replace(" ", "", ucwords($st));
		if ($st === "") $st = "empty";
	    return $st;
	}
	
	
	public static function get_seo_name($city_id,$district_id,$street='',$type,$apartment_type,$id,$rent_by_day='') {
	    	
		    	$districts = Database::instance()->from('districts')->get();
		    	foreach($districts as $d){
		    		$district[$d->id]=self::render($d->name);
		    	}
		    	$citys=Database::instance()->from('cities')->get();
		    	foreach($citys as $s){
		    		$city[$s->id]=self::render($s->name);
		    	}
	    		switch($type){
	    			case 'sale'      : $first="prodam-";break;
	    			case 'apartment' : $first="sday-";break;
	    			case 'want_rent' : $first="snimy-";break;
	    		}
	    		
	    		if($rent_by_day==0 && $first!='snimy-' && $first!='prodam-'){
	    			$second='dolgosrochno-';
	    		}
	    		elseif($rent_by_day==1 && $first!='snimy-' && $first!='prodam-') {
	    			$second='posytochno-';
	    		}
	    		else {
	    			$second='';
	    		}
	    		
	    		
	    		if($apartment_type==0){
	    			$third="kvartiry-";
	    		}
	    		else{
	    			$third="osobnyak-";
	    		}
	    		
	    		$fourth="v-gorode-".$city[$city_id]."-";
	    		
	    		$fifth="v-rayone-".$district[$district_id];
	    		if($first=='snimy-'){
	    			$six='';
	    		}
	    		else{
	    			$six="-".self::render($street);
	    		}
	    		$seo_name=$first.$second.$third.$fourth.$fifth.$six;
	    		
	    		return $seo_name;
	    }
	
	
	
}