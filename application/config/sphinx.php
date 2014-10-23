<?php

if(PHP_OS == 'WINNT') {
	$config = array
	(
		'host' => '192.168.0.87',
		'port' => 9312,
		'match_mode' => SPH_MATCH_ANY,
		'max_query_time' => 3
	);
}else {
	$config = array
	(
		'host' => 'localhost',
		'port' => 9312,
		'match_mode' => SPH_MATCH_ANY,
		'max_query_time' => 3
	);
}