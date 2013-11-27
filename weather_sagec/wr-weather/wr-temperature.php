<?php
/*---------------------------------------------------------------------------------------------
	CONTENTS
		
		eval_temperature				($parts, $part_count)
		format_temps					($form)
		eval_minmax_temp				($parts, $part_count)
		format_minmaxtemps				($form)
		calc_rel_humidity				($parts, $part_count)
		format_rel_humidity				()
		calc_humidity					($parts, $part_count)
		format_humidity					($form)
		calc_heat_index					($parts, $part_count)
		format_heat_index				($form)
		calc_windchill					($parts, $part_count)
		format_windchill				($form)
		eval_pressure					($parts, $part_count)
		format_pressure					($form)
		eval_pressure_long				($parts, $part_count)
		format_pressure_long			($form)
---------------------------------------------------------------------------------------------*/

/*---------------------------------------------------------------------------------------------
	Temperature and Pressure are two fundamental readings that all stations will provide if
	they provide nothing else. They are essential to working out short-range weather forecasts,
	and also provide the basics for calculating humidity, heat index and windchill.
	
	Temperature coding specs:
		
		http://www.met.tamu.edu/class/METAR/metar-pg11-t-td.html
		
	Pressure specs:
	
		http://www.met.tamu.edu/class/METAR/metar-pg12-pres.html
		
	Standard temperature and dewpoint measurements are listed in the body of the METAR in
	whole numbers Celsius, separated by a forward slash (/). A number below zero will be
	preceded by an 'M'. If the dewpoint is missing, either '//' or 'XX' will appear in its
	place, or possibly something else, as this part doesn't seem to be as standardized as
	one might wish.
	
	More finely-tuned measurements may be listed in the remarks. If so, they are preceded by
	a 'T' and formatted so:
	
		T[plus or minus zero][tens][ones][tenths][plus or minus zero][tens][ones][tenths]
		
	Plus or minus zero is indicated by a 0 or a 1 in that slot, 1 indicating negative.
	
	If the dewpoint is missing, it's just missing and we have to do without.
---------------------------------------------------------------------------------------------*/

function eval_temperature ($parts, $part_count) {
	global $weather;
	
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];
																				
		if(ereg('^(M?[0-9]{2})/(M?[0-9]{2}|//|XX)?$', $part, $regs)) {
			$weather['temperature']['temp_c'] = round(strtr($regs[1], 'M', '-'));
			$weather['temperature']['temp_f'] = round(strtr($regs[1], 'M', '-') * (9/5) + 32);
			$weather['temperature']['tempset'] = 1;
			
			$dew = $regs[2];
			
			if (ereg('^M?[0-9]{2}', $dew)) {
				$weather['temperature']['dew_c'] = round(strtr($regs[2], 'M', '-'));
				$weather['temperature']['dew_f'] = round(strtr($regs[2], 'M', '-') * (9/5) + 32);
				$weather['temperature']['dewset'] = 1;
			}
			
		} elseif (ereg('^T([0-1])([0-9]{3})([0-1])([0-9]{3})', $part, $regs)) {
			$temp = $regs[2] / 10;
			$temp_c = number_format($temp, 1);
			if ($regs[1]) {
				$temp_c = '-' . $temp_c;
			}
			$temp = $temp_c * (9/5) + 32;
			$temp_f = number_format ($temp, 1);
			
			$weather['temperature']['temp_c'] = $temp_c;
			$weather['temperature']['temp_f'] = $temp_f;
			$weather['temperature']['tempset'] = 1;

			$temp = $regs[4] / 10;
			$temp_c = number_format($temp, 1);
			if ($regs[3]) {
				$temp_c = '-' . $temp_c;
			}
			$temp = $temp_c * (9/5) + 32;
			$temp_f = number_format ($temp, 1);
			
			$weather['temperature']['dew_c'] = $temp_c;
			$weather['temperature']['dew_f'] = $temp_f;
			$weather['temperature']['dewset'] = 1;
			
		} elseif (ereg('^T([0-1])([0-9]{3})$', $part, $regs)) {
			$temp = $regs[2] / 10;
			$temp_c = number_format($temp, 1);
			if ($regs[1]) {
				$temp_c = '-' . $temp_c;
			}
			$temp = $temp_c * (9/5) + 32;
			$temp_f = number_format ($temp, 1);
			
			$weather['temperature']['temp_c'] = $temp_c;
			$weather['temperature']['temp_f'] = $temp_f;
			$weather['temperature']['tempset'] = 1;

		} 
	}
}

