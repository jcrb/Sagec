<?php
//----------------------------------------- SAGEC ---------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//		
//---------------------------------------------------------------------------------
//	programme: 				dispo_main.php
//	date de création: 	12/02/2010
//	auteur:					jcb
//	description:			portail accès au services par les hôpitaux.
//								Remplace le dossier services 
//	version:					1.0
//	maj le:			
//---------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."date.php");
require($backPathToRoot."dbConnection.php");

$serviceID = $_REQUEST['serviceID'];print("service:".$serviceID);
$serviceNom = $_REQUEST['nom'];
$enregistrement = $_REQUEST['enregistrement'];
$today = aujourdhui();

if($enregistrement)
{
	$requete = "SELECT * FROM lits_fermes WHERE lits_ferme_ID = '$enregistrement'";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	$date1 = uDate2French($rep[debut]);
	$date2 = uDate2French($rep[fin]);
	$serviceID = $rep[service_ID];
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Lits disponibles</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="utilitaires.js"></script>
</head>

<body onload="document.getElementById('date1').focus()">
<form name="fermeture" action= "lits_fermes_enregistre.php" method = "get">

	<input type="hidden" name="serviceID" value="<? echo $serviceID;?>">
	<input type="hidden" name="enregistrement" value="<? echo $enregistrement;?>">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend><? echo 'Fermeture Prévisionnelle de lits';?> </legend>
		<p>
			<label for="nom" title="nom">Service:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo $serviceNom;?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
		<label for="date1" title="date1">Date de début:</label>
		<input TYPE="text" VALUE="<? if(!$date1)echo $today;else echo $date1;?>" NAME="date1" SIZE="10" id="date1">
		<input type="button" class="button" onClick="window.open('../calendrier/mycalendar.php?form=fermeture&elem=date1','Calendrier','width=200,height=280')">
		</p>
		<p>
		<label for="date2" title="date1">Date de fin:</label>
		<input TYPE="text" VALUE="<? if(!$date2)echo $today;else echo $date2;?>" NAME="date2" SIZE="10" id="date2">
		<input type="button" class="button" onClick="window.open('../calendrier/mycalendar.php?form=fermeture&elem=date2','Calendrier','width=200,height=280')">
		</p>
		<p>
			<label for="nb" title="nb">Nombre de lits fermés:</label>
			<input type="text" name="nb" id="nb" title="nb" value="<? echo $rep[nb_lits_fermes];?>" size="10" onFocus="_select('nb');" onBlur="deselect('nb');"/>
		</p>
	</fieldset>
	<!-- champ de type TextArea -->
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<p>
			<label for="rem" title="rem">Remarque:</label>
			<textarea name="rem" id="rem" rows="2" cols="57"></textarea>
		</p>
	</fieldset>
	
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>

<?php
?>

</form>
</body>
</html>