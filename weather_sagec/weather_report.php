<?php
/*---------------------------------------------------------------------------------------------
Plugin Name: WeatherReport
Author: pericat
Author URI: http://pericat.ca/
Version: 3.0b
Description: Given an ICAO station plus a host of options as documented in the readme, pulls a METAR from the NWS server, decodes it, and displays the result. See readme for details.
Date: 30 August 2005

See the readme for an explanation of the options below, as well as usage notes.
Update notes consolidated into readme.

---------------------------------------------------------------------------------------------*/

/* WordPress Users - uncomment the next six lines. ------------------------------------------*/
//require_once (ABSPATH . 'wp-config.php');
//$server		= DB_HOST;
//$loginsql		= DB_USER;
//$passsql		= DB_PASSWORD;
//$base			= DB_NAME;
/*--------------------------------------------------------------------------------------------*/

/* Non-WordPress Users - uncomment the next four lines. Fill in your database info. ----------*/

$server		= 'localhost';		// should be localhost unless your setup is unusual
$loginsql		= 'root';				// your database's login user name
$passsql		= '';				// your database's login password
$base			= 'pma2';				// your database

/*
$server		= 'localhost';		// should be localhost unless your setup is unusual
$loginsql		= 'sagec67';				// your database's login user name
$passsql		= 'Kroute67';				// your database's login password
$base			= 'pma';				// your database
*/
/*--------------------------------------------------------------------------------------------*/

/*---------------database related settings ---------------------------------------------------*/
define ('NOTIMEOUT', -1);

$glopstable		= 'wp_weather_report';	
$shelfdate		= '3600';

/*--------------------------------------------------------------------------------------------*/

/*-------------- required files --------------------------------------------------------------*/

define ('WR_DIR', dirname(__FILE__));
define ('WR_SUPPORT', '/wr-weather/');

require_once ( WR_DIR . WR_SUPPORT . 'wr-temperature.php');
require_once ( WR_DIR . WR_SUPPORT . 'wr-activity.php');
require_once ( WR_DIR . WR_SUPPORT . 'wr-sky.php');
require_once ( WR_DIR . WR_SUPPORT . 'wr-remarks.php');
require_once ( WR_DIR . WR_SUPPORT . 'wr-doreport.php');
require_once ( WR_DIR . WR_SUPPORT . 'wr-en.php');

/*--------------------------------------------------------------------------------------------*/

/*-------------- optional language support files ---------------------------------------------*/
@include_once ( WR_DIR . WR_SUPPORT . 'wr-fr.php');
@include_once ( WR_DIR . WR_SUPPORT . 'wr-pt.php');

/*--------------------------------------------------------------------------------------------*/


