SELECT * FROM `s2_r_events` WHERE section_id LIKE '32-%' AND (
(`start_date` BETWEEN '2015-04-27 00:00:00' AND '2015-05-04 00:00:00') OR
(`start_date` < '2015-04-27 00:00:00' AND `end_date` > '2015-05-04 00:00:00') OR
(`start_date` < '2015-04-27 00:00:00' AND `end_date` < '2015-05-04 00:00:00' AND `end_date` > '2015-04-27 00:00:00') OR
(`start_date` > '2015-04-27 00:00:00' AND `end_date` > '2015-05-04 00:00:00') AND `start_date` < '2015-05-04 00:00:00')
