<?php
use infrajs\rest\Rest;
use infrajs\path\Path;
use akiyatkin\city\City;
use infrajs\ans\Ans;
use infrajs\lang\Lang;

$ans = array();

// Блок с глобальными переменными 
$ans = [];
$lang = Ans::REQ('lang', City::$conf['lang']['list'], City::$conf['lang']['def']); //Для сайтов с 1 языком

$city_id = null;
$city = null;
$email = null;
$timezone = null;

$meta = Rest::meta();
if (!$meta) return City::fail($ans, $lang, 'lang.meta.i1');
$action = Rest::first();

if (!$action) {
    $ans['meta'] = $meta;
    return Ans::ret($ans);
}

if (!isset($meta['actions'][$action])) return City::fail($ans, $lang, 'lang.400.h1');
$handlers = $meta['actions'][$action]['handlers'] ?? [];





$root = Rest::getRoot();



$src = Path::theme($root . '/handlers.php');
$r = include($src);
if ($r !== 1) return $r;

$src = Path::theme($root . '/actions.php');
$r = include($src);
if ($r !== 1) return $r;



// if (!$action) {
//     $ans['meta'] = $meta;
//     return Ans::ret($ans);
// }
// $city_id = Ans::REQ('city_id','int');
// $ans['city'] = City::getById($city_id);
// return City::ret($ans);