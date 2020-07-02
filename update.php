<?php

use infrajs\db\Db;
use infrajs\path\Path;

$db = &Db::pdo();

$filesql = Path::theme('-city/cities.sql');
$sql = file_get_contents($filesql);
$db->exec($sql);
