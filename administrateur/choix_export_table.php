<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
//	programme: 		choix_export_table.php
//	date de création: 	10/11/2004
//	auteur:			jcb
//	description:		choisir une table à downloader
//	version:			1.2
//	maj le:			10/11/2004
//
//--------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
$langue = $_SESSION['langue'];
$titre_principal="Administration";
include_once("top.php");
include_once("menu.php");
//include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
//require '../utilitaires/requete.php';
//require("../html.php");
require("utilitaires_table.php");
//$connect = $connexion;

/**
*Crée et affiche une liste déroulante des tables de la base de données.
*@package choix_export_table.php
*@return int $table contient la table sélectionnée.
*@param string variable de connexion.
*@version 1.0
*/
/*
function listetable($connect)
{
	$requete = "SHOW TABLES";
	$resultat = ExecRequete($requete,$connect);
	print("<select name=\"table\" size=\"1\" onChange='$onChange'>");
	$mot = "-- aucune --";
	print("<OPTION VALUE = \"$mot\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[0]\" ");
		if($item_select == $rub[0]) print(" SELECTED");
		print("> $rub[0] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
*/


?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
		<title>Récupérer une table</title>
		<LINK REL=stylesheet HREF="../pma.css" TYPE ="text/css">
		<link rel="stylesheet" href="div.css" type="text/css" media="all" />
		<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
		<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>
	
	</head>
	<body>
		<form name ="taches"  ACTION="export_table2.php" METHOD="get">
		<div id="div2">
			<fieldset id="field1">
			<legend>Récupérer le contenu d'une table</legend>
			<p>
				<label for="nom" title="nom">Nom de la table:</label>
				<?php listetable($connexion);?>
			</p>
			<p>
				<label for="date1" title="date1">Date 1:</label>
				<input TYPE="text" VALUE="" NAME="date1" SIZE="10" id="date1">
				<input type="button" class="bouton" value="..." onClick="window.open('../calendrier/mycalendar.php?form=taches&elem=date1','Calendrier','width=200,height=280')">
			</p>
			<p>
				<label for="date2" title="date2">Date 2:</label>
				<input TYPE="text" VALUE="" NAME="date2" SIZE="10" id="date2">
				<input type="button" class="bouton" value="..." onClick="window.open('../calendrier/mycalendar.php?form=taches&elem=date2','Calendrier','width=200,height=280')">
			</p>
			<p>
			<label for="nom" title="nom">FINESS:</label>
			<input type="text" required placeholder="champ obligatoire" name="etablissement" id="nom" title="nom" value="670000397" size="10" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
			
		<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
			
		</fieldset>
		<a href="../administrateur_menu.php">back</a>
	</body>
</html>
