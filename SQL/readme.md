# SQL

## Datenbank-Engine

### Leselastig
MyISAM storage engine

### Schreibelastig
INNODB storage engine


## Standardfelder für Zeitstempel
```sql
ALTER TABLE `mytable`
	ADD COLUMN `_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	ADD COLUMN `_updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
```

## LIKE
```sql
SELECT * 
FROM `mytable`
WHERE column LIKE '%". $querystring_special_chars ."%'
```

## SET
```sql
SELECT * 
FROM `mytable`
WHERE FIND_IN_SET('". $querystring ."', keywords) <> 0
```

## Lat/Lng Entfernung
```sql
$lat = 52.5243700;
$lng = 13.4105300;

SELECT (ACOS(SIN(RADIANS(lat)) * SIN(RADIANS(". $lat .")) + COS(RADIANS(lat)) * COS(RADIANS(". $lat .")) * COS(RADIANS(lng)- RADIANS(". $lng ."))) * 6380) as distance
```
