<?php
/**
*	ressource_test.php
*/

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include_once("ror_top.php");
include_once("ror_menu.php");
//require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."utilitaires/liste.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="../top.css" type="text/css" media="all" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="">
<form name="" action= "" method = "get">

<header>
	<p>Header</p>
</header>

<nav><a href="">lecture</a>|<a href="">écriture</a></nav>
<section>
	<article>
		<fieldset id="field1"><legend><? echo "gestion des ressources";?> </legend>
			<p></p>
		</fieldset>
		<fieldset id="field1"><legend><? echo "ressources";?> </legend>
			<p></p>
		</fieldset>
	</article>
	<aside>petit commentaire</aside>
</section>
<footer>FIN</footer>
</form>
</body>
</html>