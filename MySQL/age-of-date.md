```mysql
SELECT 
  TIMESTAMPDIFF(YEAR, `birthday`, CURDATE()) AS `age`
FROM YOUR_TABLE
```
