<?php
/**
  *	mode_emploi.php
  */
  
  	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$langue = $_SESSION['langue'];
	include_once("top.php");
	include_once("menu.php");
	$backPathToRoot = "../../";
	$doc = "doc_pdf/";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Cartographie</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="stylesheet" href="../top.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Documentation </legend>
		<p>
			<a href="doc_pdf/connexion.pdf">Introduction et connexion à SAGEC</a>
		</p>
		<p>
			<a href="doc_pdf/geolocalisation.pdf">Utiliser l'outil de géolocalisation</a>
		</p>
		<p>
			<a href="doc_pdf/manuel.pdf">Version provisoire du manuel d'utilisation</a>
		</p>
	</fieldset>
</div>

<?php
?>

</form>
</body>
</html>