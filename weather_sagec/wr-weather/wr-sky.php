<?php
/*--------------------------------------------------------------------------------------------
	CONTENTS:
	
		eval_visibility						($parts, $part_count)
		choose_compass_visibility			($group)
		format_visibility					($form)
		make_visibility_string				($form, $vis)
		eval_sky_short						($parts, $part_count)
		rate_clouds							($condition)
		
		eval_sky_detail						($parts, $part_count)
		format_clouds						($form)
		make_cloud_string					($clouds, $form)
		
		eval_cloudwatch						($parts, $part_count)
		format_cloudwatch					()
		getsector							($nextpart)
		get_cloud_number					($wmo_number)
		get_cloud_level						($wmo_level)
		fill_cloudwatch						($cloud)
		
		eval_runways						($parts, $part_count)
		fill_runway							($runway)
		format_runways						($form)
		make_runway_string					($runway, $form)
--------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------
	Visibility is a standard measurement recorded by nearly all stations, and should appear
	in the METAR itself rather than the remarks. It is formatted as per:
	
	http://www.met.tamu.edu/class/METAR/metar-pg7-vis.html
	
	The US and Canada both report visibility in statute miles (SM), while other stations
	use meters (M) or kilometers (KM). When it is reported in meters, there should be no 
	trailing unit mark, but if there is, it will be 'M'. More normally, if 'M' precedes the
	measurement, it indicates "less than", as in "less than 200 meters".
	
	To increase the fun, when the measurement is in miles, it can be reported in fractional
	notation:
			1 1/2SM
			
	resolves to one and a half miles.
	
	Meter format is vvvv(d)(d), or:
		[thousands][hundreds][tens][ones]([major direction])([minor direction])
		
	Example: 0438NW resolves to "438 meters looking northwest".
	
	Both '0000' and '9999' are special; 0000 indicates less than 50 meters while 9999 is at
	least 10,000 meters and probably more.
	
	Sector visibility measurements may be noted in the Remarks. The formats for these, when in
	statute miles, begin with the phrase 'VIS', then a space, then direction, space, then the
	distance ('SM' may or may not be present):
	
		VIS [major direction]([minor direction]) [units]( [fractions])(SM)
		
	Variable visiblity may also be noted in the Remarks, signalled with 'VIS'. The number
	group following is roughly "low number"V"high number". Format:
	
		VIS [whole number]( [fraction])V[whole number]( [fraction])
		
	In both of these, the numbers are not a standard length (ie, no leading zeros).
	If whole numbers and fractions are used, there's a space between them.
	
	I have not yet attempted to decode variable 'VIS' groups in Remarks.
	
--------------------------------------------------------------------------------------------*/