function get_weather($weatherargs) {
	global $aboutwr, $server, $loginsql, $passsql, $base, $glopstable, $shelfdate;
	global $weather, $station, $displayheads, $breakafterhead, $noreport, $language;
	
	$weather = '';
	$formatted = '';
	$glops = '';

	$optionslist = explode (',', $weatherargs);
	$opt_count = count($optionslist);
	$opt_count--;
	$opt_index = 0;
	
	if (ereg('(^[A-Z0-9]{4}$)', $optionslist[$opt_index])) {
		$station = $optionslist[$opt_index];
		$opt_index++;
	} else {
		$station = '';
	}
	
	if (ereg('(^[a-z]{2}$)', $optionslist[$opt_index])) {
		$languagefile = WR_DIR . WR_SUPPORT . "wr-" . $optionslist[$opt_index] . ".php";
		if (file_exists($languagefile)) {
			$language = $optionslist[$opt_index];
			$opt_index++;
		} else {
			$language = 'en';
		}
	} else {
		$language = 'en';
	}
	
	$localised = "set_global_phrases_" . $language;
	$localised();
	
	if ($optionslist[$opt_count] != 'fetch-only') {
		if (ereg('(^[0-1]{1}$)', $optionslist[$opt_count])) {
			$breakafterhead = $optionslist[$opt_count];
			$opt_count--;
		} else {
			$breakafterhead = true;
		}
		
		if (ereg('(^[0-1]{1}$)', $optionslist[$opt_count])) {
			$displayheads = $optionslist[$opt_count];
			$opt_count--;
		} else {
			$displayheads = true;
		}
		
		$suffix = $optionslist[$opt_count] . "\n";
		$opt_count--;
		$prefix = $optionslist[$opt_count];
		$opt_count--;
	} else {
		$shelfdate = 0;
	}

// next lines used for debugging. uncomment one to test multiple options without downloading METARs by
// the bucketful, and comment out the real call below.

//	$glops = '2004/05/26 17:30 CYVR 261730Z 04035G55KT 210V270 10SM R27/0300U R32/0150UP0200 -SHRA FEW022 BKN043 OVC100 15/13 A2993 RMK 20032 10035 CF2SC3AS3 CB SLP137';
//	$glops = 'CYVR 010430Z 24035G55KT 210V270 10SM R27/0300U R32/0150UP0200 -SHRA FEW022 BKN043 OVC100 15/13 A2993 RMK 20032 10035 CF2SC3AS3 CB SLP137';


	if (!$station && !$glops) {
		return ($prefix . $noreport . $suffix);
	}

	$glops = fetch_old_metar($shelfdate, $station, $glopstable, $server, $loginsql, $passsql, $base);

														//Nothing in database or expired;
														//try to fetch a new metar from NWS.
														
														//If that doesn't work out, exit while
														//casting blame on user.
														
														//If we do get a new glops successfully,
														//archive that puppy and move on.
	if (empty($glops)) {
		$glops = get_metar_file($station);
		
		if (!empty($glops)) {
			archive_glops($glops, $station, $glopstable, $server, $loginsql, $passsql, $base);
		} else {
			$glops = fetch_old_metar('-1', $station, $glopstable, $server, $loginsql, $passsql, $base);
			if (empty($glops)) {
				return ($prefix . $noreport . $suffix);
			}
		}
		
	}
	
	$weather['glops'] = $glops;
	$parts = explode(' ', $glops);
	$part_count = count($parts);
	$formatted = '';
	
	for($i = $opt_index; $i <= $opt_count; $i++) {
		$option = $optionslist[$i];
		switch ($option) {
			case 'show-glops':
				$formatted .= do_metar ($glops, $suffix, $prefix);
				break;
				
			case 'show-date':
				if (is_numeric($optionslist[$i+1])) {
					$i++;
					$zoneoffset = $optionslist[$i];
				}
				
				$zed = eval_date($parts, $part_count, $zoneoffset);
				
				if ($zed) {
					if($zoneoffset != "") {
						$localised = "format_local_date_" . $language;
						$returnvals['zed'] = $localised($zed, $zoneoffset);
						if ($returnvals['zed']) {
							$formatted .= $prefix . $returnvals['zed'] . $suffix;
						}
					} else {	
						$localised = "format_zed_date_" . $language;
						$returnvals['zed'] = $localised($zed, $zoneoffset);
						if ($returnvals['zed']) {
							$formatted .= $prefix . $returnvals['zed'] . $suffix;
						}
					}
				}
				break;
				
			case 'show-loc':
				$wrstation['id'] = $station;
				$wrstation['loc'] = '';
				$wrstation = recheckstation($wrstation);
				
				if($wrstation['loc']) {
					$formatted .= $prefix . $wrstation['loc'] . $suffix;
				}
				break;
				
			case 'temp-fc':
				eval_temperature($parts, $part_count);
				$returnvals['temperature'] = format_temps('temp-fc');

				$formatted .= do_temps ($returnvals['temperature'], $suffix, $prefix);

				break;
				
			case 'temp-cf':
				eval_temperature($parts, $part_count);
				$returnvals['temperature'] = format_temps('temp-cf');

				$formatted .= do_temps ($returnvals['temperature'], $suffix, $prefix);

				break;
				
			case 'dew-fc':
				eval_temperature($parts, $part_count);
				$returnvals['dewpoint'] = format_temps('dew-fc');

				$formatted .= do_dewpoint ($returnvals['dewpoint'], $suffix, $prefix);

				break;
				
			case 'dew-cf':
				eval_temperature($parts, $part_count);
				$returnvals['dewpoint'] = format_temps('dew-cf');

				$formatted .= do_dewpoint ($returnvals['dewpoint'], $suffix, $prefix);

				break;
				
			case 'minmax6h-fc':
				eval_minmax_temp($parts, $part_count);
				$returnvals['minmax6temps'] = format_minmaxtemps('minmax6h-fc');

				$formatted .= do_minmax6 ($returnvals['minmax6temps'], $suffix, $prefix);

				break;
				
			case 'minmax6h-cf':
				eval_minmax_temp($parts, $part_count);
				$returnvals['minmax6temps'] = format_minmaxtemps('minmax6h-cf');

				$formatted .= do_minmax6 ($returnvals['minmax6temps'], $suffix, $prefix);

				break;
				
			case 'minmax24h-fc':
				eval_minmax_temp($parts, $part_count);
				$returnvals['minmax24temps'] = format_minmaxtemps('minmax24h-fc');

				$formatted .= do_minmax24 ($returnvals['minmax24temps'], $suffix, $prefix);

				break;
				
			case 'minmax24h-cf':
				eval_minmax_temp($parts, $part_count);
				$returnvals['minmax24temps'] = format_minmaxtemps('minmax24h-cf');

				$formatted .= do_minmax24 ($returnvals['minmax24temps'], $suffix, $prefix);

				break;
				
			case 'rel-hum':
				calc_rel_humidity($parts, $part_count);
				$returnvals['rel_humidity'] = format_rel_humidity();

				$formatted .= do_relative_humidity ($returnvals['rel_humidity'], $suffix, $prefix);

				break;
				
			case 'hum-index-cf':
				calc_humidity($parts, $part_count);
				$returnvals['humidity'] = format_humidity('hum-index-cf');

				$formatted .= do_humidity ($returnvals['humidity'], $suffix, $prefix);

				break;

			case 'hum-index-fc':
				calc_humidity($parts, $part_count);
				$returnvals['humidity'] = format_humidity('hum-index-fc');

				$formatted .= do_humidity ($returnvals['humidity'], $suffix, $prefix);

				break;

			case 'heat-index-cf':
				calc_heat_index($parts, $part_count);
				$returnvals['heat_index'] = format_heat_index('heat-index-cf');

				$formatted .= do_heat_index ($returnvals['heat_index'], $suffix, $prefix);

				break;

			case 'heat-index-fc':
				calc_heat_index($parts, $part_count);
				$returnvals['heat_index'] = format_heat_index('heat-index-fc');

				$formatted .= do_heat_index ($returnvals['heat_index'], $suffix, $prefix);

				break;

			case 'windchill-cf':
				calc_windchill($parts, $part_count);
				$returnvals['windchill'] = format_windchill('windchill-cf');

				$formatted .= do_windchill ($returnvals['windchill'], $suffix, $prefix);

				break;

			case 'windchill-fc':
				calc_windchill($parts, $part_count);
				$returnvals['windchill'] = format_windchill('windchill-fc');

				$formatted .= do_windchill ($returnvals['windchill'], $suffix, $prefix);

				break;

			case 'pressure-inhg':
				eval_pressure($parts, $part_count);
				$returnvals['pressure'] = format_pressure('pressure-inhg');
				
				$formatted .= do_pressure ($returnvals['pressure'], $suffix, $prefix);

				break;

			case 'pressure-mmhg':
				eval_pressure($parts, $part_count);
				$returnvals['pressure'] = format_pressure('pressure-mmhg');
				
				$formatted .= do_pressure ($returnvals['pressure'], $suffix, $prefix);

				break;

			case 'pressure-atm':
				eval_pressure($parts, $part_count);
				$returnvals['pressure'] = format_pressure('pressure-atm');
				
				$formatted .= do_pressure ($returnvals['pressure'], $suffix, $prefix);

				break;

			case 'pressure-hpa':
				eval_pressure($parts, $part_count);
				$returnvals['pressure'] = format_pressure('pressure-hpa');
				
				$formatted .= do_pressure ($returnvals['pressure'], $suffix, $prefix);

				break;

			case 'pressure-inhg-hpa':
				eval_pressure($parts, $part_count);
				$returnvals['pressure'] = format_pressure('pressure-inhg-hpa');
				
				$formatted .= do_pressure ($returnvals['pressure'], $suffix, $prefix);

				break;

			case 'pressure-inhg-hpa-atm':
				eval_pressure($parts, $part_count);
				$returnvals['pressure'] = format_pressure('pressure-inhg-hpa-atm');
				
				$formatted .= do_pressure ($returnvals['pressure'], $suffix, $prefix);

				break;

			case 'pressure-inhg-mmhg-hpa-atm':
				eval_pressure ($parts, $part_count);
				$returnvals['pressure'] = format_pressure('pressure-inhg-mmhg-hpa-atm');
				
				$formatted .= do_pressure ($returnvals['pressure'], $suffix, $prefix);

				break;
			
			case 'pressurelong-inhg':
				eval_pressure_long ($parts, $part_count);
				$returnvals['pressurelong'] = format_pressure_long ('pressurelong-inhg');
				
				$formatted .= do_pressurelong ($returnvals['pressurelong'], $suffix, $prefix);
				
				break;

			case 'pressurelong-mmhg':
				eval_pressure_long ($parts, $part_count);
				$returnvals['pressurelong'] = format_pressure_long ('pressurelong-mmhg');
				
				$formatted .= do_pressurelong ($returnvals['pressurelong'], $suffix, $prefix);
				
				break;

			case 'pressurelong-hpa':
				eval_pressure_long ($parts, $part_count);
				$returnvals['pressurelong'] = format_pressure_long ('pressurelong-hpa');
				
				$formatted .= do_pressurelong ($returnvals['pressurelong'], $suffix, $prefix);
				
				break;

			case 'pressurelong-atm':
				eval_pressure_long ($parts, $part_count);
				$returnvals['pressurelong'] = format_pressure_long ('pressurelong-atm');
				
				$formatted .= do_pressurelong ($returnvals['pressurelong'], $suffix, $prefix);
				
				break;

			case 'pressurelong-inhg-hpa':
				eval_pressure_long ($parts, $part_count);
				$returnvals['pressurelong'] = format_pressure_long ('pressurelong-inhg-hpa');
				
				$formatted .= do_pressurelong ($returnvals['pressurelong'], $suffix, $prefix);
				
				break;

			case 'pressurelong-inhg-hpa-atm':
				eval_pressure_long ($parts, $part_count);
				$returnvals['pressurelong'] = format_pressure_long ('pressurelong-inhg-hpa-atm');
				
				$formatted .= do_pressurelong ($returnvals['pressurelong'], $suffix, $prefix);
				
				break;

			case 'pressurelong-inhg-mmhg-hpa-atm':
				eval_pressure_long ($parts, $part_count);
				$returnvals['pressurelong'] = format_pressure_long ('pressurelong-inhg-mmhg-hpa-atm');
				
				$formatted .= do_pressurelong ($returnvals['pressurelong'], $suffix, $prefix);
				
				break;

			case 'activity':
				eval_sky_short ($parts, $part_count);
				
				$localised = "format_sky_short_" . $language;
				$returnvals['sky'] = $localised();

				$conditions = eval_activity($parts, $part_count);
				
				$returnvals['activity'] = format_activity($conditions, $returnvals['sky']);

				$formatted .= do_activity ($returnvals['activity'], $suffix, $prefix);

				break;
				
			case 'visibility-kmmi':
				eval_visibility ($parts, $part_count);
				$returnvals['visibility'] = format_visibility('visibility-kmmi');

				$formatted .= do_visibility ($returnvals['visibility'], $suffix, $prefix);

				break;
			
			case 'visibility-mikm':
				eval_visibility ($parts, $part_count);
				$returnvals['visibility'] = format_visibility('visibility-mikm');

				$formatted .= do_visibility ($returnvals['visibility'], $suffix, $prefix);

				break;
			
			case 'precip-inmm':
				eval_precip($parts, $part_count);
				
				$returnvals['precip'] = format_precip ('precip-inmm');
				$formatted .= do_precip ($returnvals['precip'], $suffix, $prefix);

				$returnvals['snow'] = format_snow('precip-inmm');
				$formatted .= do_snow ($returnvals['snow'], $suffix, $prefix);
		
				$returnvals['water_equiv'] = format_water_equiv ('precip-inmm');
				$formatted .= do_waterequiv ($returnvals['water_equiv'], $suffix, $prefix);

				break;
			
			case 'precip-mmin':
				eval_precip($parts, $part_count);
				
				$returnvals['precip'] = format_precip('precip-mmin');
				$formatted .= do_precip ($returnvals['precip'], $suffix, $prefix);

				$returnvals['snow'] = format_snow('precip-mmin');
				$formatted .= do_snow ($returnvals['snow'], $suffix, $prefix);
		
				$returnvals['water_equiv'] = format_water_equiv ('precip-mmin');
				$formatted .= do_waterequiv ($returnvals['water_equiv'], $suffix, $prefix);

				break;
			
			case 'precip6-inmm':
				eval_past_precip($parts, $part_count);
				$returnvals['precip6'] = format_precip6('precip6-inmm');

				$formatted .= do_precip6 ($returnvals['precip6'], $suffix, $prefix);

				break;
			
			case 'precip6-mmin':
				eval_past_precip($parts, $part_count);
				$returnvals['precip6'] = format_precip6('precip6-mmin');

				$formatted .= do_precip6 ($returnvals['precip6'], $suffix, $prefix);

				break;
			
			case 'precip24-inmm':
				eval_past_precip($parts, $part_count);
				$returnvals['precip24'] = format_precip24('precip24-inmm');

				$formatted .= do_precip24 ($returnvals['precip24'], $suffix, $prefix);

				break;
			
			case 'precip24-mmin':
				eval_past_precip($parts, $part_count);
				$returnvals['precip24'] = format_precip24('precip24-mmin');

				$formatted .= do_precip24 ($returnvals['precip24'], $suffix, $prefix);

				break;
			
			case 'wind-km':
				eval_wind($parts, $part_count);
				$returnvals['wind_speed'] = format_wind_speed('wind-km');
				
				$formatted .= do_wind ($returnvals['wind_speed'], $suffix, $prefix);

				break;
			
			case 'wind-kt':
				eval_wind($parts, $part_count);
				$returnvals['wind_speed'] = format_wind_speed('wind-kt');
				
				$formatted .= do_wind ($returnvals['wind_speed'], $suffix, $prefix);

				break;
			
			case 'wind-mph':
				eval_wind($parts, $part_count);
				$returnvals['wind_speed'] = format_wind_speed('wind-mph');
				
				$formatted .= do_wind ($returnvals['wind_speed'], $suffix, $prefix);

				break;
			
			case 'wind-kmmph':
				eval_wind($parts, $part_count);
				$returnvals['wind_speed'] = format_wind_speed('wind-kmmph');
				
				$formatted .= do_wind ($returnvals['wind_speed'], $suffix, $prefix);

				break;
			
			case 'wind-mphkm':
				eval_wind($parts, $part_count);
				$returnvals['wind_speed'] = format_wind_speed('wind-mphkm');
				
				$formatted .= do_wind ($returnvals['wind_speed'], $suffix, $prefix);

				break;
			
			case 'wind-ktkmmph':
				eval_wind($parts, $part_count);
				$returnvals['wind_speed'] = format_wind_speed('wind-ktkmmph');
				
				$formatted .= do_wind ($returnvals['wind_speed'], $suffix, $prefix);

				break;
			
			case 'wind-dir':
				eval_wind($parts, $part_count);
				$returnvals['wind_dir'] = format_wind_dir('wind-dir');
				
				$formatted .= do_windrose ($returnvals['wind_dir'], $suffix, $prefix);

				break;
			
			case 'wind-dir-short':
				eval_wind($parts, $part_count);
				$returnvals['wind_dir'] = format_wind_dir('wind-dir-short');
				
				$formatted .= do_windrose ($returnvals['wind_dir'], $suffix, $prefix);

				break;
			
			case 'clouds-mft':
				eval_sky_detail($parts, $part_count);
				$returnvals['clouds'] = format_clouds('clouds-mft');
				
				eval_cloudwatch($parts, $part_count);
				
				$formatted .= do_clouds ($returnvals['clouds'], $suffix, $prefix);
				
				break;
				
			case 'clouds-ftm':
				eval_sky_detail($parts, $part_count);
				$returnvals['clouds'] = format_clouds('clouds-ftm');
				
				$formatted .= do_clouds ($returnvals['clouds'], $suffix, $prefix);
				
				break;
				
			case 'runways-mft':
				eval_runways($parts, $part_count);
				$returnvals['runways'] = format_runways('runways-mft');
				
				$formatted .= do_runways ($returnvals['runways'], $suffix, $prefix);
				
				break;
				
			case 'runways-ftm':
				eval_runways($parts, $part_count);
				$returnvals['runways'] = format_runways('runways-ftm');
				
				$formatted .= do_runways ($returnvals['runways'], $suffix, $prefix);
				
				break;
				
			case 'cloudwatch-ftm':
				eval_cloudwatch($parts, $part_count);
				$returnvals['cloudwatch'] = format_cloudwatch('cloudwatch-ftm');
				
				$formatted .= do_cloudwatch ($returnvals['cloudwatch'], $suffix, $prefix);
				
				break;
				
			case 'cloudwatch-mft':
				eval_cloudwatch($parts, $part_count);
				$returnvals['cloudwatch'] = format_cloudwatch('cloudwatch-mft');
				
				$formatted .= do_cloudwatch ($returnvals['cloudwatch'], $suffix, $prefix);
				
				break;
				
			case 'remarks':
				$remarks = eval_remarks($parts, $part_count);

				$formatted .= do_remarks ($remarks, $suffix, $prefix);

				break;
				
			case 'about':
				$formatted .= $prefix . $aboutwr . $suffix;
				break;

			default:
				break;
		}
	}

	return ($formatted);
}


