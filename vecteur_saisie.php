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
//---------------------------------------------------------------------------------------------------------
//
//	programme: 		vecteur_saisie
//	date de création: 	18/08/2003
//	auteur:			jcb
//	description:		interface graphique pour la saisie d'un vecteur
//						appelé par vecteur_maj qui transmet la variable ttvecteur
//						la variable $ttvecteur contient le n°ID du vecteur ou 0 si nouveau vecteur
//						$no_liste_org si vrai => pas de liste déroulante des organismes et seul 
//						l'organisme	org_type est affiché	
//	version:			1.2
//	maj le:			14/10/2003
// @version $Id: vecteur_saisie.php 44 2008-04-16 06:55:34Z jcb $
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION["langue"];

$backPathToRoot = "";
include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
include("utilitairesHTML.php");
require("pma_connect.php");
require("pma_connexion.php");
require("vecteurs_menu.php");
include("contact_main.php");
include($backPathToRoot."adresse_ajout.php");

$back = $_REQUEST['back'];
if(! $back) $back = $backPathToRoot."vecteur_saisie.php?ttvecteur=".$_REQUEST['ttvecteur'];

print("<HTML><HEAD><TITLE>Saisie des vecteurs</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");
print("<LINK REL=stylesheet HREF=\"vecteur/vecteur.css\" TYPE =\"text/css\"></HEAD>");


print("<body>");
print("<FORM name =\"Vecteurs\" ACTION=\"vecteur_enregistre.php?back=$back\" METHOD = \"POST\">");

// mémorisation dans un champ caché de $ttvecteur pour se rappeler s'il s'agit d'une MAJ
// ou d'une création (=0)

print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$_GET[ttvecteur]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"etat\" VALUE=\"$_GET[type_v]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"type\" VALUE=\"$_GET[v_type]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"org_type\" VALUE=\"$_GET[org_type]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"no_liste_org\" VALUE=\"$_GET[no_liste_org]\">");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

//print("<input type=\"hidden\" name=\"back\" value=\"$back\">");
$table="vecteur";
$field="Vec_Type";
if($_SESSION['auto_sagec'])
	MenuVecteurs($langue);// $nomenu est une var de session qui bloque l'affichage du menu'
if($_GET['ttvecteur'] > 0)
	$vecteur = ChercheVecteur($_GET['ttvecteur'],$connexion);

print("<div id=\"content\">");
print("<fieldset id=\"\">");
print("<legend class=\"time_v\">Caractéristiques du moyen</legend>");
TblDebut(0,"75%","","",time_r);
	TblDebutLigne();
		if($_GET['ttvecteur'] == 0)
		{
			$mot=$string_lang['VECTEUR_NOUVEAU'][$langue];
			TblCellule($mot);
		}
		else
		{
			$mot=$string_lang['VECTEUR_MODIFIER'][$langue];
			TblCellule($mot);
		}
		if($back)
			TblCellule("<A HREF = \"$back\">Retour");
	TblFinLigne();
TblFin();
print("<BR>");

