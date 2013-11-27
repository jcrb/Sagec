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
//	programme: 				pb_victimes.php
//	date de cr�ation: 	12/02/2010
//	auteur:					jcb
//	description:			portail acc�s au plan blanc
//							
//	version:					1.0
//	maj le:			
//---------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "Plan blanc - Victimes";
$sousmenu = "<a href='lits_comment.php'>main</a> > <a href='pbComment.php'>plan blanc</a> > <a href=''>victimes</a>";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$member_id = $_SESSION['member_id']; 
if(!isset($member_id)) header("Location:".$backPathToRoot."logout.php");
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

<?php
		$requete = "SELECT no_ordre,nom, prenom,gravite_nom,gravite_couleur,age1,age2,signes,lesions,traitement,photo
			FROM victime, gravite
			WHERE Hop_ID = '$_SESSION[Hop_ID]'
			AND gravite.gravite_ID = victime.gravite
			";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	print("<p>");
	print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
	print("<tr bgcolor=\"$rub[gravite_couleur]\">");
		print("<td width=\"100\">N� d'identification</td>");
		print("<td width=\"300\"><b>".$rub['no_ordre']."</b></td>");
		print("<td width=\"100\">Gravit�</td>");
		print("<td><b>".Security::db2str($rub['gravite_nom'])."</b></td>");
	print("</tr>");
	print("<tr>");
		print("<td>nom</td>");
		print("<td><b>".Security::db2str($rub['nom'])."</b></td>");
		print("<td>pr�nom</td>");
		print("<td><b>".Security::db2str($rub['prenom'])."</b></td>");
	print("</tr>");
	print("<tr>");
		print("<td>date de naissance</td>");
		print("<td><b>"." "."</b></td>");
		print("<td>age</td>");
		$age=$rub['age1'];
		if(!$rub['age1']) $age = $rub['age2'];
		print("<td><b>".$age."</b></td>");
	print("</tr>");
	print("<tr>");
		print("<td>adresse</td>");
		print("<td><b>".Security::db2str($rub['adresse'])."</b></td>");
		print("<td>Photo</td>");
		print("<td><img alt=\"\" border=\"0\" src=\"../$rub[photo]></td>");
	print("</tr>");
	print("<tr>");
		print("<td>Signes</td>");
		print("<td><b>".Security::db2str($rub['signes'])."</b></td>");
		print("<td>L�sions</td>");
		print("<td><b>".Security::db2str($rub['lesions'])."</b></td>");
	print("</tr>");
	print("<tr>");
		print("<td>Traitements</td>");
		print("<td><b>".Security::db2str($rub['traitement'])."</b></td>");
		print("<td>&nbsp;</td>");
		//print("<td><a href=\"dossier/dossier_frameset.php?id=$rub[no_ordre]&back=$back\">acc�der au dossier m�dical</a></td>");
		print("<td>");
			print("<a href='../dossier/dossier_frameset.php?id=$rub[no_ordre]&back=$back'>acc�der au dossier m�dical </a>");
		print("</td>");
	print("</tr>");
	print("</table>");
	print("</p>");
}
@mysql_free_result($resultat);

?>

</form>
</body>
</html>