<?php
/**
	* googlemap.php
	*	@version $Id: google_test.php 29 2008-01-13 22:52:31Z jcb $
	*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// r�cup�ration des donn�es
	if($_REQUEST['lat']) $latitude = $_REQUEST['lat']; else $latitude = 48.585;//gare
	if($_REQUEST['long']) $longitude = $_REQUEST['long']; else $longitude = 7.736;//gare
	if($_REQUEST['zoom']) $altitude = $_REQUEST['zoom']; else $altitude = 13;//gare
	if($_REQUEST['map_H']) $mapH = $_REQUEST['map_H']; else $mapH = "600px";
	if($_REQUEST['map_W']) $mapW = $_REQUEST['map_W']; else $mapW = "1000px";
	$_SESSION['commune_ID'] = $_REQUEST['commune_id'];
	if(!$_SESSION['commune_ID'])$_SESSION['commune_ID'] = 1;
	if($_REQUEST['back']) $back = "./../".$_REQUEST['back']."?commune_id=$_SESSION[commune_ID]";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
    <tittle>Googlemap</tittle>
<!-- Ceci est sp�cifique de Sagec, hus -->
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS4M0VztE0O-QJMMgCt9di7cKfD1RRqOuGcbIuRW0zmeP9ety1-dA17AA" type="text/javascript"></script>
<!-- Ceci est sp�cifique de Sagec, localhost 
	 <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS5u1nAG4uSd7t1qAnJ_TFOSdaPdBQ7Vq8M6vT5wPThrBtK6O6z4mB3Og"
      type="text/javascript"></script>  -->
      
<script src="googlemap.js" type= "text/javascript"></script>
<script src="googlemap_data.php" type= "text/javascript"></script> 
<link href = "googlemap.css" rel = "stylesheet" type = "text/css" />


</head>

<body <?php echo("onload='load($longitude,$latitude,$altitude)'")?> onunload="GUnload()">
	<div id="map"></div>
	<div id="toolbar">
		<table border="1" width="100%">
			<tr><td><a href="<?php echo($back) ?>">Page pr�c�dante</a></td></tr>
			<tr><td><input type="checkbox" name="pharmacie" id="pharma" onclick="analyseMenu();"> Pharmacies</td></tr>
			<tr><td><input type="checkbox" name="pma_noel" id="pma" onclick="analyseMenu();"> PMA march� de no�l</td></tr>
			<tr><td><a href="./../ppi/ppi_reichstett/carto_main.php"><b>PPI Reichstett (d�mo)</b></a></td></tr>
		</table>
	</div>
</body>
</html>