/*-----------------------------------------------------------------------------------
	Formats temperature and dewpoint into nice strings for display.
-----------------------------------------------------------------------------------*/

function format_temps ($form) {
	global $weather, $temphead, $dewhead;
	
	$temp_f = $weather['temperature']['temp_f'];
	$temp_c = $weather['temperature']['temp_c'];
	$dew_f = $weather['temperature']['dew_f'];
	$dew_c = $weather['temperature']['dew_c'];
	
	$temps['temphead'] = $temphead;
	$temps['dewhead'] = $dewhead;
	
	switch ($form) {
		case 'temp-fc':
			$temps['tempdata'] = $temp_f . '&deg;F (' . $temp_c . '&deg;C)';
			break;
			
		case 'temp-cf':
			$temps['tempdata'] = $temp_c . '&deg;C (' . $temp_f . '&deg;F)';
			break;

		case 'dew-fc':
			$temps['dewdata'] = $dew_f . '&deg;F (' . $dew_c . '&deg;C)';
			break;
			
		case 'dew-cf':
			$temps['dewdata'] = $dew_c . '&deg;C (' . $dew_f . '&deg;F)';
			break;
			
		default:
			break;
	}
	return ($temps);
}

/*---------------------------------------------------------------------------------------
	Min/max temperature data is not recorded by all stations; when it is, it appears in
	the remarks and only at planned intervals. Specs:
	
		http://www.met.tamu.edu/class/METAR/metar-pg13-rmk.html
		
	There are three possible sets: last 6 hours' minimum, last 6 hours' maximum, and
	last 24 hours' max/min (given as a single unit).
	
	Format:
		last 6 hours' max: 1[plus or minus][tens][ones][tenths]
		last 6 hours' min: 2[plus or minus][tens][ones][tenths]
		
		last 24 hours' max/min:
			4[plus or minus][tens][ones][tenths][plus or minus][tens][ones][tenths]
			
	NB: setting a $remarksflag since some stations send their wind data without any
	trailing KT or KMS or MPS, which, if the wind is from 200 degrees to 219 degrees,
	and only 2 slots are used to show the speed (because it's in meters per second, chiz)
	it looks JUST LIKE a 6-hour min temp notation. Bloody non-conformists.
	
---------------------------------------------------------------------------------------*/

function eval_minmax_temp ($parts, $part_count) {
	global $weather;
	$remarksflag = false;

	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];

		if ($part == 'RMK' || $part == 'REMARKS') {
			$remarksflag = true;
		}
		
		if ($remarksflag) {
			if (ereg('^1([0-1])([0-9]{3})$', $part, $regs)) {
				$temp = $regs[2] / 10;
				$temp_c = number_format($temp, 1);
				if ($regs[1]) {
					$temp_c = '-' . $temp_c;
				}
				$temp = $temp_c * (9/5) + 32;
				$temp_f = number_format ($temp, 1);
				
				$weather['temp_min_max']['max6h_c'] = $temp_c;
				$weather['temp_min_max']['max6h_f'] = $temp_f;
				$weather['temp_min_max']['maxset6'] = 1;
				
			} elseif (ereg('^2([0-1])([0-9]{3})$', $part, $regs)) {
				$temp = $regs[2] / 10;
				$temp_c = number_format($temp, 1);
				if ($regs[1]) {
					$temp_c = '-' . $temp_c;
				}
				$temp = $temp_c * (9/5) + 32;
				$temp_f = number_format ($temp, 1);
				
				$weather['temp_min_max']['min6h_c'] = $temp_c;
				$weather['temp_min_max']['min6h_f'] = $temp_f;
				$weather['temp_min_max']['minset6'] = 1;
	
			} elseif (ereg('^4([0-1])([0-9]{3})([0-1])([0-9]{3})$', $part, $regs)) {
				$temp = $regs[2] / 10;
				$temp_c = number_format($temp, 1);
				if ($regs[1]) {
					$temp_c = '-' . $temp_c;
				}
				$temp = $temp_c * (9/5) + 32;
				$temp_f = number_format ($temp, 1);
				
				$weather['temp_min_max']['max24h_c'] = $temp_c;
				$weather['temp_min_max']['max24h_f'] = $temp_f;
				$weather['temp_min_max']['maxset24'] = 1;
	
				$temp = $regs[4] / 10;
				$temp_c = number_format($temp, 1);
				if ($regs[3]) {
					$temp_c = '-' . $temp_c;
				}
				$temp = $temp_c * (9/5) + 32;
				$temp_f = number_format ($temp, 1);
				
				$weather['temp_min_max']['min24h_c'] = $temp_c;
				$weather['temp_min_max']['min24h_f'] = $temp_f;
				$weather['temp_min_max']['minset24'] = 1;
			}
		}
	}
}

