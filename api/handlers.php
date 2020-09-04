<?php

use infrajs\access\Access;
use akiyatkin\city\City;
use infrajs\lang\Lang;
use infrajs\ans\Ans;


if (!empty($handlers['debug'])) {
    if (!Access::isDebug()) return Lang::fail($ans, $lang, 'lang.debug.h1');
}
if (!empty($handlers['nostore'])) {
    header('Cache-Control: no-store');
}

if (!empty($handlers['post'])) {
	$submit = ($_SERVER['REQUEST_METHOD'] === 'POST' || Ans::GET('submit', 'bool'));
	if (!$submit) return Lang::fail($ans, $lang, 'lang.post.h1');
}

if (!empty($handlers['city'])) {
    $city_id = Ans::REQ('city_id');
    if ($city_id) $city = City::getById($city_id, $lang);
    if (!$city_id || !$city) return City::fail($ans, $lang, 'city_id.h1');
    $ans['city'] = $city;
}