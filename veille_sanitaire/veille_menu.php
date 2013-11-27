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
//	programme: 		veille_menu.php
//	date de cr?ation: 	02/03/2005
//	auteur:			jcb
//	description:		Fonctionalit? permise ? l'administrateur
//	version:			1.2
//	maj le:			14/05/2005
//
//--------------------------------------------------------------------------------
//
session_start();
if(! $_SESSION['auto_sagec'])header("Location:../logout.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

print("<head>");
print("<title>menu assu</title>");
print("<LINK REL=stylesheet HREF=\"tr_css.css\" TYPE =\"text/css\">");
print("</head>");

//print("<fieldset >");//class=\"time_v\"
//print("<legend> Menu </legend>");
print("<body bgcolor=\"#cccccc\">");
print("<ul class=\"menu1\">");
	print("<li><a href=\"veille.php\" target=\"middle\">Saisir</a></li>");
	print("<li><a href=\"veille_liste.php\" target=\"middle\">Voir/modifier</a></li>");
	//print("<li><a href=\"graphe_veille_samu.php\" target=\"middle\">Tendances</a></li>");
	print("<li><a href=\"graphe_data.php\" target=\"middle\">Tendances</a></li>");
	print("<li><a href=\"graphe_pdf.php\" target=\"middle\">Imprimer/envoyer</a></li>");
	print("<li><a href=\"alerte/alerte_menu.php\" target=\"middle\">Alertes</a></li>");
	print("<li><a href=\"veille_specialite.php\" target=\"middle\">Lits par spécialité</a></li>");


	if($_SESSION['autorisation']>9)
	{
		print("<li><a href=\"create_fichier_xml.php\" target=\"middle\">Voir fichier XML</a></li>");
		print("<li><a href=\"create_xml.php\" target=\"middle\">Exporter</a></li>");
		print("<li><a href=\"gnugpg/cle_disponible.php\" target=\"middle\">Cryptage</a></li>");
		print("<li><a href=\"cron/cron_reglage.php\" target=\"middle\">Réglages</a></li>");
	}
print("</ul>");
print("</body>");
?>
