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
/**	programme: 			evenement_actif.php
*	date de création: 	12/11/2004
*	@author:			jcb
*	description:		Fonctionalité permise à l'administrateur
*	@version:			1.2 - $Id: evenement_nouveau.php 10 2006-08-17 22:41:56Z jcb $
*	maj le:				14/10/2004
*	@package			Sagec
*/
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
//
include("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
//
$langue = $_SESSION['langue'];
//
// ENTETE
print("<html>");
print("<head>");
print("<title> Evènement courant </title>");
print("<meta name=\"author\" content=\"JCB\">");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");
// CORPS
print("<BODY>");
print("<FORM ACTION =\"evenement_actif.php\" METHOD=\"POST\">");
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

print("Modifier l'évènement courant<hr><br>");

//----------------------------
if($_REQUEST['ok']=='MAJ')
{
	$_SESSION['evenement'] = $_REQUEST['ev_courant'];
	$requete = "UPDATE alerte SET evenement_ID = '$_REQUEST[ev_courant]'";
	$resultat = ExecRequete($requete,$connect); 
}
//---------------------------------
$requete = "SELECT evenement_nom from evenement WHERE evenement_ID = '$_SESSION[evenement]'";
$resultat = ExecRequete($requete,$connect);
$rub=mysql_fetch_array($resultat);
print("Evènement actif courant: ".$rub['evenement_nom']."<br>");

// liste des évènements courants
	$requete = "SELECT evenement_ID, evenement_nom FROM evenement WHERE evenement_actif = 'o'";
	$resultat = ExecRequete($requete,$connect);
	print("<br>Choisir l'évènement à activer <SELECT name=\"ev_courant\">");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<option value=\"$rub[evenement_ID]\"> $rub[evenement_nom]</option>");
	}
	print("</SELECT>");
	print("<input type=\"submit\" name=\"ok\" value=\"MAJ\">");


print("</BODY>");
print("</FORM>");
print("</html>");
?>