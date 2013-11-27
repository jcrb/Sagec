<?php
/**
  *	dsa_implantation.php
  *
  *	Carte des implantations des DSA
  * 	@package Sagec
  * 	@author JCB
  * 	@copyright 2008
  */

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backpathToRoot = "../";
//if(!$_SESSION['auto_sagec'] && !$_SESSION['auto_ppi'])header("Location:".$backpathToRoot."logout.php");
include_once("top.php");
include_once("menu.php");
$departement = "67";
$langue = $_SESSION['langue'];

require_once($backpathToRoot."utilitairesHTML.php");
require_once($backpathToRoot."dbConnection.php");
require_once($backpathToRoot."utilitaires/globals_string_lang.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Nouveau DSA</title>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<!-- Ceci est spécifique de Sagec, localhost  -->
	<script src = "../utilitaires/google/key.js"></script>
	<script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    </script>
	<script type="text/javascript">
    
   </script>
   <script src="dsa_implantation_data.php" type="text/javascript"></script>
   <link href="dsa.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="map"></div>
	<div id="mouseTrack" style="display: none"></div>
	<div id="mouseTrack">SAGEC Alsace</div>
</body>
</html>