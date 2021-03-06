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
//
//	programme: 		contact_saisie.php
//	date de cr?ation: 	03/04/2005
//	auteur:			jcb
//	description:		saisie d'une nouvelle langue
//	version:		1.1
//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require '../utilitaires/globals_string_lang.php';
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
print("<title> Saisie d'un intervenant </title>");
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
print("<FORM name =\"contacts\" ACTION=\"contact_enregistre.php\" METHOD=\"GET\">");
print("<input type=\"hidden\" name=\"personne_id\" value=\"$_GET[personne_id]\">");
print("<input type=\"hidden\" name=\"type\" value=\"$_GET[type]\">");
print("<input type=\"hidden\" name=\"enregistrement\" value=\"$_GET[enregistrement]\">");

if($_GET[type]==0)
	print($string_lang['NOUVEAU_CONTACT'][$langue]);
else
{
	print($string_lang['MODIFIER_CONTACT'][$langue]);
	$requete = "SELECT * FROM contact WHERE contact_ID = '$_GET[enregistrement]'";
	$resultat = ExecRequete($requete,$connexion);
	$v=mysql_fetch_array($resultat);
}
$nature_contact = $_GET['nature'];
switch($nature_contact)
{
	case '1':// personne
		$requete = "SELECT Pers_Nom, Pers_Prenom FROM personnel WHERE Pers_ID = '$_GET[personne_id]'";
		$resultat = ExecRequete($requete,$connexion);
		$rub=mysql_fetch_array($resultat);
		print($rub['Pers_Nom']." ".$rub[Pers_Prenom]."<br><br>");
		break;
	case '2':	// organisme
		$requete = "SELECT org_nom FROM organisme WHERE org_ID = '$_GET[personne_id]'";
		$resultat = ExecRequete($requete,$connexion);
		$rub=mysql_fetch_array($resultat);
		print(" Organisme: ".$rub['org_nom']."<br><br>");
		break;
	case '3':	// vecteur
		$requete = "SELECT Vec_Nom FROM vecteur WHERE Vec_ID = '$_GET[personne_id]'";
		$resultat = ExecRequete($requete,$connexion);
		$rub=mysql_fetch_array($resultat);
		print("Vecteur: ".$rub['Vec_Nom']."<br><br>");
		break;
	case '4':	// service
		$requete = "SELECT service_nom FROM service WHERE service_ID = '$_GET[personne_id]'";
		$resultat = ExecRequete($requete,$connexion);
		$rub=mysql_fetch_array($resultat);
		print(" le service ".$rub['service_nom']."<br><br>");
		break;
	case '7':	// uf
		$requete = "SELECT uf_nom FROM uf WHERE uf_ID = '$_GET[personne_id]'";
		$resultat = ExecRequete($requete,$connexion);
		$rub=mysql_fetch_array($resultat);
		print(" l'UF ".$rub['uf_nom']."<br><br>");
		break;
}

print("<table>");
print("<tr>");
	print("<TD>".$string_lang['ORIGINE'][$langue]."</TD>");
	print("<TD>");
		$requete="SELECT nature_contact_ID,nature_contact_nom FROM nature_contact ORDER BY nature_contact_nom";
		$resultat = ExecRequete($requete,$connexion);
		print("<select name=\"nature\" size=\"1\">");
		print("<OPTION VALUE = \"0\">-- aucune --</OPTION> \n");
		while($rub=mysql_fetch_array($resultat))
		{
			print("<OPTION VALUE=\"$rub[nature_contact_ID]\" ");
			if($v['nature_contact_ID'] == $rub['nature_contact_ID']) print(" SELECTED");
			else if($nature_contact == $rub['nature_contact_ID']) print(" SELECTED");
			//print(">".$string_lang[strtoupper($rub['nature_contact_nom'])][$langue]." </OPTION> \n");
			print("> $rub[nature_contact_nom] </OPTION> \n");
		}
		@mysql_free_result($resultat);
		print("</SELECT>\n");
	print("<TD>");
