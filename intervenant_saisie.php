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
/**--------------------------------------------------------------------------------------------------------
*	programme: 		intervenant_saisie.php
*	@date création: 	03/09/2003
*	@author:		jcb
*	description:	interface graphique pour la saisie d'un intervenant
*					appelé par vecteur_maj qui transmet la variable $personnelID
*					la variable personnelID contient le n°ID de la personne
*					ou 0 si nouveau
*	@version:		1.6 - $Id$
*	maj le:			03/10/2004			rajout du service d'appartenance
*	maj le:			08/11/2004			correction de $back (manquait .php)
*	maj le:			12/04/2005			modif interface, langue, contact
*	@package		Sagec
*   @todo			rubrique sexe, spécialité
*--------------------------------------------------------------------------------------------------------*/
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
require("pma_connect.php");
require("pma_connexion.php");
require("intervenants_menu.php");
include("utilitairesHTML.php");
include("date.php");

$back = $_GET[back];
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
<title> Saisie d'un intervenant </title>
<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">
<!-- <script language=\"javascript\" src=\"contact/contact_scripts.js\">"); -->

<script>
function Choix(form)
{
	document.Intervenants.submit();
}
function newVaccin(id)
{

}
function newLangue(id)
{
	adresse = "langue/langue_saisie.php?personne_id="+id;
fenLangue=window.open(adresse,"langue","width=260,height=150,scrolling=no,toolbar=no,menubar=no,location=center,directories=no,status=no");
}
function ferme()
{
	if(typeof(fenLangue)=="object" && fenLangue.closed==false)
		fenLangue.close();
}
/*
	alerte_supprimer
	no 		n° de l'enregistrement à supprimer
	id 		paramètres pour le retour
	back 	adresse de retour
	param 	nom de la variable pour le retour. par ex. pour un intervenant on aura param = personne et
			id = personne_ID
*/
function alerte_supprimer(no,id,back,param)
{
	if(confirm("Voulez-vous vraiment supprimer cet enregistrement ?"))
	{
		location.replace("contact/contact_supprime.php?enregistrement_ID=" + no + "&back="+ back +"&param="+param+"&id="+id);
		//"&back=../intervenant_saisie.php&personne="
	}
}
/**
	newContact()
	id identifiant de l'objet auquel se rattache le contact
	type opération à effectuer: création=0, modifier=1, supprimer=2
	nature caractéristique de l'objet auquel se rattache le contact: personne, organisme, service, etc.
	enregistrement_id n°de l'enregistrement dans le fichier contact
*/
function newContact(id,type,nature,enregistrement_id)//type= 0 nouveau 1 = modifier 2 = supprimer
{
	adresse = "contact/contact_saisie.php?personne_id="+id+"&type="+type+"&enregistrement="+enregistrement_id+"&nature="+nature;
fenVaccin=window.open(adresse,"contacts","width=700,height=250,scrolling=no,toolbar=no,menubar=no,location=center,directories=no,status=no");
}
function newVaccination(id,type,nature,enregistrement_id)//type= 0 nouveau 1 = modifier 2 = supprimer
{
	adresse = "contact/vaccin_saisie.php?personne_id="+id+"&type="+type+"&enregistrement="+enregistrement_id+"&nature="+nature;
fenContact=window.open(adresse,"contacts","width=700,height=250,scrolling=no,toolbar=no,menubar=no,location=center,directories=no,status=no");
}
</script>
</head>
<?php

print("<BODY onUnload = \"ferme();\" onload=\"ferme();\">");
print("<FORM name =\"Intervenants\" ACTION=\"intervenant_enregistre.php\"enctype=\"multipart/form-data\" METHOD=\"POST\" >");
// mémorisation dans un champ caché de $ttintervenant pour se rappeler s'il s'agit d'une MAJ
// ou d'une création (=0)
print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$_GET[personnelID]\">");
//print("<INPUT TYPE=\"HIDDEN\" NAME=\"back\" VALUE=\"$_GET[back]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"back\" VALUE=\"intervenant_saisie.php\">");

