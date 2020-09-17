

CREATE TABLE IF NOT EXISTS `city_cities` (
    `city_id` MEDIUMINT unsigned NOT NULL,
    `country_id` SMALLINT unsigned NOT NULL,
    `EngOblName` TINYTEXT NOT NULL,
    `OblName` TINYTEXT NOT NULL,
    `CityName` varchar(255) NOT NULL,
    `Center` int(1) unsigned NOT NULL DEFAULT 0,
    `EngName` varchar(255) NOT NULL,
    `FullName` TEXT NOT NULL,
    `EngFullName` TEXT NOT NULL,
    INDEX (`CityName`),
    INDEX (`EngName`),
    PRIMARY KEY (`city_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `city_indexes` (
    `index` INT(6) unsigned NOT NULL,
    `city_id` MEDIUMINT unsigned NOT NULL,
    INDEX (`city_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `city_countries` (
    `country_id` SMALLINT unsigned NOT NULL,
    `CountryName` TINYTEXT NOT NULL,
    `EngCountryName` TINYTEXT NOT NULL,
    PRIMARY KEY (`country_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;