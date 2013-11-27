<?php
/*--------------------------------------------------------------------------------------------
	CONTENTS:
	
		function set_global_phrases_fr	()
		function format_local_date_fr	($zed)
		function format_zed_date_fr		($zed)
		function make_ordinal_fr		($number)
		function convert_windrose_fr	($compass)
		function convert_to_fr			($codeletter)
		format_sky_short_fr				()
		fill_clouds_fr					($group)
		convert_clouds_fr				($condition)
		convert_cumulus_fr				($type)
		convert_approach_fr				($approach)
		convert_tendency_fr				($trend)
		set_directions_fr				($compass_point)
		set_prefix_fr					($prefix)
		convert_pressure_change_fr		($partcode)
		fill_cloudwatch_fr				($cloud)
--------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------
	Collects all incidental phrases into one function for easy translation.
--------------------------------------------------------------------------------------------*/
function set_global_phrases_fr () {
	global $temphead, $dewhead, $temp6head, $temp24head, $relhumhead, $humidhead, $heathead;
	global $chillhead, $pressurehead, $pressure3head, $pressureratehead, $slphead;
	global $visibilityhead, $cloudhead, $cloudwatchhead, $runwayhead, $preciphead;
	global $snowhead, $waterhead, $precip6head, $precip24head, $windspeedhead;
	global $gusthead, $windcompasshead, $windshifthead, $conditionhead, $remarkshead;
	global $lessthanzero, $lowceiling, $rising, $falling, $sector, $runwaydesig, $nsw, $recentrain;
	global $low, $middle, $high, $milesperhour, $knotsperminute, $kilometersperhour;
	global $milesabbrev, $kilometerabbrev;
	global $noreport, $station, $aboutwr;
	
	$temphead			= 'Temp&eacute;rature: ';
	$dewhead			= 'Point de condensation: ';
	$temp6head			= 'Min/max, dans la derni&egrave;re 6 heures: ';
	$temp24head			= 'Min/Max, dans la derni&egrave;re 24 heures: ';
	$relhumhead			= 'Humidit&eacute; relative: ';
	$humidhead			= 'Index d\'humidit&eacute;: ';
	$heathead			= 'Index de la chaleur: ';
	$chillhead			= 'Froid de vent: ';
	$pressurehead		= 'Pression: ';
	$pressure3head		= 'Pression change, dans la derni&egrave;re 3 heures: ';
	$pressureratehead	= 'Taux de changement cod&eacute;: ';
	$slphead			= 'Pression au niveau de la mer: ';
	$visibilityhead		= 'Visibilit&eacute;: ';
	$cloudhead			= 'Nuages: ';
	$cloudwatchhead		= 'Nuages remarqu&eacute;: ';
	$runwayhead			= 'Port&eacute;e visuelle de piste: ';
	$preciphead			= 'Pr&eacute;cipitation dans la derni&egrave;re heure: ';
	$snowhead			= 'Quantit&eacute; de neige: ';
	$waterhead			= 'Quantit&eacute; &eacute;quivalente de l\'eau: ';
	$precip6head		= 'Precipitation, dans la derni&egrave;re 3&ndash;6 heures: ';
	$precip24head		= 'Precipitation, dans la derni&egrave;re 24 heures: ';
	$windspeedhead		= 'Vitesse de vent: ';
	$gusthead			= 'avec rafales &agrave;: ';
	$windcompasshead	= 'Direction de vent: ';
	$windshifthead		= 'D&eacute;calages du vent: ';
	$conditionhead		= 'Conditions atmosph&eacute;riques: ';
	$remarkshead		= 'Remarques: ';
	
	
	$lessthanzero	= 'traces';
	$lowceiling		= 'le plafond est moins ';
	$rising			= 'le barom&eacute;tre se l&eacute;ve rapidement';
	$falling		= 'le barom&eacute;tre tombe rapidement';
	$sector			= 'secteur';
	$runwaydesig	= 'piste';
	$nsw			= 'aucune activit&eacute; m&eacute;t&eacute;orologique significative';
	$recentrain		= 'pluie r&eacute;cente';
	$low			= 'bas';
	$middle			= 'milieu';
	$high			= 'haut';
	
	$milesperhour	= ' mille/h';
	$knotsperminute	= ' n&oelig;uds';
	$kilometersperhour	= ' km/h';
	$milesabbrev	= ' milles';
	$kilometerabbrev	= ' km';
		
	$noreport		= '<a target="_blank" href='.
				'"http://weather.noaa.gov/pub/data/observations/metar/stations/'.$station.'.TXT">aucun rapport disponible</a>';
	
	$aboutwr		= 'Ce rapport m&eacute;t&eacute;orologique a &eacute;t&eacute; fourni par la courtoisie de ' .
				'<a target="_blank" href="http://weather.noaa.gov/">NWS</a>, ' .
				'les milliers d\'aides, et le ' .
				'<a target="_blank" href="http://pericat.ca/">pericat</a>.';

}