/**
 *	le bandeau de navigation ne s'affiche pas pour un accès personnel
 *	auto vaut 1 si acces personnel (voir login2)
 */
$auto = $_REQUEST[auto];
if($_REQUEST[auto]!=1)
	menu_intervenants($_SESSION['langue']);
else
	?><input type="hidden" name="auto" value="1"><?php

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

if($_REQUEST['personnelID'] != 0)
	$intervenant = ChercheIntervenant($_GET['personnelID'],$connexion);

TblDebut(0,"100%","","","time_v");
	TblDebutLigne();
		TblCellule($string_lang['CIVILITE'][$langue].": ");
		print("<TD>");
			SelectCivilite($connexion,$intervenant->civilite_ID,"0",$langue);
		print("</TD>");
		TblCellule($string_lang['AFFECTE'][$langue].": ","","",time_r);
		print("<TD>");
			//SelectLocalisation($connexion,$intervenant->localisation_ID,$langue);
			SelectStructureTemporaire($connexion,$intervenant->localisation_ID,$langue);//localisation_type
		print("</TD>");
		$source_image = $intervenant->photo;
		TblCellule("photo: <input type=\"file\" name=\"photo_victime\" size=\"10\" onchange=\"Choix(this.form)\">");
	TblFinLigne();
	
	TblDebutLigne();
		TblCellule($string_lang['NOM'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$intervenant->Pers_Nom\" NAME=\"nom\" SIZE = \"30\" ");
		TblCellule("portatif 1: ","","",time_r);
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$intervenant->portatif1\" NAME=\"radio1\" SIZE = \"10\" ");
		print("<td rowspan=\"6\">");
		if($source_image !=''){
			list($width, $height, $type, $attr) = getimagesize("$source_image");
			$h = 120;
			$w = $h*$width/$height;
			print("<img src=\"$source_image\" alt=\"Photographie\" height=\"$h\" width=\"$w\" align=\"middle\" border=\"0\">");
		}
		print("</td>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule($string_lang['PRENOM'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$intervenant->Pers_Prenom\" NAME=\"prenom\" SIZE = \"30\" ");
		TblCellule("portatif 2: ","","",time_r);
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$intervenant->portatif2\" NAME=\"radio2\" SIZE = \"10\" ");
	TblFinLigne();
	TblDebutLigne();
		TblCellule($string_lang['ORGANISME'][$langue].": ");
		print("<TD>");
		SelectOrganisme($connexion,$intervenant->org_ID,$langue,"Choix(this.form);");
		print("</TD>");
		TblCellule("Telephone 1: ","","",time_r);
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$intervenant->tel_crise1\" NAME=\"tel_crise1\" SIZE = \"15\" ");
	TblFinLigne();
	TblDebutLigne();
		TblCellule($string_lang['SERVICE'][$langue].": ");
		print("<TD>");
			select_service($connexion,$intervenant->org_ID,$intervenant->service_ID);// retour $the_service
		print("</TD>");
		print("<TD>fonction</TD>");
		print("<TD>");SelectFonction($connexion,$intervenant->fonction_ID,$langue);print("</TD>");// retourne id_fonction
		TblCellule($org_type);
	TblFinLigne();
	TblDebutLigne();
		TblCellule($string_lang['PROFESSION'][$langue].": ");
		print("<TD>");
		SelectMetier($connexion,$intervenant->perso_cat_ID,$langue);
		print("</TD>");
		TblCellule($string_lang['VECTEURS'][$langue].": ");
		print("<TD>");
			SelectVecteurEngages($connexion,$intervenant->vecteur_ID);//retourne vecteur_engage_ID
		print("</TD>");
	TblFinLigne();
	TblCellule($string_lang['DELAI_ROUTE'][$langue]." (mn) ");
	TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$intervenant->delai_route\" NAME=\"delai_route\" SIZE = \"5\" ");
	TblDebutLigne();
		TblCellule(" n° RPPS ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$intervenant->rpps\" NAME=\"rpps\" SIZE = \"11\" ");
	TblFinLigne();
