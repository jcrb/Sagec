<?php

/*--------------------------------------------------------------------------------------------
	CONTENTS:
	
		function eval_precip				($parts, $part_count)
		function eval_past_precip			($parts, $part_count)
		function format_precip				($form)
		function format_snow				($form)
		function format_water_equiv			($form)
		function format_precip6				($form)
		function format_precip24			($form)
		function eval_wind					($parts, $part_count)
		function format_wind_speed			($form)
		function format_wind_dir			()
		function fill_wind_speed			($current, $measure)
		function eval_activity				($parts, $part_count)
		function fill_activity				($activity)
		function reality_check				($activity, $check)
		function format_activity			($conditions, $sky)
		function make_activity_string		($activity)
--------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------
	Precipitation is measured and reported according to these standards:
	
	http://www.met.tamu.edu/class/METAR/metar-pg13-rmk.html
	
	It is considered an 'additive', along with the 6hr and 24hr min/max reports, and will
	normally be found in the Remarks of a METAR, if it is present at all. (Not all stations
	will, or are supposed to, report the additives.)
	
	Snow depth is actually a separate grouping, since 'precipitation' already includes all
	freezing stuff. Again, only some stations are tasked with reporting snow depth or the
	"water equivalent of snow on the ground."
	
	Format for hourly precipitation: Prrrr ( P[tens][ones][tenths][hundredths] ).
	
	Format for snow depth: 4/sss ( 4/[hundreds][tens][ones] )
	
	Format for water equivalent: 933RRR ( 933[tens][ones][tenths] )

	'0000' is considered a 'trace'. Measurement is in inches by default, god knows why.
--------------------------------------------------------------------------------------------*/

function eval_precip ($parts, $part_count) {
	global $weather;
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];

		if (ereg('^P([0-9]{3,4})', $part, $regs)) {
			if ($regs[1] == '0000') {
				$weather['precipitation']['in'] = -1;
				$weather['precipitation']['mm'] = -1;
			} else {
				$weather['precipitation']['in'] = number_format($regs[1]/100, 2);
				$weather['precipitation']['mm'] = number_format($regs[1]*0.254, 2, '.', '');
			}
		} elseif (ereg('^4/([0-9]{3})', $part, $regs)) {
			if ($regs[1] == '0000') {
				$weather['precipitation']['snow_in'] = -1;
				$weather['precipitation']['snow_mm'] = -1;
			} else {
				$weather['precipitation']['snow_in'] = $regs[1] * 1;
				$weather['precipitation']['snow_mm'] = round($regs[1] * 25.4);
			}
		} elseif (ereg('^933([0-9]{3})', $part, $regs)) {
			if ($regs[1] == '0000') {
				$weather['precipitation']['water_equiv_in'] = -1;
				$weather['precipitation']['water_equiv_mm'] = -1;
			} else {
				$weather['precipitation']['water_equiv_in'] = number_format($regs[1]/10, 2);
				$weather['precipitation']['water_equiv_mm'] = number_format($regs[1] * 2.54, 2, '.', '');
			}
		}
	}
}

/*-----------------------------------------------------------------------------------------
	Evaluates the METAR data for any last-3-6hr or last-24hr precipitation measurement data.
	Will not be present in more than a handful.
	
	Format for last-3-6hr: 6RRRR ( 6 [tens][ones][tenths][hundredths] )
	
	Format for last-24hr: 7RRRR ( 7 [tens][ones][tenths][hundredths] )
-----------------------------------------------------------------------------------------*/

function eval_past_precip ($parts, $part_count) {
	global $weather;

	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];

		if (ereg('^6([0-9]{4})$', $part, $regs)) {		
			if ($regs[1] == '0000') {
				$weather['precipitation']['in_6h'] = -1;
				$weather['precipitation']['mm_6h'] = -1;
			} else {
				$weather['precipitation']['in_6h'] = number_format($regs[1]/100, 2);
				$weather['precipitation']['mm_6h'] = number_format($regs[1]*0.254, 2);
			}
		} elseif (ereg('^7([0-9]{4})', $part, $regs)) {
			if ($regs[1] == '0000') {
				$weather['precipitation']['in_24h'] = -1;
				$weather['precipitation']['mm_24h'] = -1;
			} else {
				$weather['precipitation']['in_24h'] = number_format($regs[1]/100, 2);
				$weather['precipitation']['mm_24h'] = number_format($regs[1]*0.254, 2);
			}
		}
	}
}

