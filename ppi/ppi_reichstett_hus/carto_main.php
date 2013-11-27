<?php

/**
 * index.php
 *
 * @version $Id$
 * @copyright 2007
 */
 require_once('./../../weather_sagec/sagec_weather.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
xmlns:v="urn:schemas-microsoft-com:vml">

<head>
<!-- Ceci est spécifique de Sagec, hus -->
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS4M0VztE0O-QJMMgCt9di7cKfD1RRqOuGcbIuRW0zmeP9ety1-dA17AA" type="text/javascript"></script>
	<!-- Ceci est spécifique de Sagec, localhost  
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS5u1nAG4uSd7t1qAnJ_TFOSdaPdBQ7Vq8M6vT5wPThrBtK6O6z4mB3Og"
      type="text/javascript"></script> -->
    <link href="map.css" rel="stylesheet" type="text/css" />
    <script src="map_functions.js" type="text/javascript"></script>
    <script src="Reichstett_data.js" type="text/javascript"></script>
<script>

/**
*	fait apparaitre ou disparaitre un conterneur DIV
* source http://blocnotes.jemenvol.net/5.afficher-et-masquer-une-div/
*/
function visibilite(thingId)
{

	var targetElement;
	targetElement = document.getElementById(thingId);
	if(!targetElement) alert('Elément '+ thingId + ' introuvable');
	if (targetElement.style.display == "none")
	{
		/*alert('target active: '+targetElement.style.display);*/
		targetElement.style.display = "inline";
	} 
	else 
	{
		/*alert('target inactive: '+targetElement.style.display);*/
		targetElement.style.display = "none";
	}

	analyseMenu();
}
</script>

</head>

<body>
	<div id="map"></div>
	
	<?php
	print("<div id=\"mouseTrack\" style=\"display: none\"></div>");
	print("<div id=\"meteo\" style=\"display: none\">".getWeather("LFST")."</div>");
	print("<div id=\"toolbar\">");
		print("<table>");
			print("<tr>");
  					print("<td><B>PPI Reichstett 2</B></td>");
  					print("<td><input type=\"button\" name=\"maj\" value=\"OK\" onclick=\"analyseMenu()\"></td>");
  			print("<tr><td>");
    			print("<input type=\"checkbox\" name=\"mouseTracking\" id=\"mt\" onClick=\"visibilite('mouseTrack');\"> Mouse Tracking");
    		print("</td></tr>");
    		print("<tr><td>");
    			print("<input type=\"checkbox\" name=\"meteo\" id=\"mto\" onClick=\"visibilite('meteo');\" > Météo");
    		print("</td></tr>");
    						print("<tr><td>");
    							print("<input type=\"checkbox\" name=\"zrisques\" id=\"zr\"> Scénario PPI 1");
    						print("</td></tr>");
    						print("<tr>");
    							print("<td><input type=\"checkbox\" name=\"pbouclage\" id=\"pb\"> Points de bouclage</td>");
    							print("<td><img name=\"logo\" alt=\"logo\" src=\"icon16.png\"></td>");
    						print("</tr>");
    						print("<tr>");
    							print("<td><input type=\"checkbox\" name=\"pma\" id=\"pma\"> PMA potentiels</td>");
    							print("<td><img name=\"logo\" alt=\"logo\" src=\"icon46.png\"></td>");
    						print("</tr>");
    						print("<tr>");
    							print("<td><input type=\"checkbox\" name=\"pco\" id=\"pco\"> PCO potentiels</td>");
    							print("<td><img name=\"logo\" alt=\"logo\" src=\"icon53.png\"></td>");
    						print("</tr>");
    						print("<tr>");
    							//$src = "http://maps.google.com/mapfiles/kml/pal2/icon20.png";
    							print("<td><input type=\"checkbox\" name=\"heb\" id=\"heb\"> Hébergements</td>");
    							print("<td><img name=\"logo\" alt=\"logo\" src=\"icon20.png\"></td>");
    						print("</tr>");
    						print("<tr>");
    							print("<td><input type=\"checkbox\" name=\"pprm\" id=\"prm\"> Points de rassemblement des moyens</td>");
      						print("<td><img name=\"logo\" alt=\"logo\" src=\"icon15.png\"></td>");
    						print("</tr>");
  						print("</tr>");
  					print("</table>");
	print("</div>");
	?>
</body>
</html>