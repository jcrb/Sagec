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
function SelectPlan($connexion,$item_select)
{
	$requete = "SELECT * FROM plan ORDER BY plan_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_plan\" size=\"1\">");
	//print("<OPTION VALUE = \"0\">-- choisir -- </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[plan_ID]\" ");
		if($item_select == $rub['plan_ID']) print(" SELECTED");
		print("> $rub[plan_nom]</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
function SelectEvenement($connexion,$item_select)
{
	$requete = "SELECT evenement_ID,evenement_nom FROM evenement WHERE evenement_date2='0' ORDER BY evenement_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_evenement\" size=\"1\">");
	print("<OPTION VALUE = \"0\">--aucun -- </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[evenement_ID]\" ");
		if($item_select == $rub['evenement_ID']) print(" SELECTED");
		print("> $rub[evenement_nom]</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

// ENTETE
print("<html>");
print("<head>");
print("<title> Evènement courant </title>");
print("<meta name=\"author\" content=\"JCB\">");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

// CORPS
print("<BODY>");
print("<FORM ACTION =\"plan_enregistre.php\" METHOD=\"GET\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

if($_REQUEST['plan'])
{
	print("Mise à jour<hr><br>");
	print("<input type=\"hidden\" name=\"maj\" value=\"$_REQUEST[plan]\">");
	$requete = "SELECT * FROM plan_courant WHERE plan_courant_ID = $_REQUEST[plan]";
	$resultat = ExecRequete($requete,$connexion);
	$plan=mysql_fetch_array($resultat);
}
else print("Nouveau Plan<hr><br>");
// évènement courant
print("<table>");
print("<TR>");
	print("<TD>type de plan:</TD>");
	print("<TD>");
		SelectPlan($connexion,$plan['plan_ID']);// ID_plan
	print("</TD>");
	print("<td><a href=\"nouveau_plan.php?back=evenement_plan_nouveau.php&plan=$_REQUEST[plan]\"> nouveau</a></td>");
print("</TR>");
print("<TR>");
	print("<TD>intitulé du plan</TD>");
	print("<TD><input type=\"text\" name=\"titre\" value=\"$plan[titre]\"size=\"30\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>évènement lié:</TD>");
	print("<TD>");
		SelectEvenement($connexion,$plan['evenement_ID']);// ID_evenement
	print("</TD>");
print("</TR>");
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
print("<TR>");
	print("<TD>Commentaires</TD>");
	print("<TD><TEXTAREA name=\"comment\" value=\"$rub[comment]\" cols=\"50\" rows=\"5\"></textarea></TD>");
print("</TR>");
print("</table>");


?>