/*--------------------------------------------------------------------------------------------
	Outputs the date and time in long form, according to the GMT/UTC offset specified.
	
	For shorter forms of 'date', use:
		%Y/%m/%e	- YYYY/MM/[D]D		- 2005/06/8 or 2005/06/13
		%y/%m/%e	- YY/MM/[D]D		- 05/06/8 or 05/06/13

		Change slashes to dashes, or swap the format signifiers around.
		
	Source for time signifiers: <http://php.net/manual/en/function.date.php>
	Source for date signifiers: <http://php.net/manual/en/function.strftime.php>
	
--------------------------------------------------------------------------------------------*/
function format_local_date_fr ($zed, $offset) {
	setlocale(LC_TIME, 'fr_FR.ISO8859-1');
	
	if ($zed['year']) {
		$localtime = date("H:i", $zed['local_tstamp']);
		$localday = strftime("%A, %e %B %Y", $zed['local_tstamp']);
		
		setlocale(LC_TIME, '');
		$report_date = 'la date locale: ' . $localday . ', &agrave; ' . $localtime;
		return ($report_date);
		
	} else {
		$day = make_ordinal_fr ($zed['day1'], $zed['day2']);
		
		if ($zed['day1']) {
			$day = $zed['day1'] . $day;
		}
		
		if($offset > 0) {
			$plusminus = "+";
		}
		
		setlocale(LC_TIME, '');
		$report_date = 'not&eacute;: ' . $zed['hour'] . ':' . $zed['minutes'] . ' TUC (le temps local ' . $plusminus . $offset . ' heure[s]) sur le ' . $day . ' jour du mois';
		return ($report_date);
	}
}



/*--------------------------------------------------------------------------------------------
	If the long form is present, use it. Otherwise, go with the short.
--------------------------------------------------------------------------------------------*/

function format_zed_date_fr ($zed) {

	if ($zed['glops_date'] && $zed['glops_time']) {
		$report_date = 'not&eacute;: ' . $zed['glops_time'] . ' TUC sur ' . $zed['glops_date'];
		return ($report_date);
		
	} else {
		$day = make_ordinal_fr ($zed['day1'], $zed['day2']);
		
		if ($zed['day1']) {
			$day = $zed['day1'] . $day;
		}
		
		$report_date = 'not&eacute;: ' . $zed['hour'] . ':' . $zed['minutes'] . ' TUC sur le ' . $day . ' jour du mois';
		return ($report_date);
	}
}

/*--------------------------------------------------------------------------------------------
	A touch of grammatic obsessiveness.
--------------------------------------------------------------------------------------------*/

function make_ordinal_fr ($tens, $ones) {
	if (!$tens && ($ones == '1')) {
		$ones = $ones . 'er';
		return ($ones);
	} 
	
	$ones = $ones . '&egrave;me';
	return ($ones);
}

/*--------------------------------------------------------------------------------
	Turns compass degrees into windrose notations.
--------------------------------------------------------------------------------*/

function convert_windrose_fr ($compass) {
	global $weather;
	
	if (!$compass) {
		$windrose = '';
		
	} elseif ($compass == 'VRB') {
		$windrose = 'variables';
		
	} elseif (($compass <= '022') || ($compass >= '337')) {
		$windrose = 'du nord';
		
	} elseif (($compass <= '067') && ($compass >= '023')) {
		$windrose = 'du nord-est';
		
	} elseif (($compass <= '112') && ($compass >= '068')) {
		$windrose = 'de l\'est';
		
	} elseif (($compass <= '157') && ($compass >= '113')) {
		$windrose = 'du sud-est';
		
	} elseif (($compass <= '202') && ($compass >= '158')) {
		$windrose = 'des sud';
		
	} elseif (($compass <= '247') && ($compass >= '203')) {
		$windrose = 'du sud-ouest';
		
	} elseif (($compass <= '292') && ($compass >= '248')) {
		$windrose = 'de l\'ouest';
		
	} elseif (($compass <= '336') && ($compass >= '293')) {
		$windrose = 'du nord-ouest';
	}
	return ($windrose);
}

/*----------------------------------------------------------------------------------
	Converts the METAR conditions codes into human language.
----------------------------------------------------------------------------------*/

