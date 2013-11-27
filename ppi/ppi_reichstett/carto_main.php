<?php
/**
* PPI Reichstett: données spécifiques
* @version $Id: carto_main.php 43 2008-03-13 22:41:12Z jcb $
* @author jcb
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
		<title>PPI Reichstett</title>
		
		<script src = "../../utilitaires/google/key.js"></script>
    	<script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    	</script>
    	<!--
		<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=abcdefg" type="text/javascript"></script>
		-->
		<script src="map_data.php" type= "text/javascript"></script>
		<script src="map_functions.js" type= "text/javascript"></script>
		<link href = "map.css" rel = "stylesheet" type = "text/css" />
  </head>
  
<?php

	print("<body>");
	
	print("<div id=\"map\"></div>");
	
	print("<div id=\"statusBar\">");
	print("</div>");
	
	print("<div id=\"mouseTrack\"></div>");
	print("</div>");
	
	print("<div id=\"toolbar\">");
		print("<h1>Repères</h1>");
		print("<table>");
			print("<tr>");
  				print("<td valign=\"top\" align=\"middle\">");
  					print("<input type=\"button\" name=\"maj\" value=\"Redessine\" onclick=\"analyseMenu()\">");
  				print("</td>");
  			print("<tr><td>");
    			print("<input type=\"checkbox\" name=\"mouseTracking\" id=\"mt\"> Mouse Tracking activé");
    		print("</td></tr>");
    		print("<tr><td>");
    			print("<input type=\"checkbox\" name=\"meteo\" id=\"mto\"> Météo");
    		print("</td></tr>");
    						print("<tr><td>");
    							print("<input type=\"checkbox\" name=\"zrisques\" id=\"zr\"> Scénario 1");
    						print("</td></tr>");
    						print("<tr>");
    							print("<td><input type=\"checkbox\" name=\"pbouclage\" id=\"pb\"> Points de bouclage</td>");
    							print("<td><img name=\"logo\" alt=\"logo\" src=\"Police32.png\"></td>");
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
	
	/*
	// coordonnées de la raffinerie 
	$lat = 48.6603;
	$long = 7.76639;
	$zoom = 13;
  	print("<body onload=\"load($lat,$long,$zoom)\" onunload=\"GUnload()\">"); 
  	
  		print("<table>");
  			print("<tr>");
  				print("<td>");
    				print("<div id=\"map\" style=\"width: 1000px; height: 700px\"></div>");
    			print("</td>");
    			//----------------------------------------------------------------------
    			print("<td>");// menu latéral droit

    			print("</td>");
    			//-----------------------------------------------------------------------
    		print("</tr>");
    	print("</table>");
    */
    	
  	print("</body>");
print("</html>");
?>