<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * @package  Core
 *
 * Default language locale name(s).
 * First item must be a valid i18n directory name, subsequent items are alternative locales
 * for OS's that don't support the first (e.g. Windows). The first valid locale in the array will be used.
 * @see http://php.net/setlocale
 */
$config['language'] = array('ru_RU', 'RU');
//$config['language'] = array('en_US', 'English_United States');

$config['default_lang_code'] = 'ru';

/**
 * Locale timezone. Defaults to use the server timezone.
 * @see http://php.net/timezones
 */
$config['timezone'] = '';

$config['languages'] = array(
		'ua'=>array('uk_UA', 'UA'),
		'ru'=>array('ru_RU', 'RU'),
		'en'=>array('en_US', 'EN')
);

$config['lang_ids'] = array('ru'=>0, 'ua'=>1, 'en'=>2);