function eval_visibility ($parts, $part_count) {
	global $weather;
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];
		
		unset ($group);
		
		if ($part == 'VIS') {
			$second_vis_tag = 1;

		} elseif ($second_vis_tag && !$statute_compass) {
			if (ereg ('^(N|S|E|W|NE|SE|NW|SW)$', $part)) {
				$statute_compass = $part;
			} else {
				unset ($second_vis_tag);
			}

		} elseif (ereg('^([0-9]{2,4})([NS]?[EW]?)$', $part, $regs)) {
			if ($regs[1] == '0000' || $regs[0][0] == 'M') {
				$group['prefix'] = -1;
				$group['meter']  = 50;
				$group['km']     = 0.05;
				$group['ft']     = 164;
				$group['miles']  = 0.031;
			} elseif ($regs[1] == '9999') {
				$group['prefix'] = 1; 
				$group['meter']  = 10000;
				$group['km']     = 10;
				$group['ft']     = 32800;
				$group['miles']  = 6.2;
			} else {
				$group['prefix'] = 0; 
				$group['km']     = number_format($regs[1]/1000, 2);
				$group['miles']  = number_format($regs[1]/1609.344, 2);
				$group['meter']  = number_format($regs[1] * 1);
				$group['ft']     = round($regs[1] * 3.28084);
			}
			if (!empty($regs[2])) {
				$group['deg'] = $regs[2];
				choose_compass_visibility ($group);
			} else {
				$weather['visibility'] = $group;
			}
			
				
		} elseif (ereg('^[0-9]{1,2}$', $part)) {
				$whole_mile = $part;

			
		} elseif (ereg ('^M?([1-7])(/)([1-8]{1,2})(SM)$', $part, $regs)) {
			if ($regs[2] == '/') {
				$distance = $whole_mile + ($regs[1] / $regs[3]);
			}
			if ($regs[0][0] == 'M') {
				$group['prefix'] = -1;
			} else {
				$group['prefix'] = 0;
			}
			if ($regs[4] == 'SM') {
				$group['miles'] = number_format ($distance, 2);
				$group['ft']    = round ($distance * 5280);
				$group['km']    = number_format ($distance * 1.6093, 2);
				$group['meter'] = round ($distance * 1609.3);
			}
			
			if ($second_vis_tag) {
				$group['deg'] = $statute_compass;
				choose_compass_visibility ($group);
				unset ($second_vis_tag);
				unset ($statute_compass);
			} else {
				$weather['visibility'] = $group;
			}
			
			
		} elseif (ereg ('^M?([0-9]{1,2})(SM|M|KM)$', $part, $regs)) {
	
			$distance = $regs[1];
			if ($regs[0][0] == 'M') {
				$group['prefix'] = -1;
			} elseif ($regs[0][0] =='P') {
				$group['prefix'] = 1;
			} else {
				$group['prefix'] = 0;
			}
			
			if ($regs[2] == 'SM') {
				$group['miles'] = number_format ($distance, 2);
				$group['ft']    = round ($distance * 5280);
				$group['km']    = number_format ($distance * 1.6093, 2);
				$group['meter'] = round ($distance * 1609.3);
			} elseif ($regs[2] == 'M') {
				$group['meter'] = number_format ($distance);
				$group['ft']    = round ($distance * 3.28084);
				$group['km']    = number_format ($distance / 1000, 2);
				$group['miles'] = round (($distance * 1000) * 0.621371, 2);
			} elseif ($regs[2] == 'KM') {
				$group['km']  	= number_format ($distance, 2);
				$group['ft']    = round ($distance * 3280.84);
				$group['miles'] = number_format ($distance * 0.621371, 2);
				$group['meter'] = round ($distance * 1000);
			}
			if ($second_vis_tag) {
				$group['deg'] = $statute_compass;
				choose_compass_visibility ($group);
				unset ($second_vis_tag);
				unset ($statute_compass);
			} else {
				$weather['visibility'] = $group;
			}
			
		} elseif ($part == 'CAVOK') {
			$group['prefix'] = 1; 
			$group['km']     = 10;
			$group['meter']  = 10000;
			$group['miles']  = 6.2;
			$group['ft']     = 32800;
			
			$weather['visibility'] = $group;
		}
	}
}

/*------------------------------------------------------------------------------------------------
	There may be more than one group specifying visibility in a particular direction. 
------------------------------------------------------------------------------------------------*/

function choose_compass_visibility ($group) {
	global $weather;
	
	if (empty ($weather['compass_vis']['a']['miles'])) {
		$weather['compass_vis']['a'] = $group;
		
	} elseif (empty ($weather['compass_vis']['b']['miles'])) {
		$weather['compass_vis']['b'] = $group;
		
	} elseif (empty ($weather['compass_vis']['c']['miles'])) {
		$weather['compass_vis']['c'] = $group;
	}
}
	
/*----------------------------------------------------------------------------------------------
	Start off with the general group, and if there are any for particular directions,
	add them on.
----------------------------------------------------------------------------------------------*/

function format_visibility ($form) {
	global $weather, $visibilityhead;
	$vis_string['head'] = $visibilityhead;
	
	if ($weather['visibility']['miles']) {
		$vis_string['data'] .= make_visibility_string ($form, $weather['visibility']);
		
		if ($weather['compass_vis']['a']['miles']) {
			$vis_string['data'] .= '; ';
			$vis_string['data'] .= make_visibility_string ($form, $weather['compass_vis']['a']);
			
			if ($weather['compass_vis']['b']['miles']) {
				$vis_string['data'] .= '; ';
				$vis_string['data'] .= make_visibility_string ($form, $weather['compass_vis']['b']);

				if ($weather['compass_vis']['c']['miles']) {
					$vis_string['data'] .= '; ';
					$vis_string['data'] .= make_visibility_string ($form, $weather['compass_vis']['c']);
				}
			}
		}
	}
	return ($vis_string);
}

/*---------------------------------------------------------------------------------------------
	Each visibility group, general and directional, have the same parts and can be formatted
	in the same way.
---------------------------------------------------------------------------------------------*/

