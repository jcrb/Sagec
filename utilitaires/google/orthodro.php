<?php
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
	//return $ortho * 6366;
	return $ortho * 6378;
}

?>
