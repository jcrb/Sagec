<?php
/*--------------------------------------------------------------------------------------------
	CONTENTS:
	
		do_temps				($temp, $suffix, $prefix)
		do_dewpoint				($temp, $suffix, $prefix)
		do_minmax6				($minmax, $suffix, $prefix)
		do_minmax24				($minmax, $suffix, $prefix)
		do_relative_humidity	($relhum, $suffix, $prefix)
		do_humidity				($humidity, $suffix, $prefix)
		do_heat_index			($heat, $suffix, $prefix)
		do_windchill			($chill, $suffix, $prefix)
		do_pressure				($pressure, $suffix, $prefix)
		do_pressurelong			($pressurelong, $suffix, $prefix)
		do_activity				($conditions, $suffix, $prefix)
		do_visibility			($vis, $suffix, $prefix)
		do_precip				($p, $suffix, $prefix)
		do_snow					($s, $suffix, $prefix)
		do_waterequiv			($w, $suffix, $prefix)
		do_precip6				($p6, $suffix, $prefix)
		do_precip24				($p24, $suffix, $prefix)
		do_wind					($wind, $suffix, $prefix)
		do_windrose				($windrose, $suffix, $prefix)
		do_clouds				($clouds, $suffix, $prefix)
		do_runways				($runways, $suffix, $prefix)
		do_metar				($glops, $suffix, $prefix)
		do_remarks				($remarks, $suffix, $prefix)
--------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------
	All of the functions in this file do the final string concatenation of the selected
	values.
--------------------------------------------------------------------------------------------*/

function do_temps ($temp, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['temperature']['tempset']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $temp['temphead'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		} 
		$formatted .= $temp['tempdata'] . $suffix;
	}
	return ($formatted);
}

function do_dewpoint ($temp, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['temperature']['dewset']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $temp['dewhead'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $temp['dewdata'] . $suffix;
	}
	return ($formatted);
}

function do_minmax6 ($minmax, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['temp_min_max']['maxset6']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $minmax['head6'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $minmax['data6'] . $suffix;
	}
	return ($formatted);
}

function do_minmax24 ($minmax, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['temp_min_max']['maxset24']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $minmax['head24'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $minmax['data24'] . $suffix;
	}
	return ($formatted);
}

function do_relative_humidity ($relhum, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['rel_humidity']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $relhum['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $relhum['data'] . $suffix;
	}
	return ($formatted);
}

function do_humidity ($humidity, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['humidex']['humset']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $humidity['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $humidity['data'] . $suffix;
	}
	return ($formatted);
}

function do_heat_index ($heat, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;
	
	if ($weather['heatindex']['heatset']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $heat['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $heat['data'] . $suffix;
	}
	return ($formatted);
}

function do_windchill ($chill, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['windchill']['chillset']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $chill['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $chill['data'] . $suffix;
	}
	return ($formatted);
}

function do_pressure ($pressure, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['altimeter']['inhg']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $pressure['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $pressure['data'] . $suffix;
	}
	return ($formatted);
}

function do_pressurelong ($pressurelong, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;
	
	if ($weather['pressure3']['inhg']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $pressurelong['pressure3']['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $pressurelong['pressure3']['data'] . $suffix;
	}
	if ($weather['pressure3']['risefall']) {
		$formatted .= $prefix . $pressurelong['pressure3']['risefall'] . $suffix;
	}
	if ($weather['pressure3']['rate']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $pressurelong['pressure3']['ratehead'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}	
		$formatted .= $pressurelong['pressure3']['rate'] . $suffix;
	}
	if ($weather['slp']['inhg']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $pressurelong['slp']['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $pressurelong['slp']['data'] . $suffix;
	}
	return ($formatted);
}

function do_activity ($conditions, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;
	
	if ($conditions['a'] || $weather['sky']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $conditions['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $conditions['data'] . $suffix;
	}
	return ($formatted);
}

function do_visibility ($vis, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;
	
	if ($weather['visibility']['miles']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $vis['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $vis['data'] . $suffix;
	}
	return ($formatted);
}

function do_precip ($p, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;
	
	if ($weather['precipitation']['mm']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $p['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $p['data'] . $suffix;
	}
	return ($formatted);
}

function do_snow ($s, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;
	
	if ($weather['precipitation']['snow_mm']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $s['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $s['data'] . $suffix;
	}
	return ($formatted);
}

function do_waterequiv ($w, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;
	
	if ($weather['precipitation']['water_equiv_mm']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $w['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $w['data'] . $suffix;
	}
	return ($formatted);
}

function do_precip6 ($p6, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['precipitation']['mm_6h']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $p6['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $p6['data'] . $suffix;
	}
	return ($formatted);
}

function do_precip24 ($p24, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['precipitation']['mm_24h']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $p24['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $p24['data'] . $suffix;
	}
	return ($formatted);
}

function do_wind ($wind, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['wind']['knots']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $wind['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $wind['speed'] . $suffix;
		
		if ($weather['gust']['knots']) {
			$formatted .= $prefix;
			if ($displayheads) {
				$formatted .= $wind['gusthead'];
				if ($breakafterhead) {
					$formatted .= $suffix . "\n" . $prefix;
				}
			}
			$formatted .= $wind['gust'] . $suffix;
		}
	}
	return ($formatted);
}

function do_windrose ($windrose, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['wind']['knots']) {

		if ($weather['compass']['deg']) {
			$formatted .= $prefix;
			if ($displayheads) {
				$formatted .= $windrose['compass_main_head'];
				if ($breakafterhead) {
					$formatted .= $suffix . "\n" . $prefix;
				}
			}
			$formatted .= $windrose['compass_main'] . $suffix;
			
			if ($weather['compass']['var_begin']) {
				$formatted .= $prefix;
				if ($displayheads) {
					$formatted .= $windrose['compass_shift_head'];
					if ($breakafterhead) {
						$formatted .= $suffix . "\n" . $prefix;
					}
				}
				$formatted .= $windrose['compass_shift'] . $suffix;
			}
		}	
	}
	return ($formatted);
}

function do_clouds ($clouds, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['clouds']['a']['condition']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $clouds['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $clouds['data'] . $suffix;
	}
	return ($formatted);
}

function do_runways ($runways, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['runway']['a']['nr']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $runways['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $runways['data'] . $suffix;
	}
	return ($formatted);
}

function do_cloudwatch ($clouds, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($weather['cloudwatch']['total']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $clouds['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $clouds['data'] . $suffix;
	}
	return ($formatted);
}

function do_metar ($glops, $suffix, $prefix) {
	global $displayheads, $breakafterhead;

	if ($glops) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= 'METAR: ';
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $glops . $suffix;
	}
	return ($formatted);	
}

function do_remarks ($remarks, $suffix, $prefix) {
	global $displayheads, $breakafterhead, $weather;

	if ($remarks['set']) {
		$formatted .= $prefix;
		if ($displayheads) {
			$formatted .= $remarks['head'];
			if ($breakafterhead) {
				$formatted .= $suffix . "\n" . $prefix;
			}
		}
		$formatted .= $remarks['data'] . $suffix;
	}
	return ($formatted);
}

?>