/*-------------------------------------------------------------------------------------
	These next three functions return values if options 'precip-inmm' or 'precip-mmin'
	were passed initially in $weatherargs AND if there are any values to return. If
	there's no data, they go back empty.
-------------------------------------------------------------------------------------*/

function format_precip ($form) {
	global $weather, $lessthanzero, $preciphead;
	
	$in = $weather['precipitation']['in'];
	$mm = $weather['precipitation']['mm'];
	$precip['head'] = $preciphead;
	
	if (!$in) {
		return '';
	} elseif ($in == '-1'){
		$precip['data'] = $lessthanzero;
		return $precip;
	}
	
	switch ($form) {
		case 'precip-mmin':
			$precip['data'] = $mm . ' mm (' . $in . ' in)';
			break;
			
		case 'precip-inmm':
			$precip['data'] = $in . ' in (' . $mm . ' mm)';
			break;
		default:
			break;
	}
	return $precip;
}

function format_snow ($form) {
	global $weather, $snowhead, $lessthanzero;
	
	$in = $weather['precipitation']['snow_in'];
	$mm = $weather['precipitation']['snow_mm'];
	
	$precip['head'] = $snowhead;
	
	if (!$in) {
		return '';
	} elseif ($in == '-1'){
		$precip['data'] = $lessthanzero;
		return $precip;
	}
	
	switch ($form) {
		case 'precip-mmin':
			$precip['data'] = $mm . ' mm (' . $in . ' in)';
			break;
			
		case 'precip-inmm':
			$precip['data'] = $in . ' in (' . $mm . ' mm)';
			break;
		default:
			break;
	}
	return $precip;
}

function format_water_equiv ($form) {
	global $weather, $waterhead, $lessthanzero;
	
	$in = $weather['precipitation']['water_equiv_in'];
	$mm = $weather['precipitation']['water_equiv_mm'];
	
	$precip['head'] = $waterhead;
	
	if (!$in) {
		return '';
	} elseif ($in == '-1'){
		$precip['data'] = $lessthanzero;
		return $precip;
	}
	
	switch ($form) {
		case 'precip-mmin':
			$precip['data'] = $mm . ' mm (' . $in . ' in)';
			break;
			
		case 'precip-inmm':
			$precip['data'] = $in . ' in (' . $mm . ' mm)';
			break;
		default:
			break;
	}
	return $precip;
}

function format_precip6 ($form) {
	global $weather, $precip6head, $lessthanzero;
	
	$in = $weather['precipitation']['in_6h'];
	$mm = $weather['precipitation']['mm_6h'];
	$precip['head'] = $precip6head;
	if (!$in) {
		return '';
	} elseif ($in == '-1'){
		$precip['data'] = $lessthanzero;
		return $precip;
	}
	
	switch ($form) {
		case 'precip6-mmin':
			$precip['data'] = $mm . ' mm (' . $in . ' in)';
			break;
			
		case 'precip6-inmm':
			$precip['data'] = $in . ' in (' . $mm . ' mm)';
			break;
			
		default:
			break;
	}
	return $precip;
}

function format_precip24 ($form) {
	global $weather, $precip24head, $lessthanzero;
	
	$in = $weather['precipitation']['in_24h'];
	$mm = $weather['precipitation']['mm_24h'];
	$precip['head'] = $precip24head;
	
	if (!$in) {
		return '';
	} elseif ($in == '-1'){
		$precip = $lessthanzero;
		return $precip;
	}
	
	switch ($form) {
		case 'precip24-mmin':
			$precip['data'] = $mm . ' mm (' . $in . ' in)';
			break;
			
		case 'precip24-inmm':
			$precip['data'] = $in . ' in (' . $mm . ' mm)';
			break;
		default:
			break;
	}
	return $precip;
}


