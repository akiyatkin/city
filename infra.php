<?php

use infrajs\env\Env;
use infrajs\lang\Lang;
use infrajs\ip\IP;
use infrajs\config\Config;
use infrajs\event\Events;

Env::add('city', function () {
	//FRONT-функция
	//$ip = '62.106.100.30';
	$ip = $_SERVER['REMOTE_ADDR'];
	$data = IP::get($ip, 'en');//BACK-функция без параметров вернёт английский вариант
	
	$conf = Config::get('city');
	if (!in_array($data['city'], $conf['list'])) {
		$city = $conf['def'];
	} else {
		$city = $data['city'];	
	}
	return $city;
}, function ($city) {
	$conf = Config::get('city');
	return in_array($city, $conf['list']);
});
