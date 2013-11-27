<?php
/**
*	digitaliseur.php
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<p>Digitaliseur de cartes</p>

<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
	<link href="map.css" rel="stylesheet" type="text/css" />
	<script src = "key.js"></script>
	<script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    </script>
    <script src="digitaliseur_data.php" type="text/javascript"></script>
</head>

<body>
<form name="digitaliseur" action="#" onsubmit="showAddress(this.address.value); return false">
<p>
    <input type="text" size="40" name="address" value="" />
    <input type="submit" value="Geocode!" />
</p>

<input type="button" onclick="clearMap();" value="Effacer tout"/>
<input type="button" onclick="deleteLastPoint();" value="Supprimer le dernier point"/>
<input type="button" onclick="fermer();" value="Fermer"/>

<table>
  <tr valign="top">
    <td>
    	<div id="map"></div>
    </td>
    <td>
    	<div id="status">
        <textarea id="coords" cols="40" rows="20" readonly="true" onclick="this.select();">Cliquer sur la carte pour digitaliser</textarea>
       <br/>
       KML output (Copier et coller dans un fichier .kml et ouvrez dans Google Earth!)
      </div>
     </td>
  </tr>
</table>

</form>
</body>
</html>