/*--------------------------------------------------------------------------------------
	Wind is considered a standard and handled as per the specs outlined here:
	http://www.met.tamu.edu/class/METAR/metar-pg6.html
	
	Nearly all stations will report wind direction and speed every hour. Peak wind speed
	and wind shifts are reported in Remarks, if any. I have not yet written functions for
	decoding these.
	
	Wind direction is by compass point, with 0 degrees assumed as 'north', 90 as 'east',
	180 as 'south' and 270 as 'west'. US and Canadian stations report the speed in knots,
	while others use either meters per second or kilometers per hour.
	
	Gusts, if any, are included in the standard reported group, noted by a preceding 'G'.
	If either speed or gusts are less than 100, the leading zero may be omitted.
	
	Thus, the format for wind is:
	
			[ddd][(s)ss](G(s)ss)KT|MPS|KMH
	
	where 'd' is degrees and 's' is speed. If the wind is variable, as wind is wont to be,
	and is no more than a light, 6KT breeze, 'VRB' may be substituted for the encoded
	direction. If it is blowing more energetically, though, as well as shifting around,
	the wind group will include only the main direction, but will be followed by another
	group indicating the shift. This group is formatted so:
	
			[ddd]V[ddd]
			
	(Unfortunately for me, anyway, that same format is used to report secondary ceiling
	heights, which are themselves preceded by 'CIG' and a space. So I have to set a flag
	to catch that.)
	
	When there is no measurable air movement, wind is reported as '00000KT' and sometimes
	as '000000KT' (or MPS or KMH). This is considered 'calm' and I'm decoding it as part
	of general sky conditions rather than wind.
	
	NB: positively checking for 'RMK' since some stations send their wind data without any
	trailing KT or KMS or MPS, which, if the wind is from 200 degrees to 219 degrees,
	and only 2 slots are used to show the speed (because it's in meters per second, chiz)
	it looks JUST LIKE a 6-hour min temp notation. Bloody non-conformists.
	


---------------------------------------------------------------------------------------*/

function eval_wind ($parts, $part_count) {
	global $weather;
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];
		
		if ($part == 'RMK' || $i > 7) {
			return;
			
		} elseif (ereg('([0-9]{3}|VRB)([0-9]{2,3})G?([0-9]{2,3})?(KT|MPS|KMH)?$', $part, $regs)) {
			if ($regs[1] == 'VRB') {
				$weather['compass']['deg'] = 'VRB';
			} else {
//				$weather['compass']['deg'] = number_format ($regs[1] * 1);
				$weather['compass']['deg'] = $regs[1];
			}
			$weather['wind'] = fill_wind_speed ($regs[2], $regs[4]);
			
			if (!empty($regs[3])) {
				$weather['gust'] = fill_wind_speed ($regs[3], $regs[4]);
			}
																			
		} elseif (ereg('^([0-9]{3})V([0-9]{3})$', $part, $regs) && !empty($weather['wind'])) {
			$weather['compass']['var_begin'] = $regs[1];
			$weather['compass']['var_end'] = $regs[2];
		}
	}
}

/*---------------------------------------------------------------------------------------------
	If the windspeed is zero, the return value is empty and no wind notation created. Instead,
	the routines for decoding general conditions will note 'calm' in addition to whatever
	other conditions there may be.
---------------------------------------------------------------------------------------------*/

function format_wind_speed ($form) {
	global $weather, $windspeedhead, $gusthead;
	global $milesperhour, $knotsperminute, $kilometersperhour;
	
	$knots = $weather['wind']['knots'];
	$kph = $weather['wind']['kph'];
	$mph = $weather['wind']['mph'];
	
	$gknots = $weather['gust']['knots'];
	$gkph = $weather['gust']['kph'];
	$gmph = $weather['gust']['mph'];
	
	$wind['head'] = $windspeedhead;
	$wind['gusthead'] = $gusthead;
	
	if (empty($knots)) {
		return '';
	}

	switch ($form) {
		case 'wind-km':
			$wind['speed'] = $kph . $kilometersperhour;
			if ($gkph) {
				$wind['gust'] = $gkph . $kilometersperhour;
			}
			break;
			
		case 'wind-kt':
			$wind['speed'] = $knots. $knotsperminute;
			if ($gknots) {
				$wind['gust'] = $gknots . $knotsperminute;
			}
			break;

		case 'wind-mph':
			$wind['speed'] = $mph . $milesperhour;
			if ($gmph) {
				$wind['gust'] = $gmph . $milesperhour;
			}
			break;
			
		case 'wind-kmmph':
			$wind['speed'] = $kph . $kilometersperhour . ' (' . $mph . $milesperhour . ')';
			if ($gkph) {
				$wind['gust'] = $gkph . $kilometersperhour . ' (' . $gmph . $milesperhour . ')';
			}
			break;

		case 'wind-mphkm':
			$wind['speed'] = $mph . $milesperhour . ' (' . $kph . $kilometersperhour . ')';
			if ($gmph) {
				$wind['gust'] = $gmph . $milesperhour . ' (' . $gkph . $kilometersperhour . ')';
			}
			break;
			
		case 'wind-ktkmmph':
			$wind['speed'] = $knots . $knotsperminute . ' (' . $kph . $kilometersperhour . ') (' . $mph . $milesperhour . ')';
			if ($gknots) {
				$wind['gust'] = $gknots . $knotsperminute . ' (' . $gkph . $kilometersperhour . ') (' . $gmph . $milesperhour . ')';
			}
			break;

		default:
			break;
	}
	return ($wind);

}