function make_visibility_string ($form, $vis) {
	global $language, $milesabbrev, $kilometerabbrev;
	
	$miles			= $vis['miles'];
	$km				= $vis['km'];
	$ft				= $vis['ft'];
	$meter			= $vis['meter'];
	$compass_point	= $vis['deg'];
	
	$localised = "set_directions_" . $language;
	$compass_point	= $localised($compass_point);
	$localised = "set_prefix_" . $language;
	$prefix			= $localised($vis['prefix']);
	
	
	if ($form == 'visibility-kmmi') {
		$vis_string = $prefix . $km . $kilometerabbrev . ' (' . $miles . $milesabbrev . ') ' . $compass_point;

	} elseif ($form == 'visibility-mikm') {
		$vis_string = $prefix . $miles . $milesabbrev . ' (' . $km . $kilometerabbrev . ') ' . $compass_point;
	}
	
	return ($vis_string);
}

/*-----------------------------------------------------------------------------------------------
	Clouds are relatively simple after dealing with visibility. Cloud observations are normally
	taken at more than one height. Coding is as per:
	
	http://www.met.tamu.edu/class/METAR/metar-pg10-sky.html
	
	Basic format is [dd(d)][hhh]([cc(c)])
		where d = description, h = height, and c = troublesome clouds
		
	Standard descriptions are FEW, SCT, BKN, OVC, and VV (vertical visibility; used when the
	ceiling is especially low); these stand for few, scattered, broken, and overcast.
	
	Troublesome clouds worth noting are towering cumulus (TCU) and cumulonimbus (CB).
	
	Some stations report other cloud sightings as part of their routine remarks; Vancouver, not
	surprisingly, is one of them. I'm decoding these separately, as "Cloudwatch".
	
	eval_short_sky does a quickie check of all cloud groups and rates the overall sky
	condition based on the most serious rating. This rating is returned as part of the general
	conditions if the 'activity' option is used.
-----------------------------------------------------------------------------------------------*/

function eval_sky_short ($parts, $part_count) {
	global $weather;
	
	$weather['sky'] = 0;
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];

		if (ereg('^([0]{1,6})(KT|MPS|KMH)$', $part)) {
			$weather['wind']['calm'] = 1;
						
		} elseif ($part == 'CAVOK') {
			$weather['sky'] = '1';
			
		} elseif (ereg('^(VV|SKC|SKT|CLR|FEW|NSC|SCT|BKN|OVC)([0-9]{3}|///)?(CB|TCU)?$', $part, $regs)) {
			$rating = rate_clouds($regs[1]);

			if ($weather['sky'] < $rating) {
				$weather['sky'] = $rating;
			}
		}
	}
}

function rate_clouds ($condition) {
	
	switch ($condition) {
		case 'SKC':
			$condition = 1;
			break;
			
		case 'NSC':
		case 'CLR':
			$condition = 2;
			break;
			
		case 'FEW':
			$condition = 3;
			break;
			
		case 'SCT':
		case 'SKT':
			$condition = 4;
			break;
			
		case 'BKN':
			$condition = 5;
			break;
			
		case 'OVC':
			$condition = 6;
			break;
			
		case 'VV':
			$condition = 7;
			break;
			
		default:
			break;
	}
	return ($condition);
}


/*------------------------------------------------------------------------------------------
	Collects any details about cloud groups and displays them if one of the 'clouds'
	options is used. Gathers up to three groups.
------------------------------------------------------------------------------------------*/

function eval_sky_detail ($parts, $part_count) {
	global $weather, $language;

	unset($group);
	unset($weather['clouds']['a']);
	unset($weather['clouds']['b']);
	unset($weather['clouds']['c']);
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];

		if (ereg('^(VV|FEW|SCT|SKT|BKN|OVC)([0-9]{3}|///)(CB|TCU)?$', $part, $regs)) {
			unset($group);
			$group['condition'] = $regs[1];
			if (!empty($regs[3])) {
				$group['cumulus'] = $regs[3];
			}
			if ($regs[2] == '000') {
				$group['ft']     = 100;
				$group['meter']  = 30;
				$group['prefix'] = -1;
			} elseif ($regs[2] == '///') {
				$group['ft']     = 'unknown';
				$group['meter']  = 'unknown';
			} else {
				$group['ft']     = $regs[2] *100;
				$group['meter']  = round($regs[2] * 30.48);
			}
			
			$localised = "fill_clouds_" . $language;
			
			if (empty($weather['clouds']['a']['condition'])) {
				$weather['clouds']['a'] = $localised($group);
				unset($group);
				
			} elseif (empty($weather['clouds']['b']['condition'])) {
				$weather['clouds']['b'] = $localised($group);
				unset($group);
				
			} elseif (empty($weather['clouds']['c']['condition'])) {
				$weather['clouds']['c'] = $localised($group);
				unset($group);
				
			}
		}
	}
}

