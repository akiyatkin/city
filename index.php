<?php

use infrajs\rest\Rest;
use infrajs\access\Access;
use akiyatkin\city\City;
use infrajs\ans\Ans;
use infrajs\config\Config;

Access::test(true);

return Rest::get( function () {
	echo 'Пример теста <a href="/-city/85.114.185.182">85.114.185.182</a>';	
}, function($ip){
	$ans = array();
	$ans['ip'] = $ip;
	$conf = Config::get('city');
	$ans['res'] = City::get($ip,'en');
	$ans['conf'] = $conf;
	return Ans::ans($ans);
});