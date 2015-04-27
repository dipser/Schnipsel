Beispiel:
SELECT * FROM `s2_r_events` WHERE
(
	(`start_date` BETWEEN '2015-04-27 00:00:00' AND '2015-05-04 00:00:00') OR
	(`start_date` < '2015-04-27 00:00:00' AND `end_date` > '2015-05-04 00:00:00') OR
	(`start_date` < '2015-04-27 00:00:00' AND `end_date` < '2015-05-04 00:00:00' AND `end_date` > '2015-04-27 00:00:00') OR
	(`start_date` > '2015-04-27 00:00:00' AND `end_date` > '2015-05-04 00:00:00' AND `start_date` < '2015-05-04 00:00:00')
)


PDO:
SELECT * FROM `table` WHERE 
(
	(`start_date` BETWEEN :start_date AND :end_date) OR
	(`start_date` < :start_date AND `end_date` > :end_date) OR
	(`start_date` < :start_date AND `end_date` < :end_date AND `end_date` > :start_date) OR
	(`start_date` > :start_date AND `end_date` > :end_date AND `start_date` < :end_date)
)

// Hinweis: Fall 3 und 4 könnten noch mit BETWEEN zusammengefasst werden
