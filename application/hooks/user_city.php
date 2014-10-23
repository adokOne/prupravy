<?php

Event::add('system.post_routing' ,'set_usercity');

function set_usercity(){
	
	$city = (string) cookie::get('current_city');
	if(!$city){
		$current_city = Kohana::config('locale.default_city');
		$current_city_id = Kohana::config('locale.default_city_id');
	} else {
		$data = explode(":", $city);
		$current_city = $data[1];
		$current_city_id = $data[0];
	}
	Kohana::config_set('locale.current_city', $current_city);
    Kohana::config_set('locale.current_city_id', $current_city_id);
	
	cookie::set('current_city', "{$current_city_id}:{$current_city}", 15768000);
}