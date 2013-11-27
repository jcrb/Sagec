<?php
/**
  *	calcule_distance.php
  *	utilise API googlemap pour évaluer les distances routières
  *	et les temps de trajet entre deux points
  *	Les routines de calcul sont dans le fichier google_distance.php
  */
?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<!-- Ceci est spécifique de Sagec, localhost  -->
	<script src = "../utilitaires/google/key.js"></script>
	<script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    </script>
    <script src="google_distance.php" type="text/javascript"></script>
    <!--
    <link href="../map.css" rel="stylesheet" type="text/css" />
    -->
</head>
<body>
</body>
</html>