/*-----------------------------------------------------------------------------------
	Formats min/max 6 & 24 temperature and dewpoint into nice strings for display.
-----------------------------------------------------------------------------------*/

function format_minmaxtemps ($form) {
	global $weather, $temp6head, $temp24head;

	$max6h_c = $weather['temp_min_max']['max6h_c'];
	$max6h_f = $weather['temp_min_max']['max6h_f'];
	$min6h_c = $weather['temp_min_max']['min6h_c'];
	$min6h_f = $weather['temp_min_max']['min6h_f'];
	
	$max24h_c = $weather['temp_min_max']['max24h_c'];
	$max24h_f = $weather['temp_min_max']['max24h_f'];
	$min24h_c = $weather['temp_min_max']['min24h_c'];
	$min24h_f = $weather['temp_min_max']['min24h_f'];

	$temps['head6'] = $temp6head;
	$temps['head24'] = $temp24head;


	switch ($form) {
		case 'minmax6h-fc':
			$temps['data6'] = $min6h_f . '&deg;/' . $max6h_f . '&deg;F (' . $min6h_c . '&deg;/' . $max6h_c . '&deg;C)';
			break;
			
		case 'minmax6h-cf':
			$temps['data6'] = $min6h_c . '&deg;/' . $max6h_c . '&deg;C (' . $min6h_f . '&deg;/' . $max6h_f . '&deg;F)';
			break;
			
		case 'minmax24h-fc':
			$temps['data24'] = $min24h_f . '&deg;/' . $max24h_f . '&deg;F (' . $min24h_c . '&deg;/' . $max24h_c . '&deg;C)';
			break;
			
		case 'minmax24h-cf':
			$temps['data24'] = $min24h_c . '&deg;/' . $max24h_c . '&deg;C (' . $min24h_f . '&deg;/' . $max24h_f . '&deg;F)';
			break;
			
		default:
			break;
	}
	return ($temps);
}	

/*---------------------------------------------------------------------------------------------
	Relative humidity is calculated from the current temperature and dewpoint. If those values
	have not already been recorded in the giant $weather data structure, this function will
	first attempt to find out the temps, and if that doesn't work out, will simply return
	empty and the RH value will not be displayed in the final output.
---------------------------------------------------------------------------------------------*/

function calc_rel_humidity ($parts, $part_count) {
	global $weather;
	if (!$weather['temperature']['tempset'] || !$weather['temperature']['dewset']) {
		eval_temperature($parts, $part_count);
	}
	if (!$weather['temperature']['tempset'] || !$weather['temperature']['dewset']) {
		return;
	}
	
	$dp = $weather['temperature']['dew_c'];
	$t = $weather['temperature']['temp_c'];

	$val1 = 237.3 + $t;
	$val2 = 237.3 + $dp;
	$divisor = ($val2 * $val1);
	
	$val3 = $dp - $t;
	$dividee = 1779.75 * $val3;
	
	$val4 = ($dividee / $divisor) + 2;
	$result = pow(10, $val4);
	
	$weather['rel_humidity'] = number_format($result, 1);
}

function format_rel_humidity() {
	global $weather, $relhumhead;
	
	$rh['head'] = $relhumhead;
	$rh['data'] = $weather['rel_humidity'] . '%';
	return ($rh);
}

/*----------------------------------------------------------------------------------------------
	Humidity is something else again. Requires that we already have the temperature and the
	relative humidity values. Again, if they're not already stored, this function makes the 
	effort and, if unsuccessful, returns empty. 
----------------------------------------------------------------------------------------------*/

function calc_humidity ($parts, $part_count) {
	global $weather;
	
	if (empty($weather['rel_humidity'])) {
		calc_rel_humidity ($parts, $part_count);
	}
	if (empty($weather['rel_humidity'])) {
		return;
	}
	
	$tc = $weather['temperature']['temp_c'];
	
	$e = (6.112 * pow(10, 7.5 * $tc / (237.7 + $tc)) * $weather['rel_humidity'] / 100) - 10;
	
	$weather['humidex']['humidex_c'] = number_format($tc + 5/9 * $e, 1);
	$weather['humidex']['humidex_f'] =
			number_format($weather['humidex']['humidex_c'] * 9/5 + 32, 1);
	$weather['humidex']['humset'] = 1;
}

