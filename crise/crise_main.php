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
  * programme: 			crise_main.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";

$titre_principal = "Outils de gestion de crise";
$menu_sup = "<a href='../samu/samu_main.php'>Régulation</a> > ";
$menu_sup .= "<a href='crise_main.php'>Crise </a> > ";
$menu_sup .= "Outils";

include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "" method = "post">

<div id="div2">
	
	<fieldset id="field1">
		<legend>Main courante </legend>
		<p>
			<a href="../blocnote/blocnote_lire.php?back=../crise/crise_main.php">Main courante: </a>Informations partagées entre les membres de la régulation, le terrain et les cellules de crise.
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Plans de secours </legend>
		<p>
			Liste des <a href="plans_secours.php">Plans de secours</a> (PPI). Le lien 'voir' permet se sélectionner la cartographie 
			correspondant à un site donné.
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Superviseurs</legend>
		<p>
			Liste des taches dévolues aux <a href="superviseur/superviseur_main.php">Superviseur</a> en situation de crise.
			Permet notamment de valider les check-listes.
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Victimes</legend>
		<p>
			Création et mise à jour des dossiers <a href="../dossier_cata/dossier_cata_main.php?back=../crise/crise_main.php">Victimes</a>.
			Synoptique et outils statistiques concernant les victimes
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Hôpitaux</legend>
		<p>
			Permet de sélectionner les <a href="crise_hopitaux.php">Hôpitaux</a> pouvant recevoir des victimes lors du déclenchement d'un plan de secours.
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Lits</legend>
		<p>
			Tableau synoptique des <a href="lits.php">Lits</a> disponibles
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend>Personnels</legend>
		<p>
			Liste des personnels disponibles [NON IMPLEMENTE].
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend>Vecteurs</legend>
		<p>
			Liste des <a href="vecteurs/vecteurs_index.php">Vecteurs</a> disponibles. Permet de sélectionner dans la liste des vecteurs, ceux qui sont engagés dans un plan de secours.
		</p>
	</fieldset>
	
	
</div>


</form>
</body>
</html>
