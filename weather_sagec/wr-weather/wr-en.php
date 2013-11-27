<?php
/*--------------------------------------------------------------------------------------------
	CONTENTS:
	
		function set_global_phrases_en	()
		function format_local_date_en	($zed)
		function format_zed_date_en		($zed)
		function make_ordinal_en		($number)
		function convert_windrose_en	($compass)
		function convert_to_en			($codeletter)
		format_sky_short_en				()
		fill_clouds_en					($group)
		convert_clouds_en				($condition)
		convert_cumulus_en				($type)
		convert_approach_en				($approach)
		convert_tendency_en				($trend)
		set_directions_en				($compass_point)
		set_prefix_en					($prefix)
		convert_pressure_change_en		($partcode)
		fill_cloudwatch_en				($cloud)
--------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------
	Collects all incidental phrases into one function for easy translation.
--------------------------------------------------------------------------------------------*/
function set_global_phrases_en () {
	global $temphead, $dewhead, $temp6head, $temp24head, $relhumhead, $humidhead, $heathead;
	global $chillhead, $pressurehead, $pressure3head, $pressureratehead, $slphead;
	global $visibilityhead, $cloudhead, $cloudwatchhead, $runwayhead, $preciphead;
	global $snowhead, $waterhead, $precip6head, $precip24head, $windspeedhead;
	global $gusthead, $windcompasshead, $windshifthead, $conditionhead, $remarkshead;
	global $lessthanzero, $lowceiling, $rising, $falling, $sector, $runwaydesig, $nsw, $recentrain;
	global $low, $middle, $high, $milesperhour, $knotsperminute, $kilometersperhour;
	global $milesabbrev, $kilometerabbrev;
	global $noreport, $station, $aboutwr;
	
	$temphead			= 'Temperature: ';
	$dewhead			= 'Dewpoint: ';
	$temp6head			= 'Min/Max, last 6 hrs: ';
	$temp24head			= 'Min/Max, last 24 hrs: ';
	$relhumhead			= 'Relative humidity: ';
	$humidhead			= 'Humidity index: ';
	$heathead			= 'Heat index: ';
	$chillhead			= 'Windchill: ';
	$pressurehead		= 'Barometric: ';
	$pressure3head		= 'Barometric change, last 3 hrs: ';
	$pressureratehead	= 'Rate of change coded as: ';
	$slphead			= 'Pressure at sea level: ';
	$visibilityhead		= 'Visibility: ';
	$cloudhead			= 'Clouds: ';
	$cloudwatchhead		= 'Cloudwatch: ';
	$runwayhead			= 'Runway visual ranges: ';
	$preciphead			= 'Precipitation in the last hour: ';
	$snowhead			= 'Snow Accumulation: ';
	$waterhead			= 'Water Equivalent: ';
	$precip6head		= 'Precipitation, last 3&ndash;6 hours: ';
	$precip24head		= 'Precipitation, last 24 hours: ';
	$windspeedhead		= 'Windspeed: ';
	$gusthead			= 'Gusting to: ';
	$windcompasshead	= 'Wind direction: ';
	$windshifthead		= 'Wind variance: ';
	$conditionhead		= 'Conditions: ';
	$remarkshead		= 'Remarks: ';
	
	
	$lessthanzero	= 'traces';
	$lowceiling		= 'ceiling less than ';
	$rising			= 'barometer rising rapidly';
	$falling		= 'barometer falling rapidly';
	$runwaydesig	= 'runway';
	$sector			= 'sector';
	$nsw			= 'no significant weather';
	$recentrain		= 'recent rain';
	$low			= 'low';
	$middle			= 'middle';
	$high			= 'high';
	
	$milesperhour	= ' mph';
	$knotsperminute	= ' knots';
	$kilometersperhour	= ' kph';
	$milesabbrev	= ' miles';
	$kilometerabbrev	= ' km';
	
	$noreport		= '<a target="_blank" href='.
				'"http://weather.noaa.gov/pub/data/observations/metar/stations/'.$station.'.TXT">no report available</a>';
	
	$aboutwr		= 'weather report courtesy of <a target="_blank" href='.
				'"http://weather.noaa.gov/">NWS</a>, a cast of thousands, '.
				'and <a target="_blank" href="http://pericat.ca/">pericat</a>.<br />'.
				'weather courtesy of sniffly Brazilian butterflies.';

}