/*------------------------------------------------------------------------------------------
	Checks the database for the weather table; if there is one, looks for an entry keyed to
	the value of $station. If there's such a row, gets its timestamp and METAR all ready before
	checking how long that METAR has been around, and returns it if it isn't too old.
	
	Returns '' if there is no weather table, or there is no pre-existing entry for the current
	$station, or if the existing entry is older than $shelfdate.
	
	Will die if the database itself doesn't exist or mysql refuses the connection.
------------------------------------------------------------------------------------------*/

function fetch_old_metar($shelfdate, $station, $glopstable, $server, $loginsql, $passsql, $base) {
	global $weather;
	$stationrow = '';
	
	$reqselect = 'SELECT timestamp, metar FROM ' . $glopstable . ' WHERE icao = \'' . $station . '\' LIMIT 1';
	
	$pipe = mysql_connect ($server, $loginsql, $passsql);
	if ($pipe) {
		mysql_select_db($base, $pipe);
		
		if (!mysql_select_db($base, $pipe)) {
			die ('Could not open specified database.');
		}
		
		if (!table_exists ($glopstable, $base)) {
			return '';
		}
		
		$res = mysql_query($reqselect, $pipe);
		
		if (mysql_num_rows($res)) {
			$stationrow['timestamp'] = mysql_result($res, 0, 'timestamp');
			$stationrow['metar'] = mysql_result($res, 0, 'metar');
			if (stristr($stationrow['metar'], "404 not found")) {
				return '';
			}
		}
		
		if ($stationrow) {
		
			$elderly = check_shelf_date($shelfdate, $stationrow['timestamp']);
			
			if (!$elderly) {
			
				$weather['timestamp'] = $stationrow['timestamp'];
				return $stationrow['metar'];
			}
		}
		
	} else {
		die ('Could not connect to mysql.');
	}
	return '';
}

