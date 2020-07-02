<?php
use infrajs\ans\Ans;
use infrajs\path\Path;

// Подключаем SxGeo.php класс
Path::req("-city/SxGeo/SxGeo.php");
// Создаем объект
// Первый параметр - имя файла с базой (используется оригинальная бинарная база SxGeo.dat)
// Второй параметр - режим работы: 
//     SXGEO_FILE   (работа с файлом базы, режим по умолчанию); 
//     SXGEO_BATCH (пакетная обработка, увеличивает скорость при обработке множества IP за раз)
//     SXGEO_MEMORY (кэширование БД в памяти, еще увеличивает скорость пакетной обработки, но требует больше памяти)

$src = Path::theme('~SxGeoCity.dat');
if (!$src) {
    $ans = [];
    return Ans::err($ans, 'Ошибка, нет данных');
}
$SxGeo = new SxGeo($src);
//$SxGeo = new SxGeo('SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY); // Самый производительный режим, если нужно обработать много IP за раз


if (!empty($_GET['ip'])) $ip = $_GET['ip'];
else $ip = $_SERVER['REMOTE_ADDR'];


//if ($ip == '127.0.0.1') $ip = '81.28.168.100';

$data = $SxGeo->getCityFull($ip); // Вся информация о городе
//var_export($SxGeo->get($ip));         // Краткая информация о городе или код страны (если используется база SxGeo Country)
//var_export($SxGeo->about());          // Информация о базе данных
$data['ip'] = $ip;
return Ans::ans($data);