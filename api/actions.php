<?php

use akiyatkin\city\City;
use akiyatkin\fs\FS;
use infrajs\db\Db;
use infrajs\path\Path;
use infrajs\load\Load;
use infrajs\excel\Xlsx;
use infrajs\ans\Ans;


$dir = '~CDEK_city/';
if ($action == 'countries') {
    $colname = ($lang == 'ru') ? 'CountryName' : 'EngCountryName';
    $sql = "SELECT country_id, $colname as name FROM city_countries ORDER BY $colname";
    $ans['countries'] = Db::all($sql);
    return City::ret($ans);
} else if ($action == 'search') {
    $val = Ans::REQ('val','string');
    $country_id = Ans::REQ('country_id', 'int');
    if (!$country_id) return City::fail($ans, $lang, 'country_id.a4');
    $country = City::getCountryById($country_id, $lang);
    if (!$country) return City::fail($ans, $lang, 'country_id.a3');
    
    //$ans['country_id'] = $country_id;

    $colname = ($lang == 'ru') ? 'CityName' : 'EngName';
    $colobl = ($lang == 'ru') ? 'OblName' : 'EngOblName';

    $sql = "SELECT city_id, $colname as name, $colobl as region, Center
        FROM city_cities
        WHERE country_id = :country_id and $colname like :val
        ORDER BY Center DESC, city_id, $colname
        LIMIT 0,10
        ";
    $cities = Db::all($sql, [
        ':val' => $val.'%',
        ':country_id' => $country_id
    ]);
    $ans['cities'] = $cities;

     return City::ret($ans);
} else if ($action == 'get') {
    $city_id = Ans::REQ('city_id', 'int');
    if (!$city_id) return City::fail($ans, $lang, 'city_id.a1');
    $city = City::getById($city_id, $lang);
	
    $ans['city'] = $city;
    return City::ret($ans);
} else if ($action == 'cities') {
    $country_id = Ans::REQ('country_id', 'int');
    if (!$country_id) return City::fail($ans, $lang, 'country_id.a2');
    $colname = ($lang == 'ru') ? 'CityName' : 'EngName';
    $colfull = ($lang == 'ru') ? 'FullName' : 'EngName';
    $colobl = ($lang == 'ru') ? 'OblName' : 'EngOblName';
    $sql = "SELECT city_id, $colname as name, $colfull as full, $colobl as region FROM city_cities WHERE country_id = :country_id";
    $ans['list'] = Db::all($sql, [
        ':country_id' => $country_id
    ]);
    return City::ret($ans);
} else if ($action == 'update-sql') {
    /* Создать базу данных и заного загрузить все Excel данные*/
    //City::update();

    $filesql = Path::theme('-city/update.sql');
    $sql = file_get_contents($filesql);

    $r = Db::exec($sql) !== false;

    if (!$r) return City::fail($ans, $lang, 'lang.db.a1');

    return City::ret($ans);
} else if ($action == 'update-load') {
    $files = FS::scandir($dir, function ($file) {
        $ext = Path::getExt($file);
        if ($ext !== 'xls') return false;
    });
    Db::exec('TRUNCATE city_cities');
    Db::exec('TRUNCATE city_countries');
    Db::exec('TRUNCATE city_indexes');

    foreach ($files as $file) {
        $data = Xlsx::get($dir . $file);
        $rows = $data['childs'][0]['data'];
        foreach ($rows as $row) {
            if ($row['CityName'] === "1") continue;

            if (in_array($row['CityName'], [
                "1", "Авиа карго", "Тара многоборотная","5663234234",
                "Москва (Предпочтовая подготовка)",
                "Москва, Международная сортировка",
                "Минск Национальный Аэропорт Минск-2"
            ])) continue;
            
            if (City::$conf['def_city_id'] == $row['ID']) $row['Center'] = 1;

            $sql = 'INSERT IGNORE INTO city_countries (country_id, CountryName, EngCountryName) 
			        VALUES(:country_id, :CountryName, :EngCountryName)';

            Db::exec($sql, [
                ':country_id' => $row['CountryCode'],
                ':CountryName' => $row['CountryName'],
                ':EngCountryName' => $row['EngCountryName']
            ]);

            $sql = 'INSERT IGNORE INTO city_cities (city_id, FullName, CityName, Center, OblName, EngOblName, EngName, EngFullName, country_id) 
                    VALUES(:city_id, :FullName, :CityName, :Center, :OblName, :EngOblName, :EngName, :EngFullName, :country_id)';
            Db::exec($sql, [
                ':city_id' => $row['ID'],
                ':OblName' => $row['OblName'] ?? '',
                ':EngOblName' => $row['EngOblName'] ?? '',
                ':FullName' => $row['FullName'],
                ':CityName' => $row['CityName'],
                ':Center' => $row['Center'] ?? 0 ? 1 : 0,
                ':EngName' => $row['EngName'] ?? Path::encode($row['CityName']),
                ':EngFullName' => $row['EngFullName'] ?? Path::encode($row['FullName']),
                ':country_id' => $row['CountryCode']
            ]);

            if (isset($row['PostCodeList'])) {
                //Индекс может быть для двух городов 1.
                $indexes = explode(',', $row['PostCodeList']);
                $sql = 'INSERT INTO city_indexes (city_id, `index`) 
                        VALUES(:city_id, :index)';
                foreach ($indexes as $index) {
                    if ($index == '000001') continue;
                    $r = Db::exec($sql, [
                        ':city_id' => $row['ID'],
                        ':index' => $index
                    ]);
                }
            }
        }
    }

    return City::ret($ans);
} else if ($action == 'update-list') {
    $files = FS::scandir($dir, function ($file) {
        $ext = Path::getExt($file);
        if ($ext !== 'xls') return false;
    });
    $list = [];
    foreach ($files as $file) {
        $data = Xlsx::get($dir . $file);
        $len = sizeof($data['childs'][0]['data']);
        $list[$file] = $len;
    }
    $ans['list'] = $list;
    return City::ret($ans);
}