/*--------------------------------------------------------------------------------------------
	Outputs the date and time in long form, according to the GMT/UTC offset specified.
	
	For shorter forms of 'date', use:
		%Y/%m/%e	- YYYY/MM/[D]D		- 2005/06/8 or 2005/06/13
		%y/%m/%e	- YY/MM/[D]D		- 05/06/8 or 05/06/13
		
		Change slashes to dashes, or swap the format signifiers around.
		
	Source for time signifiers: <http://php.net/manual/en/function.date.php>
	Source for signifiers: <http://php.net/manual/en/function.strftime.php>
	
--------------------------------------------------------------------------------------------*/
function format_local_date_en ($zed, $offset) {
	setlocale(LC_TIME, 'en_EN.ISO8859-1');
	
	if ($zed['year']) {
		$localtime = date("g:i a", $zed['local_tstamp']);
		$localday = strftime("%A, %e %B %Y", $zed['local_tstamp']);
		
		setlocale(LC_TIME, '');
		$report_date = 'local time: ' . $localday . ', at ' . $localtime;
		return ($report_date);
		
	} else {
		$day = make_ordinal_en ($zed['day1'], $zed['day2']);
		
		if ($zed['day1']) {
			$day = $zed['day1'] . $day;
		}
		
		if($offset > 0) {
			$plusminus = "+";
		}
		
		setlocale(LC_TIME, '');
		$report_date = 'reported: ' . $zed['hour'] . ':' . $zed['minutes'] . ' UTC (local time ' . $plusminus . $offset . ' hour[s]) on the ' . $day . ' of the month';
		return ($report_date);
	}
}


/*--------------------------------------------------------------------------------------------
	If the long form is present, use it. Otherwise, go with the short.
--------------------------------------------------------------------------------------------*/

function format_zed_date_en ($zed) {

	if ($zed['glops_date'] && $zed['glops_time']) {
		$report_date = 'reported: ' . $zed['glops_time'] . ' UTC on ' . $zed['glops_date'];
		return ($report_date);
		
	} else {
		$day = make_ordinal_en ($zed['day1'], $zed['day2']);
		
		if ($zed['day1']) {
			$day = $zed['day1'] . $day;
		}
		
		$report_date = 'reported: ' . $zed['hour'] . ':' . $zed['minutes'] . ' UTC on the ' . $day . ' of the month';
		return ($report_date);
	}
}

/*--------------------------------------------------------------------------------------------
	A touch of grammatic obsessiveness. Only valid for English.
--------------------------------------------------------------------------------------------*/

function make_ordinal_en ($tens, $ones) {
	if ($tens == '1') {
			$ones = $ones .'th';
			return ($ones);
	}
			
	switch ($ones) {
		case '1':
			$ones = $ones . 'st';
			break;
			
		case '2':
			$ones = $ones . 'nd';
			break;
			
		case '3':
			$ones = $ones . 'rd';
			break;
			
		default:
			$ones = $ones . 'th';
			break;
	}
	
	return ($ones);
}

/*--------------------------------------------------------------------------------
	Turns compass degrees into windrose notations.
--------------------------------------------------------------------------------*/

function convert_windrose_en ($compass) {
	global $weather;
	
	if (!$compass) {
		$windrose = '';
		
	} elseif ($compass == 'VRB') {
		$windrose = 'variable';
		
	} elseif (($compass <= '022') || ($compass >= '337')) {
		$windrose = 'from the north';
		
	} elseif (($compass <= '067') && ($compass >= '023')) {
		$windrose = 'from the northeast';
		
	} elseif (($compass <= '112') && ($compass >= '068')) {
		$windrose = 'from the east';
		
	} elseif (($compass <= '157') && ($compass >= '113')) {
		$windrose = 'from the southeast';
		
	} elseif (($compass <= '202') && ($compass >= '158')) {
		$windrose = 'from the south';
		
	} elseif (($compass <= '247') && ($compass >= '203')) {
		$windrose = 'from the southwest';
		
	} elseif (($compass <= '292') && ($compass >= '248')) {
		$windrose = 'from the west';
		
	} elseif (($compass <= '336') && ($compass >= '293')) {
		$windrose = 'from the northwest';
	}
	return ($windrose);
}

/*----------------------------------------------------------------------------------
	Converts the METAR conditions codes into human language.
----------------------------------------------------------------------------------*/

