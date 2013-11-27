<?php
/**
  * liste_evenement.php
  */
  session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
	$backPathToRoot = "../../";
	require $backPathToRoot."dbConnection.php";
	$langue = $_SESSION['langue'];
	require $backPathToRoot.'utilitaires/globals_string_lang.php';
	include_once("top.php");
	include_once("menu.php");
  ?>
  	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Nouvel evenement</title>
	<link rel="stylesheet" href="../div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>

<form name="choix" method="post" action="evenement_maj.php">
<div id="div2">
	<fieldset id="field1">
		<legend> Sélectionner un évènement </legend>
		<p>
			<label for="nom" title="nom">Nom de lévènement:</label>
  			<?php
				$requete = "SELECT evenement_ID, evenement_nom FROM evenement WHERE evenement_actif = 'oui'";
				$resultat = ExecRequete($requete,$connexion);
				print("<SELECT name=\"ev_courant\" size=\"5\">");
				while($rub=mysql_fetch_array($resultat))
				{
					print("<option value=\"$rub[evenement_ID]\"> $rub[evenement_nom]</option>");
				}
				print("</SELECT>");
			?>
		</p>
	</fieldset>
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
</form>
</html>