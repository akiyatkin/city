<?php

namespace akiyatkin\city;

use akiyatkin\boo\MemCache;
use infrajs\load\Load;
use infrajs\sequence\Sequence;
use infrajs\lang\Lang;
use infrajs\config\Config;

use infrajs\lang\LangAns;
use infrajs\cache\CacheOnce;

class City
{
	public static $name = 'city';
	use LangAns;
	use CacheOnce;
	public static $conf = array();
	static public function read($ip = '')
	{
		$data = Load::loadJSON('-city/SxGeo/?ip=' . $ip);
		return $data;
	}
	static public function getById($city_id)
	{
		return City::get();
	}
	static public function get($ip = null)
	{
		//Язык определяется по данным в $_SERVER в расширении lang

		$data = City::read($ip);

		$ans = false;
		if (isset($data['city']['name_en']) && isset($data['city']['name_ru'])) {
			$ans = [
				'ip' => $ip,
				'def' => false,
				'ru' => $data['city']['name_ru'],
				'en' => $data['city']['name_en']
			];
		}

		$conf = City::$conf;
		if (!$ans || ($conf['list'] && !in_array($ans['ru'], $conf['list']))) {

			$ans = [
				'ip' => $ip,
				'def' => true,
				'ru' => $conf['defru'],
				'en' => $conf['defen']
			];
		}
		$ans['city_id'] = 1;
		$ans['name'] = 'Самарканд';
		return $ans;
	}
}
