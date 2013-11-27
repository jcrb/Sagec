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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		liste_victimes.php
//	date de cr�ation: 	5/03/2005
//	auteur:			jcb
//	description:		affiche la liste des victimes adress�es � un service
//	version:		1.0
//	maj le:			16/10/2011 introduction de Security
//
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");

//if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$member_id = $_SESSION['member_id']; 
if(!isset($_SESSION['member_id'])) header("Location:".$backPathToRoot."logout.php");

//====================== Corps =======================================

print("<html>");
print("<head>");
print("<title> menu service </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");
//print($_SESSION[service]);
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
/*
if($_SESSION["auto_org"])
{
		$requete = "SELECT no_ordre,nom, prenom,gravite_nom,gravite_couleur,age1,age2,signes,lesions,traitement,photo
			FROM victime, gravite,hopital
			WHERE hopital.Hop_ID = victime.Hop_ID
			AND hopital.org_ID = '$_SESSION[organisation]'
			AND gravite.gravite_ID = victime.gravite
			";
}
else if($_SESSION["auto_hopital"])
{
*/
		$requete = "SELECT no_ordre,nom, prenom,gravite_nom,gravite_couleur,age1,age2,signes,lesions,traitement,photo
			FROM victime, gravite
			WHERE Hop_ID = '$_SESSION[Hop_ID]'
			AND gravite.gravite_ID = victime.gravite
			";
/*
}
else

	$requete = "SELECT no_ordre,nom, prenom,gravite_nom,gravite_couleur,age1,age2,signes,lesions,traitement,photo
			FROM victime, gravite
			WHERE service_ID = '$_SESSION[service]'
			AND gravite.gravite_ID = victime.gravite
			";
*/
//print($requete);
	
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
print("</html>");
?>
