<?php

/**
 * index.php
 *
 * @version $Id: index.php 38 2008-02-27 21:07:19Z jcb $
 * @package Sagec
 * @author JCB
 * @copyright 2007
 */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
require '../../utilitaires/globals_string_lang.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<!-- Ceci est spécifique de Sagec, localhost  -->
	<script src = "../../utilitaires/google/key.js"></script>
	<!--
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=myKey"
      type="text/javascript"></script> -->
  
    <script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    </script>
    <script src="lanxes.js" type="text/javascript"></script>
    <script src="../../utilitaires/google/map_functions.js" type="text/javascript"></script>
    <script src="lanxes_data.php" type="text/javascript"></script>
    <link href="../map.css" rel="stylesheet" type="text/css" />
    
    
</head>

<body>
	<div id="map"></div>
	<div id="mouseTrack">SAGEC Alsace</div>
	<div class="transp" id="rose">MTO<br>Temp: 1°C<img src="./rose_vent.png"></div> <!-- <img src="./rose_vent.png">   -->
	
	<?php
	$langue = $_SESSION['langue'];

	print("</div>");
	
	print("<div id=\"toolbar\">");
		print("<table>");
			print("<tr>");
  					print("<td><B>PPI Lanxes</B></td>");
  					//print("<td><input type=\"button\" name=\"maj\" value=\"OK\" onclick=\"analyseMenu()\"></td>");
  			print("<tr><td>");
    			print("<input type=\"checkbox\" name=\"mouseTracking\" id=\"mt\" onClick=\"analyseMenu()\"> Mouse Tracking");
    		print("</td></tr>");
    						
    		print("<tr>");
    				$mot = "Butadiène";
    				print("<td><input type=\"checkbox\" name=\"_SAU\" id=\"sau\" onclick=\"analyseMenu()\">".$mot."</td>");
    				print("<td><img name=\"logo\" alt=\"logo\" src=\"../../utilitaires/google/icons/icong.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = "Scénario 1";
    			print("<td><input type=\"checkbox\" name=\"_zr1\" id=\"zr1\" onclick=\"analyseMenu()\">".$mot."</td>");
    			//print("<td><img name=\"logo\" alt=\"logo\" src=\"../utilitaires/google/icons/icon16.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    				$mot = "Acrylonitrile";
    				print("<td><input type=\"checkbox\" name=\"_acn\" id=\"acn\" onclick=\"analyseMenu()\">".$mot."</td>");
    				print("<td><img name=\"logo\" alt=\"logo\" src=\"../../utilitaires/google/icons/iconb.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = "Scénario 5";
    			print("<td><input type=\"checkbox\" name=\"_zr2\" id=\"zr2\" onclick=\"analyseMenu()\">".$mot."</td>");
    		print("</tr>");
    		print("<tr>");
    				$mot = "Ammoniac";
    				print("<td><input type=\"checkbox\" name=\"_amn\" id=\"amn\" onclick=\"analyseMenu()\">".$mot."</td>");
    				print("<td><img name=\"logo\" alt=\"logo\" src=\"../../utilitaires/google/icons/orange_MarkerA.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = "Scénario 2";
    			print("<td><input type=\"checkbox\" name=\"_zr3\" id=\"zr3\" onclick=\"analyseMenu()\">".$mot."</td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = "PMA potentiels";
    			print("<td><input type=\"checkbox\" name=\"_pma\" id=\"pma\" onclick=\"analyseMenu()\">".$mot."</td>");
    			print("<td><img name=\"logo\" alt=\"logo\" src=\"../../utilitaires/google/icons/icon46.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = "PCO potentiels";
    			print("<td><input type=\"checkbox\" name=\"_pco\" id=\"pco\" onclick=\"analyseMenu()\">".$mot."</td>");
    			print("<td><img name=\"logo\" alt=\"logo\" src=\"../../utilitaires/google/icons/icon53.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = "PPD potentiels";
    			print("<td><input type=\"checkbox\" name=\"_ppd\" id=\"ppd\" onclick=\"analyseMenu()\">".$mot."</td>");
    			print("<td><img name=\"logo\" alt=\"logo\" src=\"../../utilitaires/google/icons/icon15.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = "Rose des Vents";
    			print("<td><input type=\"checkbox\" name=\"rdv\" id=\"rdv\" onclick=\"analyseMenu()\">".$mot."</td>");
    		print("</tr>");

  		print("</table>");
	print("</div>");
	?>
</body>
</html>
