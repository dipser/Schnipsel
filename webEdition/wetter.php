<?php

// Synchronsieren der OpenWeatherMap mit webEdition
// http://openweathermap.org

function owm_sync($classID, $ort) {

	// TODO: OWM Daten lesen
	$temperatur = 0;
	$auspraegung = 'Regen'


	$obj = new we_objectFile();
	$obj->we_new();
	$obj->TableID = $classID;
	$obj->setRootDirID(true);
	$obj->resetParentID();
	$obj->restoreDefaults();
	$obj->Text = date('Ymd-Hi');
	$obj->Path = date('Y/m/d/').$obj->getParentPath();
	$obj->setElement('Datum', time());
	$obj->setElement('Temperatur', $temperatur);
	$obj->we_save();
	$obj->we_publish();
}
owm_sync(1, 'Friesland');





?>