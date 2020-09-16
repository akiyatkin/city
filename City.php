<?php

namespace akiyatkin\city;

use akiyatkin\boo\MemCache;
use infrajs\load\Load;
use infrajs\sequence\Sequence;
use infrajs\lang\Lang;
use infrajs\config\Config;
use infrajs\db\Db;

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
	static public function getIdByName($city_name, $lang) {
		$colname = ($lang == 'ru') ? 'CityName' : 'EngName';
		return Db::col("SELECT city_id FROM city_cities WHERE $colname like :$colname LIMIT 0,1", [
			":$colname" => $city_name.'%'
		]);
	}
	static public function getById($city_id, $lang)
	{
		return static::once('getById', [$city_id, $lang], function ($city_id, $lang) {

			$colname = ($lang == 'ru') ? 'CityName' : 'EngName';
			$colobl = ($lang == 'ru') ? 'OblName' : 'EngOblName';
			$sql = "SELECT city_id, country_id, $colname as name FROM city_cities where city_id = :city_id";

			$city = Db::fetch($sql, [
				':city_id' => $city_id
			]);
			
			if ($city) {
				
				$city['city'] = explode(',', $city['name'])[0];
				$city['zip'] = Db::col('SELECT `index` from city_indexes where city_id = :city_id', [
					':city_id' => $city_id
				]);
				unset($city['name']);
			}
			return $city;
		});
	}
	
	static public function getIndexes($city_id) {
		$sql = "SELECT `index` FROM city_indexes WHERE city_id = :city_id
		order by `index` ASC
		";
		return Db::colAll($sql,[
			':city_id' => $city_id
		]);
	}
	static public function getCountryById($country_id, $lang) {
		$colname = ($lang == 'ru') ? 'CountryName' : 'EngCountryName';
		$sql = "SELECT country_id, $colname as name FROM city_countries WHERE country_id = :country_id";
		return Db::fetch($sql,[
			':country_id' => $country_id
		]);
	}
	static public function get($ip)
	{
		//Язык определяется по данным в $_SERVER в расширении lang

		$data = City::read($ip);
		if (empty($data['country']['name_ru'])) return City::$conf['def_city_id'];
		$country_id = Db::col("SELECT country_id FROM city_countries WHERE CountryName = :CountryName", [
			'CountryName' => $data['country']['name_ru']
		]);
		if (!$country_id) {
			$country_id = Db::col("SELECT country_id FROM city_countries WHERE EngCountryName = :EngCountryName", [
				'EngCountryName' => $data['country']['name_en']
			]);
		}
		if (!$country_id) return City::$conf['def_city_id'];

		$city_id = Db::col("SELECT city_id FROM city_cities WHERE country_id = :country_id and CityName like :CityName", [
			':country_id' => $country_id,
			':CityName' => $data['city']['name_ru'].'%'
		]);
		if (!$city_id) return City::$conf['def_city_id'];
		return $city_id;
	}
}
