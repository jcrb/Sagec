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
//	date de cr�ation: 	12/02/2010
//	auteur:					jcb
//	description:			portail acc�s au services par les h�pitaux.
//								Remplace le dossier services 
//	version:					1.0
//	maj le:			
//---------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "Services - Disponibilit�s en lits";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "" method = "post">

<div id="div2">

	<!-- champ de type INPUT -->
	<?php
	if($_REQUEST['enregistrement']=='ok'){?>
		<fieldset id="field1">
		<legend>G�rer les lits disponibles </legend>
			<p color="red">Le nombre de lits/places disponibles a bien �t� enregistr�</p>
		</fieldset>
		<?php } ?>
	
	<fieldset id="field1">
		<legend>G�rer les lits disponibles </legend>
			<p>Cette page permet d'enregistrer le nombre de lits/places disponibles</p>
			<p>On parle de <b>lit</b>s pour les sevices conventionnels (m�decine, chirurgie, etc.</p>
			<p>On parle de <b>places</b> pour les services o� le patient n'est pr�sent que pour<br>
				un temps limit�: salle d'op�ration, r�veil, dialyse, h�pital de jour, etc.</p>
			<p><a href="lits_dispo.php">mettre � jour les lits disponibles</a></p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Remarques </legend>
			<p>Les disponibilit�s concernant les salles de r�veil, salles d'op�ration, morgue, etc.<br>
			ne sont � fournir qu'en cas de crise grave avec ou sans d�clenchement du plan Blanc</p>
	</fieldset>
	
</div>

<?php
?>

</form>
</body>
</html>