/*-------------------------------------------------------------------------------------------
	After the cloud structures have been filled, or there weren't any to begin with, these
	two functions put them altogether.
	
	If the first structure is empty, the rest aren't fooled with as they would be empty, too.
-------------------------------------------------------------------------------------------*/

function format_clouds ($form) {
	global $weather, $cloudhead;
	
	$cloud_string = '';
	$prefix = '';
	
	if ($weather['clouds']['a']['condition']) {
		$cloud_string['head'] = $cloudhead;
		$cloud_string['data'] .= make_cloud_string ($weather['clouds']['a'], $form);
		
		if ($weather['clouds']['b']['condition']) {
			$cloud_string['data'] .= '; ' . make_cloud_string ($weather['clouds']['b'], $form);

			if ($weather['clouds']['c']['condition']) {
				$cloud_string['data'] .= '; ' . make_cloud_string ($weather['clouds']['c'], $form);
			}
		}
	}
	return ($cloud_string);
}

function make_cloud_string ($clouds, $form) {
	$condition	= $clouds['condition'];
	$cumulus	= $clouds['cumulus'];
	$prefix		= $clouds['prefix'];
	$ft			= $clouds['ft'];
	$m			= $clouds['meter'];
	
	switch ($form) {
		case 'clouds-ftm':
			$cloud_string .= $condition . ', ' . $prefix . $ft . ' ft (' . $m . ' m)' . $cumulus;
			break;

		case 'clouds-mft':
			$cloud_string .= $condition . ', ' . $prefix . $m . ' m (' . $ft . ' ft)' . $cumulus;
			break;
	}
	return ($cloud_string);
}

/*------------------------------------------------------------------------------------------------
	Cloudwatching
	
	I
	There's not a lot about this group in the web handbook; as far as I've been able to sort out,
	though, cloud notations outside of the general ceiling and visibility groups are made in
	this format:
	
			[cc(c)(c)][sector]
			
	In Canada, anyway.
	
	As many cloud sightings as there are will be strung into one group; SF1CI2CI3CU2 is not unusual.
	The numbers appear to refer to sections of the sky; I've seen references to dividing the sky
	into eight sections and I assume from this that the sections are divided along compass lines:
	north, northeast, east, southeast, south, southwest, west, northwest. But that could just be me,
	so I've not gone so far as to substitute 'east' for 'sector #3' yet.
	
	Since this kind of cloudwatch group is of indeterminate length, I have to use a lot of for() loops
	to define the variables, and try real hard to notice when I've hit the end of the line.
	
	II
	Another kind is formatted:
			[number of clouds][cc(c)(c)][ten thousands][thousands][hundreds]
			
	where 'c' is the cloud type (CB, ACC, TCU, etc.) and is preceded by the number of that kind of
	cloud and followed by the height in feet. This latter measurement mirrors that of the more
	general 'clouds' codes used to evaluate overall sky conditions (see 'eval_sky_detail'). This is
	a very cool standard. I've only seen it in Japan. I'm hoping it catches on.
	
	III
	Then sometimes the cloud type is listed without any further info. I suspect this of being a
	mis-key on the part of the station operator, but whattheheck.
	
	IV
	Lastly, I lied. There is a cloud standard defined, but only Mexico, bless their hearts, seems to
	follow it:
		http://www.met.tamu.edu/class/METAR/metar-pg13-rmk.html
		
	Its format is:
	
		8/[WMO cloud number, low slot][WMO cloud number, middle slot][WMO cloud number, high slot]
		
	If there overcast below a level, that level is coded '/'. So it's '8', followed by a forward
	slash, then either three numbers or forward slashes. I'm not saying it's a good standard, I'm
	just trying to get along.


	The $weather['cloudwatch'] structure merges all formats, using a large hammer.
	
------------------------------------------------------------------------------------------------*/