/*---------------------------------------------------------------------------------------------
	Checks how long the existing METAR in the database has been there. If longer than
	$shelfdate (as defined up top), will trigger an attempt to fetch a new one from NWS.
	
	Setting $shelfdate to 'notimeout' can be useful when also using the 'fetch-only' option
	in $weatherargs. See the readme for a better articulation of this.
---------------------------------------------------------------------------------------------*/

function check_shelf_date($shelfdate, $timestamp) {
	if ($shelfdate == NOTIMEOUT) {
		return 0;
	}
	
	$timenow = time();
	if (($timenow - $timestamp) > $shelfdate) {
		return 1;
	} else {
		return 0;
	}
}
	
/*--------------------------------------------------------------------------------------------
	Uses the file() method of fetching the new METAR data via http. If this method has been
	disabled in your PHP installation (the manual says it is on by default, but can be
	problematic for Windows servers), then it tries via fopen. If that fails, fsockopen. If
	that fails, returns empty-handed.
	
	A bad or empty $station code looks just like one that's temporarily off-line and will
	generate an error.
--------------------------------------------------------------------------------------------*/

function get_metar_file ($station) {
	$host = 'weather.noaa.gov';
	$path = '/pub/data/observations/metar/stations/';
		
	$rawfile = 'http://' . $host . $path . $station . '.TXT';
	$res = '';
	
	
	$res = @file($rawfile);

	if (!$res) {
		ini_set('user_agent','MSIE 4\.0b2;');
		
		$mf = @fopen($rawfile,'rb');
		if ($mf) {
			$res = fread($mf,8192);
			fclose($mf);
		}
		if (!$res) {
			$mf = @fsockopen($host, 80);
			if($mf) {
				$out = "GET " . $rawfile . " HTTP/1.0\r\nHost: $host\r\n\r\n";
				fwrite ($mf, $out);
				$body = false;
				while (!feof($mf)) {
					$s = fgets($mf, 1024);
					if($body) {
						$res .= $s;
					}
					if ($s == "\r\n") {
						$body = true;
					}
				}
				fclose($mf);
			}
		}
		if (!$res || stristr($res, "404 not found")) {
			return '';
		}
	}
	

	$glops = ereg_replace("[\n\r ]+", ' ', trim(implode(' ', (array)$res)));
	
	return ($glops);
}