function format_humidity ($form) {
	global $weather, $humidhead;
	
	$temp_f = $weather['humidex']['humidex_f'];
	$temp_c = $weather['humidex']['humidex_c'];
	
	$humidity['head'] = $humidhead;
	
	switch ($form) {
		case 'hum-index-fc':
			$humidity['data'] = $temp_f . '&deg;F (' . $temp_c . '&deg;C)';
			break;
			
		case 'hum-index-cf':
			$humidity['data'] = $temp_c . '&deg;C (' . $temp_f . '&deg;F)';
			break;

		default:
			break;
	}
	return ($humidity);
}

/*--------------------------------------------------------------------------------------------
	Heat Index
	
	Formula checked against that at http://www.srh.noaa.gov/bmx/tables/heat_index.html
	
	Looks awful, don't it? Requires relative humidity and temperature, plus a chorus line of
	constants. The temperature has to be over 70 degrees Fahrenheit or no dice.
	
	Same story, third verse-- if there's no data, nothing appears on screen.
--------------------------------------------------------------------------------------------*/

function calc_heat_index ($parts, $part_count) {
	global $weather;
	
	if (!$weather['temperature']['tempset']) {
		eval_temperature ($parts, $part_count);
	}
	
	if ($weather['temperature']['temp_f'] > 70) {
		if (empty ($weather['rel_humidity'])) {
			calc_rel_humidity ($parts, $part_count);
		}
	} else {
		return;
	}
	
	$tf = $weather['temperature']['temp_f'];
	$rh = $weather['rel_humidity'];

	$weather['heatindex']['heatindex_f'] = number_format(-42.379 + 2.04901523 * $tf
																	+ 10.1433312 * $rh
																	- 0.22475541 * $tf * $rh
																	- 0.00683783 * $tf * $tf
																	- 0.05481717 * $rh * $rh
																	+ 0.00122874 * $tf * $tf * $rh
																	+ 0.00085282 * $tf * $rh * $rh
																	- 0.00000199 * $tf * $tf * $rh * $rh);
	$weather['heatindex']['heatindex_c'] =
				number_format(($weather['heatindex']['heatindex_f'] - 32) / 1.8);
	$weather['heatindex']['heatset'] = 1;
}

function format_heat_index($form) {
	global $weather, $heathead;
	
	$temp_f = $weather['heatindex']['heatindex_f'];
	$temp_c = $weather['heatindex']['heatindex_c'];
	
	$temps['head'] = $heathead;
	
	switch ($form) {
		case 'heat-index-fc':
			$temps['data'] = $temp_f . '&deg;F (' . $temp_c . '&deg;C)';
			break;
			
		case 'heat-index-cf':
			$temps['data'] = $temp_c . '&deg;C (' . $temp_f . '&deg;F)';
			break;

		default:
			break;
	}
	return ($temps);
}

/*--------------------------------------------------------------------------------------------
	Windchill
	
	Formula checked against that at http://www.srh.noaa.gov/bmx/tables/the_new_chill.html,
	which seemingly calculates a more gentle curve than the older formula.
	
	Requires the temperature to be below 40 degrees Fahrenheit, and the windspeed to be
	above 4 miles per hour. 
--------------------------------------------------------------------------------------------*/

function calc_windchill ($parts, $part_count) {
	global $weather;
	
	if (!$weather['temperature']['tempset']) {
		eval_temperature ($parts, $part_count);
	}
	
	if (!$weather['temperature']['tempset']) {
		return;
	}
	
	if ($weather['temperature']['temp_f'] <= 40) {
		if (empty ($weather['wind']['mph'])) {
			eval_wind ($parts, $part_count);
		}
	} else {
		return;
	}
	
	if ($weather['wind']['mph'] < 4) {
		return;
	}
	$tf = $weather['temperature']['temp_f'];
	$tc = $weather['temperature']['temp_c'];
	
	$mph = $weather['wind']['mph'];
	
	$wind_f = pow((float)$mph, 0.16);
	$wind_c = pow(($mph/1.609), 0.16);
			
	$weather['windchill']['windchill_f'] =
		number_format(35.74 + 0.6215 * $tf - 35.75 * $wind_f + 0.4275 * $tf * $wind_f);

	$weather['windchill']['windchill_c'] = 
		number_format(13.112 + 0.6215 * $tc - 13.37 * $wind_c + 0.3965 * $tc * $wind_c);
		
	$weather['windchill']['chillset'] = 1;
}

