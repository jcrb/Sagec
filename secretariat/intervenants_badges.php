<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//----------------------------------------- SAGEC ---------------------------------------------
//
//	programme: 		intervenants_badges.php
//	date de création: 	18/08/2008
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			18/08/2008
//
//---------------------------------------------------------------------------------------------
/**
* Règles applicables à la saisie des victimes
* 
* Limiter le nombre d'hôpital à afficher
*/
session_start();
$path="../";
if(! $_SESSION['auto_sagec'])header("Location:".$path."logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
$titre_principal="Secrétariat - Badges";
include_once("top.php");
include_once("menu.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require($path."pma_requete.php");
require($path."pma_connect.php");
require($path."pma_connexion.php");
include_once($path."pdf/codebarre_utilitaires.php");
require_once($path."code_barre.php");
$connexion = connexion(NOM,PASSE,BASE,SERVEUR);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head><meta http-equiv="content-type" content="ent="text; charset=ISO-8859-1" >
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des intervenants</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<!--LINK REL=stylesheet HREF="pma.css" TYPE ="text/css"> -->
	<!--<LINK REL=stylesheet HREF="../../css/impression2.css" TYPE ="print/css"> -->
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	<script  type="text/javascript" src="../ajax/jquery-courant.js"></script>
<script>
	$(document).ready(function(){
			$('tr:odd').addClass('alt');
		});
</script>
</head>

<body>
	<form name="selection" action="../pdf/badges.php" method="post">
	<p>Sélectionner les personnes à badger, puis <input type="submit" name="VALIDER" value="VALIDER" class="noprint"></p>
<?php

$requete = "SELECT Pers_ID,Pers_Nom, Pers_Prenom,org_nom, personnel.org_ID
				FROM personnel,organisme
				WHERE personnel.org_ID = organisme.org_ID
				AND visible='o'
				ORDER BY Pers_Nom";
$resultat = ExecRequete($requete,$connexion);
//$listeID = 1;//NE PAS MODIFIER
print("<table>");
while($rub=mysql_fetch_array($resultat))
{
	$pays=30;
	$codeBarre = code($rub[Pers_ID],$rub[org_ID],$pays);
	print("<tr>");
		print("<td align=\"left\"><input type=\"checkbox\" class=\"noprint\" name=\"ch[]\" value=\"$rub[Pers_ID]\" ></td>");
		print("<td>$rub[Pers_Nom]</td>");
		print("<td>$rub[Pers_Prenom]</td>");
		print("<td>$rub[org_nom]</td>");
		print("<td>$codeBarre</td>");
		print("<td><IMG SRC=\"../Barcode/code_barre_fabrique.php?ean=$codeBarre&largeur=120&hauteur=70\"></td>");
	print("</tr>");
}
print("</table>");
?>
</form>
</body>
</html>