function eval_cloudwatch ($parts, $part_count) {
	global $weather;
	
	$cloudcount = 0;
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];

		if (ereg ('^(AC|ACC|ACSL|AS|CB|CC|CCSL|CF|CI|CS|CU|LC|NS|SC|SCSL|SF|SL|ST|TCU)([0-9])', $part, $regs)) {
			$size = strlen ($part);
			$match = $part;
			
			for ($j = 0; $j <= $size; $j++) {
				if ( ereg ('[0-9]', $match[$j])) {
					$thispartcount++;
					$cloudcount++;
					$type = 'cloud' . $cloudcount;
					$quad = 'quad' . $cloudcount;
					
					$cloudset[$type] = $walk;
					$cloudset[$quad] = $match[$j];
					unset ($walk);
					continue;
				}
				$walk .= $match[$j];
			}
			
			for ($j = 1; $j <= $thispartcount; $j++) {
				$weather['cloudwatch']['cloud' . $j] = $cloudset['cloud' . $j];
				$weather['cloudwatch']['quad' . $j] = $cloudset['quad' . $j];
				$weather['cloudwatch']['height' . $j]['ft'] = '';
				$weather['cloudwatch']['height' . $j]['meter'] = '';
				$weather['cloudwatch']['level' . $j] = '';
				$weather['cloudwatch']['count' . $j] = '';
			}
		} elseif (ereg ('^([0-9])' .
							'(AC|ACC|ACSL|AS|CB|CC|CCSL|CF|CI|CS|CU|LC|NS|SC|SCSL|SF|SL|ST|TCU)' .
							'([0-9]{3}|///)$', $part, $regs)) {
							
			if ($regs[3] == '000') {
				$height['ft']     = 100;
				$height['meter']  = 30;
			} elseif ($regs[3] == '///') {
				$height['ft']     = 'unknown';
				$height['meter']  = 'unknown';
			} else {
				$height['ft']     = $regs[3] *100;
				$height['meter']  = round($regs[3] * 30.48);
			}

			
			$cloudcount++;
			$weather['cloudwatch']['cloud' . $cloudcount] = $regs[2];
			$weather['cloudwatch']['height' . $cloudcount]['ft'] = $height['ft'];
			$weather['cloudwatch']['height' . $cloudcount]['meter'] = $height['meter'];
			$weather['cloudwatch']['count' . $cloudcount] = $regs[1] . ' ';
			$weather['cloudwatch']['level' . $cloudcount] = '';
			$weather['cloudwatch']['quad' . $cloudcount] = '';

		} elseif (ereg ('^([0-9])(AC|ACC|ACSL|AS|CB|CC|CCSL|CF|CI|CS|CU|LC|NS|SC|SCSL|SF|SL|ST|TCU)$', $part, $regs)) {
			$cloudcount++;
			$weather['cloudwatch']['cloud' . $cloudcount] = $regs[2];
			$weather['cloudwatch']['height' . $cloudcount]['ft'] = '';
			$weather['cloudwatch']['height' . $cloudcount]['meter'] = '';
			$weather['cloudwatch']['count' . $cloudcount] = $regs[1] . ' ';
			$weather['cloudwatch']['quad' . $cloudcount] = getsector ($parts[$i + 1]);
			$weather['cloudwatch']['level' . $cloudcount] = '';

		} elseif (ereg ('^(AC|ACC|ACSL|AS|CB|CC|CCSL|CF|CI|CS|CU|LC|NS|SC|SCSL|SF|SL|ST|TCU)$', $part, $regs)) {
			$cloudcount++;
			$weather['cloudwatch']['cloud' . $cloudcount] = $regs[1];
			$weather['cloudwatch']['height' . $cloudcount]['ft'] = '';
			$weather['cloudwatch']['height' . $cloudcount]['meter'] = '';
			$weather['cloudwatch']['count' . $cloudcount] = '';
			$weather['cloudwatch']['quad' . $cloudcount] = '';
			$weather['cloudwatch']['level' . $cloudcount] = '';
			
		} elseif (ereg ('^8/([0-9/])([0-9/])([0-9/])$', $part, $regs)) {

			for ($j = 1; $j <= 3; $j++) {
			
				if ($regs[$j] != "/") {
					$cloudcount++;
					$weather['cloudwatch']['cloud' . $cloudcount] = get_cloud_number ($regs[$j]);
					$weather['cloudwatch']['height' . $cloudcount]['ft'] = '';
					$weather['cloudwatch']['height' . $cloudcount]['meter'] = '';
					$weather['cloudwatch']['count' . $cloudcount] = '';
					$weather['cloudwatch']['quad' . $cloudcount] = '';
					$weather['cloudwatch']['level' . $cloudcount] = get_cloud_level ($j);
				}
			}
		}
	}
	$weather['cloudwatch']['total'] = $cloudcount;
}

