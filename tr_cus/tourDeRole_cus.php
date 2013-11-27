<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		tourDeRole_cus.php
//	date de cr�ation: 	15/08/2003
//	auteur:			jcb
//	description:		Indique la prochaine ASSU � contacter
//	version:			1.1
//	maj le:			7/10/2003
//
//---------------------------------------------------------------------------------------------------------
//
include ("../menu_sagec.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("utilitaire_tr.php");
//require("../html.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
/*
if($_GET[ok]=="valider")
{
	//$_GET[ok]="";
	$requete="UPDATE apa_tour SET ordre = MOD(ordre+1,3)";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete);
}
*/
print("<html>");
print("<head>");
print("<title> Tour de r�le </title>");
//print("<meta http-equiv=\"refresh\" content=\"15\">");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
?>
<script type="text/javascript">
<!-- set focus to a field with the name "dossier" in my form-->
function setfocus()
{
document.forms[0].dossier.focus()
}
function verifie()
{
	if(!document.forms[0].dossier.value)
	{
		alert("Le n� de dossier est invalide");
 		return false;
	}
	return true;
}
</script>
<?php
print("</head>");

print("<body>");
print("<BODY  onload=setfocus();>");//#ffffff
//entete_sagec($titre="Tour de r�le sur la CUS");
print("<Form name=\"tr\" method=\"get\" action=\"tourDeRole_enregistre.php\" onSubmit=\"return verifie();\">");

//print("<fieldset class=\"time_v\">");
//print("<legend> ASSU � contacter </legend>");
//maj_tabGarde($connexion);
print("<br>");
print("<table width=\"100%\" >");//bgcolor=\"yellow\"
print("<TR>");
	print("<TD>");
		print("N� de dossier: <input type=\"text\" name=\"dossier\" value=\"$_GET[dossier]\">");
	print("</TD>");
	/*
	print("<TD>Soci�t� � contacter:</TD>");
	print("<TD class=\"time_r\">");
		$requete = "SELECT MAX(ordre) FROM apa_tour";
		$resultat = ExecRequete($requete,$connexion);
		$max=mysql_fetch_array($resultat);

		$requete = "SELECT apa_tour.org_ID,organisme.org_nom
				FROM apa_tour,organisme
				WHERE organisme.org_ID = apa_tour.org_ID
				AND ordre = '$max[0]'
				";
	$resultat = ExecRequete($requete,$connexion);
	$rub= LigneSuivante($resultat);
	print($rub->org_nom);
	print("<input type=\"hidden\" name=\"org_id\" value=\"$rub->org_ID\">");
	print("</TD>");
	print("<TD class=\"GAUCHE\"><A HREF=\"tourDeRole_cus.php\">V�rifier</A></TD>");
	*/
//print("</TR>");

//print("<TR>");
//print("<TD>&nbsp;</TD>");
//print("<TD>&nbsp;</TD>");
print("<TD>");
		print("<input type=\"radio\" name=\"disponible\" value=\"oui\" checked> Disponible");
	print("</TD>");
//print("<TD><A HREF=\"tourDeRole_cus.php\">V�rifier</A></TD>");
//print("</TR>");

//print("<TR>");
//print("<TD>&nbsp;</TD>");
//print("<TD>&nbsp;</TD>");
print("<TD>");
	print("<input type=\"radio\" name=\"disponible\" value=\"non\"> Indisponible");
print("</TD>");
print("<TD>");
		print("<input type=\"submit\" name=\"ok\" value=\"valider\">");
	print("</TD>");
//print("</TR>");

print("</table>");
//print("</fieldset>");
print("<HR>");
print("</form>");

print("<div align=\"left\">");
print("</div>");
print("</body>");
print("</html>");
?>
