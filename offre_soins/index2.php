<?php
/**
 * index.php
 *
 * @version $Id$
 * @copyright 2007
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Google Maps JavaScript API Example - EZ Google Map Digitizer</title>
<link href="map.css" rel="stylesheet" type="text/css" />
<script src = "../utilitaires/google/key.js"></script>
<script>
    var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    document.write(scriptTag);
</script>
<script src="offre.js" type="text/javascript"></script>
<script src="../utilitaires/google/map_functions.js" type="text/javascript"></script>
</head>

<body>
	<div id="map"></div>
</body>