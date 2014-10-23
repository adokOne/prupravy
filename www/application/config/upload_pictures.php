<?php 

$config['photos_extension'] = array('.jpg', '.png', '.gif');

$config['sizes'] = array
(	
	array('width' => 480, 'height' => 319, 'prefix' => 'h_', 'suffix' => '_h', 'crop' => false, 'watermark' => false),
	array('width' => 160, 'height' => 106, 'prefix' => 'p_', 'suffix' => '_p', 'crop' => false, 'watermark' => false),
	array('width' => 105, 'height' => 70, 'prefix' => 'm_', 'suffix' => '_m', 'crop' => false, 'watermark' => false),
    array('width' => 480, 'height' => 319, 'prefix' => 't_', 'suffix' => '_t', 'crop' => false, 'watermark' => false),
	array('width' => 980, 'height' => 497, 'prefix' => 'w_', 'suffix' => '_w', 'crop' => false, 'watermark' => false),
	array('width' => 190, 'height' => 131, 'prefix' => 'a_', 'suffix' => '_a', 'crop' => false, 'watermark' => false)
);

$config['items_per_page'] = 5; 