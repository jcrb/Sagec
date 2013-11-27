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
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  
	*	specialites_affiche.php
	*	affiche la liste des spécialités dont on veut le nombre de lits
	*	une case à cocher permet de sélectionner les spécialités qui apparaitront
	*	dans le formulaire hospitalier
	*	Permet également de modifier des intitulés mais pas de les supprimer
	*/
/* -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
$titre_principal = "Crise et Supervision - Gestion des spécialités hospitalières";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");

$visible = array();
/**
  * récupère les items de la liste
  */
$requete = "SELECT * FROM planblanc_specialite ORDER BY pb_spe_ID";
$resultat = ExecRequete($requete,$connexion);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Specialité</title>
	<link rel="stylesheet" href="../div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form id="catalogue" action="specialite_visible_enregistre.php" method="post">

<div id="div2">
	
	<fieldset id="field1">
		<legend>Spécialités</legend>
		<p>
			Cochez les cases correspondants aux spécialités que l'on souhaite voir apparaître dans les formulaires.
		</p>
	</fieldset>
	<p></p>
	
	<?php
	print("<table>");
while($rep = mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td bgcolor=\"#FFFF66\">".$rep[pb_spe_ID]."</td>");
		print("<td bgcolor=\"#FFFF99\"><label for=\"$rep[pb_spe_short]\">".$rep[pb_spe_nom]."</label></td>");
		print("<td bgcolor=\"#FFFFCC\"><label for=\"$rep[pb_spe_short]\">".$rep[pb_spe_short]."</label></td>");
		/** Utilisation de label permet de sélectionner une case en cliquant sur le nom */
		print("<td  bgcolor=\"#CCFF99\"><input type=\"checkbox\" name =\"visible[]\" value=\"$rep[pb_spe_ID]\" id=\"$rep[pb_spe_short]\" ");
			if($rep[pb_spe_visible]) echo 'checked';print("></td>");
			
		//print("<td>".$rep[pb_spe_comment0]."</td>");
		//print("<td>".$rep[pb_spe_comment1]."</td>");
		//print("<td>".$rep[pb_spe_comment2]."</td>");
		print("<td bgcolor=\"\" class=\"noprint\"><a href=\"specialite_nouvelle.php?speID=$rep[pb_spe_ID]\">modifier</a></td>");
	print("</tr>");
}
print("</table>");

?>

<p>
	<div>
		<input type="submit" class="noprint" name="ok" value ="valider">
	</div>
</p>
<p>
	<div>
		<input type="submit" class="noprint" name="ok" value ="Ajouter">
	</div>
</p>

</body>
</html>
	
</div>


</form>
</body>
</html>
