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
//---------------------------------------------------------------------------------------------------------
/**
//	programme: 		vaccin_saisie.php
//	date de création: 	28/09/2006
//	auteur:			jcb
//	description:		saisie d'une nouvelle langue
//	version:		1.1
*/
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require '../utilitaires/globals_string_lang.php';
include("../date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
print("<title> Vaccin d'un intervenant </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
?>
<SCRIPT>
function exite()
{
	window.opener.location.reload();
	this.close();
}
</SCRIPT>
<?php
print("</head");
print("<BODY onUnload=\"exite();\">");
print("<FORM name =\"contacts\" ACTION=\"vaccin_enregistre.php\" METHOD=\"GET\">");

print("<input type=\"hidden\" name=\"personne_id\" value=\"$_GET[personne_id]\">");
print("<input type=\"hidden\" name=\"type\" value=\"$_GET[type]\">");
print("<input type=\"hidden\" name=\"enregistrement\" value=\"$_GET[enregistrement]\">");

if($_GET[type]==0)
	print($string_lang['NOUVEAU_CONTACT'][$langue]);
else
{
	print($string_lang['MODIFIER_CONTACT'][$langue]);
	$requete = "SELECT * FROM vaccination WHERE vaccination_ID = '$_GET[enregistrement]'";
	$resultat = ExecRequete($requete,$connexion);
	$v=mysql_fetch_array($resultat);
}
$requete = "SELECT Pers_Nom, Pers_Prenom FROM personnel WHERE Pers_ID = '$_GET[personne_id]'";
		$resultat = ExecRequete($requete,$connexion);
		$rub=mysql_fetch_array($resultat);
		print(" ".$rub['Pers_Nom']." ".$rub[Pers_Prenom]."<br><br>");

print("<table>");
print("<tr>");
	print("<TD>Type de vaccin</TD>");
	print("<TD>");
		$requete="SELECT vaccin_type_ID,vaccin_type_nom FROM vaccin_type ORDER BY vaccin_type_nom";
		$resultat = ExecRequete($requete,$connexion);
		print("<select name=\"nature\" size=\"1\">");
		print("<OPTION VALUE = \"0\">-- aucun --</OPTION> \n");
		while($rub=mysql_fetch_array($resultat))
		{
			print("<OPTION VALUE=\"$rub[vaccin_type_ID]\" ");
			if($v['vaccin_type_ID'] == $rub['vaccin_type_ID']) print(" SELECTED");
			else if($vaccin_type == $rub['vaccin_type_ID']) print(" SELECTED");
			print("> $rub[vaccin_type_nom] </OPTION> \n");
		}
		@mysql_free_result($resultat);
		print("</SELECT>\n");
	print("<TD>");
print("</tr>");
print("<tr>");
	print("<TD>Date d'injection (jj/mm/aaaa)</TD>");
	$date_fr = uDate2French($v[date]);
	print("<TD><input type=\"text\" name=\"date\" value=\"$date_fr\" size=\"50\"></TD>");
print("</tr>");
print("<tr>");
	print("<TD>Dose administrée</TD>");
	print("<TD><input type=\"text\" name=\"dose\" value=\"$v[dose]\" size=\"50\"></TD>");
print("</tr>");
print("<tr>");
	print("<TD>nom du vaccin</TD>");
	print("<TD><input type=\"text\" name=\"nom\" value=\"$v[nom]\" size=\"50\"></TD>");
print("</tr>");
print("</table>");

print("<input type=\"submit\" name=\"ok\" value=\"valider\">");
print("</form>");
print("</BODY>");