/*-------------------------------------------------------------------------------------
	parses into plain language both main compass direction and variations thereof.
	
	returns main direction of wind (if any) as well as the shifts (if any). If there
	are no compass values, the calling switch will fail to print anything to screen.
-------------------------------------------------------------------------------------*/

function format_wind_dir ($descriptive) {
	global $weather, $windcompasshead, $windshifthead, $language;
	
	$from_compass = '';
	$to_compass = '';
	$compass = '';
	
	$wind['compass_main_head'] = $windcompasshead;
	$wind['compass_shift_head'] = $windshifthead;
	
	$localised = "convert_windrose_" . $language;
	$compass = $localised($weather['compass']['deg']);
	if (!$compass) {
		$wind['compass_main'] = '';
		$wind['compass_main_head'] = '';
	}
	
	if ($descriptive == "wind-dir") {
		if ($compass == 'variable') {
			$wind['compass_main'] = 'variable';
		} else {
			$wind['compass_main'] = $compass . ' (' . $weather['compass']['deg'] . '&deg;)';
		}
	} elseif ($descriptive == "wind-dir-short") {
		if ($compass == 'variable') {
			$wind['compass_main'] = 'var';
		} else {
			$wind['compass_main'] = $weather['compass']['deg'] . '&deg;';
		}
	}

	if ($weather['compass']['var_begin']) {
		$from_compass = $weather['compass']['var_begin'];
		$to_compass = $weather['compass']['var_end'];
		
		if($from_compass && $to_compass) {
			$wind['compass_shift'] = $from_compass . '&deg;&ndash;'  . $to_compass . '&deg;';
		} else {
			$wind['compass_shift_head'] = '';
			$wind['compass_shift'] = '';
		}
	}
	
	return $wind;
}

/*---------------------------------------------------------------------------------------
	Convert windspeed from the unit in the METAR to other common forms.
---------------------------------------------------------------------------------------*/

function fill_wind_speed ($current, $measure) {
	
	if ($current == 0) {
		$speed['knots'] = 0;
		$speed['mps'] = 0;
		$speed['mph'] = 0;
		$speed['kph'] = 0;
		return ($speed);
	}
	
	if (empty($measure)) {
		$measure = 'MPS';
	}


	switch ($measure) {
		case 'KT':
			$speed['knots'] = number_format($current * 1);
			$speed['mps'] = number_format($current * 0.5144, 1);
			$speed['mph'] = number_format($current * 1.1508, 1);
			$speed['kph'] = number_format ((($speed['mps'] * 60) * 60) / 1000, 1);
			break;
			
		case 'MPS':
			$speed['mps'] = number_format($current * 1);
			$speed['knots'] = number_format($current / 0.5144, 1);
			$speed['mph'] = number_format($current / 0.5144 * 1.1508, 1);
			$speed['kph'] = number_format ((($speed['mps'] * 60) * 60) / 1000, 1);
			break;
			
		case 'KMH':
			$speed['mps'] = number_format($current * 1000 / 3600, 1);
			$speed['knots'] = number_format($current * 1000 / 3600 / 0.5144, 1);
			$speed['mph'] = number_format($current * 1.1508, 1);
			$speed['kph'] = number_format ((($speed['mps'] * 60) * 60) / 1000, 1);
			break;
			
		default:
			break;
	}
	return ($speed);
}