/*------------------------------------------------------------------------------------------
	Store the newly-acquired METAR in the weather table of our database (names of both are
	specified up top). If the table doesn't exist, create it. If there is already an entry
	for this particular ICAO station, UPDATE it. If it doesn't exist (that is, if UPDATE call
	affects zero rows), add a new row via INSERT.
	
	Will die if the database itself doesn't exist or mysql refuses the connection.
------------------------------------------------------------------------------------------*/

function archive_glops($glops, $station, $glopstable, $server, $loginsql, $passsql, $base) {
	global $weather;
	$timenow = time();
	
	$reqmake = 'CREATE TABLE ' . $glopstable . '(icao char(4) NOT NULL, timestamp int unsigned, metar varchar(255) NOT NULL, PRIMARY KEY (icao))';
	$reqinsert = 'INSERT INTO ' . $glopstable . ' VALUES (\'' . $station . '\',' . $timenow . ',\'' . $glops .'\')';
	$requpdate = 'UPDATE ' . $glopstable . ' SET timestamp = \''. $timenow . '\', metar = \'' . $glops . '\' WHERE icao = \'' . $station . '\'';
	
	$pipe = mysql_connect ($server, $loginsql, $passsql);
			
	if ($pipe) {
		if (!mysql_select_db($base, $pipe)) {
			die ('Could not open specified database.');
		}
		
		if (table_exists ($glopstable, $base)) {
			mysql_query($requpdate, $pipe);

			if (!mysql_affected_rows($pipe)) {
				mysql_query ($reqinsert, $pipe);
			}
		} else {
			mysql_query($reqmake, $pipe);
			mysql_query($reqinsert, $pipe);
		}
		
	} else {
		die ('Could not connect to mysql.');
	}
	$weather['timestamp'] = $timenow;
}

