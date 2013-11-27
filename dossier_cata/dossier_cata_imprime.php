<?php
/**----------------------------------------- SAGEC ---------------------------------
  * This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
  * SAGEC67 is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation; either version 2 of the License, or
  * (at your option) any later version.
  * SAGEC67 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * You should have received a copy of the GNU General Public License
  * along with SAGEC67; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */	
/** ---------------------------------------------------------------------------------
  * programme: 			dossier_cata_imprime.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * @variables
  *	$pma				nom du pma courant
  *	$loc				ID du pma courant
  *	$poste			poste de saisie
  *	$identifiant	n° d'ordre de la victime
  *	$now				date et heure courante (unix)
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "Dossier victimes - Impressions";
include_once("dossier_cata_top.php");
require_once("cata_menu_top.php");
include_once("dossier_cata_utilitaires.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");
require($backPathToRoot."utilitairesHTML.php");

/**
  *	heure courante
  */
$now = uDateTime2MySql(time());
/**
  *	Evènement courant
  */
$evenement = $_SESSION['evenement'];

/**
  * nom du PMA où se fait la saisie
  */
$requete = "SELECT ts_nom FROM temp_structure WHERE ts_ID = '$_SESSION[localisation]'";
$resultat = ExecRequete($requete,$connexion);
$pma = mysql_fetch_array($resultat);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<!--<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">-->
	<meta http-equiv="content-type" content="""text/ht; charset=ISO-8859-1" >
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="stylesheet" href="dossier_victime.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>

</head>

<body>
	<form name="rabot" id="rabot" action="PDF_fichemed.php" method="get" >
	<input type="hidden" name="identifiant" value="<?php echo $identifiant;?>"/>
	<div id = "dossier_div1">
		<fieldset id="field2">
		<legend> Impression / Fichiers PDF </legend>
			<p>
				<a href="PDF_fichemed.php?imp=dossier">Dossier patient</a>
			</p>
			<p>
				Uniquement le dossier 
				<input type="text" name="dossier" id="dossier" value="<?php echo $_SESSION['dossier_courant'];?>">
				<input type="submit" name="ok"  id="" value="imprime"/>
			</p>
			<p>
				<a href="PDF_fichemed.php?imp=liste">Liste des victimes (PDF)</a>
			</p>
			<p>
				<a href="PDF_fichemed.php?imp=all">Tous les dossiers (PDF)</a>
			</p>
			<p>
				<a href="PDF_fichemed.php?imp=xml">Tous les dossiers (XML)</a>
			</p>
		</fieldset>
		
	</div>
</form>
</body>
</html>