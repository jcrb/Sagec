<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC --------------------------------
/**
*	programme: 		brule_carto.php
*	date de création: 	23/09/2005
*	auteur:			jcb
*	description:	
*	@version:		$Id$
*	modifié le		23/09/2005
*/
// 
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete = "SELECT cle_valeur FROM cles WHERE cle_nom = 'googlemap'";
$resultat = ExecRequete($requete,$connexion);
$rub = mysql_fetch_array($resultat);
$cle = $rub['cle_valeur'].'"';
?>

<html>
<head>
<title>Who locations in London</title>
<link rel="shortcut icon" href="../images/sagec67.ico" />
<!-- Ceci est spécifique de Sagec, localhost  -->
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo($cle) ?> type="text/javascript"></script> 
<link href="brule.css" rel="stylesheet" type="text/css" />
</head>

<body >

<p><strong>Burn Centers</strong></p>
<div id="map" ></div>
<script type="text/javascript">
//<![CDATA[

var map = new GMap2(document.getElementById("map"));
map.addControl(new GLargeMapControl());
map.addControl(new GMapTypeControl());
map.addControl(new GScaleControl());
map.setCenter(new GLatLng(51.512161, -0.14110), 5, G_NORMAL_MAP);

// Creates a marker whose info window displays the given number
function createMarker(point, number)
{
	var marker = new GMarker(point);
	// Show this markers index in the info window when it is clicked
	var html = number;
	GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(html);});
	return marker;
};

<?php

$requete = "SELECT Hop_nom, service_nom,service_ID,ville_longitude, ville_latitude,ville_nom, ad_longitude, ad_latitude
				FROM hopital, service, adresse,ville
				WHERE service.Type_ID = '10'
				AND service.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				";
//print($requete."<BR>");
$back="brules/brule_carto.php";
$resultat = ExecRequete($requete,$connexion);
if (!$resultat)
{
	echo "no results ";
}
while($row = mysql_fetch_array($resultat))
{
	if($row['ad_latitude'] !=0 && $row['ad_longitude']!=0)
	{
		echo "var point = new GLatLng(" . $row['ad_latitude'] . "," . $row['ad_longitude'] . ");\n";
		$contact="brule_service.php?service_ID=".$row['service_ID']."&back=".$back;
		$m = addslashes($row['ville_nom']).'<br>'.addslashes($row['Hop_nom']).'<br><a href="'.$contact.'"">'.addslashes($row['service_nom']).'</a>';
		echo "var marker = createMarker(point, '".$m. "');\n";
		echo "map.addOverlay(marker);\n";
		echo "\n";
	}
	else 
	if($row['ville_latitude'] !='' && $row['ville_longitude']!='')
	{
		echo "var point = new GLatLng(" . $row['ville_latitude'] . "," . $row['ville_longitude'] . ");\n";
		$contact="brule_service.php?service_ID=".$row['service_ID']."&back=".$back;
		$m = addslashes($row['ville_nom']).'<br>'.addslashes($row['Hop_nom']).'<br><a href="'.$contact.'"">'.addslashes($row['service_nom']).'</a>';
		echo "var marker = createMarker(point, '".$m. "');\n";
		echo "map.addOverlay(marker);\n";
		echo "\n";
	}
}

?>
//]]>
</script>

</body>
</html>
