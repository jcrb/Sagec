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
/**
* 	programme: 			apa_menu.php																	 	 
*	date de création: 	08/03/2004																	 
*	auteur:				jcb																				 
*	description:		page de choix pour les transporteurs															 											 //
*	@version $Id: apa_menu.php 39 2008-02-28 17:59:09Z jcb $
*	maj le:				08/03/2004
*/																										 
//---------------------------------------------------------------------------------------------------------
// ouverture d'une session
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("html.php");

if(!$_SESSION["auto_apa"])
{
	print("<H2>Vous n'êtes pas autorisé à accéder à cette zone</H2><BR>");
	echo "<a href = \"langue.php\"><H1>Continuer</H1></a><br>";
	exit();
}
print("<HTML><HEAD><TITLE>APA</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</HEAD>");

$_SESSION["langue"] = 'FR';
$mot = "Vous êtes enregistré en tant qu'utilisateur n°";
entete_sagec($mot.$_SESSION["member_id"]);
print("<BR>");

//echo $mot.$_SESSION["member_id"]."<br>";
if($_SESSION["organisation"] != 0)
{
	$mot = "Mise à jour des véhicules disponibles";
	echo "<a href = \"apa.php\" class=\"time\">$mot</a><br><br>";
}

$mot = "Page d'informations";
echo "<a href = \"apa_info.php\" class=\"time\">$mot</a><br><br>";

if($_SESSION["autorisation"]==2)
echo "<a href = \"apa/apa_territoire.php\" class=\"time\"> Mettre à jour la zone d'intervention</a><br><br>";

/* Spécial SDIS */

if($_SESSION["organisation"]==3)// SDIS 
{
	$mot = "Gestion de crise";
	echo "<a href = \"sdis/sdis_frameset.php\" class=\"time_r\">$mot</a><br><br>";
}

/* Quitter la session */

$mot = "Quitter la session";
echo "<a href = \"logout.php\" class=\"time_r\">$mot</a><br><br>";

?>
