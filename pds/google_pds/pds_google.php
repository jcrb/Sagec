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
if(! $_SESSION['auto_sagec'])header("../../Location:logout.php");
$ville_id = $_REQUEST['ville'];// correspond à la table ville
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<script src = "../../utilitaires/google/key.js"></script>
	<script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    </script>
    <!-- 
    <script src="../../utilitaires/google/map_functions.js" type="text/javascript"></script>  -->
    <script src="../../ajax/ajax.js" type="text/javascript"></script>
    <script src="pds_google_data.php" type="text/javascript"></script>
    <script src="pds_google_function.js" type="text/javascript"></script> 
    <script src="../../ajax/JSON.js" type="text/javascript"></script> 
    <link href="../map.css" rel="stylesheet" type="text/css" />
</head>

	<div id="map"></div>
	<div id="mouseTrack">SAGEC Alsace</div>
	
<?php
	if($_REQUEST['lat']) $latitude = $_REQUEST['lat']; else $latitude = 48.585;//gare
	if($_REQUEST['long']) $longitude = $_REQUEST['long']; else $longitude = 7.736;//gare
	if($_REQUEST['zoom']) $altitude = $_REQUEST['zoom']; else $altitude = 13;//gare
	if($_REQUEST['map_H']) $mapH = $_REQUEST['map_H']; else $mapH = "600px";
	if($_REQUEST['map_W']) $mapW = $_REQUEST['map_W']; else $mapW = "1000px";
	if($_REQUEST['back']) $back = $_REQUEST['back']."?ville_id=$_REQUEST[ville]";
	$_SESSION['ville_ID'] = $_REQUEST['ville'];// correspond à la table ville

	//print("<body onload=\"load($longitude,$latitude,$altitude)\" onunload=\"GUnload()\">");
print("<body onload=\"init($longitude,$latitude,$_REQUEST[ville]);\">");
		print("<div id=\"toolbar\">");
			print("<table>");
			print("<tr>");
  					print("<td><B>PPI PMC</B></td>");
  			print("<tr><td>");
    			print("<input type=\"checkbox\" name=\"mouseTracking\" id=\"mt\" onClick=\"analyseMenu()\"> Geoloc");
    		print("</td></tr>");
				print("<tr>");
		print("<td>");
			if($back)
			{
				$back = "./../../".$back;
				print("<a href=\"$back\"><b> Retour &agrave la page pr&eacute;c&eacute;dante</b></a></td>");
			}
		print("</tr>");
		
		print("<tr>");
			print("<td>");
				print("<input type=\"checkbox\" name=\"pharma\" id=\"pharma\" onchange=\"analyseMenu();\">Pharmacies");
			print("</td>");
		print("</tr>");
		print("<tr>");
			print("<td>");
				print("<input type=\"checkbox\" name=\"med\" id=\"med\" onchange=\"analyseMenu();\">M&eacute;decins");
			print("</td>");
		print("</tr>");
		print("<tr>");
			print("<td>");
				print("<input type=\"checkbox\" name=\"ide\" id=\"ide\" onchange=\"analyseMenu();\">Infirmier(e)s ");
			print("</td>");
		print("</tr>");
  		print("</table>");
		print("</div>");
	?>
</body>
</html>