function format_windchill ($form) {
	global $weather, $chillhead;
	
	$temp_f = $weather['windchill']['windchill_f'];
	$temp_c = $weather['windchill']['windchill_c'];
	
	$temps['head'] = $chillhead;
	
	switch ($form) {
		case 'windchill-fc':
			$temps['data'] = $temp_f . '&deg;F (' . $temp_c . '&deg;C)';
			break;
			
		case 'windchill-cf':
			$temps['data'] = $temp_c . '&deg;C (' . $temp_f . '&deg;F)';
			break;

		default:
			break;
	}
	return ($temps);
}

/*----------------------------------------------------------------------------------------------
	Pressure shows up practically in the clear, it's just a matter of running conversions
	using tried and true formulas.
	
	Some stations send it as inches mercury; these are formatted:
	
		A[tens][ones][tenths][hundredths]
		
	Others send it as hectoPascals:
		
		Q[thousands][hundreds][tens][ones]
		
----------------------------------------------------------------------------------------------*/

function eval_pressure ($parts, $part_count) {
	global $weather;
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];

		if (ereg('A([0-9]{4})', $part, $regs)) {
			$weather['altimeter']['inhg'] = number_format($regs[1] / 100, 2);
			$weather['altimeter']['mmhg'] = number_format($regs[1] * 0.254, 1, '.', '');
			$weather['altimeter']['hpa']  = round($regs[1] * 0.33864);
			$weather['altimeter']['atm']  = number_format($regs[1] * 3.3421e-4, 3, '.', '');
		} elseif (ereg('Q([0-9]{4})', $part, $regs)) {
			$weather['altimeter']['hpa']  = round($regs[1]);
			$weather['altimeter']['mmhg'] = number_format($regs[1] * 0.75006, 1, '.', '');
			$weather['altimeter']['inhg'] = number_format($regs[1] * 0.02953, 2);
			$weather['altimeter']['atm']  = number_format($regs[1] * 9.8692e-4, 3, '.', '');
		}
	}
}

function format_pressure ($form) {
	global $weather, $pressurehead;
	
	$inhg = $weather['altimeter']['inhg'];
	$mmhg = $weather['altimeter']['mmhg'];
	$hpa = $weather['altimeter']['hpa'];
	$atm = $weather['altimeter']['atm'];
	
	$pressure['head'] = $pressurehead;

	switch ($form) {
		case 'pressure-inhg':
			$pressure['data'] = $inhg . ' inHg';
			break;
			
		case 'pressure-mmhg':
			$pressure['data'] = $mmhg. ' mmHg';
			break;

		case 'pressure-atm':
			$pressure['data'] = $atm. ' atm';
			break;
			
		case 'pressure-hpa':
			$pressure['data'] = $hpa. ' hPa';
			break;

		case 'pressure-inhg-hpa':
			$pressure['data'] = $inhg . ' inHg (' . $hpa . ' hPa)';
			break;
			
		case 'pressure-inhg-hpa-atm':
			$pressure['data'] = $inhg . ' inHg (' . $hpa . ' hPa) (' . $atm . ' atm)';
			break;

		case 'pressure-inhg-mmhg-hpa-atm':
			$pressure['data'] = $inhg . ' inHg (' . $mmhg . ' mmHg) ('. $hpa . ' hPa) (' . $atm . ' atm)';
			break;

		default:
			break;
	}
	return ($pressure);
}

