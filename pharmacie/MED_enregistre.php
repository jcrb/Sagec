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
//	programme: 		MED_enregistre.php
//	date de cr�ation: 	5/10/2004
//	auteur:			jcb
//	description:		saisie d'une nouveau m�dicament
//	version:			1.0
//	maj le:			05/10/2004
//
//--------------------------------------------------------------------------------------------------------
//
session_start();
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require '../utilitaires/globals_string_lang.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

print("<html>");
print("<head>");
print("<title> M�dicaments </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
?>
<script type="text/javascript">
<!-- set focus to a field with the name "med_dci" in my form -->
function setfocus()
// met le focus sur la zone de saisie
{
document.forms[0].med_dci.focus()
}
function fen_close()
// ferme le dialogue dans rien enregistrer
{
	this.close();
}
function fen_refresh()
// rafraichit la fen�tre m�re, ce qui permet de mettre � jour la liste
// puis ferme le dialogue
{
	window.opener.location.reload();
	this.close();
}
</script>
<?php
print("</head>");

print("<BODY BGCOLOR=\"#ffffff\" onload=\"setfocus();\" >");//onUnload=\"fen_close();\"
print("<FORM name =\"DCI\"  ACTION=\"MED_enregistre.php\" METHOD=\"GET\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$_GET[maj]\">");
//print("maj=".$_GET['maj']);
// Si la rubrique nom n'est pas vide, on enregistre la nouvelle DCI dans la base
if($_GET[med_nom])
{
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	//print("maj".$_GET['maj']);
	if($_GET['maj'])// c'est une mise � jour
	{
		$requete="UPDATE med_specialite SET special_nom='$_GET[med_nom]' WHERE special_ID='$_GET[maj]'";
		$resultat = ExecRequete($requete,$connexion);
	}
	else
	{
		$requete="SELECT special_nom FROM med_specialite";
		$resultat = ExecRequete($requete,$connexion);
		if(mysql_num_rows == 0) // � condition que ce nom n'existe pas d�j�
		{
			$requete="INSERT INTO med_specialite VALUES('','$_GET[med_nom]','1')";
			$resultat = ExecRequete($requete,$connexion);
		}
	}
	print("<script> fen_refresh();</script>");
}
//Affichage du dialogue de saisie
print("<P>M�dicament: ");
print("<INPUT TYPE=\"TEXT\" VALUE=\"\" NAME=\"med_nom\" SIZE = \"30\"></P>");
if($_GET['maj'])
	print"<input type=\"submit\" name=\"select_med\" value=\"Modifier\">";// onclick=\"submit();\"
else print"<input type=\"submit\" name=\"select_med\" value=\"Ajouter un m�dicament\">";
print"<input type=\"button\" name=\"abort_med\" value=\"Annuler\" onclick=\"fen_close();\">";

print("</FORM>");
print("</html>")
?>
