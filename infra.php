<?php

use infrajs\env\Env;
use infrajs\lang\Lang;
use infrajs\ip\IP;
use infrajs\config\Config;
use infrajs\template\Template;
use infrajs\event\Event;
use infrajs\db\Db;
use akiyatkin\city\City;

Env::add('city_id', function () {
	//FRONT-функция
	//$ip = '62.106.100.30';
	$ip = null;
	$city_id = City::get($ip);
	
	return $city_id;

}, function ($city_id) {
	$conf = Config::get('city');
	
	//1 если есть нужные данные
	if ((int) $city_id != $city_id) return false;
	
	//2 если есть список возможных городов, то город должен быть из этого списка. Достаточно совпадения из любого списка
	if ($conf['list']) return in_array($city_id, $conf['list']);
	
	//3 если указанный город есть в данных
	$lang = Lang::detect();
	
	$city = City::getById($city_id, $lang);
	if ($city) return true;
	return false;
});

Event::one('Controller.oninit', function () {
	Template::$scope['City'] = array();
	Template::$scope['City']['id'] = function () {
		return Env::get()['city_id'];
	};
	Template::$scope['City']['lang'] = function ($stren = null) {
		//Для контроллера функция
		$lang = Lang::name('city');
		if (is_null($stren)) return $lang;
		return City::lang($lang, $stren);
	};
});