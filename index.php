<?php

use infrajs\rest\Rest;
use infrajs\access\Access;
use akiyatkin\city\City;
use infrajs\ans\Ans;
use infrajs\nostore\Nostore;
use infrajs\config\Config;
use infrajs\ip\IP;

//Access::test(true);

return Rest::get( function ($ip = null) {
	if (!$ip) Nostore::on();
	$ans = array();
	$ans['read'] = City::read($ip);
	$ans['get'] = City::get($ip);
	return Ans::ans($ans);
},'get', function ($get, $ip = null) {
	if (!$ip) Nostore::on();
	$ans = City::get($ip);
	return Ans::ans($ans);
});