TblFin();
//============================================= LANGUES  ======================================================
print("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" class=\"Style24\" bgcolor=\"#ffffcc\">");
	print("<tr>");
		print("<TD> Langues parlées </td>");
		TblCellule("<A HREF= javascript:newLangue($_GET[personnelID]);>nouvelle</A>");
		print("<TD>Passeport</td>");
		print("<TD>n° <input type \"text\" name=\"passport_no\" value=\"$intervenant->passport_no\"></td>");
		$date_fr = uDate2French($intervenant->passport_date); 
		print("<TD>délivré le <input type \"text\" name=\"passport_date\" value=\"$date_fr\"></td>");
		print("<TD>par <input type \"text\" name=\"passport_qui\" value=\"$intervenant->passport_qui\"></td>");
	print("</tr>");
print("</table>");
print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" class=\"Style22\">");
$requete = "SELECT langue_nom,langue.langue_ID
			FROM langue, langue_parlee
			WHERE Pers_ID='$_GET[personnelID]'
			AND langue.langue_ID = langue_parlee.langue_ID";
		$resultat = ExecRequete($requete,$connexion);
		while($rub=mysql_fetch_array($resultat))
		{
			TblDebutLigne();
			print("<td><A HREF=\"langue/langue_supprime.php?langue=$rub[langue_ID]&personne=$_GET[personnelID]\">
			<img src=\"images/button_drop.png\" Title=\"supprimer\" border=\"0\"></A></td>");
			TblCellule("<div align=\"left\" class=\"Style23\"> $rub[langue_nom]");
			TblFinLigne();
		}
TblFin();
//============================================= CONTACTS ======================================================
print("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style24\" bgcolor=\"#ffffcc\">");
	print("<tr>");
		print("<TD> Contacts </td>");
		TblCellule("<A HREF= javascript:newContact($_GET[personnelID],0,1);>Ajouter un nouveau contact</A>");
	print("</tr>");
print("</table>");
print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" class=\"Style22\">");
	print("<TR>");
	print("<TD><B>Type</B></TD>");
	print("<TD><B>Localisation</B></TD>");
	print("<TD><B>Valeur</B></TD>");
	print("<TD><B>&nbsp;</B></TD>");
	print("<TD><B>&nbsp;</B></TD>");
	print("</TR>");

	$requete="SELECT type_contact_nom,valeur,confidentialite_ID,contact_lieu,contact_ID
			FROM contact,type_contact
			WHERE identifiant_contact = '$_GET[personnelID]'
			AND nature_contact_ID = '1'
			AND contact.type_contact_ID = type_contact.type_contact_ID
			";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print("<TR>");
		TblCellule("<div align=\"left\" class=\"Style23\"> $rub[0]");
		if($rub[contact_lieu]==1)
			TblCellule("<div align=\"left\" class=\"Style23\">domicile");
		else
			TblCellule("<div align=\"left\" class=\"Style23\">travail");
		if($rub['confidentialite_ID'] == 1)
			TblCellule("<div align=\"left\" class=\"Style23\"> $rub[valeur]");
		else if($rub['confidentialite_ID'] == 2)
			TblCellule("<div align=\"center\" class=\"time_r\"> Liste Rouge");
		else
			TblCellule("<div align=\"center\" class=\"time_r\"> Classifié");//button_drop.png
		//if($rub['confidentialite_ID']==1 && $_SESSION[]!=)
		//{
			TblCellule("<div align=\"center\" class=\"time_r\"><A href=javascript:newContact($_GET[personnelID],1,1,$rub[contact_ID]);><img src=\"images/button_edit.png\" Title=\"modifier\" border=\"0\"></a>");

		$mot1="'../intervenant_saisie.php'";
		$mot2="'personnelID'";
			TblCellule("<div align=\"center\" class=\"time_r\"><A href=\"javascript:alerte_supprimer($rub[contact_ID],$_GET[personnelID],$mot1,$mot2)\"><img src=\"images/button_drop.png\" Title=\"supprimer\" border=\"0\"></a>");
		//}

		print("</TR>");
	}
