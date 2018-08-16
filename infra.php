<?php

use infrajs\env\Env;
use infrajs\lang\Lang;
use infrajs\ip\IP;
use infrajs\config\Config;
use infrajs\event\Events;

Env::add('city', function () {
	//FRONT-функция
	//$ip = '62.106.100.30';

	$city = City::get();
	
	return $city;
}, function ($city) {
	$conf = Config::get('city');
	return in_array($city, $conf['list']);
});