TblDebut(0,"100%","","",time);

	/** LIGNE 1 */
	TblDebutLigne();
		/** nom du vecteur */
		TblCellule($string_lang['NOM'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$vecteur->Vec_Nom\" NAME=\"nom\" SIZE = \"30\" ");
		/** nombre de places couchées */
		print("<TD>");
			print("nombre de places couchées</td><td><input type=\"text\" name=\"places_c\" size=\"3\" value=\"$vecteur->Vec_place_couche\">");
		print("</TD>");
		
		/** Status du véhicule */
		print("<TD>");
			print("status: </td><td>");
			$etat=ChercheTypeEtatVecteur($_GET['ttvecteur'],$connexion);
			SelectEtatVecteur($connexion,$etat,$langue);// remplacer "" par $langue
		print("</TD>");
		/** VALIDATION */
		$mot=$string_lang['VALIDER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"VALIDER\" ");
	TblFinLigne();
	
	/** Ligne 2 */
	TblDebutLigne();
		TblCellule($string_lang['TYPE'][$langue]);
		print("<TD>");
			SelectTypeVecteur($connexion,$vecteur->Vec_Type,"");// remplacer "" par $langue
		print("</TD>");
		print("<TD>");
			print("nombre de places assises</td><td><input type=\"text\" name=\"places_a\" size=\"3\" value=\"$vecteur->Vec_place_assise\">");
		print("</TD>");
		/** engagé ou non */
		$mot=$string_lang['ENGAGE'][$langue];
		print("<td>$mot</td>");
		if($vecteur->Vec_Engage)
			TblCellule("<INPUT TYPE=\"CHECKBOX\" VALUE=\"o\" NAME=\"engage\"CHECKED>");
		else
			TblCellule("<INPUT TYPE=\"CHECKBOX\" VALUE=\"o\" NAME=\"engage\">");
		print("<TD>");
	TblFinLigne();
	
	/** Ligne 3 */
	TblDebutLigne();
		TblCellule($string_lang['INDICATIF'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$vecteur->Vec_Indicatif\" NAME=\"indicatif\" SIZE = \"30\" ");
		print("<td>&nbsp;</td>");
		print("<td>&nbsp;</td>");
		print("<td>".$string_lang['LOCALISATION'][$langue].":</td><td>");
		SelectStructureTemporaire($connexion,$vecteur->localisation_ID,$langue); //localisation_type
		print("</td>");
	TblFinLigne();
	
	/** Ligne 4 */
	TblDebutLigne();
		TblCellule($string_lang['TEL'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$vecteur->Vec_Tel\" NAME=\"tel\" SIZE = \"30\" ");
		print("<td>&nbsp;</td>");
		print("<td>&nbsp;</td>");
		TblCellule("latitude actuelle</TD><td><INPUT TYPE=\"TEXT\" VALUE=\"$vecteur->lat\" NAME=\"lat_actuelle\" SIZE = \"10\" ");
	TblFinLigne();
	
	/** Ligne 5 */
	TblDebutLigne();
		TblCellule($string_lang['IMMATRICULATION'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$vecteur->Vec_immatriculation\" NAME=\"immatriculation\" SIZE = \"30\" ");
		print("<td>&nbsp;</td>");
		print("<td>&nbsp;</td>");
		TblCellule("longitude actuelle</TD><td><INPUT TYPE=\"TEXT\" VALUE=\"$vecteur->lng\" NAME=\"lng_actuelle\" SIZE = \"10\" ");
	TblFinLigne();
	
	TblDebutLigne();
		TblCellule($string_lang['ORGANISME'][$langue].": ");
		// on traite le cas où c'est un intervenant extérieur qui remplit la fiche
		// on ne lui laisse pas le choix de l'organisme
		if($_GET['no_liste_org'])
		{
			$org = GetOrganisme_nom($connexion,$_GET['org_type']);
			TblCellule($org);
		}
		else
		{
			print("<TD>");
			SelectOrganisme($connexion,$vecteur->org_ID,$langue);
			print("</TD>");
			//print("org ".$org_type);
			$org = $vecteur->org_ID;
			TblCellule("<A HREF = \"organisme/organisme_saisie.php?orgID=$org&back=$back\">Voir");
			TblCellule("<A HREF = \"organisme_saisie.php?back=$back\">Créer un organisme");
		}
	TblFinLigne();
		TblCellule($string_lang['VILLE'][$langue].": ");
		print("<TD>");
			select_commune($connexion,$vecteur->com_ID,$langue,$change="");//retourne commune_id
		print("</TD>");
		TblCellule($string_lang['CENTRALES'][$langue].": ");
		print("<TD>");
			SelectCentrale($connexion,$vecteur->centrale_ID);//retourne id_centrale
			print("<a href=\"centrales/centrales_main?centraleID=$vecteur->centrale_ID\">voir</a>");
		print("</TD>");
	TblDebutLigne();
	TblFinLigne();
TblFin();
print("</fieldset>");
print("</div>");
//===============================  affichage des contacts  ==============================================
$service_caracid=$_GET['ttvecteur'];
$type=0;//nouveau
$nature=3;//nature_contact = vecteur
$back="vecteur_saisie.php";//adresse de retour
$variable="$_GET[ttvecteur]";// variable de retour
print("<FIELDSET>");
print("<LEGEND class=\"time\">Contacts</LEGEND>");
if($_GET['ttvecteur'])
	contact($service_caracid,$type,$nature,$contact_id,$back,$variable,$_GET['tri']);
//contact($contact,$type,$nature,$contact_id,$back,$variable_retour)
print("</FIELDSET>");
//===============================  affichage des Adresses  ==============================================
print("<div id=\"content\">");
$adresse_ID = $vecteur->adresse_ID;
print("<input type=\"hidden\" name=\"adresse_ID\" value=\"$adresse_ID\">");
get_adresse($adresse_ID,$ville_ou_commune='V',$classe='');
print("</div>");
//=======================================================================================================

// 14/40/03 Ajout champ matériel spécifique
print("<BR>");
print("<fieldset>");
print("<legend class=\"time_v\">Matériel spécifique</legend>");
if($vecteur->dsa)
	print("<INPUT TYPE=\"CHECKBOX\" VALUE=\"o\" NAME=\"dsa\"CHECKED>DSA ");
else
	print("<INPUT TYPE=\"CHECKBOX\" VALUE=\"o\" NAME=\"dsa\">DSA ");
print("</fieldset>");

print("</FONT>");
print("</FORM>");
print("</body>");
print("</HTML>");
?>
