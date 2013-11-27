<?php

/*-------------------------------------------------------------------------------
	It's not enough to key on 'RMK' and list everything following it; half of the
	really good stuff goes in remarks. So what I've done is copy over every ereg
	used in the rest of the code, and anything left over I'm calling a remark.
	
	It's not pretty, my sakes, is it ever not pretty! but it works.
	
-------------------------------------------------------------------------------*/

function eval_remarks ($parts, $part_count) {
	global $station, $remarkshead, $nsw, $recentrain;
	
	$remarks['head'] = $remarkshead;
	
	for ($i = 0; $i < $part_count; $i++) {
		$part = $parts[$i];
		
		if ($part == $station) {
			continue;
		}
//short temperature
		if(ereg('^(M?[0-9]{2})/(M?[0-9]{2}|//|XX)?$', $part)) {
			continue;

//date			
		} elseif (ereg ('^20([0-9]{2})/([0-9]{2})/([0-9]{2})$', $part)) {
			continue;

//time		
		} elseif (ereg ('([0-9]{2}:[0-9]{2})$', $part)) {
			continue;

//zed time		
		} elseif (ereg ('^(([0-9])([0-9]))([0-9]{2})([0-9]{2})Z$', $part)) {
			continue;
		
		} elseif (ereg ('^([0-9]{2})([0-9]{2})([0-9]{2})$', $part)) {
			continue;

//long temperature		
		} elseif (ereg('^T([0-1])([0-9]{3})([0-1])([0-9]{3})', $part)) {
			continue;
		
		} elseif (ereg('^T([0-1])([0-9]{3})$', $part)) {
			continue;

//minmax temp		
		} elseif (ereg('^1([0-1])([0-9]{3})$', $part)) {
			continue;
		
		} elseif (ereg('^2([0-1])([0-9]{3})$', $part)) {
			continue;
		
		} elseif (ereg('^4([0-1])([0-9]{3})([0-1])([0-9]{3})$', $part)) {
			continue;

//activity		
		} elseif (ereg('^(VC)?' . '(-|\+)?' .   '(MI|PR|BC|DR|BL|SH|TS|FZ)?' .
												'(-|\+)?' .
												'(DZ|RA|SN|SG|IC|PL|GR|GS|UP)?' .
												'(BR|FG|FU|VA|DU|SA|HZ|PY)?' .
												'(PO|SQ|FC|SS|DS)?$', $part)) {
			continue;

//visibility		
		} elseif (ereg('^([0-9]{2,4})([NS]?[EW]?)$', $part)) {
			continue;
		
		} elseif (ereg('^[0-9]{1,2}$', $part)) {
			continue;

		} elseif (ereg('^M?([1-7])(/)([1-8]{1,2})(SM)$', $part)) {
			continue;
			
		} elseif (ereg ('^M?([0-9]{1,2})(SM|M|KM)$', $part)) {
			continue;
			
		} elseif (ereg ('^(CAVOK|CIG|RMK)$', $part)) {
				
			continue;


//wind
		} elseif (ereg('^([0]{1,6})(KT|MPS|KMH)$', $part)) {
			continue;
		
		} elseif (ereg('([0-9]{3}|VRB)([0-9]{2,3})G?([0-9]{2,3})?(KT|MPS|KMH)?', $part)) {
			continue;
		
		} elseif (ereg('^([0-9]{3})V([0-9]{3})$', $part)) {
			continue;

//clouds
		} elseif (ereg('^(VV|SKC|SKT|CLR|FEW|NSC|SCT|BKN|OVC)([0-9]{3}|///)?(CB|TCU)?$', $part)) {
			continue;
			
		} elseif (ereg ('^(AC|ACC|ACSL|AS|CB|CC|CCSL|CF|CI|CS|CU|LC|NS|SC|SCSL|SF|SL|ST|TCU)([0-9])', $part)) {
			continue;

		} elseif (ereg ('^([0-9])' .
							'(AC|ACC|ACSL|AS|CB|CC|CCSL|CF|CI|CS|CU|LC|NS|SC|SCSL|SF|SL|ST|TCU)' .
							'([0-9]{3}|///)$', $part)) {
			continue;

		} elseif (ereg ('^(AC|ACC|ACSL|AS|CB|CC|CCSL|CF|CI|CS|CU|LC|NS|SC|SCSL|SF|SL|ST|TCU)$', $part)) {
			continue;

		} elseif (ereg ('^([0-9])(AC|ACC|ACSL|AS|CB|CC|CCSL|CF|CI|CS|CU|LC|NS|SC|SCSL|SF|SL|ST|TCU)$', $part)) {			
			$nextpart = $parts[$i + 1];
			if (ereg ('^(/)([0-9])(/)$', $nextpart)) {
				$i++;
			}
			
		} elseif (ereg ('^8/([0-9/])([0-9/])([0-9/])$', $part)) {
			continue;

			
//runways		
		} elseif (ereg('^R([0-9]{2})(R|L|C|RR|LL)?/([MP]?)([0-9]{4})(FT)?' .
						'([DNU]?)V?(P?)([0-9]{4})?(FT)?([DNU]?)$', $part)) {
			continue;

//precipitation		
		} elseif (ereg('^P([0-9]{3,4})', $part)) {
			continue;
		
		} elseif (ereg('^4/([0-9]{3})', $part)) {
			continue;
		
		} elseif (ereg('^6([0-9]{4})$', $part)) {
			continue;
		
		} elseif (ereg('^7([0-9]{4})', $part)) {
			continue;

//pressure			
		} elseif (ereg('A([0-9]{4})', $part)) {
			continue;

		} elseif (ereg('Q([0-9]{4})', $part)) {
			continue;

//long pressure
		} elseif (ereg ('^SLP([0-9]{3})$', $part)) {
			continue;
			
		} elseif (ereg ('^5([0-9])([0-9]{3})$', $part)) {
			continue;
			
		} elseif (ereg ('^PRES(FR|RR)$', $part)) {
			continue;
			
			
//for-real remarks coming up

		} elseif ($part == 'NSW' || $part == 'NOSIG') {
			$remarks['set'] = 1;
			$remarks['data'] .= $nsw . ' ';
		} elseif ($part == 'RERA') {
			$remarks['set'] = 1;
			$remarks['data'] .= $recentrain . ' ';
		} elseif ($part == 'LTG') {
			$remarks['set'] = 1;
			$remarks['data'] .= ' lightning ';
		} elseif ($part == 'DST' || $part == 'DSNT') {
			$remarks['set'] = 1;
			$remarks['data'] .= ' distant ';

		} else {
			$remarks['set'] = 1;
			$remarks ['data'] .= $part . ' ';
		}
	}
	
	return $remarks;
}
?>