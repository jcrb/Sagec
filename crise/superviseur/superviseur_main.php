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
  * programme: 			ars_deces.php
  * date de cr�ation: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
$titre_principal = "Crise et Supervision";
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
	<title>Superviseur</title>
	<link rel="stylesheet" href="../div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "" method = "post">

<div id="div2">
	
	<fieldset id="field1">
		<legend>Main courante </legend>
		<p>
			Informations partag�es entre les membres de la r�gulation, le terrain et les cellules de crise.
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend>Check-list</legend>
		<p>
			Pour ne rien oublier en situation d'urgence.
			Les �l�ments valid�s de la check-list sont automatiquement enregistr�s dans la main courante.
		</p>
	</fieldset>
		
	<fieldset id="field1">
		<legend>H�pitaux</legend>
		<p>
			S�lectionner les h�pitaux qui doivent �tre contact�s dans le cadre d'une recherche de lits
		</p>
	</fieldset>
		
	<fieldset id="field1">
		<legend>Sp�cialit�s</legend>
		<p>
			S�lectionner les sp�cialit�s qui doivent �tre contact�s dans le cadre d'une recherche de lits. Combin� avec l'item pr�c�dent permer de disposer d'une fiche de
			recueuil de lits et d'un tableau de synth�se h�pitaux/sp�cialit�s.
		</p>
	</fieldset>
	
	</fieldset>
	<fieldset id="field1">
		<legend>Retour au menu principal</legend>
		<p>
			Retour au menu pr�c�dant
		</p>
	</fieldset>
	
	
</div>


</form>
</body>
</html>