print("</table>");
//============================================= VACCINATIONS =====================================================
print("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" class=\"Style24\" bgcolor=\"#ffffcc\">");
	print("<tr>");
		print("<TD>Vaccinations</td>");
		TblCellule("<A HREF= javascript:newVaccination($_GET[personnelID],0,1);>nouvelle</A>");
	print("</tr>");
print("</table>");

print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" class=\"Style22\">");
	print("<TR>");
	print("<TD><B>Type</B></TD>");
	print("<TD><B>date</B></TD>");
	print("<TD><B>dose</B></TD>");
	print("<TD><B>nom</B></TD>");
	print("<TD><B>&nbsp;</B></TD>");
	print("<TD><B>&nbsp;</B></TD>");
	print("</TR>");

$requete="SELECT vaccin_type_nom, vaccination_ID,date,dose,nom
			FROM vaccination, vaccin_type
			WHERE personne_ID = '$_GET[personnelID]'
			AND vaccination.vaccin_type_ID = vaccin_type.vaccin_type_ID
			";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print("<TR>");
		TblCellule("<div align=\"left\" class=\"Style23\"> $rub[vaccin_type_nom]");
		$date_fr = uDate2French($rub[date]);
		TblCellule("<div align=\"left\" class=\"Style23\"> $date_fr");
		TblCellule("<div align=\"left\" class=\"Style23\"> $rub[dose]");
		TblCellule("<div align=\"left\" class=\"Style23\"> $rub[nom]");
		//button_drop.png
		//if($rub['confidentialite_ID']==1 && $_SESSION[]!=)
		//{
			TblCellule("<div align=\"center\" class=\"time_r\"><A href=javascript:newVaccination($_GET[personnelID],1,1,$rub[vaccination_ID]);><img src=\"images/button_edit.png\" Title=\"modifier\" border=\"0\"></a>");

		$mot1="'../intervenant_saisie.php'";
		$mot2="'personnelID'";
			TblCellule("<div align=\"center\" class=\"time_r\"><A href=\"javascript:alerte_supprimer($rub[contact_ID],$_GET[personnelID],$mot1,$mot2)\"><img src=\"images/button_drop.png\" Title=\"supprimer\" border=\"0\"></a>");
		//}

		print("</TR>");
	}
print("</table>");
//============================================= ======== ======================================================
//TblDebut(0,"75%","","","time_r");
print("<br>");
Print("<TABLE WIDTH=\"100%\" CLASS=\"time_r\" bgcolor=\"#ffffcc\">");
TblDebutLigne();
if($_GET['personnelID'] == 0)
{
	$mot=$string_lang['INTERVENANT_NOUVEAU'][$langue];
	TblCellule("$mot");
}
else
{
	$mot=$string_lang['INTERVENANT_MODIFIER'][$langue];
	TblCellule("$mot");
	//$intervenant = ChercheIntervenant($_GET['personnelID'],$connexion);
}
$mot=$string_lang['VALIDER'][$langue];
TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"VALIDER\" ");

if(!$_GET[type])
	TblCellule("<A HREF = \"$back\"?personnelID=$identifiant>Retour</A>");
else
	TblCellule("<A HREF = \"intervenants_selection.php?perso_type_ID=$_GET[type]&org_type=$_GET[organisme]&engage=$_GET[alerte]\">Retour</A>");
/**
 *	TblCellule("<A HREF=\"passeport.php?personnelID=$_GET[personnelID]\">Badge</A>");
 */
TblFinLigne();
TblFin();

print("</FORM>");
print("</BODY>");
print("</html>");
?>
