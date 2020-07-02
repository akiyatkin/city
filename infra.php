<?php

use infrajs\env\Env;
use infrajs\lang\Lang;
use infrajs\ip\IP;
use infrajs\config\Config;
use infrajs\event\Events;
use akiyatkin\city\City;

Env::add('city', function ($data) {
	//FRONT-функция
	$ip = '62.106.100.30';
	//$ip = null;
	$get = City::get($ip);
	return $get['ru'];
}, function ($city) {
	$conf = Config::get('city');
	if (empty($conf['list'])) return true;
	return in_array($city, $conf['list']);
});
