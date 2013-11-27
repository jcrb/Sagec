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
//----------------------------------------- SAGEC --------------------------------
/**
*	programme: 		administrateur_menu.php
*	date de création: 	26/12/2003
*	auteur:			jcb
*	description:		Fonctionalité permise à l'administrateur
*	@version:			$Id: administrateur_menu.php 39 2008-02-28 17:59:09Z jcb $
*	maj le:			13/02/2005
*/
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
$langue = $_SESSION['langue'];

include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
include("html.php");
require 'utilitaires/globals_string_lang.php';

if($_POST["language"])
{
	$langue = $_POST["language"];
	$_SESSION['langue'] = $_POST["language"];
}

// ENTETE
	print("<html>");
	print("<head>");
	print("<title> Gestion des Lits </title>");
	print("<meta name=\"author\" content=\"JCB\">");
	print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
	print("</head>");

// CORPS
	print("<BODY>");
	print("<FORM ACTION =\"administrateur_menu.php\" METHOD=\"POST\">");
	/*
	TblDebut(0,"100%");
	TblDebutLigne();
	TblCellule(Image('images/SAMU.jpeg',50,50));
	$mot = $string_lang['ADMINISTRATEUR'][$langue]." ".$hopital;
	TblCellule("<B>$mot</B>",1,1,"TITRE");
	TblCellule("SAMU 67",1,1);
	TblFinLigne();
	TblFin();
*/
	$mot = $string_lang['ADMINISTRATEUR'][$langue]." ".$hopital;
	entete_sagec($mot);

	print("<hr>");// barre horizontale
	TblDebut(0,"100%",0);
	$_style = "A2";
	TblDebutLigne("$_style");
		if($_SESSION['autorisation']==10)
		{
			$mot = strToUpper($string_lang['GESTION_UTILISATEUR'][$langue]);
			TblCellule("<div align=\"center\"><a href=\"utilisateurs_menu.php\"><B>$mot</B></a>");
			TblCellule("<div align=\"center\"><a href=\"resetPMA.php\"><B>RAZ</B>");
			TblCellule("<div align=\"center\"><a href=\"administrateur/sauvegarde.php\"><B>Sauvegarde</B>");
			TblCellule("<div align=\"center\"><a href=\"administrateur/choix_export_table.php\"><B>exporter table</B>");
			//TblCellule("<div align=\"center\"><a href=\"carto/decortique.php\"><B>limites</B>");
		}
		$mot = strToUpper($string_lang['CONNEXION'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"administrateur_connexions.php\"><B>$mot</B></a>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/dump_database.php\"><B>Dump Database</B></a>");
		$mot = strToUpper($string_lang['QUITTER'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"sagec67.php\"><B>$mot</B>");
	TblFinLigne();

	TblDebutLigne("$_style");
		TblCellule("<div align=\"center\"><a href=\"evenement/evenement_frameset.php\"><B>Evènement</B>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/sauvegarde_table.php\"><B>Tables</B>");
		if($_SESSION['autorisation']==10)
		{
			TblCellule("<div align=\"center\"><a href=\"administrateur/requete/requete_frame.php\"><B>Requêtes
					</B>");//
			TblCellule("<div align=\"center\"><a href=\"administrateur/fichier_en_table.php\"><B>F->T
					</B>");
			TblCellule("<div align=\"center\"><a href=\"administrateur/liredata.php\"><B>lire data
					</B>");
			TblCellule("<div align=\"center\"><a href=\"administrateur/centaure.php\"><B>Données Centaure 15
					</B>");
			TblCellule("<div align=\"center\"><a href=\"administrateur/ajoute_fichier.php\"><B>ajoute fichier
					</B>");
		}
	TblFinLigne();

	TblDebutLigne("$_style");
	if($_SESSION['autorisation']==10)
	{
		TblCellule("<div align=\"center\"><a href=\"administrateur/cree_dossier.php\"><B>Crée dossier</B>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/modifie_fichier.php\"><B>modifier dossier</B>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/session.php\"><B>Session</B>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/stat_connexion.php\"><B>Stat.connexion</B>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/export_fichier_sagec.php\"><B>Fichier Sagec</B>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/synchronise.php\"><B>Synchronisation</B>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/mail_dhos/mail_frameset.php\"><B>mail</B>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/mail.php\"><B>mail 2</B>");
		//TblCellule("<div align=\"center\"><a href=\"administrateur/mail_dhos/mail_dhos.php\"><B>mail 2</B>");
	}
	TblFinLigne();
	TblDebutLigne();
		TblCellule("<div align=\"center\"><a href=\"administrateur/lire_repertoire.php\"><B>Lire répertoire</B>");
		TblCellule("<div align=\"center\"><a href=\"Eskuel/index.php\"><B>ESKUEL</B>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/php_info.php\"><B>PHP info</B>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/choix_lire_table\"><B>Lire Table</B>");
		TblCellule("<div align=\"center\"><a href=\"organisme/liste_org.php\"><B>Liste Organismes</B>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/liste_tables.php\"><B>Gestion des tables</B>");
		TblCellule("<div align=\"center\"><a href=\"administrateur/liste_invites.php\"><B>Gestion des invités</B>");
	TblFinLigne();
	
	TblFinLigne();
		TblCellule("<div align=\"center\"><a href=\"administrateur/corrige_orthographe.php\"><B>Corrige UTF8</B>");
	TblDebutLigne();
	TblFinLigne();
	TblFin();

	print("<hr>");// barre horizontale
	print("<div align=\"left\">");
	print("</div>");

	TblDebut(0,"50%",0);
	TblDebutLigne();
		$mot = strToUpper($string_lang['MODIFIER_LANGUE'][$langue]);
		TblCellule("<B>$mot</B>");
		print("<TD>");
		print("<SELECT NAME=\"language\">");
		$mot = $string_lang['FRANCAIS'][$langue];
		print("<OPTION VALUE=\"FR\"> $mot </OPTION>");//
		$mot = $string_lang['ALLEMAND'][$langue];
		print("<OPTION VALUE=\"GE\"> $mot</OPTION>");
		$mot = $string_lang['ANGLAIS'][$langue];
		print("<OPTION VALUE=\"UK\">$mot </OPTION>");
		print("</SELECT>");
		print("</TD>");
		print("<TD>");
		print("<INPUT TYPE=\"submit\" NAME=\"ok\">");
		print("</TD>");
	TblFinLigne();

	TblFin();

	print("</form>");
	print("</body>");
	print("</html>");

?>