/*-----------------------------------------------------------------------------------------
	Simple method for finding out if a given table is in the specified database. Taken
	from online PHP manual, in either the mysql_list_tables or mysql_tablename threads.
-----------------------------------------------------------------------------------------*/

function table_exists ($tablename, $db) {
  
   $result = mysql_list_tables($db);
   $rcount = mysql_num_rows($result);

   for ($i=0;$i<$rcount;$i++) {
       if (mysql_tablename($result, $i)==$tablename) return true;
   }
   return false;
}

/*-----------------------------------------------------------------------------------------
	The time and date data can be coded in two ways: one is to send it full, in yyyy/mm/dd
	followed by the UTC time (hh:mm), or in short form: ddhhmmZ. The short form is mandatory;
	but if the long form is also sent, this function stores both in $zed.
	
	No recalibrating of time from UTC to local; it really doesn't seem that useful an
	exercise. I could be wrong, though.
	
	9 June 2005: okay, okay, I'm recalibrating.
	
	091700Z
-----------------------------------------------------------------------------------------*/

function eval_date ($parts, $part_count, $zoneoffset=0) {
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];

		if ($part == 'RMK') {
			return ($zed);
			
		} elseif (ereg ('^20([0-9]{2})/([0-9]{2})/([0-9]{2})$', $part)) {
			$zed['glops_date'] = $part;
			$zed['month'] = date(m, strtotime($zed['glops_date']));
			$zed['year'] = date(Y, strtotime($zed['glops_date']));
			$zed['day'] = date(d, strtotime($zed['glops_date']));
			
		} elseif (ereg ('([0-9]{2}:[0-9]{2})$', $part, $regs)) {
			$zed['glops_time'] = $regs[1];
			
			$zed['hour'] = date(H, strtotime($zed['glops_time']));
			$zed['minutes'] = date(i, strtotime($zed['glops_time']));
			
			if($zoneoffset != "") {
				$zed = eval_timezone($zoneoffset, $zed);
			}
			return($zed);
			
		} elseif (ereg ('^(([0-9])([0-9]))([0-9]{2})([0-9]{2})Z$', $part, $regs)) {
			$zed['day'] = $regs[1];
			$zed['day1'] = $regs[2];
			$zed['day2'] = $regs[3];
			$zed['hour'] = $regs[4];
			$zed['minutes'] = $regs[5];
			$mygmyear = gmdate("Y", time());
			$mygmmonth = gmdate("m", time());
			$zed['month'] = gmdate("m", mktime($zed['hour'],$zed['minutes'],0,$mygmmonth,$zed['day'],$mygmyear));
			$zed['year'] = gmdate("Y", mktime($zed['hour'],$zed['minutes'],0,$mygmmonth,$zed['day'],$mygmyear));
			
			if($zoneoffset) {
				$zed = eval_timezone($zoneoffset, $zed);
			}
			
		}
	}
	return ($zed);	
}

