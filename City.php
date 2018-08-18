<?php
namespace akiyatkin\city;
use akiyatkin\boo\MemCache;
use infrajs\load\Load;
use infrajs\lang\Lang;
use infrajs\ip\IP;
use infrajs\config\Config;

class City {
	static public function read($ip, $lang = 'en') {
		$data = IP::get($ip, $lang);
		return $data['city'];
	}
	static public function get($ip = false){
		$city = City::read($ip);
		
		$conf = Config::get('city');
		if (!$city || !in_array($city, $conf['list'])) return $conf['def'];
		
		return $city;
	}
}