function convert_to_fr ($codeletter) {
	switch ($codeletter) {
	
													// intensity
		case '-':
			$codephrase = ' faible ';
			break;
			
		case ' ':
			$codephrase = ' mod&eacute;r&eacute;e ';
			break;
			
		case '+':
			$codephrase = ' forte ';
			break;
													
													// proximity
		case 'VC':
			$codephrase = ' au voisinage ';
			break;
			
													// descriptors
		case 'PR':
			$codephrase = ' partiel ';
			break;
			
		case 'BC':
			$codephrase = ' bancs (de) ';
			break;
			
		case 'RE':
			$codephrase = ' r&eacute;cents ';
			break;
			
		case 'FZ':
			$codephrase = ' se congelant (surfondu) ';
			break;
			
		case 'MI':
			$codephrase = ' mince ';
			break;
			
		case 'DR':
			$codephrase = ' chasse-poussi&egrave;re  ';
			break;
			
		case 'BL':
			$codephrase = ' chasse-poussi&egrave;re (&eacute;lev&eacute;e) ';
			break;
			
		case 'SH':
			$codephrase = ' averses (de) ';
			break;
			
		case 'TS':
			$codephrase = ' orages (avec) ';
			break;
			
													// precipitation
		case 'DZ':
			$codephrase = ' bruine';
			break;
			
		case 'RA':
			$codephrase = ' pluie';
			break;
			
		case 'SN':
			$codephrase = ' neige';
			break;
			
		case 'SG':
			$codephrase = ' granules de neige';
			break;
			
		case 'IC':
			$codephrase = ' cristaux de glace';
			break;
			
		case 'PL':
			$codephrase = ' granules de glace';
			break;
			
		case 'GR':
			$codephrase = ' la gr&ecirc;le';
			break;
			
		case 'GS':
			$codephrase = ' gr&eacute;sil';
			break;
			
		case 'UP':
			$codephrase = ' pr&eacute;cipitation inconnue';
			break;
			
													// obscuration
		case 'BR':
			$codephrase = ' brume';
			break;
			
		case 'FG':
			$codephrase = ' brouillard';
			break;
			
		case 'FU':
			$codephrase = ' fum&eacute;e';
			break;
			
		case 'VA':
			$codephrase = ' cendres volcaniques';
			break;
			
		case 'DU':
			$codephrase = ' la poussi&egrave;re g&eacute;n&eacute;ralis&eacute;e';
			break;
			
		case 'SA':
			$codephrase = ' sable';
			break;
			
		case 'HZ':
			$codephrase = ' brume s&egrave;che';
			break;
			
		case 'PY':
			$codephrase = ' jet';
			break;
			
													// other
		case 'PO':
			$codephrase = ' tourbillons de poussie&egrave;re/sable';
			break;
			
		case 'SQ':
			$codephrase = ' grains';
			break;
			
		case 'FC':
			$codephrase = ' nuage(s) en entonnoir';
			break;
			
		case 'SS':
			$codephrase = ' temp&ecirc;te de sable';
			break;
			
		case 'DS':
			$codephrase = ' temp&ecirc;te de poussi&egrave;re';
			break;
			
		default:
			$codephrase = $codeletter;
			break;
	}
	return $codephrase;
}

/*---------------------------------------------------------------------------------------
	'calme' is used when there are also no clouds. It makes a slightly nicer string. It
	has no other purpose.
---------------------------------------------------------------------------------------*/

function format_sky_short_fr () {
	global $weather;

	if ($weather['wind']['calm']) {
		$nowind = ', aucun vent';
		$def_nowind = 'calme';
	}
	switch ($weather['sky']) {
		case 1:
			$weather['sky'] = 'cieux clairs' . $nowind;
			break;
			
		case 2:
			$weather['sky'] = 'bon' . $nowind;
			break;
			
		case 3:
			$weather['sky'] = 'g&eacute;n&eacute;ralement d&eacute;gag&eacute;' . $nowind;
			break;
			
		case 4:
			$weather['sky'] = 'partiellement nuageux' . $nowind;
			break;
			
		case 5:
			$weather['sky'] = 'g&eacute;n&eacute;ralement nuageux' . $nowind;
			break;
			
		case 6:
			$weather['sky'] = 'couvert' . $nowind;
			break;
			
		case 7:
			$weather['sky'] = 'ciel tr&egrave;s bas' . $nowind;
			break;
			
		default:
			$weather['sky'] = $def_nowind;
			break;
	}
	
	return ($weather['sky']);
}

function convert_clouds_fr ($condition) {
	
	switch ($condition) {
		case 'FEW':
			$condition = 'quelques nuages';
			break;
			
		case 'SCT':
		case 'SKT':
			$condition = 'nuages dispers&eacute;s';
			break;
			
		case 'BKN':
			$condition = 'nuages fragment&eacute;';
			break;
			
		case 'OVC':
			$condition = 'couvert';
			break;
			
		case 'VV':
			$condition = 'ciel bas';
			break;
			
		default:
			break;
	}
	return ($condition);
}