/*----------------------------------------------------------------------------------------
	The touchy-feely part of weather. So what's it like outside, eh? These METAR codes try
	to answer that question, as specifically as possible. As per the specs, reproduced at
	
	http://www.met.tamu.edu/class/METAR/metar-pg9-ww.html, the gross format is:
	
		[vicinity/intensity][descriptor][precipitation][obscuration][other]
		
	With that there are rules describing what descriptors should go with which precipitations
	or obscurations, and which may NOT be coded together (not that one can rely on that).
	
	The translations to human-speak for all codes is handled by the function convert_to_$language.
	What this function (eval_activity) does is simply to try to recognise them.
	
	There can be up to three of such condition groups in any given METAR, and there may be
	even more tucked into Remarks, depending on which station issues the METAR.
	
	There may also be none at all. And, of course, there may be items that look like
	conditions codes but are not.
	
----------------------------------------------------------------------------------------*/

function eval_activity ($parts, $part_count) {
	global $weather;
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];
		
			
		if (ereg('^(VC)?' . '(-|\+)?' . '(MI|PR|BC|DR|BL|SH|TS|FZ)?' .
										'(-|\+)?' .
										'(DZ|RA|SN|SG|IC|PL|GR|GS|UP)?' .
										'(BR|FG|FU|VA|DU|SA|HZ|PY)?' .
										'(PO|SQ|FC|SS|DS)?$', $part, $regs)) {
			$activity['proximity'] = 	$regs[1];
			$activity['intensity'] = 	$regs[2];
			$activity['descriptor'] = 	$regs[3];
			$activity['intensity2'] =	$regs[4];
			$activity['precipitation'] = $regs[5];
			$activity['obscuration'] = 	$regs[6];
			$activity['other'] = 		$regs[7];

			if ($activity['descriptor'] && $activity['precipitation']) {
				$check = 'precip';
				$activity = reality_check ($activity, $check);
			}
			if ($activity['descriptor'] && $activity['obscuration']) {
				$check = 'obscur';
				$activity = reality_check ($activity, $check);
			}
			if ($activity['descriptor'] && $activity['other']) {
				$check = 'other';
				$activity = reality_check ($activity, $check);
			}
			
			if ($activity) {
				if (empty($conditions['a'])) {
					$conditions['a'] = fill_activity ($activity);
					$weather['conditions']['a'] = $conditions['a'];
				} elseif (empty($conditions['b'])) {
					$conditions['b'] = fill_activity ($activity);
					$weather['conditions']['b'] = $conditions['a'];
				} elseif (empty($conditions['c'])) {
					$conditions['c'] = fill_activity ($activity);
					$weather['conditions']['c'] = $conditions['a'];
				} else {
					return ($conditions);
				}
			}
		}
	}
	return ($conditions);
}

/*----------------------------------------------------------------------------------
	For each possible condition code group, this function sends the postulant code
	to convert_to_$language. If it comes back unchanged, it is considered to be 
	misidentified (or mis-keyed) and the entire array is re-set.
----------------------------------------------------------------------------------*/

function fill_activity ($activity) {
	global $language;

	$localised = "convert_to_" . $language;
	
	if($activity['proximity']) {
		$proximity = $localised($activity['proximity']);
		if ($proximity != $activity['proximity']) {
			$conditions['proximity'] = $proximity;
			$conditions['set'] = true;
		} else {
			$conditions['proximity'] = '';
			$conditions['set'] = false;
		}		
	}
	if($activity['intensity']) {
		$intensity = $localised($activity['intensity']);
		if ($intensity != $activity['intensity']) {
			$conditions['intensity'] = $intensity;
			$conditions['set'] = true;
		} else {
			$conditions['intensity'] = '';
			$conditions['set'] = false;
		}		
	}
	if($activity['descriptor']) {
		$descriptor = $localised($activity['descriptor']);
		if ($descriptor != $activity['descriptor']) {
			$conditions['descriptor'] = $descriptor;
			$conditions['set'] = true;
		} else {
			$conditions['descriptor'] = '';
			$conditions['set'] = false;
		}		
	}
	if($activity['intensity2']) {
		$intensity = $localised($activity['intensity2']);
		if ($intensity != $activity['intensity2']) {
			$conditions['intensity2'] = $intensity;
			$conditions['set'] = true;
		} else {
			$conditions['intensity2'] = '';
			$conditions['set'] = false;
		}		
	}
	if($activity['precipitation']) {
		$precipitation = $localised($activity['precipitation']);
		if ($precipitation != $activity['precipitation']) {
			$conditions['precipitation'] = $precipitation;
			$conditions['set'] = true;
		} else {
			$conditions['precipitation'] = '';
			$conditions['set'] = false;
		}		
	}
	if($activity['obscuration']) {
		$obscuration = $localised($activity['obscuration']);
		if ($obscuration != $activity['obscuration']) {
			$conditions['obscuration'] = $obscuration;
			$conditions['set'] = true;
		} else {
			$conditions['obscuration'] = '';
			$conditions['set'] = false;
		}		
	}
	if($activity['other']) {
		$other = $localised($activity['other']);
		if ($other != $activity['other']) {
			$conditions['other'] = $other;
			$conditions['set'] = true;
		} else {
			$conditions['other'] = '';
			$conditions['set'] = false;
		}		
	}
	return ($conditions);
}

