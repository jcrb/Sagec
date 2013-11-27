<?php
	// googlemap.php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//include_once('googlemap_data.php');

// récupération des données
	if($_REQUEST['lat']) $latitude = $_REQUEST['lat']; else $latitude = 48.585;//gare
	if($_REQUEST['long']) $longitude = $_REQUEST['long']; else $longitude = 7.736;//gare
	if($_REQUEST['zoom']) $altitude = $_REQUEST['zoom']; else $altitude = 13;//gare
	if($_REQUEST['map_H']) $mapH = $_REQUEST['map_H']; else $mapH = "600px";
	if($_REQUEST['map_W']) $mapW = $_REQUEST['map_W']; else $mapW = "1000px";
	if($_REQUEST['back']) $back = $_REQUEST['back']."&ville_id=".$_REQUEST['ville_id'];
	$_SESSION['commune_ID'] = $_REQUEST['commune_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <!--   <meta http-equiv="content-type" content="text/html; charset=utf-8"/> -->
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
    <title>Google Maps JavaScript API Example</title>
	<!-- Ceci est spécifique de Sagec, HUS 
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS4M0VztE0O-QJMMgCt9di7cKfD1RRqOuGcbIuRW0zmeP9ety1-dA17AA"
      type="text/javascript">
	</script> -->
<!-- Ceci est spécifique de Sagec, localhost  -->
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS5u1nAG4uSd7t1qAnJ_TFOSdaPdBQ7Vq8M6vT5wPThrBtK6O6z4mB3Og"
      type="text/javascript"></script> 
      
<script src="googlemap.js" type= "text/javascript"></script>
<script src="googlemap_data.php" type= "text/javascript"></script>
<link href = "./../ppi/ppi_reichstett/map.css" rel = "stylesheet" type = "text/css" />
</head>

<?php
print("<body onload=\"load($longitude,$latitude,$altitude)\" onunload=\"GUnload()\">");
print("<div id=\"map\" ></div>");
print("<div id=\"toolbar\">");
print("<table border=\"1\" width=\"100%\">");
	print("<tr>");
			print("<td>");
				if($back)
		print("<a href=\"$back\"><b> Retour &agrave la page pr&eacute;c&eacute;dante</b></a></td>");
		print("</tr>");
		
		print("<tr>");
			print("<td>");
				print("<input type=\"checkbox\" name=\"pharma\" id=\"pharma\" onchange=\"analyseMenu();\">Pharmacies ");
			print("</td>");
		print("</tr>");
		
		print("<tr>");
			print("<td>");
				print("<input type=\"checkbox\" name=\"pma\" id=\"pma\" onchange=\"analyseMenu();\">PMA mùarché de noël");
			print("</td>");
		print("</tr>");
		
		print("<tr>");
		print("<td><a href=\"./../../ppi/ppi_reichstett/carto_main.php\"><b>PPI REichstett (démo)</b></a></td>");
		print("</tr>");
	print("</table>");
	print("</div>");
print("</body>");
?>
</html>