function convert_to_en ($codeletter) {
	switch ($codeletter) {
	
													// intensity
		case '-':
			$codephrase = ' light ';
			break;
			
		case ' ':
			$codephrase = ' moderate ';
			break;
			
		case '+':
			$codephrase = ' heavy ';
			break;
													
													// proximity
		case 'VC':
			$codephrase = ' in the near vicinity ';
			break;
			
													// descriptors
		case 'PR':
			$codephrase = ' partial ';
			break;
			
		case 'BC':
			$codephrase = ' patches (of) ';
			break;
			
		case 'RE':
			$codephrase = ' recent ';
			break;
			
		case 'FZ':
			$codephrase = ' freezing ';
			break;
			
		case 'MI':
			$codephrase = ' shallow ';
			break;
			
		case 'DR':
			$codephrase = ' low drifting ';
			break;
			
		case 'BL':
			$codephrase = ' blowing ';
			break;
			
		case 'SH':
			$codephrase = ' showers (of) ';
			break;
			
		case 'TS':
			$codephrase = ' thunderstorms (plus) ';
			break;
			
													// precipitation
		case 'DZ':
			$codephrase = ' drizzle';
			break;
			
		case 'RA':
			$codephrase = ' rain';
			break;
			
		case 'SN':
			$codephrase = ' snow';
			break;
			
		case 'SG':
			$codephrase = ' snow grains';
			break;
			
		case 'IC':
			$codephrase = ' ice crystals';
			break;
			
		case 'PL':
			$codephrase = ' ice pellets';
			break;
			
		case 'GR':
			$codephrase = ' hail';
			break;
			
		case 'GS':
			$codephrase = ' small hail';
			break;
			
		case 'UP':
			$codephrase = ' unknown precipitation';
			break;
			
													// obscuration
		case 'BR':
			$codephrase = ' mist';
			break;
			
		case 'FG':
			$codephrase = ' fog';
			break;
			
		case 'FU':
			$codephrase = ' smoke';
			break;
			
		case 'VA':
			$codephrase = ' volcanic ash';
			break;
			
		case 'DU':
			$codephrase = ' widespread dust';
			break;
			
		case 'SA':
			$codephrase = ' sand';
			break;
			
		case 'HZ':
			$codephrase = ' haze';
			break;
			
		case 'PY':
			$codephrase = ' spray';
			break;
			
													// other
		case 'PO':
			$codephrase = ' dust devils';
			break;
			
		case 'SQ':
			$codephrase = ' squalls';
			break;
			
		case 'FC':
			$codephrase = ' funnel cloud(s)';
			break;
			
		case 'SS':
			$codephrase = ' sandstorm';
			break;
			
		case 'DS':
			$codephrase = ' duststorm';
			break;
			
		default:
			$codephrase = $codeletter;
			break;
	}
	return $codephrase;
}

/*---------------------------------------------------------------------------------------
	'calm' is used when there are also no clouds. It makes a slightly nicer string. It
	has no other purpose.
---------------------------------------------------------------------------------------*/

function format_sky_short_en () {
	global $weather;

	if ($weather['wind']['calm']) {
		$nowind = ', no wind';
		$def_nowind = 'calm';
	}
	switch ($weather['sky']) {
		case 1:
			$weather['sky'] = 'clear skies' . $nowind;
			break;
			
		case 2:
			$weather['sky'] = 'fair' . $nowind;
			break;
			
		case 3:
			$weather['sky'] = 'mostly clear' . $nowind;
			break;
			
		case 4:
			$weather['sky'] = 'partly cloudy' . $nowind;
			break;
			
		case 5:
			$weather['sky'] = 'mostly cloudy' . $nowind;
			break;
			
		case 6:
			$weather['sky'] = 'overcast' . $nowind;
			break;
			
		case 7:
			$weather['sky'] = 'very low ceiling' . $nowind;
			break;
			
		default:
			$weather['sky'] = $def_nowind;
			break;
	}
	
	return ($weather['sky']);
}

function convert_clouds_en ($condition) {
	
	switch ($condition) {
		case 'FEW':
			$condition = 'a few clouds';
			break;
			
		case 'SCT':
		case 'SKT':
			$condition = 'scattered clouds';
			break;
			
		case 'BKN':
			$condition = 'broken clouds';
			break;
			
		case 'OVC':
			$condition = 'overcast';
			break;
			
		case 'VV':
			$condition = 'low ceiling';
			break;
			
		default:
			break;
	}
	return ($condition);
}

function convert_cumulus_en ($type) {
	switch ($type) {
		case 'TCU':
			$type = ', including towering cumulus';
			break;
			
		case 'CB':
			$type = ', including cumulonimbus';
			break;
			
		default:
			break;
	}
	return ($type);
}

function fill_clouds_en ($group) {
	global $lowceiling;
	
	$clouds['condition']	= convert_clouds_en ($group['condition']);
	$clouds['cumulus']		= convert_cumulus_en ($group['cumulus']);
	$clouds['ft']			= $group['ft'];
	$clouds['meter']		= $group['meter'];
	
	if ($group['prefix'] == -1) {
		$clouds['prefix'] = $lowceiling;
	}
	return ($clouds);
}

/*----------------------------------------------------------------------------------------------
	While the specs only mention R, L, & C, I've seen tables that mention RR and LL, for really
	big runways. Most RVRs will assume a single approach, though.
----------------------------------------------------------------------------------------------*/

function convert_approach_en ($approach) {
	switch ($approach) {
		case 'R':
			$approach = 'right';
			break;
			
		case 'L':
			$approach = 'left';
			break;
			
		case 'C':
			$approach = 'centre';
			break;
			
		case 'RR':
			$approach = 'rightmost';
			break;
			
		case 'LL':
			$approach = 'leftmost';
			break;
			
		default:
			break;
	}
	return ($approach);
}