/*------------------------------------------------------------------------------------------
	Converts the timezone offset from hours to seconds and stores result in $zed array.
------------------------------------------------------------------------------------------*/

function eval_timezone($offset, $zed) {
	$tstamp = mktime($zed['hour'], $zed['minutes'], 0, $zed['month'], $zed['day'], $zed['year']);
	
	if($offset) {
		$offset *= 3600;
	}
	
	$tstamp += $offset;
	
	$zed['local_tstamp'] = $tstamp;
	
	return ($zed);
}

/*------------------------------------------------------------------------------------------
	Sorts out the URI of both stations.txt and wr-setstation.php for use by the
	interactive weather report display routines added in v2.3.
------------------------------------------------------------------------------------------*/

function weatherdocloc() {
	$absoluteloc = WR_DIR . WR_SUPPORT;	//should be absolute path to /wr-weather/ directory
	$key = dirname($_SERVER['PHP_SELF']); //should be the root URI path of the calling script
	$webloc = strstr($absoluteloc, $key); //trim absolute path to its URI component

	return ($webloc);
}

/*------------------------------------------------------------------------------------------
	Gets the absolute path of wr-weatherstation.php, which itself creates the 
	interactive weather report form (station entry text field plus 'display' button)
------------------------------------------------------------------------------------------*/

