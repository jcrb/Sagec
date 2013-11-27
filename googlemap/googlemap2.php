<?php
/**
*	googlemap.php
 * @package Sagec
 * @author JCB
*	@version $Id: googlemap.php 43 2008-03-13 22:41:12Z jcb $
*/

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
 
<script src = "../utilitaires/google/key.js"></script>
    <script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    </script>
      
 	<script src="googlemap.js" type= "text/javascript"></script>
 	<script src="googlemap_data.php" type= "text/javascript"></script> 
	<link href="googlemap.css" rel="stylesheet" type = "text/css" />
</head>


<?php
	if($_REQUEST['lat']) $latitude = $_REQUEST['lat']; else $latitude = 48.585;//gare
	if($_REQUEST['long']) $longitude = $_REQUEST['long']; else $longitude = 7.736;//gare
	if($_REQUEST['zoom']) $altitude = $_REQUEST['zoom']; else $altitude = 13;//gare
	if($_REQUEST['map_H']) $mapH = $_REQUEST['map_H']; else $mapH = "600px";
	if($_REQUEST['map_W']) $mapW = $_REQUEST['map_W']; else $mapW = "1000px";
	if($_REQUEST['back']) $back = $_REQUEST['back']."?ville_id=$_REQUEST[ville]";
	$_SESSION['ville_ID'] = $_REQUEST['ville'];// correspond à la table ville
	
print("<body onload=\"load($longitude,$latitude,$altitude)\" onunload=\"GUnload()\">");
print("<div id=\"map\"></div>");
print("<div id=\"toolbar\">");
print("<table border=\"1\" width=\"100%\">");
	print("<tr>");
		print("<td>");
			if($back)
			{
				$back = "./../".$back;
				print("<a href=\"$back\"><b> Retour &agrave la page pr&eacute;c&eacute;dante</b></a></td>");
			}
		print("</tr>");
		
		print("<tr>");
			print("<td>");
				print("<input type=\"checkbox\" name=\"pharma\" id=\"pharma\" onchange=\"analyseMenu();\">Pharmacies ");
			print("</td>");
		print("</tr>");
		print("<tr>");
			print("<td>");
				print("<input type=\"checkbox\" name=\"med\" id=\"med\" onchange=\"analyseMenu();\">Médecins ");
			print("</td>");
		print("</tr>");
		print("<tr>");
			print("<td>");
				print("<input type=\"checkbox\" name=\"ide\" id=\"ide\" onchange=\"analyseMenu();\">Infirmier(e)s ");
			print("</td>");
		print("</tr>");
		
	print("</table>");
	print("</div>");
print("</body>");
?>
</html>