/*--------------------------------------------------------------------------------------------
	Barometric changes are recorded and reported every 3 hours, if any changes, and if that
	station reports such measurements. They'll be in remarks, coded as per:

		http://www.met.tamu.edu/class/METAR/metar-pg13-rmk.html
		
	Format:
			5[rate of change][tens][ones][tenths]
			
	'Rates of change' range from 0 to 8 and correspond with particular phrases; these are set
	up in convert_pressure_change_$language. As wordy as some of them are, I believe they have
	very specific meanings to meteorologists so I've not tried to rephrase any.
	
	Sea Level pressure may be sent in the remarks by some stations; it is coded as per that
	same page.
	
	Format: SLP[tens][ones][tenths] of hectoPascals. As far as I can tell, one is supposed to
	assume a leading '9', such that SLP097 becomes SLP 909.7.
		
--------------------------------------------------------------------------------------------*/
function eval_pressure_long ($parts, $part_count) {
	global $weather, $rising, $falling, $language;
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];

		if (ereg ('^SLP([0-9]{3})$', $part, $regs)) {
			$slp = '9' . $regs[1];
			$weather['slp']['hpa'] = number_format ($slp / 10, 1);
			$weather['slp']['mmhg'] = number_format($weather['slp']['hpa'] * 0.75006, 1, '.', '');
			$weather['slp']['inhg'] = number_format($weather['slp']['hpa'] * 0.02953, 2);
			$weather['slp']['atm']  = number_format($weather['slp']['hpa'] * 9.8692e-4, 3, '.', '');
		
		} elseif (ereg ('^5([0-9])([0-9]{3})$', $part, $regs)) {
			$localised = "convert_pressure_change_" . $language;
			$weather['pressure3']['rate'] = $localised($regs[1]);
			
			$weather['pressure3']['hpa'] = number_format($regs[2] / 10, 1);
			$weather['pressure3']['mmhg'] = number_format($weather['pressure3']['hpa'] * 0.75006, 1, '.', '');
			$weather['pressure3']['inhg'] = number_format($weather['pressure3']['hpa'] * 0.02953, 2);
			$weather['pressure3']['atm']  = number_format($weather['pressure3']['hpa'] * 9.8692e-4, 3, '.', '');
		} elseif (ereg ('^PRES(FR|RR)$', $part, $regs)) {
			if ($regs[1] == 'RR') {
				$weather['pressure3']['risefall'] = $rising;
			} else {
				$weather['pressure3']['risefall'] = $falling;
			}
		}
	}
}


function format_pressure_long ($form) {
	global $weather, $pressure3head, $slphead, $pressureratehead;
	
	$inhg6 = $weather['pressure3']['inhg'];
	$mmhg6 = $weather['pressure3']['mmhg'];
	$hpa6 = $weather['pressure3']['hpa'];
	$atm6 = $weather['pressure3']['atm'];

	$inhg_slp = $weather['slp']['inhg'];
	$mmhg_slp = $weather['slp']['mmhg'];
	$hpa_slp = $weather['slp']['hpa'];
	$atm_slp = $weather['slp']['atm'];
	
	$pressure['pressure3']['head'] = $pressure3head;
	$pressure['slp']['head'] = $slphead;

	$pressure['pressure3']['ratehead'] = $pressureratehead;
	$pressure['pressure3']['risefall'] = $weather['pressure3']['risefall'];
	$pressure['pressure3']['rate'] = $weather['pressure3']['rate'];
	

	switch ($form) {
		case 'pressurelong-inhg':
			$pressure['pressure3']['data'] = $inhg6 . ' inHg';
			$pressure['slp']['data'] = $inhg_slp . ' inHg';
			break;
			
		case 'pressurelong-mmhg':
			$pressure['pressure3']['data'] = $mmhg6. ' mmHg';
			$pressure['slp']['data'] = $mmhg_slp . ' mmHg';
			break;

		case 'pressurelong-atm':
			$pressure['pressure3']['data'] = $atm6. ' atm';
			$pressure['slp']['data'] = $atm_slp . ' atm';
			break;
			
		case 'pressurelong-hpa':
			$pressure['pressure3']['data'] = $hpa6 . ' hPa';
			$pressure['slp']['data'] = $hpa_slp . ' hPa';
			break;

		case 'pressurelong-inhg-hpa':
			$pressure['pressure3']['data'] = $inhg6 . ' inHg (' . $hpa6 . ' hPa)';
			$pressure['slp']['data'] = $inhg_slp . ' inHg (' . $hpa_slp . ' hPa)';
			break;
			
		case 'pressurelong-inhg-hpa-atm':
			$pressure['pressure3']['data'] = $inhg6 . ' inHg (' . $hpa6 . ' hPa) (' . $atm6 . ' atm)';
			$pressure['slp']['data'] = $inhg_slp . ' inHg (' . $hpa_slp . ' hPa) (' . $atm_slp . ' atm)';
			break;

		case 'pressurelong-inhg-mmhg-hpa-atm':
			$pressure['pressure3']['data'] = $inhg6 . ' inHg (' . $mmhg6 . ' mmHg) ('. $hpa6 . ' hPa) (' . $atm6 . ' atm)';
			$pressure['slp']['data'] = $inhg_slp . ' inHg (' . $mmhg_slp . ' mmHg) ('. $hpa_slp . ' hPa) (' . $atm_slp . ' atm)';
			break;

		default:
			break;
	}
	return ($pressure);
}
			
?>