function format_cloudwatch ($form) {
	global $weather, $cloudwatchhead, $sector, $language;
	
	$cloud_string['head'] = $cloudwatchhead;
	$localised = "fill_cloudwatch_" . $language;
	
	$i = $weather['cloudwatch']['total'];
	
	for ($c = 1; $c <= $i; $c++) {
		$weather['cloudwatch']['cloud' . $c] = $localised($weather['cloudwatch']['cloud' . $c]);
		
		$cloud = $weather['cloudwatch']['cloud' . $c];
		$quad = $weather['cloudwatch']['quad' . $c];
		$ft = $weather['cloudwatch']['height' . $c]['ft'];
		$meter = $weather['cloudwatch']['height' . $c]['meter'];
		$count = $weather['cloudwatch']['count' . $c];
		$level = $weather['cloudwatch']['level' . $c];
		
		if ($level) {
			$level = ', ' . $weather['cloudwatch']['level' . $c] . ' level';
		}
		
		if (ereg ('^[0-9]$', $quad)) {
			$quad = ' ' . $sector . ' ' . $quad;
		}
		
		if ($meter && $form == 'cloudwatch-mft') {
			$height = ' at ' . $meter . ' m (' . $ft . ' ft)';
		} elseif ($meter && $form == 'cloudwatch-ftm') {
			$height = ' at ' . $ft . ' ft (' . $meter . ' m)';
		}
		
		$cloud_string['data'] .= $count . $cloud . $quad . $height . $level;
		
		if ($c < $i) {
			$cloud_string['data'] .= '; ';
		}
	}
	return ($cloud_string);
}

/*---------------------------------------------------------------------------------------------------
	This one's for NASA. Specifically, for station KTTS.
---------------------------------------------------------------------------------------------------*/

function getsector ($nextpart) {
	if (ereg ('^(/)([0-9])(/)$', $nextpart, $regs)) {
		$quad = $regs[2];
		return ($quad);
	}
	return '';
}

/*---------------------------------------------------------------------------------------------------
	This one's for the WMO. And Mexico.
---------------------------------------------------------------------------------------------------*/

function get_cloud_number ($wmo_number) {

	switch ($wmo_number) {
		case '0':
			$cloud = 'CI';
			break;
			
		case '1':
			$cloud = 'CB';
			break;
			
		case '2':
			$cloud = 'CU';
			break;
			
		case '3':
			$cloud = 'NS';
			break;
			
		case '4':
			$cloud = 'ST';
			break;
			
		case '5':
			$cloud = 'SC';
			break;
			
		case '6':
			$cloud = 'AS';
			break;
			
		case '7':
			$cloud = 'AC';
			break;
			
		case '8':
			$cloud = 'CS';
			break;
			
		case '9':
			$cloud = 'CC';
			break;
			
		default:
			break;
	}
	return ($cloud);
}

function get_cloud_level ($wmo_level) {
	global $low, $middle, $high;
	
	switch ($wmo_level) {
		case '1':
			$level = $low;
			break;
		case '2':
			$level = $middle;
			break;
		case '3':
			$level = $high;
			break;
		default:
			break;
	}
	return $level;
}

