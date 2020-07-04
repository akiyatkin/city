<?php

use infrajs\env\Env;
use infrajs\lang\Lang;
use infrajs\ip\IP;
use infrajs\config\Config;
use infrajs\event\Events;
use infrajs\db\Db;
use akiyatkin\city\City;

Env::add('city', function ($data) {
	//FRONT-функция
	//$ip = '62.106.100.30';
	$get = City::get();
	return $get['ru'];
}, function ($city) {
	$conf = Config::get('city');
	if ($conf['list']) return in_array($city, $conf['list']);

	$stmt = Db::stmt('SELECT city from cities where city = ?');
	$stmt->execute(array($city));
	$r = $stmt->fetchColumn();
	if ($r) return true; 
	
});
