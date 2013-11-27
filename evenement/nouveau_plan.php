<?
// This file is part of SAGEC67 Copyright (C) 2003-2006 (Jean-Claude Bartier).
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
/**	programme: 			nouveau_plan.php
//	date de création: 	17/08/06
//	@author:			jcb
//	description:		ajoute une entrée dans la table plan
//	@version:			1.0 - $Id: nouveau_plan.php 10 2006-08-17 22:41:56Z jcb $
//	maj le:				17/08/06
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
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

// ENTETE
print("<html>");
print("<head>");
print("<title> Evènement courant </title>");
print("<meta name=\"author\" content=\"JCB\">");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

// CORPS
print("<BODY>");
print("<FORM ACTION =\"nouveau_plan.php\" METHOD=\"GET\">");

if($_REQUEST['ok']=='créer')
{
	$requete = "INSERT INTO plan VALUES('','$_REQUEST[nouveau_plan]')";
	$resultat = ExecRequete($requete,$connexion);
	header("Location:".$_REQUEST['back']."?maj=".$_REQUEST['plan']);
}
elseif($_REQUEST['ok']=='annuler')
{
	header("Location:".$_REQUEST['back']."?maj=".$_REQUEST['plan']);
}
print("<input type=\"hidden\" name=\"back\" value=\"$_REQUEST[back]\">");
print("<input type=\"hidden\" name=\"plan\" value=\"$_REQUEST[plan]\">");
print("Créer un nouveau plan<hr><br>");
print("intitulé:<input type=\"text\" name=\"nouveau_plan\" size=\"50\">");
print("<input type=\"submit\" name=\"ok\" value=\"créer\">");
print("<input type=\"submit\" name=\"ok\" value=\"annuler\">");

print("</BODY>");
print("</html>");
?>