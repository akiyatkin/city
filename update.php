<?php

use infrajs\db\Db;

$db = Db::pdo();
Db::exec('TRUNCATE cities');
$sql = FS::file_get_contents('-city/cities.sql');
Db::exec($sql);