/*-----------------------------------------------------------------------------------------------------
	Runway Visual Ranges are coded as per:
	
	http://www.met.tamu.edu/class/METAR/metar-pg8-RVR.html
	
	Runway notations supplement the standard Visibility measurements, since conditions on runways can
	differ from each other and from those of other nearby locations, and because that information is
	crucial to pilots.
	
	I strongly suspect that only stations at airports will report this information. Call me cynical. I
	also suspect that very, very few people will care to display this information on their websites.
	But as it costs no processing time just to code the functions, and as PHP Weather had already made
	a jolly good stab at decoding them, I felt it would be slacking if I left them out.
	
	Below is a detail on just how the $regs will evaluate, depending on what information is present in
	a given runway group, but the gist is:
	
	R[0-9][0-9]([approach])/([MP])[0-9][0-9][0-9][0-9](FT)([DNU])([V](P)[0-9][0-9][0-9][0-9](FT))([DNU])

		1. Begins with 'R'; then a 2-digit runway number follows.
		2. R, L, C, (or RR or LL) if present. Signifies 'right', 'left' or 'centre' approach. Will
			contain the "/" char regardless.
		3. M or P, if present. Minus or Plus. Actual conditions outside instrument range.
		4. 4-digit number, either the minimum visibility, or the visibility, depending on presence of #8.
		5. 'FT', if measured in feet; empty if in meters.
		7. D, N, U, if present. Indicates if the trend is Down, No change, or Up. Modifies value of #4.
			May be followed by V, or may only contain V, or may be entirely empty. (V indicates
			Variability.)
		7. P, if present. Plus.
		8. 4-digit number, if present. Indicates maximum visibility. Its presence ID's #4 as
			'minimum visibility'.
		9. 'FT', if max visibility measured in feet; blank if in meters or no max visibility measurement.
		10. D, N, U, if present. Modifies max visibility, if any.

	UPSHOT: There will always be a Runway, followed by a distance. If there are two distances, one
	is min and the other is max. If there is a trend noted, it will only be noted once. Same with
	P or M modifiers. Distances are by default in meters, and US stations will use 'FT' to signal
	ranges reported in feet.
------------------------------------------------------------------------------------------------------*/

function eval_runways ($parts, $part_count) {
	global $weather;

	unset($group);
	unset($weather['runway']['a']);
	unset($weather['runway']['b']);
	unset($weather['runway']['c']);
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];

//key
//1         2              3      4         5    6         7   8          9    10
//([0-9]{2})(R|L|C|RR|LL)?/([MP]?)([0-9]{4})(FT)?([DNU]?)V?(P?)([0-9]{4})?(FT)?([DNU]?)
	
	
		if (ereg('^R([0-9]{2})(R|L|C|RR|LL)?/([MP]?)([0-9]{4})(FT)?' .
						'([DNU]?)V?(P?)([0-9]{4})?(FT)?([DNU]?)$', $part, $regs)) {
			unset($group);
			$group['nr'] = $regs[1];
			
			if (!empty($regs[2])) {
				$group['approach'] = $regs[2];
			}
			if (!empty($regs[8])) {
				if (!empty($regs[6])) {
					$group['min_tendency'] = $regs[6];
				}
				if (!empty($regs[10])) {
					$group['max_tendency'] = $regs[10];
				}
				if ($regs[3] == 'M') {
					$group['min_prefix'] = -1;
				}
				
				if ($regs[4] == '0000') {
					$group['min_meter'] = 'nil';
					$group['min_ft']    = 'nil';
				} else {
					if (empty ($regs[9])) {
						$group['min_meter'] = $regs[4] * 1;
						$group['min_ft']    = round ($regs[4] * 3.2808);
					} else {
						$group['min_meter'] = round ($regs[4] * 0.3048);
						$group['min_ft']    = $regs[4] * 1;;
					}
				}

				if ($regs[7] == 'P') {
					$group['max_prefix'] = 1;
				}
				
				if ($regs[8] == '0000') {
					$group['max_meter'] = 'nil';
					$group['max_ft']    = 'nil';
				} else {
					if (empty ($regs[9])) {
						$group['max_meter'] = $regs[8] * 1;
						$group['max_ft']    = round ($regs[8] * 3.2808);
					} else {
						$group['max_meter'] = round ($regs[8] * 0.3048);
						$group['max_ft']    = $regs[8] * 1;
					}
				}
			} else {
				$group['tendency'] = $regs[6];
				if ($regs[3] == 'M') {
					$group['prefix'] = -1;
				} elseif ($regs[3] == 'P') {
					$group['prefix'] = 1;
				}
				
				if ($regs[4] == '0000') {
					$group['meter'] = 'nil';
					$group['ft']    = 'nil';
				} else {
					if (empty ($regs[5])) {
						$group['meter'] = $regs[4] * 1;
						$group['ft']    = round ($regs[4] * 3.2808);
					} else {
						$group['meter'] = round ($regs[4] * 0.3048);
						$group['ft']    = $regs[4] * 1;
					}
				}
			}
			
			if (empty ($weather['runway']['a']['nr'])) {
				$weather['runway']['a'] = fill_runway ($group);				
				unset ($group);
				
			} elseif (empty ($weather['runway']['b']['nr'])) {
				$weather['runway']['b'] = fill_runway ($group);
				unset ($group);
				
			}elseif (empty ($weather['runway']['c']['nr'])) {
				$weather['runway']['c'] = fill_runway ($group);
				unset ($group);
				
			} else {
				return;
			}
		}
	}
}

