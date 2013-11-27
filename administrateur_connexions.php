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
/**
*	programme: 			administrateur_connexions.php
*	date de création: 	26/12/2003
*	@author:				jcb
*	description:		Journal des connexions
* 	@version:			$Id: administrateur_connexions.php 39 2008-02-28 17:59:09Z jcb $
*	maj le:				26/12/2003
*/
//---------------------------------------------------------------------------------------------------------
//
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");

include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
include("html.php");
require 'utilitaires/globals_string_lang.php';
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");

print("<HTML><HEAD><TITLE>Ajout Utilisateur</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");

print("<BODY>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete = "SELECT org_nom, utilisateurs.nom, connexion_date, connexion_ip
			FROM connexion, organisme, utilisateurs
			WHERE connexion.org_ID = organisme.org_ID
			AND user_ID = ID_utilisateur
			ORDER BY connexion_date DESC";
$resultat = ExecRequete($requete,$connexion);

TblDebut(0,"100%");
$_style = "A2";
TblDebutLigne("$_style");
	TblCellule("<B>Date</B>");
	TblCellule("<B>Organisme</B>");
	TblCellule("<B>Nom</B>");
	TblCellule("<B>Adresse IP</B>");
TblFinLigne();
$_style = "A5";
while($i = LigneSuivante($resultat))
{
	if($_style=="A5")$_style="A6";
	else $_style="A5";
	TblDebutLigne("$_style");
		TblCellule("<div align=\"left\" class=\"Style23\">$i->connexion_date");
		TblCellule("<div align=\"left\" class=\"Style23\">$i->org_nom");
		TblCellule("<div align=\"left\" class=\"Style23\">$i->nom");
		TblCellule("<div align=\"rigth\" class=\"Style23\">$i->connexion_ip");
	TblFinLigne();
}
TblFin();
print("</BODY>");
print("</HTML>");
?>
