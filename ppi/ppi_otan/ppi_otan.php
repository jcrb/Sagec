<?php

/**
 * ppi_pmc.php
 *
 * @version $Id: index.php 38 2008-02-27 21:07:19Z jcb $
 * @package Sagec
 * @author JCB
 * @copyright 2008
 */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
//     <script src="../../utilitaires/google/map_functions.js" type="text/javascript"></script>
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<!-- Ceci est spécifique de Sagec, localhost  -->
	<script src = "../../utilitaires/google/key.js"></script>
	<script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    </script>

    <script src="ppi_otan_data.php" type="text/javascript"></script>
    <link href="../map.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="map"></div>
	<div id="mouseTrack">SAGEC Alsace</div>
	<div class="transp"><img src="rose_vent_trans.png"/></div>
	<?php
		print("<div id=\"toolbar\">");
			print("<table>");
			print("<tr>");
  					print("<td><B>PPI OTAN</B></td>");
  			print("<tr><td>");
    			print("<input type=\"checkbox\" name=\"mouseTracking\" id=\"mt\" onClick=\"analyseMenu()\"> Geoloc");
    		print("</td></tr>");
    		/*				
    		print("<tr>");
    				$mot = "Butadiène";
    				print("<td><input type=\"checkbox\" name=\"_SAU\" id=\"sau\" onclick=\"analyseMenu()\">".$mot."</td>");
    				print("<td><img name=\"logo\" alt=\"logo\" src=\"../../utilitaires/google/icons/icong.png\"></td>");
    		print("</tr>");*/

  		print("</table>");
		print("</div>");
	?>
</body>
</html>