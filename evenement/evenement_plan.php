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
//	programme: 		evenement_plan.php
//	date de création: 	12/11/2004
//	auteur:			jcb
//	description:		Fonctionalité permise à l'administrateur
//	version:			1.2
//	maj le:			14/10/2004
//
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
print("<title>liste des plans</title>");
print("<meta name=\"author\" content=\"JCB\">");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

// CORPS
print("<BODY>");
print("<FORM ACTION =\"\" METHOD=\"GET\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

	print("Plans de secours<br>");
	$requete = "SELECT plan_courant_ID,titre,date1,date2,plan_nom,evenement_nom
 				FROM plan_courant,plan,evenement
				WHERE plan_courant.plan_ID = plan.plan_ID
				AND plan_courant.evenement_ID = evenement.evenement_ID
				";
	$resultat = ExecRequete($requete,$connexion);

print("<table border=\"1\" cellspacing=\"0\">");
print("<TR>");
	print("<TD>plan</TD>");// nom du plan
	print("<TD>catégorie</TD>");// ex. sater
	print("<TD>déclenché le</TD>");
	print("<TD>levé le</TD>");
	print("<TD>évènement associé</TD>");
print("</TR>");

while($plan=mysql_fetch_array($resultat))
{
	print("<TR>");
		print("<TD>$plan[titre]</TD>");
		print("<TD>$plan[plan_nom]</TD>");
		print("<TD>$plan[date1]</TD>");
		print("<TD>$plan[date2]</TD>");
		print("<TD>$plan[evenement_nom]</TD>");
		if($_SESSION['auto_sagec'])
			print("<td><a href=\"evenement_plan_nouveau.php?plan=$plan[plan_courant_ID]\">modifier</a></td>");
	print("</TR>");
}
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
print("<TR>");
	print("<TD>&nbsp;</TD>");
	if($_SESSION['auto_sagec'])
		print("<TD><input type=\"submit\" name=\"ok\" value=\"Modifier\"></TD>");
print("</TR>");
*/
print("</table>");


?>
