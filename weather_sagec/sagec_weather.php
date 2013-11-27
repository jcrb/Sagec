<?php
/**
* sagec_weather.php
*/
require_once ('weather_report.php');

function getWeather($station)
{
	// strasbourg = LFST
	return get_weather('LFST,fr,show-date,temp-cf,dew-cf,pressure-hpa,wind-km,wind-dir,wind-dir-short,activity,,<br />,1,0');
}

?> 
