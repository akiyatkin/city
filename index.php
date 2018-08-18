<?php

use infrajs\rest\Rest;
use infrajs\access\Access;
use akiyatkin\city\City;
use infrajs\ans\Ans;
use infrajs\config\Config;
use infrajs\ip\IP;

Access::test(true);

return Rest::get( function () {
	echo 'Пример <a href="/-city/85.114.185.182">85.114.185.182</a>, <a href="/-city/true/ru">true</a>';	
}, function($ip, $lang = 'en'){
	if ($ip == 'true') $ip = null;
	$ans = array();
	
	$conf = Config::get('city');
	$ans['city'] = City::read($ip, $lang);
	$ans['conflist'] = $conf['list'];
	$ans['confdef'] = $conf['def'];
	$ans['ip'] = IP::get($ip, $lang);
	return Ans::ans($ans);
});