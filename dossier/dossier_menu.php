<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 		dossier_menu.php
//	date de cr?ation: 	06/02/2005
//	auteur:			jcb
//	description:		Fonctionalit? permise ? l'administrateur
//	version:			1.1
//	maj le:			10/06/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pma_requete.php");
require("../pma_connect.php");
require("../pma_connexion.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$langue = $_SESSION['langue'];
$id = $_REQUEST['id'];

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

print("<head>");
print("<title>menu assu</title>");
print("<LINK REL=stylesheet HREF=\"tr_css.css\" TYPE =\"text/css\">");
print("</head>");

function select_dossier($connexion,$langue,$item_select,$onChange)
{
	require '../utilitaires/globals_string_lang.php';
	$requete="SELECT no_ordre FROM victime";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"no_dossier\" size=\"1\" onChange='$onChange'>");
	$mot = $string_lang['NO_SELECT'][$langue];
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[no_ordre]\" ");
			if($item_select == $rub['no_ordre']) print(" SELECTED");
			print("> $rub[no_ordre] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//print("<fieldset >");//class=\"time_v\"
//print("<legend> Menu </legend>");
print("<body bgcolor=\"#cccccc\">");
print("<form name=\"dossier\" target=\"left\" method=\"get\">");
print("N� de dossier: ");
if(!$id)
{
	select_dossier($connexion,$langue,$_REQUEST['no_dossier'],'document.dossier.submit();');
	$no_dossier = $_GET[no_dossier];
}
else 
{
	$no_dossier = $id;
	print($no_dossier);
}

if($no_dossier != "")
{
print("<ul class=\"menu1\">");
	print("<li><a href=\"identite.php?dossier=$no_dossier\" target=\"middle\">Etat civil</a></li>");
	print("<li><a href=\"feuille_soins2.php?dossier=$no_dossier\" target=\"middle\">Feuille de soins</a></li>");
	print("<li><a href=\"resume.php?dossier=$no_dossier\" target=\"middle\">R�sum�</a></li>");	
	print("<li><a href=\"constantes.php?dossier=$no_dossier\" target=\"middle\">Constantes</a></li>");
	print("<li><a href=\"bolus.php?dossier=$no_dossier\" target=\"middle\">Traitements</a></li>");
	print("<li><a href=\"conditionnement.php?dossier=$no_dossier\" target=\"middle\">Conditionnement</a></li>");
	print("<li><a href=\"gestes.php?dossier=$no_dossier\" target=\"middle\">Gestes</a></li>");
	print("<li><a href=\"dossier_med.php?dossier=$no_dossier\" target=\"middle\">L�sions</a></li>");
	print("<li><a href=\"feuille_soins3.php?dossier=$no_dossier\" target=\"middle\">feuille soins 3</a></li>");
print("</ul>");
}
//print($_GET['no_dossier']);
print("<form>");
print("</body>");
?>
