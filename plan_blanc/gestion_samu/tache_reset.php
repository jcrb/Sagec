<?php
/**
  *		tache_reset.php
  *		réactive toutes les taches d'une check-list
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
//include_once("top.php");
//include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");

if($_REQUEST[reset]=="ok")
{
	$requete = "UPDATE tache SET tache_faite = 'n'";
	ExecRequete($requete,$connexion);
	?>
		<br>
		<p>La liste des tâches a été réinitialisée</p>
	<?php
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Réinitialisation de la Check-List</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "" method = "post">

	<p>Réinitialisation de la Check-List</p>
	<a href = "tache_reset.php?reset=ok" onclick="return confirm('Etes vous sûre de vouloir réinitialiser la Check-List ?\n Toutes les données vont être perdues');">Réinitialisation</a>

<?php

?>

</form>
</body>
</html>
