<?php
/**
 * regul_carto.php
 * @package Sagec
 * @author JCB
 * @copyright 2008
 */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<!-- Ceci est spécifique de Sagec, localhost  -->
	<script src = "../utilitaires/google/key.js"></script>
	<script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    </script>

    <script src="carto_data.php" type="text/javascript"></script>
    <link href="regul_map.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="map">Cartographie</div>
	<div id="mouseTrack">SAGEC Alsace</div>
	<?php
	/*
		print("<div id=\"toolbar\">");
			print("<table>");
			print("<tr>");
  					print("<td><B>PPI OTAN</B></td>");
  			print("<tr><td>");
    			print("<input type=\"checkbox\" name=\"mouseTracking\" id=\"mt\" onClick=\"analyseMenu()\"> Geoloc");
    		print("</td></tr>");

  		print("</table>");
		print("</div>");
		*/
	?>
</body>
</html>