/*-------------------------------------------------------------------------------------
	As in the preceding function, should the trend codes be present in a runway group,
	it is now time to expand them into recognisable words.
-------------------------------------------------------------------------------------*/

function convert_tendency_en ($trend) {
	switch ($trend) {
		case 'D':
			$trend = ', decreasing';
			break;
			
		case 'U':
			$trend = ', increasing';
			break;
			
		case 'N':
			$trend = ', holding steady';
			break;
		
		default:
			break;
	}
	return ($trend);
}

/*-----------------------------------------------------------------------------------------
	Expands direction codes into phrases for the Visibility section.
-----------------------------------------------------------------------------------------*/

function set_directions_en ($compass_point) {
	switch ($compass_point) {
		case 'N':
			$compass_point = ' in the north';
			break;
			
		case 'S':
			$compass_point = ' in the south';
			break;
			
		case 'E':
			$compass_point = ' in the east';
			break;
			
		case 'W':
			$compass_point = ' in the west';
			break;
			
		case 'NE':
			$compass_point = ' in the northeast';
			break;
			
		case 'SE':
			$compass_point = ' in the southeast';
			break;
			
		case 'NW':
			$compass_point = ' in the northwest';
			break;
			
		case 'SW':
			$compass_point = ' in the southwest';
			break;
			
		case '0':
			$compass_point = 'overhead';
			break;
			
		default:
			break;
	}
	return ($compass_point);
}

/*----------------------------------------------------------------------------------------------
	Both Visibility and RVRs use 'M' and 'P' qualifiers to indicate the actual distance is
	outside the range of the station's instruments. These are decoded as -1 and 1 respectively,
	for a really important reason I've forgotten.
----------------------------------------------------------------------------------------------*/

function set_prefix_en ($prefix) {

	switch ($prefix) {
		case '-1':
			$prefix = 'under ';
			break;
			
		case '1':
			$prefix = 'over ';
			break;
			
		default:
			$prefix = '';
			break;
	}
	return ($prefix);
}

function convert_pressure_change_en ($partcode) {
	switch ($partcode) {
	
		case 0:
			$tendency = 'increasing, then decreasing';
			break;
			
		case 1:
			$tendency = 'increasing, then steady, or increasing then increasing more slowly';
			break;
			
		case 2:
			$tendency = 'increasing steadily or unsteadily';
			break;
			
		case 3:
			$tendency = 'decreasing or steady, then increasing; or ';
			$tendency .= 'increasing, then increasing more rapidly';
			break;
			
		case 4:
			$tendency = 'steady';
			break;
		
		case 5:
			$tendency = 'decreasing, then increasing';
			break;
			
		case 6:
			$tendency = 'decreasing then steady; or decreasing then decreasing more slowly';
			break;
			
		case 7:
			$tendency = 'decreasing steadily or unsteadily';
			break;
			
		case 8:
			$tendency = 'steady or increasing, then decreasing; or ';
			$tendency .= 'decreasing then decreasing more rapidly';
			break;
			
		default:
			$tendency = '';
			break;
			
	}
	return $tendency;
}

function fill_cloudwatch_en ($cloud) {
	switch ($cloud) {
		case 'AC':
			$cloud = 'altocumulus';
			break;
			
		case 'ACC':
			$cloud = 'altocumulus castellanus';
			break;
			
		case 'ACSL':
			$cloud = 'standing lenticular altocumulus';
			break;
			
		case 'AS':
			$cloud = 'altostratus';
			break;
			
		case 'CB':
			$cloud = 'cumulonimbus';
			break;
			
		case 'CC':
			$cloud = 'cirrocumulus';
			break;
			
		case 'CCSL':
			$cloud = 'standing lenticular cirrocumulus';
			break;
			
		case 'CF':
			$cloud = 'cumuloform';
			break;
			
		case 'CI':
			$cloud = 'cirrus';
			break;
			
		case 'CS':
			$cloud = 'cirrostratus';
			break;
		
		case 'CU':
			$cloud = 'cumulus';
			break;
			
		case 'LC':
			$cloud = 'lenticular';
			break;
			
		case 'NS':
			$cloud = 'nimbostratus';
			break;
			
		case 'SC':
			$cloud = 'stratocumulus';
			break;
			
		case 'SCSL':
			$cloud = 'standing lenticular stratocumulus';
			break;
			
		case 'SF':
			$cloud = 'stratoform';
			break;
			
		case 'SL':
			$cloud = 'standing lenticular cloud';
			break;
			
		case 'ST':
			$cloud = 'stratus';
			break;
			
		case 'TCU':
			$cloud = 'towering cumulus';
			break;
			
		default:
			$cloud = 'untyped cloud';
			break;
	}
	return ($cloud);
}

?>