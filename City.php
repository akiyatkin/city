<?php
namespace infrajs\city;
use akiyatkin\boo\MemCache;
use infrajs\load\Load;
use infrajs\lang\Lang;
use akiyatkin\ip\IP;
use infrajs\config\Config;

class City {
	static public function get($ip = false){
		$data = IP::get($ip, 'en');
		$conf = Config::get('city');
		if (!in_array($data['city'], $conf['list'])) {
			$city = $conf['def'];
		} else {
			$city = $data['city'];	
		}
		return $city;
	}
}