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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		materiel_fiche.php
//	date de création: 	01/10/2004
//	auteur:			jcb
//	description:		saisie des caractéristiques d'un médicament
//	version:			1.0
//	maj le:			01/10/2004
//
//--------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backpathToRoot="../";
require($backpathToRoot."dbConnection.php");
include($backpathToRoot."utilitaires/table.php");
require $backpathToRoot.'utilitaires/globals_string_lang.php';
//include("../utilitairesHTML.php");
include("utilitaires_MED.php");

if($_REQUEST[ok]=="Valider")
{
	$nom = $_REQUEST['nom'];
	$fournisseur = $_REQUEST['fournisseur'];
	$inventaire = $_REQUEST['inventaire'];
	
	$requete="INSERT INTO med_specialite VALUES ('','$nom',2)";
	//print("document.writeln($requete);");
	$resultat = ExecRequete($requete,$connexion);
	@mysql_free_result($resultat);
}
?>
<html>
<head>
<title> Matériel </title>
<LINK REL=stylesheet HREF="../pma.css" TYPE ="text/css">
<LINK REL = stylesheet TYPE = "text/css" HREF = "pharma.css">
</script>
</head>

<BODY BGCOLOR=\"#ffffff\" >
<FORM name =\"Services\"  ACTION=\"medicament_enregistre.php\" METHOD=\"GET\">
<p>Nouveau matériel</p>
<table class="time">
	<tr>
		<td><?php echo $string_lang['NOM'][$langue].": ";?></td>
		<td><input type="text" name="nom"></td>
	</tr>
	<tr>
		<td><?php echo $string_lang['FOURNISSEUR'][$langue].": ";?></td>
		<td><input type="text" name="fournisseur"></td>
	</tr>
	<tr>
		<td><?php echo $string_lang['INVENTAIRE'][$langue].": ";?></td>
		<td><input type="text" name="nom"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="ok" value="Valider"></td>
	</tr>
</table>
</FORM>
</html>
