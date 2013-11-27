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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		batiment_saisie.php
//	date de cr?ation: 	28/07/2005
//	auteur:			jcb
//	description:		enregistre un batiment bouveau ou modifi?
//	version:			1.0
//	maj le:			28/07/2005
//
//--------------------------------------------------------------------------------------------------------
//
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require '../utilitaires/globals_string_lang.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
include("../utilitairesHTML.php");

print("<html>");
print("<head>");
print("<title> batiment </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
?>
<script type="text/javascript">
<!-- set focus to a field with the name "med_dci" in my form -->
function setfocus()
{
document.forms[0].nom.focus()
}
function fen_close()
// ferme le dialogue dans rien enregistrer
{
	this.close();
}
function fen_refresh()
// rafraichit la fen?tre m?re, ce qui permet de mettre ? jour la liste
// puis ferme le dialogue
{
	window.opener.location.reload();
	this.close();
}
</script>
<?php
print("</head>");

print("<BODY BGCOLOR=\"#ffffff\" onload=\"setfocus();\" >");//onUnload=\"fen_close();\"
print("<FORM name =\"batiment\"  ACTION=\"batiment_enregistre.php\" METHOD=\"GET\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
// Si la rubrique nom n'est pas vide, on enregistre la nouvelle DCI dans la base
if($_GET['maj'])
{
	$requete="SELECT stockage_batiment_nom FROM stockage_batiment WHERE stockage_batiment_ID = '$_GET[maj]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	//print("<script> fen_refresh();</script>");
	print("<P>Modifier un batiment</P>");
	//print("<input type=\"hidden\" name=\"maj\" value=\"$_GET[maj]\">");
}
else
	print("<P>Nouveau batiment</P>");

//Affichage du dialogue de saisie
print("<table>");
print("<tr>");
	print("<td>nom:</td>");
	print("<td><INPUT TYPE=\"TEXT\" VALUE=\"$rub[stockage_batiment_nom]\" NAME=\"nom\" SIZE = \"30\"></td>");
	print("</tr>");
	print("<tr>");
	print("<td>organisme:</td>");
	print("<td>");
		SelectOrganisme($connexion,$_GET['org'],$langue,"");//$org_type
	print("</td>");
print("</tr>");
print("</table>");
print"<input type=\"submit\" name=\"select\" value=\"Valider\">";// onclick=\"submit();\"
print"<input type=\"button\" name=\"abort\" value=\"Annuler\" onclick=\"fen_close();\">";

print("</FORM>");
print("</html>")
?>
