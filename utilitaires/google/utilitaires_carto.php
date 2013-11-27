<?php
/**
* utilitaires_carto.php
*/

/**
* Calcul de la distance orthodromique entre deux points
* @version $Id: brule_cherche.php 35 2008-02-19 22:50:08Z jcb $
* @author JCB
* @param [in] $latA  latitude du point A
* @param [in] $longA longitude du point A
* @param [in] $latB  latitude du point B
* @param [in] $longB longitude du point B
* @return distance en km
*/
function orthodro($latA,$longA,$latB,$longB)
{
	$ortho = acos(cos(deg2rad($latA))*cos(deg2rad($latB))*cos(deg2rad($longA-$longB))+sin(deg2rad($latA))*sin(deg2rad($latB)));
	return $ortho * 6366;
}

/**
* fonction de comparaison. S'utilise avec la méthode php usort
*	ex usort($b,cmp); tie le tableau $b
* @param [in] $a valeur A
* @param [in] $b valeur B
* @return 0 si a = b, 1 si a > b, -1 si a < b
*/
function cmp ($a, $b) {
    if ($a['dist'] == $b['dist']) return 0;
    return ($a['dist'] > $b['dist']) ? 1 : -1;
}

/**
*	dec2min
* 	transforme degrés décimaux en deg/mn/sec
*	1 degré = 60 min
*	1mn=60 sec
*	ex: 34,53 degrés = 34 degrés + 0,55 degré
*	0,53 degré = 0,53*60 = 31,8 minutes = 31 minutes + 0,8 minute
*	0,8 minute = 48 secondes
*	34,55 degrés = 34Â° 31mn 48 sec
*/
function dec2min($dec=34.53)
{
	$x = explode(".",$dec);
	$deg = $x[0]." deg";
	$y = (".".$x[1])*60;
	$y = explode(".",$y);
	$min = $y[0];
	$z = (".".$y[1])*60;
	$z = explode(".",$z);
	$sec = $z[0];
	return $deg." ".$min."' ".$sec."''";
}

/**
*	min2dec
*	transforme 34° 31mn 48 sec en degré décimaux
*/
function min2dec($min)
{

}
?>