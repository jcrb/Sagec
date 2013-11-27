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
//
//	programme: 		cherche_adresse.php
//	date de création: 	06/02/2005
//	auteur:			jcb
//	description:		Met le contenu du fichier dans une table
//	version:		1.1
//	maj le:			23/09/2005 Apostrophes
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
//include("utilitaires/google/key.php");
include("utilitaires/google/adresse.php");
include("utilitaires/google/utilitaires_carto.php");

/**
*	transforme degrés décimaux en degrés minutes
*	$d mesure décimale ex 7.568942
*/
function dec2deg($a)
{
	$d = explode(".",$a);
	$r = $d[0]."°";
	$m = explode(".",($a - $d[0])*60);
	$r .= $m[0]."'";
	$s = explode(".",("0.".$m[1])*60);
	$r .= $s[0]."''";
	return $r;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <title>Google Maps JavaScript API Example: Simple Directions</title>
    <LINK REL=stylesheet HREF="../pma.css" TYPE ="text/css">
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"/>
    <script src="http://maps.google.com/maps?file=api&v=2.x&key=ABQIAAAAzr2EBOXUKnm_jVnk0OJI7xSosDVG8KKPE1-m51RBrvYughuyMxQ-i1QfUnH94QxWIa6N4U6MouMmBA"
      type="text/javascript"></script>
    <script type="text/javascript" src="chercheAdresse_data.php"></script>
  </head>

  <body onload="initialize()">
<!-- onsubmit="setDirections(this.de.value, '1 place hôpital,67000 Strasbourg, france', this.locale.value); -->
 <!--  	<form name="menu" action="#" onsubmit="setDirections(this.from.value,this.to.value,'fr');"> -->
	<form name="menu" action="#" onsubmit="Smur(this.from.value);">
  	
<table width="100%">
	<tr>
			<td>
				adresse1 <input type="text" name="from" id="from" size="50" value="">
				<input type="submit" name="valider" value="ok"><br>
				adresse2 <input type="text" name="to" id="to" size="50" value="">
				<br>
				exemple: 8 rue des noyers, 67550 vendenheim, france 
			</td>
		<td>
			<div id="getStatus" style="width:500px; height:100px; border:1px solid black;"></div>
		</td>
	</tr>
	<tr>
		<td>
			<div id="map_canvas" style="width: 500px; height: 480px; float:left; border: 1px solid black;"></div>
		</td>
		<td>
			<div id="route" style=" height:480px; float:left; border; 1px solid black;"></div>
		</td>
	</tr>
</table>
<?php

if($_REQUEST['valider']=='ok')
{
	$localisation = localise($_REQUEST['from']);
	//echo $localisation."<br>";
	$_result_parts = explode(',',$localisation);
	if($_result_parts[0] != 200) analyse_erreur($_result_parts[0]);
	else
	{
       	$_coords['lat'] = $_result_parts[2];
       	$_coords['lon'] = $_result_parts[3];
   	?>
   	<table border="1" cellspacing="0">
   		<tr>
   			<td>&nbsp;</td>
   			<td>Latitude</td>
   			<td>Longitude</td>
   		</tr>
   		<tr>
   			<td>Coord. GPS</td>
   			<td><? echo $_coords['lat'];?></td>
   			<td><? echo $_coords['lon'];?></td>
   		</tr>
   		<tr>
   			<td>Coord. HELICO</td>
   			<td><? echo dec2deg($_coords['lat']);?></td>
   			<td><? echo dec2deg($_coords['lon']);?></td>
   		</tr>
   	</table>
   	<?php
	}
	print("<a href=\"googlemap.php?long=$_coords[lon]&lat=$_coords[lat]&back=cherche_adresse.php\"> carte </a>");
	
}
else if($_REQUEST['valider']=='menu principal')
	header("Location:sagec67.php");

?>
</div>
</body>
</html>