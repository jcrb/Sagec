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
/**
*	programme: 			evenements.php
*	date de création: 	17/08/06
*	@author:			jcb
*	description:		Tableau des évènements
*	@version:			1.2 - $Id: evenements.php 10 2006-08-17 22:41:56Z jcb $
*	maj le:				17/08/06
*	@package			Sagec
*/
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
$langue = $_SESSION['langue'];

//=============================================================================
//	SelectPlan()		Liste des plans de secours
//=============================================================================
/**
*Retourne la Liste des plans de secours.
*
*@package utilitairesHTML.php
*@return rien
*@param int paramètre de connexion
*@param int item sélectionné par défaut
*@version 1.0
*/

// ENTETE
print("<html>");
print("<head>");
print("<title>liste des évènements</title>");
print("<meta name=\"author\" content=\"JCB\">");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

// CORPS
print("<BODY>");
print("<FORM ACTION =\"\" METHOD=\"GET\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

function affiche($resultat)
{
	print("<table border=\"1\" cellspacing=\"0\">");
		print("<TR bgcolor=\"green\">");
			print("<TD>libellé</TD>");// nom du plan
			print("<TD>date</TD>");// ex. sater
			print("<TD>heure</TD>");
			print("<TD>dossier SAMU</TD>");
			print("<TD>dossier SDIS</TD>");
		print("</TR>");
		while($plan=mysql_fetch_array($resultat))
		{
			print("<TR>");
				print("<TD>$plan[evenement_nom]</TD>");
				print("<TD>$plan[evenement_date1]</TD>");
				print("<TD>$plan[evenement_heure1]</TD>");
				print("<TD>$plan[dossier_samu]</TD>");
				print("<TD>$plan[dossier_sdis]</TD>");
				if($_SESSION['auto_sagec'])
				print("<td><a href=\"evenement_maj.php?ev_courant=$plan[evenement_ID]&ok=MAJ\">modifier</a></td>");
				print("<td><a href=\"evenement_archive.php?ev_courant=$plan[evenement_ID]\">archive</a></td>");
		print("</TR>");
	}
	print("</table>");
}

/**
* MAIN
*/

	print("Evènements en cours<hr><br>");
	$requete = "SELECT evenement_ID,evenement_date1,evenement_heure1,evenement_nom,dossier_samu,dossier_sdis
 				FROM evenement WHERE evenement_actif = 'oui' ORDER BY evenement_date1 DESC
				";
	$resultat = ExecRequete($requete,$connexion);
	affiche($resultat);
	
	print("Evènements non en cours<hr><br>");
	$requete = "SELECT evenement_ID,evenement_date1,evenement_heure1,evenement_nom,dossier_samu,dossier_sdis
 				FROM evenement WHERE evenement_actif = 'non' ORDER BY evenement_date1 DESC
				";
	$resultat = ExecRequete($requete,$connexion);
	affiche($resultat);
	
	print("<br>Evènements clos<hr><br>");
	$requete = "SELECT evenement_ID,evenement_date1,evenement_heure1,evenement_nom,dossier_samu,dossier_sdis
 				FROM evenement WHERE evenement_actif = 'clos' ORDER BY evenement_date1 DESC
				";
	$resultat = ExecRequete($requete,$connexion);
	affiche($resultat);

	print("<br>Evènements archivés<hr><br>");
	$requete = "SELECT evenement_ID,evenement_date1,evenement_heure1,evenement_nom,dossier_samu,dossier_sdis
 				FROM evenement WHERE evenement_actif = 'archivé' ORDER BY evenement_date1 DESC
				";
	$resultat = ExecRequete($requete,$connexion);
	affiche($resultat);
	
	print("<br>Evènements Statut indéterminé<hr><br>");
	$requete = "SELECT evenement_ID,evenement_date1,evenement_heure1,evenement_nom,dossier_samu,dossier_sdis
 				FROM evenement WHERE evenement_actif = 0 ORDER BY evenement_date1 DESC
				";
	$resultat = ExecRequete($requete,$connexion);
	affiche($resultat);



/*
print("<TR>");
	print("<TD>activé le</TD>");
	if(!$plan[date1])$plan[date1]="aaaa-mm-jj hh:mm";
	print("<TD><input type=\"text\" name=\"date1\" size=\"30\" value=\"$plan[date1]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>levé le</TD>");
	if(!$plan[date1])$plan[date2]="aaaa-mm-jj hh:mm";
	print("<TD><input type=\"text\" name=\"date2\" size=\"30\" value=\"$plan[date2]\"></TD>");
print("</TR>");

*/
?>
