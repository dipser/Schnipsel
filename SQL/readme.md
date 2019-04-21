# SQL


## LIKE
```sql
SELECT * 
FROM table
WHERE column LIKE '%". $querystring_special_chars ."%'
```

## SET
```sql
SELECT * 
FROM table
WHERE FIND_IN_SET('". $querystring ."', keywords) <> 0
```

## Lat/Lng Entfernung
```sql
$lat = 52.5243700;
$lng = 13.4105300;

SELECT (ACOS(SIN(RADIANS(lat)) * SIN(RADIANS(". $lat .")) + COS(RADIANS(lat)) * COS(RADIANS(". $lat .")) * COS(RADIANS(lng)- RADIANS(". $lng ."))) * 6380) as distance
```