print("</tr>");
print("<tr>");
	print("<TD>".$string_lang['MEDIA'][$langue]."</TD>");
	$type_contact = $v['type_contact_ID'];
	if($type_contact==0)$type_contact=1;//public par d�faut
	print("<TD>");
		$requete="SELECT type_contact_ID,type_contact_nom FROM type_contact ORDER BY type_contact_nom";
		$resultat = ExecRequete($requete,$connexion);
		print("<select name=\"type_contact\" size=\"1\">");
		print("<OPTION VALUE = \"0\">-- aucune --</OPTION> \n");
		while($rub=mysql_fetch_array($resultat))
		{
			print("<OPTION VALUE=\"$rub[type_contact_ID]\" ");
			if($type_contact == $rub['type_contact_ID']) print(" SELECTED");
			print(">".$string_lang[$rub['type_contact_nom']][$langue]."</OPTION> \n");
		}
		@mysql_free_result($resultat);
		print("</SELECT>\n");
print("<TD>");
print("</tr>");
print("<tr>");
	print("<TD>".$string_lang['LOCALISATION_CONTACT'][$langue]."</TD>");
	print("<TD>");
		//$requete="SELECT type_contact_ID,type_contact_nom FROM type_contact ORDER BY type_contact_nom";
		//$resultat = ExecRequete($requete,$connexion);
		print("<select name=\"lieu_contact\" size=\"1\">");
		print("<OPTION VALUE = \"0\">-- aucune --</OPTION> \n");
		if($v['contact_lieu']==1)$s1="SELECTED";
		if($v['contact_lieu']==2)$s2="SELECTED";
		if($v['contact_lieu']==0)$s2="SELECTED";
		print("<OPTION VALUE = \"1\" $s1>".$string_lang['DOMICILE'][$langue]."</OPTION> \n");
		print("<OPTION VALUE = \"2\" $s2>".$string_lang['TRAVAIL'][$langue]."</OPTION> \n");
		@mysql_free_result($resultat);
		print("</SELECT>\n");
print("<TD>");
print("</tr>");
print("<tr>");
	print("<TD>".$string_lang['CONFIDENTIALITE_CONTACT'][$langue]."</TD>");
	$confidentialite = $v['confidentialite_ID'];
	if($confidentialite==0) $confidentialite=1;
	print("<TD>");
		$requete="SELECT confidentialite_ID,confidentialite_nom FROM confidentialite ORDER BY confidentialite_nom";
		$resultat = ExecRequete($requete,$connexion);
		print("<select name=\"confidentialite\" size=\"1\">");
		print("<OPTION VALUE = \"0\">-- aucune --</OPTION> \n");
		while($rub=mysql_fetch_array($resultat))
		{
			print("<OPTION VALUE=\"$rub[confidentialite_ID]\" ");
			if($confidentialite == $rub['confidentialite_ID']) print(" SELECTED");
			print("> $rub[confidentialite_nom] </OPTION> \n");
		}
		@mysql_free_result($resultat);
		print("</SELECT>\n");
print("<TD>");
print("</tr>");
print("<tr>");
	print("<TD>".$string_lang['NATURE_CONTACT'][$langue]."</TD>");
	print("<TD>");
		print("<input type=\"text\" name=\"nom\" value=\"$v[contact_nom]\" size=\"50\">");
	print("<TD>");
print("</tr>");
print("<tr>");
	print("<TD>".$string_lang['VALEUR_CONTACT'][$langue]."</TD>");
	print("<TD>");
		print("<input type=\"text\" name=\"value\" value=\"$v[valeur]\" size=\"50\">");
	print("<TD>");
print("</tr>");
print("</table>");

print("<input type=\"submit\" name=\"ok\" value=\"valider\">");
print("</form>");
print("</BODY>");
?>
