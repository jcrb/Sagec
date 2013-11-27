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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		synoptique_menu.php
//	date de crï¿½ation: 	15/04/2004
//	auteur:			jcb
//	description:		affiche un choix d'options
//	version:			1.2
//	maj le:			13/10/2004
//
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../utilitairesHTML.php");
require '../utilitaires/globals_string_lang.php';
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$langue = $_SESSION['langue'];

print("<html>");
print("<head>");
print("<title> menu service </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
?>
<script language="javascript">

function checkBoxes (form, check)
{
	for (var c = 0; c < form.elements.length; c++)
	if (form.elements[c].type == 'checkbox')
		form.elements[c].checked = check;
}
</script>

<?php
print("</head>");

print("<BODY>");
print("<FORM name=\"menu\" method=\"get\" TARGET=\"droite\" action=\"synoptique_home.php\">");

//------------------------------------- Home ------------------------------------------
$mot = $string_lang['SYNTHESE'][$langue];
print("<div align=\"center\"><input type = \"submit\" name = \"ok1\" value=\"$mot\"></Div><br>");

//------------------------------------- Hopital ------------------------------------------
print("<fieldset class=\"time_r\">");
$mot = $string_lang['SELECT_HOPITAL'][$langue];
print("<legend>$mot</legend>");
select_hopital($connexion,$_GET['ID_hopital'],$langue);// retourne ID_hopital
print("</fieldset>");

//------------------------------------- Services ------------------------------------------
print("<fieldset class=\"time_r\">");
$mot = $string_lang['SELECT_SERVICE'][$langue];
print("<legend>$mot</legend>");
SelectTypeService($connexion,$_GET['type_s'],$langue);// retourne type_s
print("</fieldset>");

//------------------------------------- Département ------------------------------------------
print("<fieldset class=\"time_v\">");
if($langue=="GE")
	$mot="Ein oder mehrere Departements/Kreiss wählen";
else
	$mot = "Choisir un ou plusieurs départements/Kreiss";
print("<legend>$mot</legend>");

$requete="SELECT * FROM departement ORDER BY departement_id";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
$x = 0;
print("<TR>");
while($rub = mysql_fetch_array($resultat))
{
	if($rub[departement_ID]==67) $ck="CHECKED";else $ck="";
	print("<TD><input type =\"checkbox\" name=\"dpt[]\" value=\"$rub[departement_ID]\" $ck >$rub[departement_nom]</TD>");
	$x++;
	if($x>1)
	{
		$x = 0;
		print("</TR><TR>");
	}
}
print("</TR>");
print("</table>");
print("<table>");

print("<br><div align=\"center\">");
$coche=$string_lang['COCHER'][$langue];
$decoche=$string_lang['DECOCHER'][$langue];
print("<input type=\"button\" name=\"coche\" value=\"$coche\" onclick=\"checkBoxes(this.form,true)\">");
print("<input type=\"button\" name=\"decoche\" value=\"$decoche\"onclick=\"checkBoxes(this.form,false)\"></Div>");
print("</fieldset>");
	
print("<fieldset>");
print("<legend>".$string_lang['TRIE_PAR'][$langue]."</legend>");
print("<input type=\"radio\" name=\"tri\" value=\"hopital\" CHECKED >".$string_lang['HOPITAL'][$langue]);
print("<input type=\"radio\" name=\"tri\" value=\"service\" >".$string_lang['SERVICE'][$langue]);
print("<input type=\"radio\" name=\"tri\" value=\"ldispo\" >".$string_lang['LITS'][$langue]);
print("</fieldset>");

//------------------------------------- Exï¿½cuter ------------------------------------------
$mot = $string_lang['VALIDER'][$langue];
print("<br><div align=\"center\"><input type = \"submit\" name = \"ok\" value=\"$mot\"></Div>");

print("</FORM>");
print("</BODY>");
print("</html>");
?>
