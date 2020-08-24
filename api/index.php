<?php

use akiyatkin\city\City;
use infrajs\ans\Ans;

$ans = array();
$city_id = Ans::REQ('city_id','int');
$ans['city'] = City::getById($city_id);
return City::ret($ans);