/*-------------------------------------------------------------------------------------------
	Takes the data just evaluated and, after expanding and converting the terser bits,
	returns it as a unit.
-------------------------------------------------------------------------------------------*/
function fill_runway ($runway) {
	global $language;
	
	$group['nr'] = $runway['nr'];
	
	$localised = "convert_approach_" . $language;
	$group['approach']		= $localised($runway['approach']);
	
	$localised = "convert_tendency_" . $language;
	$group['tendency']		= $localised($runway['tendency']);
	$group['min_tendency']	= $localised($runway['min_tendency']);
	$group['max_tendency']	= $localised($runway['max_tendency']);
	
	$localised = "set_prefix_" . $language;
	$group['prefix']		= $localised($runway['prefix']);
	$group['min_prefix']	= $localised($runway['min_prefix']);
	$group['max_prefix']	= $localised($runway['max_prefix']);
	
	$group['meter']			= $runway['meter'];
	$group['min_meter']		= $runway['min_meter'];
	$group['max_meter']		= $runway['max_meter'];
	$group['ft']			= $runway['ft'];
	$group['min_ft']		= $runway['min_ft'];
	$group['max_ft']		= $runway['max_ft'];
	
	return ($group);
}


/*-------------------------------------------------------------------------------------------
	Will handle up to 3 RVR groups. Those with data are sent off for string creation, and 
	the results are concatenated here into a single line for final display. If there is no
	runway data, none of this happens, and only an empty string is returned.
-------------------------------------------------------------------------------------------*/

function format_runways ($form) {
	global $weather, $runwayhead;
	
	if ($weather['runway']['a']['nr']) {
		$runway_string['head'] = $runwayhead;
		$runway_string['data'] .= make_runway_string($weather['runway']['a'], $form);
		
		if ($weather['runway']['b']['nr']) {
			$runway_string['data'] .= '; ';
			$runway_string['data'] .= make_runway_string($weather['runway']['b'], $form);
			
			if ($weather['runway']['c']['nr']) {
				$runway_string['data'] .= '; ';
				$runway_string['data'] .= make_runway_string($weather['runway']['c'], $form);
			}
		}
	}
	return ($runway_string);
}

/*-----------------------------------------------------------------------------------
	Have populated runway structures with expanded data, converted as necessary.
	Final strings created here and returned to be concatenated all together as a
	single line.
-----------------------------------------------------------------------------------*/

function make_runway_string ($runway, $form) {
	global $runwaydesig;
	
	$runway_string .= $runwaydesig . ' #' . $runway['nr'];
	if ($runway['approach']) {
		$runway_string .= '(' . $runway['approach'] . ') - ';
	} else {
		$runway_string .= ' - ';
	}
	
	if ($form == 'runways-ftm') {
		if ($runway['ft']) {
			$runway_string .= $runway['prefix'] . $runway['ft'] . ' ft (' . $runway['meter'] . ' m)' . $runway['tendency'];
		}
		if ($runway['min_ft']) {
			$runway_string .= ' (min) ' . $runway['min_prefix'] . $runway['min_ft'] . ' ft (' . $runway['min_meter'] . ' m)' . $runway['min_tendency'];
		}
		if ($runway['max_ft']) {
			$runway_string .= ' / (max) ' . $runway['max_prefix'] . $runway['max_ft'] . ' ft (' . $runway['max_meter'] . ' m)' . $runway['max_tendency'];
		}
	} else {
		if ($runway['meter']) {
			$runway_string .= $runway['prefix'] . $runway['meter'] . ' m (' . $runway['ft'] . ' ft)' . $runway['tendency'];
		}
		if ($runway['min_meter']) {
			$runway_string .= ' (min) ' . $runway['min_prefix'] . $runway['min_meter'] . ' m (' . $runway['min_ft'] . ' ft)' . $runway['min_tendency'];
		}
		if ($runway['max_meter']) {
			$runway_string .= ' / (max) ' . $runway['max_prefix'] . $runway['max_meter'] . ' m (' . $runway['max_ft'] . ' ft)' . $runway['max_tendency'];
		}
	}
	return ($runway_string);
}


?>