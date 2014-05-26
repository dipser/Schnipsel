<?php
// Zeitstempel des aktuellen Tag um 0 Uhr
function timetodaystart($time = time()) {
	return strtotime(date('d.m.Y', $time));
}
?>