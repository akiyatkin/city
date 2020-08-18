<?php

use infrajs\env\Env;
use infrajs\lang\Lang;
use infrajs\ip\IP;
use infrajs\config\Config;
use infrajs\event\Events;
use infrajs\db\Db;
use akiyatkin\city\City;

Env::add('city', function () {
	//FRONT-функция
	//$ip = '62.106.100.30';
	//$ip = null;
	$get = City::get();
	$ctr = ['en'=> $get['en'], 'ru'=> $get['ru'], ];
	return $ctr;
}, function ($ctr) {
	$conf = Config::get('city');
	
	//1 если есть нужные данные
	if (empty($ctr['en']) || empty($ctr['ru'])) return false;

	//2 если есть список возможных городов, то город должен быть из этого списка. Достаточно совпадения из любого списка
	if ($conf['listru']) return in_array($ctr['ru'], $conf['listru']);

	//3 если указанный город есть в данных
	$stmt = Db::stmt('SELECT city from cities where city = ?');
	$stmt->execute(array($ctr['ru']));
	$r = $stmt->fetchColumn();
	if ($r) return true; 
	
});