function includestation() {
	$yourweather = WR_DIR . WR_SUPPORT . 'wr-weatherstation.php';
	include($yourweather);
}

/*------------------------------------------------------------------------------------------
	Creates a link to stations.txt, so visitors can pick out a station code from a list.
	
	If you want to direct visitors to a nicely formatted list of locations and stations,
	see wr-readme.txt for details on using makeprettytxtfile.php or makeprettylistfile.php.
	
	Do not delete the supplied stations.txt unless you know what you're doing. You can
	delete lines from it, though.
------------------------------------------------------------------------------------------*/

function linkstationlist() {
	if (file_exists(WR_DIR . WR_SUPPORT . "stationsbyname.php")) {
		echo ('<a href="' . weatherdocloc() . 'stationsbyname.php">list of stations</a>');
	} elseif (file_exists(WR_DIR . WR_SUPPORT . "stationsbyname.txt")) {
		echo ('<a href="' . weatherdocloc() . 'stationsbyname.txt">list of stations</a>');
	} elseif (file_exists(WR_DIR . WR_SUPPORT . "stations.txt")) {
		echo ('<a href="' . weatherdocloc() . 'stations.txt">list of stations</a>');
	}
}

/*------------------------------------------------------------------------------------------
	Reads and validates the 'weatherstation' cookie, and if valid, combines it with
	the other options and sends the whole to get_weather().
------------------------------------------------------------------------------------------*/

function getuserweather($weatherargs) {
	$wrstation['id'] = $_COOKIE['weatherstation'];
	$report = '';
	
	if ($wrstation['id']) {
		$wrstation['id'] = substr($wrstation['id'], 0, 4);
		$wrstation = recheckstation($wrstation);

		$optionslist = explode (',', $weatherargs);
		$opt_count = count($optionslist);
		$suffix = $optionslist[$opt_count - 3] . "\n";
		$prefix = $optionslist[$opt_count - 4];

		if ($wrstation['loc']) {
			$report = $prefix . $wrstation['loc'] . $suffix;
		}
		
		if ($wrstation['id'] == "invalid station") {
			$report .= $prefix . 'station not listed' . $suffix;
		} else {	
			$report .= get_weather($wrstation['id']. ',' . $weatherargs);
		}
	}
	return ($report);
}

/*------------------------------------------------------------------------------------------
	Checks the 'weatherstation' cookie contents against the legal list of weather stations
	in stations.txt. If stations.txt does not exist, assumes that the site owner does not
	want to bother with validation or parsing the station location.
------------------------------------------------------------------------------------------*/

function recheckstation($wrstation) {

	$myfile = WR_DIR . WR_SUPPORT . 'stations.txt';
	
	if (file_exists($myfile)) {
		$stationlist = fopen($myfile, r);
		
		while (!feof($stationlist)) {
			$line = fgets($stationlist, 512);
			if (substr($line, 0, 1) == '#') {
				continue;
			}
			
			$callcode = substr($line, 0, 4);
			
			if (strstr($callcode, $wrstation['id'])) {
				$wrstation['loc'] = getstationloc($line);
				fclose ($stationlist);
				return ($wrstation);
			}
		}
		fclose ($stationlist);
		$wrstation['id'] = "invalid station";
	}
	return ($wrstation);

}

/*------------------------------------------------------------------------------------------
	Parses the station location.
	
	Expected formatting in stations.txt:
	
	0      1     2     3            4        5
	[code];[geo];[geo];[place name];[region];[country]... 
	
	BIVM;04;048;Vestmannaeyjar;;Iceland;6;63-24N;020-17W;;;118;124;P
	
	Note that if you edit stations.txt, you need to preserve the order of the first
	six fields in each line. 
------------------------------------------------------------------------------------------*/

function getstationloc($line) {
	$stationentry = explode (';', $line);
	$loc = $stationentry[3];				//town, airport, weather station
	if($stationentry[4]) {
		$loc .= ', ' . $stationentry[4];	//state, province, region
	}
	$loc .= ', ' . $stationentry[5];		//country
	
	return ($loc);
}
?>
