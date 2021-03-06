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
//
//----------------------------------------- SAGEC --------------------------------------------------------
//													//
//	programme: 		/gis/ville/ville_saisie.php						//
//	date de cr�ation: 	18/08/2003								//
//	auteur:			jcb									//
//	description:		affiche les caract�ristiques d'une ville dont l'identifiant est 	//
//				transmis par la variable $_GET[id_ville]
//	version:		1.0									//
//	maj le:			18/08/2003								//
//													//
//---------------------------------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathtoRoot = "./../../";
require $backPathtoRoot.'utilitaires/globals_string_lang.php';
include($backPathtoRoot."utilitairesHTML.php");
require($backPathtoRoot."pma_connect.php");
require($backPathtoRoot."pma_connexion.php");
require($backPathtoRoot."login/init_security.php");

print("<html>");
print("<head>");
print("<title>caract�ristiques villes </title>");
print("<LINK REL=stylesheet HREF=\"./../../pma.css\" TYPE =\"text/css\">");
?>
<script>
	function alerte()
	{
		if(confirm("Voulez-vous vraiment supprimer d�finitivement cette ville ?"))
		{
			window.close();
		}
	}
</script>
<?php
print("</head>");

print("<FORM name=\"ville\" action=\"ville_enregistre.php\" TARGET=\"midle\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"id_ville\" VALUE=\"$_GET[id_ville]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"back\" VALUE=\"ville_saisie.php\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$langue = $_SESSION['langue'];
// Saisie ou modification ?
if($_GET["id_ville"]==0)
{
	print("Saisie d'une nouvelle ville<BR><BR>");
}
else
{
	print("Modifier une ville<BR><BR>");
	$requete="SELECT * from ville WHERE ville_ID = '$_GET[id_ville]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
}
$nom = Security::db2str($rub[ville_nom]);
$insee = Security::db2str($rub[ville_insee]);
$zip = Security::db2str($rub[ville_zip]);

print("<hr>");
print("<table class=\"Style24\">");
print("<TR>");
	print("<TD class=\"grise\">nom</TD>");
	print("<TD><input type=\"text\" name=\"nom\" value=\"$nom\"></TD>");
	print("<TD><input type=\"submit\" name=\"bouton\" value=\"Enregistrer\"></TD>");
	print("<TD class=\"red\">Lambert2 X</TD>");
	print("<TD><input type=\"text\" name=\"X\" value=\"$rub[ville_lambertX]\"size=\"10\"></TD>");
	print("<TD><A href=\"http://www.ign.fr/affiche_rubrique.asp?rbr_id=903&saisie=$rub[ville_nom]\" target=\"ign\">Aide IGN</A></TD>");
print("</TR>");
print("<TR>");
	print("<TD class=\"blue\">n� INSEE</TD>");
	print("<TD><input type=\"text\" name=\"insee\" value=\"$rub[ville_insee]\"></TD>");
	print("<TD><input type=\"submit\" name=\"bouton\" value=\"Supprimer \" onClick=\"alerte()\"></TD>");
	print("<TD class=\"red\">Lambert2 Y</TD>");
	print("<TD><input type=\"text\" name=\"Y\" value=\"$rub[ville_lambertY]\" size=\"10\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD class=\"blue\">code postal</TD>");
	print("<TD><input type=\"text\" name=\"zip\" value=\"$rub[ville_zip]\"></TD>");
	print("<TD><input type=\"submit\" name=\"bouton\" value=\"Nouvelle \"></TD>");
	print("<TD class=\"red\">Longitude</TD>");
	print("<TD><input type=\"text\" name=\"long\" value=\"$rub[ville_longitude]\" size=\"10\"></TD>");
	print("<TD><A href=\"http://world.maporama.com/idl/maporama/\" target=\"ign\">Maporama</A></TD>");
print("</TR>");
print("<TR>");
	print("<TD class=\"blue\">d�partement</TD>");
	print("<TD><input type=\"text\" name=\"departement\" value=\"$rub[departement_ID]\"></TD>");
	print("<TD>&nbsp;</TD>");
	print("<TD class=\"red\">Latitude</TD>");
	print("<TD><input type=\"text\" name=\"lat\" value=\"$rub[ville_latitude]\" size=\"10\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD class=\"blue\">zone</TD>");
	print("<TD>");
		select_zone($connexion,$rub['zone_ID'],$langue);// retourne $id_zone
	print("</TD>");
print("</TR>");
print("<TR>");
	print("<TD class=\"blue\">r�gion</TD>");
	print("<TD>");
		select_region($connexion,$rub['region_ID'],$langue);// retourne $id_region
	print("</TD>");
print("</TR>");
print("<TR>");
	print("<TD class=\"blue\">pays</TD>");
	print("<TD>");
		select_pays($connexion,$rub['pays_ID'],$langue);// retourne $id_pays
	print("</TD>");
print("</TR>");
print("</table>");

print("<br>");
print("<hr>");
print("<table>");
print("<TR>");
	print("<TD class=\"blue\">secteur ADPS</TD>");
	print("<TD>");
		SelectSecteurPds($connexion,$rub['secteur_Adps_ID']);// retourne $secteur_ID
	print("</TD>");
		print("<TD class=\"blue\">secteur APA</TD>");
	print("<TD>");
		SelectSecteur($connexion,$rub['secteur_apa_ID']);// retourne $secteur_ID
	print("</TD>");
		print("<TD class=\"blue\">secteur SMUR</TD>");
	print("<TD>");
		liste_smur($connexion,$rub['secteur_Smur_ID'],$langue);// retourne $smur_id
	print("</TD>");
print("</TR>");
print("<TR>");
	print("<TD class=\"blue\">Territoire de sant�</TD>");
	print("<TD>");
		select_territoire_sante($connexion,$rub['territoire_sante'],$langue,"");// retourne $id_territoire
	print("</TD>");
		print("<TD class=\"blue\">Territoire de proximit�</TD>");
	print("<TD>");
		select_zone_proximite($connexion,$rub['zone_proximite'],$langue,"");// retourne $id_zone_p
	print("</TD>");
print("</TR>");
print("</table>");
print("<hr>");
print("</FORM>");
print("</html>")
?>