function convert_cumulus_fr ($type) {
	switch ($type) {
		case 'TCU':
			$type = ', y compris le cumulus congestus de grande &eacute;tendue verticale';
			break;
			
		case 'CB':
			$type = ', y compris le cumulonimbus';
			break;
			
		default:
			break;
	}
	return ($type);
}

function fill_clouds_fr ($group) {
	global $lowceiling;
	
	$clouds['condition']	= convert_clouds_fr ($group['condition']);
	$clouds['cumulus']		= convert_cumulus_fr ($group['cumulus']);
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

function convert_approach_fr ($approach) {
	switch ($approach) {
		case 'R':
			$approach = 'droite';
			break;
			
		case 'L':
			$approach = 'gauche';
			break;
			
		case 'C':
			$approach = 'centrale';
			break;
			
		case 'RR':
			$approach = 'droite lointaine';
			break;
			
		case 'LL':
			$approach = 'gauche lointaine';
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

function convert_tendency_fr ($trend) {
	switch ($trend) {
		case 'D':
			$trend = ', d&eacute;croissante';
			break;
			
		case 'U':
			$trend = ', croissante';
			break;
			
		case 'N':
			$trend = ', aucun changement';
			break;
		
		default:
			break;
	}
	return ($trend);
}

/*-----------------------------------------------------------------------------------------
	Expands direction codes into phrases for the Visibility section.
-----------------------------------------------------------------------------------------*/

function set_directions_fr ($compass_point) {
	switch ($compass_point) {
		case 'N':
			$compass_point = ' dans le nord';
			break;
			
		case 'S':
			$compass_point = ' dans les sud';
			break;
			
		case 'E':
			$compass_point = ' dans l\'est';
			break;
			
		case 'W':
			$compass_point = ' dans l\'ouest';
			break;
			
		case 'NE':
			$compass_point = ' dans le nord-est';
			break;
			
		case 'SE':
			$compass_point = ' dans le sud-est';
			break;
			
		case 'NW':
			$compass_point = ' dans le nord-ouest';
			break;
			
		case 'SW':
			$compass_point = ' dans le sud-ouest';
			break;
			
		case '0':
			$compass_point = 'en haut';
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

function set_prefix_fr ($prefix) {

	switch ($prefix) {
		case '-1':
			$prefix = 'moins de ';
			break;
			
		case '1':
			$prefix = 'plus de ';
			break;
			
		default:
			$prefix = '';
			break;
	}
	return ($prefix);
}

function convert_pressure_change_fr ($partcode) {
	switch ($partcode) {
	
		case 0:
			$tendency = 'est augmentation, diminuant alors';
			break;
			
		case 1:
			$tendency = 'augmente, puis aucun changement, ou augmente alors l\'augmentation plus lentement';
			break;
			
		case 2:
			$tendency = 'augmente solidement ou de mani&egrave;re instable';
			break;
			
		case 3:
			$tendency = 'diminuer ou constant, alors augmentant ; ou ';
			$tendency .= 'augmentation, augmentant alors plus rapidement';
			break;
			
		case 4:
			$tendency = 'constant';
			break;
		
		case 5:
			$tendency = 'diminuer, augmentant alors';
			break;
			
		case 6:
			$tendency = 'diminuer alors constant ; ou diminuant diminuer alors plus lentement';
			break;
			
		case 7:
			$tendency = 'diminuer solidement ou de mani&egrave;re instable';
			break;
			
		case 8:
			$tendency = 'affermissez ou augmentation, diminuant alors ; ou ';
			$tendency .= 'diminuant diminuer alors plus rapidement';
			break;
			
		default:
			$tendency = '';
			break;
			
	}
	return $tendency;
}

function fill_cloudwatch_fr ($cloud) {
	switch ($cloud) {
		case 'AC':
			$cloud = 'altocumulus';
			break;
			
		case 'ACC':
			$cloud = 'altocumulus castellanus';
			break;
			
		case 'ACSL':
			$cloud = 'lenticulaire debout altocumulus';
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
			$cloud = 'lenticulaire debout cirrocumulus';
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
			$cloud = 'lenticulaire';
			break;
			
		case 'NS':
			$cloud = 'nimbostratus';
			break;
			
		case 'SC':
			$cloud = 'stratocumulus';
			break;
			
		case 'SCSL':
			$cloud = 'lenticulaire debout stratocumulus';
			break;
			
		case 'SF':
			$cloud = 'stratoform';
			break;
			
		case 'SL':
			$cloud = 'lenticulaire debout nuage';
			break;
			
		case 'ST':
			$cloud = 'stratus';
			break;
			
		case 'TCU':
			$cloud = 'cumulus congestus de grande &eacute;tendue verticale';
			break;
			
		default:
			$cloud = 'indiff&eacute;renci&eacute; nuage';
			break;
	}
	return ($cloud);
}

?>