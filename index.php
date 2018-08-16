<?php

use infrajs\rest\Rest;
use infrajs\access\Access;
use akiyatkin\city\City;
use infrajs\ans\Ans;

Access::test(true);

return Rest::get( function () {
	echo 'Пример теста <a href="/-city/85.114.185.182">85.114.185.182</a>';	
}, function($ip){
	$res = City::get($ip,'en');
	return Ans::ans($res);
});