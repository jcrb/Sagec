<?php

/**
 * index.php
 *
 * @version $Id: index.php 44 2008-04-16 06:55:34Z jcb $
 * @package Sagec
 * @author JCB
 * @copyright 2007
 */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//if(! $_SESSION['auto_sagec']||! $_SESSION['auto_apa'])header("Location:logout.php");
require '../utilitaires/globals_string_lang.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<!-- Ceci est spécifique de Sagec, localhost  -->
	<script src = "../utilitaires/google/key.js"></script>
	<!--
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=myKey"
      type="text/javascript"></script> -->
  
    <script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    </script>
    
    <script src="../utilitaires/google/map_functions.js" type="text/javascript"></script>
    <script src="offre.js" type="text/javascript"></script>
    <script src="offre_data.php" type="text/javascript"></script>
    <link href="map.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="map"></div>
	<div id="mouseTrack" style="display: none"></div>
	<?php
	$langue = $_SESSION['langue'];
	print("<div id=\"toolbar\">");
		print("<table>");
			print("<tr>");
  					print("<td><B>".$string_lang["OFFRE_SOINS"][$langue]."</B></td>");
  					print("<td><input type=\"button\" name=\"maj\" value=\"OK\" onclick=\"analyseMenu()\"></td>");
  			print("<tr><td>");
    			print("<input type=\"checkbox\" name=\"mouseTracking\" id=\"mt\" onClick=\"visibilite('mouseTrack');\"> Mouse Tracking");
    		print("</td></tr>");
    						
    		print("<tr>");
    				$mot = $string_lang["SAU"][$langue];
    				print("<td><input type=\"checkbox\" name=\"SAU\" id=\"sau\" onclick=\"analyseMenu()\">".$mot."</td>");
    				print("<td align=\"center\"><img name=\"logo\" alt=\"logo\" src=\"../utilitaires/google/icons/icon46.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = $string_lang["STROKE"][$langue];
    			print("<td><input type=\"checkbox\" name=\"avc\" id=\"avc\" onclick=\"analyseMenu()\">".$mot."</td>");
    			print("<td align=\"center\"><img name=\"logo\" alt=\"logo\" src=\"../images/pma_markers/strokeCenter.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = $string_lang["SMUR"][$langue];
    			print("<td><input type=\"checkbox\" name=\"smur\" id=\"smur\" onclick=\"analyseMenu()\">".$mot."</td>");
    			print("<td align=\"center\"><img name=\"logo\" alt=\"logo\" src=\"../images/pma_markers/smur.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = "Rettungswache";
    			print("<td><input type=\"checkbox\" name=\"rw\" id=\"rw\" onclick=\"analyseMenu()\">".$mot."</td>");
    			print("<td align=\"center\"><img name=\"logo\" alt=\"logo\" src=\"../images/pma_markers/retWache.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = $string_lang["HELICOPTERE"][$langue];
    			print("<td><input type=\"checkbox\" name=\"helico\" id=\"helico\" onclick=\"analyseMenu()\">".$mot."</td>");
    			print("<td align=\"center\"><img name=\"logo\" alt=\"logo\" src=\"../images/pma_markers/helico.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = $string_lang["SAMU"][$langue];
    			print("<td><input type=\"checkbox\" name=\"c15\" id=\"c15\" onclick=\"analyseMenu()\">".$mot."</td>");
    			print("<td align=\"center\"><img name=\"logo\" alt=\"logo\" src=\"../images/pma_markers/112.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = $string_lang["CS"][$langue];$mot="CS";
    			print("<td><input type=\"checkbox\" name=\"cs\" id=\"cs\" onclick=\"analyseMenu()\">".$mot."</td>");
    			print("<td align=\"center\"><img name=\"logo\" alt=\"logo\" src=\"../images/pma_markers/vsav.png\"></td>");
    		print("</tr>");
    		print("<tr>");
    			$mot = $string_lang["ASSU"][$langue];$mot="ASSU";
    			print("<td><input type=\"checkbox\" name=\"assu\" id=\"assu\" onclick=\"analyseMenu()\">".$mot."</td>");
    			print("<td align=\"center\"><img name=\"logo\" alt=\"logo\" src=\"../images/pma_markers/assu.png\"></td>");
    		print("</tr>");

  		print("</table>");
	print("</div>");
	?>
</body>
</html>