/*-----------------------------------------------------------------------------------------------
	A rather heavy-handed approach to evaluating the legality or not of a possible conditions
	encoding. $legal is set to the various allowable combinations, then the values of the current
	activity are concatenated and checked against the ones in $legal. If a match is found, the
	group is returned intact. If not, return empty.
	
	There should not be in one group a descriptor, plus a precipitation, AND an obscuration
	and/or other. If there is, I'll just have to do my best. 
-----------------------------------------------------------------------------------------------*/

function reality_check ($activity, $check) {

	$legal = array (1 => 'BCFG','BLDU','BLSA','BLSN','BLPY','DRDU',
						'DRSA','DRSN','FZDZ','FZFG','FZRA','MIFG',
						'PRFG','SHGR','SHGS','SHPL','SHRA','SHSN',
						'TSGR','TSGS','TSPL','TSRA','TSSN');
	
	$legal_count = count ($legal);
	
	switch ($check) {
		case 'precip':
			$combo = $activity['descriptor'] . $activity['precipitation'];
			
			for ($i = 0; $i < $legal_count; $i++) {
				if ($combo == $legal[$i]) {
					return $activity;
				}
			}
			break;
			
		case 'obscur':
			$combo = $activity['descriptor'] . $activity['obscuration'];
			
			for ($i = 0; $i < $legal_count; $i++) {
				if ($combo == $legal[$i]) {
					return $activity;
				}
			}
			break;
	
		case 'other':
			$combo = $activity['descriptor'] . $activity['other'];
			
			for ($i = 0; $i < $legal_count; $i++) {
				if ($combo == $legal[$i]) {
					return $activity;
				}
			}
			break;
			
		default:
			break;
	}
	return '';
}

/*------------------------------------------------------------------------------------------
	Should there be any conditions left after all that checking, they are combined with the
	$sky value and sent off to be concatenated into a single 'conditions' string.
	
	If not, only the $sky assessment is sent. If there is one. There may not be.
------------------------------------------------------------------------------------------*/

function format_activity ($conditions, $sky) {
	global $conditionhead;
	
	$activity_string = '';
	
	$activity['head'] = $conditionhead;
	if ($sky) {
		$activity['data'] = $sky;
	}
	
	if ($conditions['a']['set']) {
		$current = $conditions['a'];
		
		if($sky) {
			$activity['data'] .= '; ';
		}
		$activity['data'] .= make_activity_string ($current);

		if ($conditions['b']['set']) {
			$current = $conditions['b'];
			$activity['data'] .= '; ' . make_activity_string ($current);
		
			if ($conditions['c']['set']) {
				$current = $conditions['c'];
				$activity['data'] .= '; ' . make_activity_string ($current);
			}
		}
	}
	
	return ($activity);
}

/*----------------------------------------------------------------------------------
	Puts all the conditions together, while ignoring the empties. It is probably
	not necessary to enclose each in an 'if' statement.
----------------------------------------------------------------------------------*/

function make_activity_string ($activity) {
	if ($activity['intensity']) {
		$string .= $activity['intensity'];
	}
	if ($activity['descriptor']) {
		$string .= $activity['descriptor'];
	}
	if ($activity['intensity2']) {
		$string .= $activity['intensity2'];
	}
	if ($activity['precipitation']) {
		$string .= $activity['precipitation'];
	}
	if ($activity['obscuration']) {
		$string .= $activity['obscuration'];
	}
	if ($activity['other']) {
		$string .= $activity['other'];
	}
	if ($activity['proximity']) {
		$string .= $activity['proximity'];
	}
	return ($string);
}

?>