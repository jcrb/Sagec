<?php
//----------------------------------------- SAGEC ------------------------------
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
//----------------------------------------- SAGEC ----------------------------
//											
//	programme: 		utilitairesHTML.php					
//	date de création: 	18/08/2003						
//	auteur:				jcb						
//	description:				 					
//	version:			1.2						
//	maj le:				01/04/2004					
//											
//----------------------------------------------------------------------------
// "UtilitairesHTML.php"
require("pma_constantes.php");
require("pma_requete.php");
require("utilitaires/table.php");

function date_allemande()
{
	setlocale(LC_TIME,"fr");
	$jour = strFTime("%A");
	switch ($jour) {
		case "lundi": $j="Montag";break;
		case "mardi": $j="Dienstag";break;
		case "mercredi": $j="Mittwoch";break;
		case "jeudi": $j="Donnerstag";break;
		case "vendredi": $j="Freitag";break;
		case "samedi": $j="Samstag";break;
		case "dimanche": $j="Sonntag";break;
	}
	$d = strFTime("%d");
	$mois = strFTime("%B");
	switch ($mois) {
		case janvier: $m="Januar";break;
		case février: $m="Februar";break;
		case mars: $m="März";break;
		case avril: $m="April";break;
		case mai: $m="Mai";break;
		case juin: $m="Juni";break;
		case juillet: $m="Juli";break;
		case août: $m="August";break;
		case septembre: $m="September";break;
		case octobre: $m="Oktober";break;
		case novembre: $m="November";break;
		case decembre: $m="Dezember";break;
	}
	$y = strFTime("%Y");
	return $j." ".$d." ".$m." ".$y;
}
//=============================================================================
//	DateHeure()		retourne la date et l'heure
//=============================================================================
/**
*Retourne la date et l'heure courante.
*L'heure est formatée en fonction du pays d'origine.
*@package utilitairesHTML.php
*@return string heure courante formatée
*@param string langue ou pays courant. par défaut la date est affichée en français
*@version 1.0
*/
function DateHeure($langue="FR")
{
	require 'utilitaires/globals_string_lang.php';
	if($langue=="GE")$dateFR=date_allemande();
	else
	{
		if($langue=="UK")$mot="en";
		else $mot = "fr";
		setlocale(LC_TIME,$mot);
		$dateFR = strFTime("%A %d %B %Y");
	}
	$heure = date("H:i");
	$mot2 = $string_lang['A'][$langue];
	$mot = $dateFR." ".$mot2." ".$heure;
	return $mot;
}
//=============================================================================
//	maDate()		retourne la date et l'heure
//=============================================================================
/**
*Retourne la date et l'heure courante.
*L'heure est formatée en fonction du pays d'origine.
*@package utilitairesHTML.php
*@return string heure courante formatée
*@param string date au format aaaa-mm-jj hh:mm:ss
*@version 1.0
*/
function maDate($d,$param="")
{
	$jour_heure=explode(" ",$d);
	$date = explode("-",$jour_heure[0]);
	$heure = explode(":",$jour_heure[1]);
	$heure1= $heure[0]."h".$heure[1];
	$jour=$date[2]."/".$date[1]."/".$date[0];
	if($param=="")
		return $jour;
	else if($param=="h1")
		return $heure1;
	else if($param=="dh")
		return $jour." ".$heure1;

}
//=============================================================================
//	NumTel()		retourne un n° de tel formaté
//				Trouvé sur le Web
//				auteur inconnu
//	utilisation: echo "Téléphone : ".NumTel($teldom);
//=============================================================================
/**
*Retourne un n° de tel formaté.
*Le numéro brut est présenté par paquet de 2 chiffres séparés par un point. Ex: 03.88.11.69.01
*@package utilitairesHTML.php
*@return string n° formatté
*@param string n° de téléphone brut. Ex: 0388116901
*@version 1.0
*/
 function NumTel($tel)
 {
	// pays de l'appelant
	$langue = substr($HTTP_ACCEPT_LANGUAGE, 0, 2);
	$ch=10;	// Numéro à 10 chiffres
	$tel = eregi_replace('[^0-9]',"",$tel); // supression sauf chiffres
	$tel = trim($tel);// suppression espaces avant et après
	if (strlen($tel) > $ch)
	{
		$d = strlen($tel) - $ch;// retrouve la position pour ne garder que les $ch derniers
	}
	else
	{
		$sd=0;
	}
	$tel = substr($tel,$d,$ch);// récupération des $ch derniers chiffres
$newtel=eregi_replace('([0-9]{1,2})([0-9]{1,2})([0-9]{1,2})([0-9]{1,2})([0-9]{1,2})$','\\1.\\2.\\3.\\4.\\5',$tel);
	// mise en form
	return $newtel; // Exemple : 03-81-51-45-78
 }

//==========================================================================
//	Select	Crée une liste de sélection
//			$titre NAME de l'objet select
//			$$liste_valeurs tableau commençant à 1 de la liste des valeurs
//			$item_select N° de l'item sélectionné par défaut
//==========================================================================
function Select($titre,$liste_valeurs,$item_select,$onChange="")
{

	print("<SELECT NAME =\"$titre\" size=\"1\" onChange='$onChange'>");
	$max = count($liste_valeurs);
	print("<OPTION VALUE=\"0\">? ");
	for($i=1;$i<=$max;$i++)
	{
		print("<OPTION VALUE=\"$i\" ");
		//if($item_select == $liste_valeurs[$i])
		if($item_select == $i)
			print(" SELECTED");
		print("> $liste_valeurs[$i]");
	}
	print("</SELECT>");
}
// test
//Select("essai",$item_gravite,2);

//==========================================================================
//	Select	Crée une liste de sélection à partir d'une table
//			$name NAME de l'objet select
//			$table table de la BD
//			$colID colonne identifiant/valeur
//			$colName colonne nom
//			$colTri colonne sur laquelle se fait le tri
//			$item_select N° de l'item sélectionné par défaut
//==========================================================================
function Select_from_table($name,$table,$colID,$colName,$item_select,$colTri,$onChange="")
{
	global $connexion;

	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT ".$colID.",".$colName." FROM ".$table." ORDER BY ".$colTri;
	$resultat = ExecRequete($requete,$connexion);
	print("<select name='$name' size='1' onChange='$onChange'>");
	$mot = $string_lang['NO_SELECT'][$langue];
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[0]\" ");
			if($item_select == $rub[0]) print(" SELECTED");
			print(">".Security::db2str($rub[1])." </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

//==========================================================================
//	Recupere_Enum	Crée une liste de sélection à partir des données du champ ENUM d'une BD
//			$ma_table	nom de la table
//			$ma_colonne nom de la colonne contenant les valeurs ENUM
//			$item_select N° de l'item sélectionné par défaut
//			$connexion	variable de connexion
//==========================================================================
/**
*Crée une liste de sélection à partir des données du champ ENUM d'une BD.
*Appelle la fonction Select().
*@package utilitairesHTML.php.
*@param string table concernée.
*@param string colonne de la table concernée.
*@param int ID l'item courant courant.
*@param string variable de connexion.
*@version 1.0
*/
function Recupere_Enum($ma_table,$ma_colonne,$item_select,$connexion)
{
	$recherche = "SHOW COLUMNS FROM $ma_table LIKE '$ma_colonne'";
	$resultat = ExecRequete($recherche,$connexion);
	// récupère les données brutes
	$donnees = mysql_fetch_array($resultat);
	// élimination des caractères inutiles
	eregi("('.*')",$donnees["Type"],$liste);
	$liste_enum = eregi_replace("'","",$liste[1]);
	// ventilation de la liste dans un tableau
	$vec_enum = explode(',',$liste_enum);
	// appel de la fonction créant le Select
	Select("Type_de_vecteur",$vec_enum,$item_select);
}

//=======================================================================================
//	SelectHopital()		Crée une liste déroulante avec la liste des hôpitaux
//		$connexion variable de connexion
//		$item_select	Hop_ID de l'hopital sélectionné
//		Au retour $ID_hopital contient l'Hop_ID de l'hopital sélectionné
//=======================================================================================
/**
*Crée et affiche une liste déroulante avec la liste des hôpitaux.
*@package utilitairesHTML.php.
*@return int $ID_hopital contient l'hopital_ID de l'établissement sélectionné.
*@param string variable de connexion.
*@param int ID de l'hopital courant.
*@param string langue ou pays courant.
*@param string action à entreprendre si la sélection change (facultatif).
*@version 1.0
*/
function select_hopital($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT Hop_ID,Hop_nom FROM hopital ORDER BY Hop_nom";
	//$requete="SELECT org_ID,org_nom FROM organisme WHERE organisme_type_ID = '12'ORDER BY org_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_hopital\" size=\"1\" onChange='$onChange'>");
	$mot = $string_lang['NO_SELECT'][$langue];
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[Hop_ID]\" ");
			if($item_select == $rub['Hop_ID']) print(" SELECTED");
			print(">".Security::db2str($rub[Hop_nom])." </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	idem mais ne sélectionne que les hôpitaux visibles
*/
function select_hopital_visible($connexion,$item_select,$langue,$listeID,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$org = 85; // $_SESSION[organisation]
	$requete="SELECT hopital.Hop_ID,hopital.Hop_nom
				FROM hopital,hopital_visible
				WHERE hopital.Hop_ID = hopital_visible.Hop_ID
				AND hopital_visible.org_ID = '$org'
				AND hopital_visible.liste_ID = '$listeID'
				ORDER BY Hop_nom";
	//$requete="SELECT org_ID,org_nom FROM organisme WHERE organisme_type_ID = '12'ORDER BY org_nom";
	//echo $requete;
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_hopital\" id=\"ID_hopital\" size=\"1\" onChange='$onChange'>");
	$mot = $string_lang['NO_SELECT'][$langue];
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[Hop_ID]\" ");
			if($item_select == $rub['Hop_ID']) print(" SELECTED");
			print(">".Security::db2str($rub['Hop_nom'])." </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectHopital2()		Crée une liste déroulante avec la liste des hôpitaux
//						à partir de la table organisme
//						$connexion variable de connexion
//						$item_select	org_ID de l'hopital sélectionné
//						Au retour $ID_hopital contient l'org_ID de l'hopital sélectionné
//=============================================================================
/**
*Crée et affiche une liste déroulante avec la liste des hôpitaux.
*Utilise la table 'organisme'.
*@package utilitairesHTML.php.
*@return int $ID_hopital contient l'org_ID de l'établissement sélectionné.
*@param string variable de connexion.
*@param int ID de l'hopital courant.
*@param string langue ou pays courant.
*@param string action à entreprendre si la sélection change (facultatif).
*@version 1.0
*/
function select_hopital2($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT org_ID,org_nom FROM organisme WHERE organisme_type_ID='12' ORDER BY org_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_hopital\" size=\"1\" onChange='$onChange'>");
	$mot = $string_lang['NO_SELECT'][$langue];
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[org_ID]\" ");
			if($item_select == $rub[org_ID]) print(" SELECTED");
			print("> $rub[org_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//========================================================================
//	ChercheNomHopital	Retourne le nom de l'hopital $id
//				$id n° identification de l'hopital
//				$ variable de connexion
//				$resultat contient toutes les données d'une ligne
//				sous forme d'un tableau
//========================================================================
/**
*Retourne le nom de l'hopital dont on connait l'hopital_ID.
*@package utilitairesHTML.php.
*@return string.
*@param int ID de l'hopital courant.
*@param string variable de connexion..
*@version 1.0
*/
function ChercheNomHopital($id,$connexion)
{
	$requete = "SELECT Hop_nom FROM hopital
				WHERE Hop_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	return LigneSuivante($resultat);
}
//========================================================================
//	ChercheVilleHopital	Retourne la ville siège de l'hopital $id et le nom de l'hôpital
//				$id n° identification de l'hopital
//				$ variable de connexion
//				$resultat contient toutes les données d'une ligne
//				sous forme d'un tableau
//========================================================================
/**
*Retourne le nom de l'hopital dont on connait l'hopital_ID, ainsi qque le nom
*de la ville, du pays en clair et en abrégé
*@package utilitairesHTML.php.
*@return array $rub['Hop_nom'],$rub['ville_nom'],$rub['pays_nom'],$rub['iso2'].
*@param int ID de l'hopital courant.
*@param string variable de connexion..
*@version 1.0
*/
function ChercheVilleHopital($id,$connexion)
{
	$requete = "SELECT Hop_nom,ville_nom,pays_nom,iso2
				FROM hopital,ville,adresse,pays
				WHERE Hop_ID = '$id'
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_id
				AND ville.pays_ID = pays.pays_ID
				";
				//print($requete."<br>");
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	//print($rub[0]." ".$rub[1]." ".$rub[2]." ".$rub[3]."<br>");
	return $rub;
}
//=============================================================================
//	SelectSAMU()	Crée une liste déroulante avec la liste des SAMU
//				$connexion 		variable de connexion
//				$organisme		org_ID de l'organisme dont dépend le service
//				$item_select	service_ID du service sélectionné
//				L'ID du service sera renvoyé dans la variable the_service
//=============================================================================
function select_samu($connexion,$item_select)
{
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT service_ID,service_nom FROM service WHERE Type_ID = '13' ORDER BY service_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"samu\" size=\"1\">");
	print("<OPTION VALUE = \"0\">[-- aucun--] </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[service_ID]\" ");
			if($item_select == $rub[service_ID]) print(" SELECTED");
			print("> $rub[service_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

//=============================================================================
//	SelectService()		Crée une liste déroulante avec la liste des services d'un organisme
//						d'un hopital donné
//						$connexion 		variable de connexion
//						$organisme		org_ID de l'organisme dont dépend le service
//						$item_select	service_ID du service sélectionné
//						L'ID du service sera renvoyé dans la variable the_service
// MODIFIE LE 28/02/04 organisme remplace hopital
//=============================================================================
function select_service($connexion,$organisme,$item_select)
{
	// lit la liste des hôpitaux dans la base de données
	//print("organisme: ".$organisme."<BR>");
	$requete="SELECT service_ID,service_nom FROM service WHERE org_ID = '$organisme'ORDER BY service_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"the_service\" size=\"1\">");
	print("<OPTION VALUE = \"0\">[pas de service] </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[service_ID]\" ");
			if($item_select == $rub[service_ID]) print(" SELECTED");
			print("> $rub[service_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectService2()		Crée une liste déroulante avec la liste des services d'un hopital
//						d'un hopital donné
//						$connexion 	variable de connexion
//						$hopital		Hop_ID de l'organisme dont dépend le service
//						$item_select	service_ID du service sélectionné
//						L'ID du service sera renvoyé dans la variable the_service
// MODIFIE LE 28/02/04 organisme remplace hopital
//=============================================================================
function select_service2($connexion,$hopital,$item_select)
{
	// lit la liste des hôpitaux dans la base de données
	//print("organisme: ".$organisme."<BR>");
	$requete="SELECT service_ID,service_nom FROM service WHERE Hop_ID = '$hopital'ORDER BY service_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"the_service\" id=\"serviceID\" size=\"1\">");
	print("<OPTION VALUE = \"0\">[pas de service] </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[service_ID]\" ");
			if($item_select == $rub[service_ID]) print(" SELECTED");
			print("> ".($rub[service_nom])." </OPTION> \n");// Security::db2str supprimé pour l'instant
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
/**
*	SelectTousService()	Crée une liste déroulante avec la liste des services
*	@param	$connexion variable de connexion
*	@param	$item_select	service_ID du service sélectionné
*	@param	$multiple: autorise ou non la sélection multiple. Si $multiple est > 0
*	@param	$multiple indique le nombre de lignes à afficher.
*	@return	Au retour $ttservice contient le service_ID du service sélectionné
*		En cas de sélection multiple retourne le tableau $ttservice[]
*/
//=============================================================================
function SelectTousService($connexion,$item_select,$langue,$multiple=0)
{
	// lit la liste des hôpitaux dans la base de données
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT service_ID,service_nom FROM service ORDER BY service_nom";
	$resultat = ExecRequete($requete,$connexion);
	
	if($multiple > 0)
		print("<select name=\"ttservice[]\" size=\"$multiple\" multiple>");
	else
		print("<select name=\"ttservice\" size=\"1\">");

	$mot = $string_lang['NOUVEAU'][$langue];
	print("<OPTION VALUE = \"0\">-- $mot --</OPTION> \n");
	
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[service_ID]\" ");
			if($item_select == $rub[service_ID]) print(" SELECTED");
			print("> $rub[service_nom] </OPTION> \n");
	}
	
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectTypeService()	Crée une liste déroulante avec la liste des types de
//						services d'un hopital donné
//						$connexion 		variable de connexion
//						$item_select	type_ID du service sélectionné
//		Au retour, $type_s contient le type_ID
//	17/8/03 ajout de $langue qui permet d'afficher la liste déroulante en fonction
//			de la langue sélectionnée.
//=============================================================================
function SelectTypeService($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT Type_ID,type_nom FROM type_service ORDER BY type_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"type_s\" size=\"1\" onChange='$onChange'>");
	if($langue)
		$mot = $string_lang['ALL_SERVICES'][$langue];
	else
		$mot = "[tous les services]";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[Type_ID]\" ");
			if($item_select == $rub[Type_ID]) print(" SELECTED");
			if($langue)
			{
				$mot1 = $string_lang[$rub[type_nom]][$langue];
				print(">$mot1</OPTION> \n");
			}
			else
				print("> $rub[type_nom] </OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//========================================================================
//	ChercheTypeService	Cherche un enregistrement avec le N° identitification
//					$id n° identification du service
//					$ variable de connexion
//					$resultat contient toutes les données d'une ligne sous
//					forme d'un tableau
//========================================================================
function ChercheTypeService($id,$connexion)
{
	$requete = "SELECT * FROM type_service WHERE type_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	$n = LigneSuivante($resultat);
	return $n->type_nom;
}
//========================================================================
//	ChercheService	Cherche un enregistrement avec le N° identitification
//					$id n° identification du service
//					$ variable de connexion
//					$resultat contient toutes les données d'une ligne sous
//					forme d'un tableau
//========================================================================
function ChercheService($id,$connexion)
{
	$requete = "SELECT * FROM service WHERE service_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	return LigneSuivante($resultat);
}
//========================================================================
//	Table_Service	Affiche les services sous forme d'une table
//
//========================================================================
function Table_Service($connexion,$langue)
{
	require 'utilitaires/globals_string_lang.php';
	$requete=	"SELECT *
				FROM service, organisme
				WHERE service.org_ID = organisme.org_ID
				ORDER BY organisme.org_nom";
	$resultat = ExecRequete($requete,$connexion);
	TblDebut(0,"100%");
	$_style = "A2";
	TblDebutLigne("$_style");
		$modifier = $string_lang['MODIFIER'][$langue];TblCellule("<B>$modifier</B>");
		TblCellule("<B>ID</B>");
		$mot = $string_lang['HOPITAL'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['TYPE'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['SERVICE'][$langue];TblCellule("<B>$mot</B>");
		TblCellule("<B>Code</B>");
		$mot = $string_lang['TEL'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['FAX'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['ETAGE'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['BATIMENT'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['ASCENCEUR'][$langue];TblCellule("<B>$mot</B>");
	TblFinLigne();
$_style = "A5";
while($i = LigneSuivante($resultat))
{
	if($_style=="A5")$_style="A6";
	else $_style="A5";
	TblDebutLigne("$_style");
	// MODFIER: on appelle Tri2 avec comme paramètre le n° d'ordre contenu
	// dans la variable 'identifiant' qui est attendue par Tri2
	$identifiant = $i->service_ID;
	TblCellule("<a href=\"services.php?ttservice=$identifiant\">$modifier</a>");
	// Affichage des données de la ligne
	TblCellule("$i->service_ID");
	//$hop = ChercheNomHopital($i->Hop_ID,$connexion);
	TblCellule($i->org_nom);
	$type = ChercheTypeService($i->Type_ID,$connexion);
	//$mot = $string_lang[$type->type_nom][$langue];
	$mot = $string_lang[$type][$langue];
	TblCellule($mot);
	//TblCellule($type->type_nom);
	//TblCellule("$i->Type_ID");
	TblCellule("$i->service_nom");
	TblCellule("$i->service_code");
	TblCellule("$i->service_tel");
	TblCellule("$i->service_fax");
	TblCellule("$i->service_etage");
	TblCellule("$i->service_batiment");
	TblCellule("$i->service_ascenceur");
	TblFinLigne();
}
TblFin();
}
//========================================================================
//	MAZ_Lits_cata	Met à 0 les champs lits_cata de la table lits
//					Calcule le nombre de lits disponibles
//========================================================================
function MAZ_Lits_cata($connexion)
{
	$requete1="SELECT * FROM lits ";
	$n = ExecRequete($requete1,$connexion);
	while($i = LigneSuivante($n))
	{
		$lits_dispo = $i->lits_sp + $i->lits_supp - $i->lits_occ - $i->lits_cata;
		//print($lits_dispo."<BR\n>");
		$requete="UPDATE lits SET lits_cata ='0',lits_dispo ='$lits_dispo' WHERE lits_ID = $i->lits_ID";
		$resultat = ExecRequete($requete,$connexion);
	}
}

function MAJ_Lits_cata($connexion)
{
	MAZ_Lits_cata($connexion);
	// on récupère les services où ont été hospitalisées les victimes
	$requete="SELECT service_ID FROM victime";
	$service_victime = ExecRequete($requete,$connexion);
	// pour chaque victimes, il faut mettre à jour le champ lits_cata du service concerné
	while($i = LigneSuivante($service_victime))
	{
		$requete1="SELECT * FROM lits WHERE service_ID = '$i->service_ID'";
		$n = ExecRequete($requete1,$connexion);
		$n2 = LigneSuivante($n);
		$n2->lits_cata ++;
		$lits_dispo = $n2->lits_sp + $n2->lits_supp - $n2->lits_occ - $n2->lits_cata;
		$requete2="UPDATE lits SET lits_cata ='$n2->lits_cata',lits_dispo = '$lits_dispo' WHERE service_ID = '$i->service_ID'";
		$resultat = ExecRequete($requete2,$connexion);
	}

}
//===========================================================================
//	Table_Lits	Affiche l'état des lits sous forme d'une table
//	$connexion	variable de connection
//	$hopID		identifiant d'un hopital. Par défaut vaut 0. Dans ce cas
//				la liste de tous les services, de tous les hôpitaux est
//				renvoyée. Sinon, seuls les services d'un hopital sont renvoyés
//	$back		adresse de retour pour la fonction modifier
//============================================================================
function Table_Lits($connexion,$hopID="0",$type_service="0",$langue,$back="")
{
	require 'utilitaires/globals_string_lang.php';
	MAJ_Lits_cata($connexion);
	// tous les hôpitaux et tous les services
	if($hopID < 1 && $type_service < 1)
		$requete="SELECT * FROM lits ORDER BY lits_dispo DESC";
	// tous les hôpitaux, service spécifique
	else if($hopID < 1 && $type_service > 0)
		$requete=	"SELECT *
					FROM service,lits
					WHERE service.Type_ID = '$type_service'
					AND service.service_ID = lits.service_ID
					ORDER BY lits_dispo DESC";
	// tous les services, hôpital spécifique
	else if($hopID > 0 && $type_service < 1)
		$requete=	"SELECT *
					FROM service,lits
					WHERE service.Hop_ID = '$hopID'
					AND service.service_ID = lits.service_ID
					ORDER BY lits_dispo DESC";
	// hopital et service spécifique
	else
		$requete=	"SELECT *
					FROM service,lits
					WHERE service.Hop_ID = '$hopID'
					AND service.Type_ID = '$type_service'
					AND service.service_ID = lits.service_ID
					ORDER BY lits_dispo DESC";
	//print($requete."<BR>");
	$resultat = ExecRequete($requete,$connexion);
	TblDebut(0,"100%");
	$_style = "A2";
	TblDebutLigne("$_style");
		$mot = $string_lang['MODIFIER'][$langue];TblCellule("<B>$mot</B>");
		TblCellule("<B>ID</B>");
		$mot = $string_lang['HOPITAL'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['SERVICE'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['TYPE'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['TOTAL_LITS'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['LITS_OCC'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['LITS_LIB'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['LITS_SUP'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['LITS_DISPO'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['VICTIMES_CATA'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['MAJ'][$langue];TblCellule("<B>$mot</B>");
	TblFinLigne();

	$_style = "A5";
	$modifier = $string_lang['MODIFIER'][$langue];
	while($i = LigneSuivante($resultat))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		TblDebutLigne("$_style");
		// MODFIER: on appelle Tri2 avec comme paramètre le n° d'ordre contenu
		// dans la variable 'identifiant' qui est attendue par Tri2
		$identifiant = $i->service_ID;
		TblCellule("<a href=\"Services.php?ttservice=$identifiant&back=$back\">$modifier</a>");
		// Affichage des données de la ligne
	TblCellule("$i->lits_ID");
	$hop = ChercheNomHopital($i->Hop_ID,$connexion);
	TblCellule($hop->hop_nom);
	$service = ChercheService($i->service_ID,$connexion);
	TblCellule($service->service_nom);

	$type = ChercheTypeService($service->Type_ID,$connexion);
	//$mot = $string_lang[$type->type_nom][$langue];
	$mot = $string_lang[$type][$langue];
	TblCellule($mot);
	//TblCellule($type->type_nom);

	TblCellule("<div align=\"right\"> $i->lits_sp");
	TblCellule("<div align=\"right\"> $i->lits_occ");
	TblCellule("<div align=\"center\"> $i->lits_liberable");
	TblCellule("<div align=\"center\"> $i->lits_supp");
	//$lits_dispo = $i->lits_sp + $i->lits_supp - $i->lits_occ - $i->lits_cata;
	TblCellule("<div align=\"center\"><B> $i->lits_dispo</B>");
	TblCellule("<div align=\"center\"> $i->lits_cata");
	if($i->date_maj < 1)
		TblCellule(" ");
	else
		TblCellule(date("j/m/Y H:i",$i->date_maj));
	TblFinLigne();
	}
	TblFin();
}
//===========================================================================
//	Table_Lits2	Affiche l'état des lits sous forme d'une table
//	$connexion	variable de connection
//	$hopID		identifiant d'un hopital. Par défaut vaut 0. Dans ce cas
//				la liste de tous les services, de tous les hôpitaux est
//				renvoyée. Sinon, seuls les services d'un hopital sont renvoyés
//				ATTENTION: $hopID correspond à org_ID
//	$back		adresse de retour pour la fonction modifier
//============================================================================
function explode_dpt($dpt)
{
	$requete = " 	AND organisme.ville_ID = ville.ville_ID
				AND ville.departement_ID IN (";
				for($i=0;$i<count($dpt); $i++)
					$requete .= "'".$dpt[$i]."',";
				$requete .= "'-1')";// rajoute un département fictif pour clore la liste
	return $requete;
}
function lits2_creeRequete($connexion,$orgID="0",$type_service="0",$dpt="")
{
	if($orgID < 1 && $type_service < 1)
	{
		$requete="SELECT *
					FROM lits,service, organisme";
			if($dpt !="") $requete .= ",ville";
		$requete .=	" WHERE lits.service_ID = service.service_ID
					AND service.org_ID = organisme.org_ID";
			if($dpt !="") $requete .= explode_dpt($dpt);
		$requete .= " ORDER BY lits_dispo DESC";
	}
	// tous les hôpitaux, service spécifique
	else if($orgID < 1 && $type_service > 0)
	{
		$requete=	"SELECT *
					FROM organisme,lits, service";
			if($dpt !="") $requete .= ",ville";
		$requete .=	" WHERE organisme_type_ID='12'
					AND service.Type_ID = '$type_service'
					AND service.service_ID = lits.service_ID
					AND organisme.org_ID = service.org_ID";
			if($dpt !="") $requete .= explode_dpt($dpt);
		$requete .= " ORDER BY lits_dispo DESC";
	}
	// tous les services, hôpital spécifique
	else if($orgID > 0 && $type_service < 1)
	{
		$requete=	"SELECT *
					FROM service,lits,organisme";
		$requete .=" WHERE organisme_type_ID='12'
					AND service.org_ID = '$orgID'
					AND service.service_ID = lits.service_ID
					AND organisme.org_ID = service.org_ID";
		$requete .=" ORDER BY service.Type_ID";
	}
	// hopital et service spécifique
	else
	{
		$requete=	"SELECT *
					FROM service,lits,organisme
					WHERE organisme_type_ID='12'
					AND service.org_ID = '$orgID'
					AND service.Type_ID = '$type_service'
					AND service.service_ID = lits.service_ID
					AND organisme.org_ID = service.org_ID
					ORDER BY lits_dispo DESC";
	}
	return $requete;
	//print($requete."<BR>");
}
function Table_Lits2($connexion,$orgID="0",$type_service="0",$langue,$back="",$dpt="")
{
	require 'utilitaires/globals_string_lang.php';
	MAJ_Lits_cata($connexion);
	// création et exécution de la requete
	$requete = lits2_creeRequete($connexion,$orgID,$type_service,$dpt);
	$resultat = ExecRequete($requete,$connexion);
	// affichage du résultat
	TblDebut(0,"100%");
	$_style = "A2";
	TblDebutLigne("$_style");
	$mot = $string_lang['MODIFIER'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"> $mot");
	//TblCellule("<B>ID</B>");
	$mot = $string_lang['HOPITAL'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['SERVICE'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['TYPE'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['TOTAL_LITS'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['LITS_OCC'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['LITS_LIB'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['LITS_SUP'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['LITS_DISPO'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['VICTIMES_CATA'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['MAJ'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	TblFinLigne();

	$_style = "A5";
	$modifier = $string_lang['MODIFIER'][$langue];
	while($i = LigneSuivante($resultat))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		TblDebutLigne("$_style");
		// MODFIER: on appelle Tri2 avec comme paramètre le n° d'ordre contenu
		// dans la variable 'identifiant' qui est attendue par Tri2
		$identifiant = $i->service_ID;
		// on transmet l'identifiant de l'hôpital et/ou du type de service
TblCellule("<a href=\"services.php?ttservice=$identifiant&back=$back&orgID=$orgID&type_service=$type_service\" class=\"time\">$modifier</a>");
		// Affichage des données de la ligne
	//TblCellule("$i->lits_ID");
	//TblCellule("<div align=\"left\" class=\"Style23\"> $identifiant");
	TblCellule("<div align=\"left\" class=\"Style23\"> $i->org_nom");
	TblCellule("<div align=\"left\" class=\"Style23\"> $i->service_nom");

	$type = ChercheTypeService($i->Type_ID,$connexion);
	//$mot = $string_lang[$type->type_nom][$langue];
	$mot = $string_lang[$type][$langue];
	//------------------------------ adulte ou enfant ? -------------------
	if($i->service_adulte) $mot .= " ".$string_lang['ADULTE'][$langue];
	if($i->service_enfant) $mot .= " ".$string_lang['ENFANT'][$langue];
	if($i->age_min) $mot .= ">".$i->age_min.$string_lang['ANS'][$langue];
	TblCellule("<div align=\"left\" class=\"Style22\"> $mot");
	//---------------------------------------------------------------------
	TblCellule("<div align=\"right\" class=\"time\"> $i->lits_sp");
	TblCellule("<div align=\"right\" class=\"Style23\"> $i->lits_occ");
	TblCellule("<div align=\"center\" class=\"Style23\"> $i->lits_liberable");
	TblCellule("<div align=\"center\" class=\"Style23\"> $i->lits_supp");
	//$lits_dispo = $i->lits_sp + $i->lits_supp - $i->lits_occ - $i->lits_cata;
	TblCellule("<div align=\"center\" class=\"time_v\"><B> $i->lits_dispo</B>");
	TblCellule("<div align=\"center\" class=\"Style23\"> $i->lits_cata");
	if($i->date_maj < 1)
		TblCellule(" ");
	else
	{
		$t = date("j/m/Y H:i",$i->date_maj);
		TblCellule("<div align=\"center\" class=\"Style22\">$t");
	}
	TblFinLigne();
	}
	TblFin();
}
//========================================================================
//	ChercheLit	Cherche un enregistrement avec le N° identitification
//					$id n° identification du service
//					$ variable de connexion
//					$resultat contient toutes les données d'une ligne sous
//					forme d'un tableau
//========================================================================
function ChercheLit($id_service,$connexion)
{
	$requete = "SELECT * FROM lits WHERE service_ID = '$id_service'";
	$resultat = ExecRequete($requete,$connexion);
	return LigneSuivante($resultat);
}
//========================================================================
//	Table_Vecteurs	Affiche l'état des vecteurs sous forme d'une table
//	$connexion			variable de connexion
//	$type	Si = 0 (valeur par défaut)affiche tous les types de vecteurs
//	$back: adresse de retour (facultatif)
// $sens du tri 1 = asc 2= desc 
//========================================================================
function Table_Vecteurs($connexion,$type="",$type_v="",$engage="",$langue,$back="",$tri="",$sens="1")
{
	require 'utilitaires/globals_string_lang.php';
	TblDebut(0,"100%");
	$_style = "A2";
	TblDebutLigne("$_style");
		$modifier = StrToUpper($string_lang['MODIFIER'][$langue]);
		TblCellule("<B>$modifier</B>");
		TblCellule("<B>ID</B>");
		$mot = StrToUpper($string_lang['NOM'][$langue]);
		TblCellule("<a href='$back?tri=vec&sens=$sens'><B>$mot</B></a>");
		$mot = StrToUpper($string_lang['ORGANISME'][$langue]);
		TblCellule("<a href='$back?tri=org&sens=$sens'><B>$mot</B></a>");
		$mot = StrToUpper($string_lang['ENGAGE'][$langue]);
		TblCellule("<B>$mot</B>");
		$mot = StrToUpper($string_lang['ETAT_MOYEN'][$langue]);
		TblCellule("<B>$mot</B>");
		$mot = StrToUpper($string_lang['TYPE'][$langue]);
		TblCellule("<a href='$back?tri=type&sens=$sens'><B>$mot</B></a>");
		$mot = StrToUpper($string_lang['INDICATIF'][$langue]);
		TblCellule("<B>$mot</B>");
		$mot = StrToUpper($string_lang['TEL'][$langue]);
		TblCellule("<B>$mot</B>");
	TblFinLigne();
	
	// lire les enregistrements
	// ,organisme,vecteur_type "; $requete .= "AND vecteur.org_ID = organisme.org_ID AND Vec_Type = vecteur_type_ID";
	$requete="SELECT vecteur.*,org_nom,vecteur_type_nom 
	FROM vecteur LEFT OUTER JOIN organisme ON vecteur.org_ID = organisme.org_ID
					 LEFT OUTER JOIN vecteur_type ON vecteur.Vec_Type = vecteur_type.vecteur_type_ID ";
	
	if($type != '0')
	{
		$requete= $requete."WHERE Vec_Type = '$type' ";
	}
	else $requete= $requete."WHERE Vec_Type LIKE '%' ";
	if($type_v)
		$requete= $requete."AND Vec_Etat = '$type_v' ";
	if($engage)
		$requete= $requete."AND Vec_Engage = 'o' ";
	
	//=============== organisation du tri =====================
	if($tri=="org")
		$requete = $requete." ORDER BY org_nom";
	else if($tri=="vec")
		$requete = $requete." ORDER BY Vec_Nom";
	else if($tri=="type")
		$requete = $requete." ORDER BY vecteur_type_nom";
	else
		$requete = $requete." ORDER BY Vec_Nom";
		
	if($sens==1) $requete .= " ASC";
		else $requete .= " DESC";
	//=========================================================
	//print($requete."<BR>");
	$resultat = ExecRequete($requete,$connexion);
	$_style = "A5";
	$modifier=StrToLower($modifier);
	while($i = LigneSuivante($resultat))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		TblDebutLigne("$_style");

		// Affichage des données de la ligne
	$identifiant = $i->Vec_ID;
	TblCellule("<a href=\"vecteur_saisie.php?ttvecteur=$identifiant&back=$back\">$modifier</a>");
	//TblCellule("zzz");
	TblCellule("$i->Vec_ID");
	TblCellule("$i->Vec_Nom");
	TblCellule("$i->org_nom");
	if($i->Vec_Engage)
	{
		$mot = $string_lang['OUI'][$langue];
		TblCellule("<div align=\"center\"> $mot");
	}
	else
		TblCellule("");
	TblCellule(ChercheNomTypeEtatVecteur($i->Vec_Etat,$connexion,$langue));
	//$mot = $string_lang[ChercheTypeVecteur($i->Vec_Type,$connexion)][$langue];
	$mot = $string_lang[$i->vecteur_type_nom][$langue];
	TblCellule($mot);
	TblCellule("$i->Vec_Indicatif");
	TblCellule("$i->Vec_Tel");
	TblFinLigne();
	}
	TblFin();
}
//=======================================================================================
//	ChercheVecteur	Cherche un vecteur avec le N° identification
//			$id n° identification du vecteur
//			$ variable de connexion
//			$resultat contient toutes les données d'une ligne sous
//			forme d'un tableau
//=======================================================================================
function ChercheVecteur($id,$connexion)
{
	$requete = "SELECT * FROM vecteur WHERE Vec_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	return LigneSuivante($resultat);
}
//=======================================================================================
//	SelectTousVecteur()	Crée une liste déroulante avec la liste des services
//				$connexion 		variable de connexion
//				$item_select	service_ID du service sélectionné
//				Au retour $ttvecteur contient le service_ID du service
//				sélectionné
//=======================================================================================
function SelectTousVecteur($connexion,$item_select)
{
	// lit la liste des vecteurs dans la base de données
	$requete="SELECT Vec_ID,Vec_Nom FROM vecteur ORDER BY Vec_Nom ASC";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ttvecteur\" size=\"1\">");
	print("<OPTION VALUE = \"0\">[nouveau vecteur] </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[Vec_ID]\" ");
			if($item_select == $rub[Vec_ID]) print(" SELECTED");
			print("> $rub[Vec_Nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	SelectVecteurEngages()	Crée une liste déroulante avec la liste des vecteurs engagés
//				$connexion 		variable de connexion
//				$item_select	vecteur_ID du vecteur sélectionné
//				Au retour $vecteur_engage_ID contient le vecteur_ID
//				vecteur sélectionné
//=======================================================================================
function SelectVecteurEngages($connexion,$item_select)
{
	// lit la liste des vecteurs dans la base de données
	$requete="SELECT Vec_ID,Vec_Nom FROM vecteur WHERE Vec_Engage='o' ORDER BY Vec_Nom ASC";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"vecteur_engage_ID\" size=\"1\">");
	print("<OPTION VALUE = \"0\">[autre vecteur] </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[Vec_ID]\" ");
		if($item_select == $rub[Vec_ID]) print(" SELECTED");
		print("> $rub[Vec_Nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	SelectVecteurDisponible()	Crée une liste déroulante avec la liste des vecteurs
//								engagés ET disponibles
//				$connexion 		variable de connexion
//				$item_select	vecteur_ID du vecteur sélectionné
//				Au retour $vecteur_disponible_ID contient le vecteur_ID
//				vecteur sélectionné
//=======================================================================================
function SelectVecteurDisponible($connexion,$item_select)
{
	// lit la liste des vecteurs dans la base de données
	$requete="SELECT Vec_ID,Vec_Nom FROM vecteur WHERE Vec_Engage='o' AND Vec_Etat IN('2','4') ORDER BY Vec_Nom ASC";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"vecteur_disponible_ID\" size=\"1\">");
	print("<OPTION VALUE = \"0\">[autre vecteur] </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[Vec_ID]\" ");
		if($item_select == $rub['Vec_ID']) print(" SELECTED");
		print("> $rub[Vec_Nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	SelectOrgVecteur()	Crée une liste déroulante avec la liste des vecteurs
//				appartenant à un même organisme
//				$connexion 		variable de connexion
//				$org_id			ID de l'organisme'
//				Au retour org_vecteur contient le vecteur_ID du vecteur
//				sélectionné
//=======================================================================================
function SelectOrgVecteur($connexion,$org_id)
{
	// lit la liste des vecteurs dans la base de données
	$requete="SELECT Vec_ID,Vec_Nom FROM vecteur WHERE org_ID ='$org_id'";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"org_vecteur\" size=\"1\">");
	print("<OPTION VALUE = \"0\">[aucun vecteur] </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[Vec_ID]\" ");
			//if($item_select == $rub[Vec_ID]) print(" SELECTED");
			print("> $rub[Vec_Nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectEtatVecteur()	Crée une liste déroulante avec la liste des états
//						possibles d'un vecteur
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'état sélectionné
//		Au retour, $type_v contient le type_ID
//=============================================================================
function SelectEtatVecteur($connexion,$item_select,$langue)
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT VEtat_ID,VEtat_nom FROM vecteurs_etat";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"type_v\" size=\"1\">");
	if($langue)
		$mot = $string_lang['ALL_ETATS'][$langue];
	else
		$mot = "[--]";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[VEtat_ID]\" ");
			if($item_select == $rub[VEtat_ID]) print(" SELECTED");
			if($langue)
			{
				$mot1 = $string_lang[$rub[VEtat_nom]][$langue];
				print(">$mot1</OPTION> \n");
			}
			else
				print("> $rub[VEtat_nom] </OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//========================================================================
//	ChercheTypeEtatVecteur	Cherche l'état du vecteur $id
//					$id n° identification du vecteur
//					$ variable de connexion
//					Retourne 1,2 ou 3
//
//========================================================================
function ChercheTypeEtatVecteur($id,$connexion)
{
	$requete="SELECT Vec_Etat FROM vecteur WHERE Vec_ID='$id'";
	$resultat = ExecRequete($requete,$connexion);
	$item_select=mysql_fetch_array($resultat);
	return $item_select[Vec_Etat];
}
//========================================================================
//	ChercheNomTypeEtatVecteur	Cherche le nom de l'état d'un vecteur
//					$id = Vec_ID
//					$ variable de connexion
//					Retourne Disponible, affect, etc.
//
//========================================================================
function ChercheNomTypeEtatVecteur($id,$connexion,$langue)
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT VEtat_nom FROM vecteurs_etat WHERE VEtat_ID='$id'";
	$resultat = ExecRequete($requete,$connexion);
	$item_select=mysql_fetch_array($resultat);
	$type = $item_select[VEtat_nom];
	$mot = $string_lang[$type][$langue];
	return $mot;
}
//========================================================================
//	ChercheTypeVecteur	Cherche le nom du type d'un vecteur
//					$id = Vec_Type
//					$ variable de connexion
//					Retourne VLM, UMH, etc.
//
//========================================================================
function ChercheTypeVecteur($id,$connexion)
{
	$requete="SELECT vecteur_type_nom FROM vecteur_type WHERE vecteur_type_ID='$id'";
	$resultat = ExecRequete($requete,$connexion);
	$item_select=mysql_fetch_array($resultat);
	return $item_select[vecteur_type_nom];
}
//=============================================================================
//	SelectTypeVecteur()	Crée une liste déroulante avec la liste des types
//						possibles d'un vecteur (UMH, VLM, ETC)
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'état sélectionné
//						$limit: accepte une série d'item pour limiter la taille de la liste
//							ex: '1','2' pour limiter aux VLM et UMH.
//							par défaut vaut 0 => all 
//						Au retour, $v_type contient le type_ID
//=============================================================================
function SelectTypeVecteur($connexion,$item_select,$langue,$onChange="",$limit="0")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete= "SELECT vecteur_type_ID,vecteur_type_nom FROM vecteur_type ";
		if($limit != '0')
			$requete.=" WHERE vecteur_type_ID IN('$limit') ";
		$requete.=" ORDER by vecteur_type_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT name=\"v_type\" size=\"1\" onChange='$onChange' >");
	if($langue)
		$mot = $string_lang['ALL_ETATS'][$langue];
	else
		$mot = "[Tous]";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[vecteur_type_ID]\" ");
			if($item_select == $rub[vecteur_type_ID]) print(" SELECTED");
			if($langue)
			{
				$mot = $rub[vecteur_type_nom];
				$mot1 = $string_lang[$mot][$langue];
				print(">$mot1</OPTION> \n");
			}
			else
				print("> $rub[vecteur_type_nom] </OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectTypeOrganisme()Crée une liste déroulante avec la liste des types
//						 d'Organismes possibles
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'organisme sélectionné
//						Au retour, organisme_type contient le type_ID
//=============================================================================
function SelectTypeOrganisme($connexion,$item_select,$langue)
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT organisme_type_ID,organisme_type_nom FROM organisme_type";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"organisme_type\" size=\"1\">");
	$mot = $string_lang['ALL_ETATS'][$langue];
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[organisme_type_ID]\" ");
		if($item_select == $rub[organisme_type_ID]) print(" SELECTED");
		print(">$rub[organisme_type_nom]</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectOrganisme()	Crée une liste déroulante avec la liste des Organismes
//						possibles
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'organisme sélectionné
//						Au retour, $orgID contient le type_ID
//=============================================================================
function SelectOrganisme($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT org_ID,org_nom FROM organisme ORDER BY org_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"orgID\" size=\"1\" onChange=\"$onChange\">");
	$mot = $string_lang['ALL_ETATS'][$langue];
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[org_ID]\" ");
		if($item_select == $rub['org_ID'])
			print(" SELECTED");
		print(">".Security::db2str($rub[org_nom])."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectOrganisme()	Crée une liste déroulante avec la liste des Organismes
//						selon un certain type
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'organisme sélectionné
//						Au retour, $orgID contient le type_ID
//=============================================================================
function SelectOrgParType($connexion,$item_select,$langue,$type)
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT org_ID,org_nom FROM organisme WHERE organisme_type_ID IN (".$type.") ORDER BY org_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"orgByType\" size=\"1\" >");
	$mot = $string_lang['ALL_ETATS'][$langue];
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[org_ID]\" ");
		if($item_select == $rub['org_ID'])
			print(" SELECTED");
		print(">".Security::db2str($rub[org_nom])."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//========================================================================
//	ChercheOrganisme	Cherche un organisme avec le N° identification
//					$id n° identification du vecteur
//					$ variable de connexion
//					$resultat contient toutes les données d'une ligne sous
//					forme d'un tableau
//========================================================================
function ChercheOrganisme($id,$connexion)
{
	$requete = "SELECT * FROM organisme WHERE org_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	return LigneSuivante($resultat);
}
//=============================================================================
//	GetOrganisme_nom()	Retourne le nom d'un organisme dont on connait
//						l'identifiant
//						$connexion 		variable de connexion
//						$item_select	identifiant de l'organisme
//=============================================================================
function GetOrganisme_nom($connexion,$item_select)
{
	$requete="SELECT org_ID,org_nom FROM organisme WHERE org_ID = '$item_select' ";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	return $rub[org_nom];
}

//=============================================================================
//	SelectOrganisme()	Crée une liste déroulante avec la liste des Organismes
//						possibles
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'organisme sélectionné
//						Au retour, $centralesID contient le type_ID
//=============================================================================
function SelectCentrales($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT centrale_type_ID,centrale_type_nom FROM centrale_type ORDER BY centrale_type_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"centralesID\" size=\"1\" onChange='$onChange'>");
	$mot = $string_lang['ALL_ETATS'][$langue];
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[centrale_type_ID]\" ");
		if($item_select == $rub['centrale_type_ID'])
			print(" SELECTED");
		print(">$rub[centrale_type_nom]</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

//=============================================================================
//	SelectMetier()	Crée une liste déroulante avec la liste des Organismes
//						possibles
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'organisme sélectionné
//						Au retour, $prof_type contient le type_ID
//=============================================================================
function SelectMetier($connexion,$item_select,$langue)
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des métiers dans la base de données
	$requete="SELECT perso_cat_ID,perso_cat_nom FROM perso_cat";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"prof_type\" size=\"1\">");
	$mot = $string_lang['ALL_ETATS'][$langue];
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[perso_cat_ID]\" ");
		if($item_select == $rub[perso_cat_ID]) print(" SELECTED");
		print(">$rub[perso_cat_nom]</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectLocalisation()	Crée une liste déroulante avec la liste des
//				localisations possibles (TRI, PMA, PRE, etc.)
//				$connexion 		variable de connexion
//				$item_select	type_ID de la localisation
//				Au retour, $localisation_type contient le type_ID
//=============================================================================
function SelectLocalisation($connexion,$item_select,$langue)
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des localisations dans la base de données
	$requete="SELECT localisation_ID,local_nom FROM localisation ORDER BY local_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"localisation_type\" size=\"1\">");
	$mot = $string_lang['AUCUNE'][$langue];
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[localisation_ID]\" ");
		if($item_select == $rub[localisation_ID]) print(" SELECTED");
		print(">$rub[local_nom]</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectLocal()	Crée une liste déroulante avec la liste des
//				localisations possibles (TRI, PMA, PRE, etc.)
//				$connexion 		variable de connexion
//				$item_select	type_ID de la localisation
//				Au retour, $localisation_type contient le type_ID
//=============================================================================
function SelectLocal($connexion,$item_select,$langue)
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des localisations dans la base de données
	$requete="SELECT local_type_ID,local_type_nom FROM local_type ORDER BY local_type_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"local_type\" size=\"1\">");
	$mot = $string_lang['AUCUNE'][$langue];
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[local_type_ID]\" ");
		if($item_select == $rub[local_type_ID]) print(" SELECTED");
		print(">$rub[local_type_nom]</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectCivilite()	Crée une liste déroulante avec la liste des
//						lcivilités possibles (Mr, Mme, etc.)
//						$connexion 		variable de connexion
//						$item_select	type_ID de la civilité
//						$short 			si = 1 retourne la version courte (Mr)
//										si = 0 retourne la version longue (Monsieur)
//						Au retour, $civilite_type contient le civilite_ID
//=============================================================================
function SelectCivilite($connexion,$item_select,$short,$langue="FR")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des localisations dans la base de données
	$requete="SELECT civilite_ID,civilite_nom,civilite_abrev FROM civilite";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"civilite_type\" size=\"1\">");
	$mot = $string_lang['ALL_ETATS'][$langue];
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[civilite_ID]\" ");
		if($item_select == $rub[civilite_ID]) print(" SELECTED");
		if(short)
			print(">$rub[civilite_abrev]</OPTION> \n");
		else
			print(">$rub[civilite_nom]</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
/**	select_commune()	Crée une liste déroulante avec la liste des communes
//				$connexion variable de connexion
//				$commune_id ID de la commune sélectionné
//				Au retour $commune_id contient l'ID de la commune sélectionné
*/
//=============================================================================
function select_commune($connexion,$item_select,$langue,$change="")
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT com_ID,com_INSEE,com_nom 
				FROM commune 
				ORDER BY com_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"commune_id\" size=\"1\" onChange='$change'>");
	$mot = $string_lang['NO_SELECT'][$langue];
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[com_ID]\" ");
		if($item_select == $rub[com_ID]) print(" SELECTED");
		print("> $rub[com_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//===============================================================================
/** même chose mais à partir du fichier ville 
  * 1 seul département: $departement = 67
*/
function select_ville_france($connexion,$item_select,$departement,$langue,$change="")
{
	require 'utilitaires/globals_string_lang.php';	
	$requete = "SELECT ville_nom,ville_ID
				FROM ville 
				WHERE departement_ID ='$departement'
				ORDER BY ville_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ville_id\" id=\"ville_id\" size=\"1\" onChange='$change'>");
	$mot = $string_lang['NO_SELECT'][$langue];
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[ville_ID]\" ");
		if($item_select == $rub[ville_ID]) print(" SELECTED");
		print(">$rub[ville_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
/** idem mais sélection de plusieurs départements
  * plusieurs départements: $departement = '67'."','".'68'
  */
function select_ville_france2($connexion,$item_select,$departement,$langue,$change="")
{
	require 'utilitaires/globals_string_lang.php';	
	$requete = "SELECT ville_nom,ville_ID
				FROM ville 
				WHERE departement_ID IN ('$departement')
				ORDER BY ville_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ville_id\" id=\"ville_id\" size=\"1\" onChange='$change'>");
	$mot = $string_lang['NO_SELECT'][$langue];
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[ville_ID]\" ");
		if($item_select == $rub[ville_ID]) print(" SELECTED");
		print(">$rub[ville_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	select_n_commune()	Crée une liste déroulante permettant une sélection multiple des communes
//				$connexion variable de connexion
//				$commune_id ID de la commune sélectionné
//				Au retour $commune_id contient l'ID de la commune sélectionné
//=============================================================================
function select_n_commune($connexion,$item_select,$langue,$change="")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT com_ID,com_INSEE,com_nom FROM commune ORDER BY com_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"commune_id[]\" size=\"20\" MULTIPLE onChange='$change'>");
	$mot = $string_lang['NO_SELECT'][$langue];
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[com_ID]\" ");
		if($item_select == $rub[com_ID]) print(" SELECTED");
		print("> $rub[com_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	get_carac_commune()
//				$connexion variable de connexion
//				$commune_id ID de la commune sélectionné
//=============================================================================
function get_carac_commune($connexion,$ID_commune)
{
	$requete="SELECT com_INSEE,
			com_nom,
			secteur_smur_ID,
			secteur_apa_ID,
			secteur_adps_ID,
			Lx,Ly
		FROM commune WHERE com_ID = '$ID_commune'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	@mysql_free_result($resultat);
	return $rub;
}
function get_carac_ville($connexion,$ID_ville)
{
	$requete="SELECT ville_Insee,
			ville_nom,
			secteur_smur_ID,
			secteur_apa_ID,
			secteur_adps_ID,
			ville_longitude,
			ville_latitude
		FROM ville WHERE ville_ID = '$ID_ville'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	@mysql_free_result($resultat);
	return $rub;
}
function get_smur($connexion,$secteur_smur)
{
	$requete="SELECT secteur_smur_nom FROM secteur_smur WHERE secteur_smur_ID = '$secteur_smur'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	@mysql_free_result($resultat);
	return $rub[secteur_smur_nom];
}

function liste_smur($connexion,$item_select,$langue)
{
	$requete="SELECT secteur_smur_ID,secteur_smur_nom FROM secteur_smur";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"smur_id\" size=\"1\">");
	$mot = $string_lang['NO_SELECT'][$langue];
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[secteur_smur_ID]\" ");
		if($item_select == $rub[secteur_smur_ID]) print(" SELECTED");
		print("> $rub[secteur_smur_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	est_apa_disponible()Renvoie le nb de véhicules disponibles pour une entreprise donnée
//						$connexion	variable de connexion
//						$ID_APA		ID de l'organisme
//						Au retour renvoie le nb de véhicules dispo
//=============================================================================
function est_apa_disponible($connexion,$ID_APA)
{
	$requete="SELECT COUNT(*),Vec_Maj FROM vecteur WHERE org_ID = '$ID_APA' AND Vec_Etat ='3' GROUP BY org_ID";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	@mysql_free_result($resultat);
	//return $rub[0];
	return $rub;
}
//=============================================================================
//	apa_du_secteur()	Affiche les entreprises APA d'un secteur donné et le
//					nombre de vecteurs disponibles
//					$connexion	variable de connexion
//					$ID_Secteur		n° zone
//					Au retour renvoie le nb de véhicules dispo
//=============================================================================
function apa_du_secteur($connexion,$ID_Secteur)
{
	$requete=	"SELECT DISTINCT (org_nom)
				FROM vecteur,organisme,commune
				WHERE Vec_Etat ='3'
				AND organisme_type_ID = '4'
				AND vecteur.org_ID = organisme.org_ID
				AND organisme.com_ID = commune.com_ID
				AND commune.secteur_apa_ID = '$ID_Secteur'
				";
	$requete=	"SELECT DISTINCT (org_nom),org_ID
				FROM organisme,commune
				WHERE organisme_type_ID = '4'
				AND organisme.com_ID = commune.com_ID
				AND commune.secteur_apa_ID = '$ID_Secteur'
				";
				//print($requete);
	$resultat = ExecRequete($requete,$connexion);
	//print("<select name=\"commune_id\" size=\"1\">");
	//$mot = $string_lang['NO_SELECT'][$langue];
	//print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			//print("<OPTION VALUE=\"$rub[com_ID]\" ");
			//if($item_select == $rub[com_ID]) print(" SELECTED");
			//print("> $rub[com_nom] </OPTION> \n");
			print($rub[org_nom]." (");
			$n=est_apa_disponible($connexion,$rub[org_ID]);
			print($n[0]);
			print(")<BR>");

	}
	@mysql_free_result($resultat);
	return $rub;
}
//=============================================================================
//	liste_apa_du_secteur()	Renvoie les entreprises APA d'un secteur donné sous forme d'une liste déroulante'
//						$connexion	variable de connexion
//						$ID_Secteur		n° zone
//						$entreprise_ID contient le n° de l'entreprise sélectionnée'
//=============================================================================
function liste_apa_du_secteur($connexion,$ID_Secteur,$item_select="")
{
	$requete=	"SELECT DISTINCT (org_nom),org_ID
				FROM organisme,commune
				WHERE organisme_type_ID = '4'
				AND organisme.com_ID = commune.com_ID
				AND commune.secteur_apa_ID = '$ID_Secteur'
				";
				//print($requete);
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"entreprise\" size=\"1\">");
	//$mot = $string_lang['NO_SELECT'][$langue];
	$mot="choisir";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[org_ID]\" ");
			if($item_select == $rub[org_ID]) print(" SELECTED");
			print("> $rub[org_nom] </OPTION> \n");

	}
	@mysql_free_result($resultat);
	return $rub;
}
//=============================================================================
//	est_apa_disponible()Renvoie le nb de véhicules disponibles pour une entreprise donnée
//						$connexion	variable de connexion
//						$ID_APA		ID de l'organisme
//						Au retour renvoie le nb de véhicules dispo
//=============================================================================
function est_secteur_disponible($connexion,$ID_Secteur)
{/*
	$requete=	"SELECT COUNT(*)
				FROM vecteur,organisme,adresse,commune
				WHERE Vec_Etat ='3'
				AND organisme_type_ID = '4'
				AND vecteur.org_ID = organisme.org_ID
				AND organisme.adresse_ID = adresse.ad_ID
				AND adresse.com_ID = commune.com_ID
				AND commune.secteur_apa_ID = '$ID_Secteur'
				";*/
	$requete=	"SELECT COUNT(*)
				FROM vecteur,organisme,commune
				WHERE Vec_Etat ='3'
				AND organisme_type_ID = '4'
				AND vecteur.org_ID = organisme.org_ID
				AND organisme.com_ID = commune.com_ID
				AND commune.secteur_apa_ID = '$ID_Secteur'
				";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	@mysql_free_result($resultat);
	return $rub[0];
}
//=============================================================================
//	SelectIntervenant()	Crée une liste déroulante avec la liste des Intervenants
//						possibles
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'organisme sélectionné
//						Au retour, $personnelID contient le type_ID
//=============================================================================
function SelectIntervenant($connexion,$item_select,$langue)
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT Pers_ID,Pers_nom,Pers_Prenom FROM personnel ORDER BY Pers_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"personnelID\" size=\"1\">");
	$mot = $string_lang['ALL_ETATS'][$langue];
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[Pers_ID]\" ");
		if($item_select == $rub[Pers_ID]) print(" SELECTED");
		print(">$rub[Pers_nom]  $rub[Pers_Prenom]</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//========================================================================
//	ChercheIntervenant	Cherche un intervenant avec le N° identification
//					$id n° identification de la personne
//					$ variable de connexion
//					$resultat contient toutes les données d'une ligne sous
//					forme d'un tableau
//========================================================================
function ChercheIntervenant($id,$connexion)
{
	$requete = "SELECT * FROM personnel WHERE Pers_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	return LigneSuivante($resultat);
}
//=============================================================================
//	SelectTypeIntervenant()Crée une liste déroulante avec la liste des types
//						 d'intervenants possibles
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'intervenant sélectionné
//						Au retour, perso_type_ID contient le type_ID de la catégorie
//=============================================================================
function SelectTypeIntervenant($connexion,$item_select,$langue)
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT perso_cat_ID,perso_cat_nom FROM perso_cat";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"perso_type_ID\" size=\"1\">");
	$mot = $string_lang['ALL_ETATS'][$langue];
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[perso_cat_ID]\" ");
		if($item_select == $rub[perso_cat_ID]) print(" SELECTED");
		print(">$rub[perso_cat_nom]</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//========================================================================
//	Table_Intervenants	Affiche l'état des intervenants sous forme d'une table
//	$connexion			variable de connexion
//	$type	Si = 0 (valeur par défaut)affiche tous les types. Snon désigne
//			la catégorie professionnelle (médecin, IDE..)
//========================================================================
function Table_Intervenants($connexion,$type="",$organisme="",$service="",$alerte="",$langue)
{
	require 'utilitaires/globals_string_lang.php';
	print("<SCRIPT>");
	print("function coche(objet,checked){");
	// maj et checked sont des variables cachées de la forme Intervenants (cf intervenants_selection))
	print("document.Intervenants.maj.value = objet;");
	print("document.Intervenants.checked.value = checked;");
	print("document.Intervenants.submit();");
	print("}");
	print("</SCRIPT>");
	TblDebut(0,"100%");
	$_style = "A2";
	TblDebutLigne("$_style");
		$modifier = StrToUpper($string_lang['MODIFIER'][$langue]);
		TblCellule("<B>$modifier</B>");
		$mot = StrToUpper($string_lang['NOM'][$langue]);
		TblCellule("<B>$mot</B>");
		$mot = StrToUpper($string_lang['PRENOM'][$langue]);
		TblCellule("<B>$mot</B>");
		$mot = StrToUpper($string_lang['ALERTE'][$langue]);
		TblCellule("<B>$mot</B>");
		$mot = StrToUpper($string_lang['ARRIVE'][$langue]);
		TblCellule("<B>$mot</B>");
		$mot = StrToUpper($string_lang['AFFECTE'][$langue]);
		TblCellule("<B>$mot</B>");
		$mot = StrToUpper($string_lang['TEL 1'][$langue]);
		TblCellule("<B>TEL 1</B>");
		$mot = StrToUpper($string_lang['TEL 2'][$langue]);
		TblCellule("<B>TEL 2</B>");
		$mot = StrToUpper($string_lang['TEL 3'][$langue]);
		TblCellule("<B>TEL 3</B>");
	TblFinLigne();

	// lire les enregistrements
	$requete="SELECT * FROM personnel ";
	if($type != '0')
	{
		$requete= $requete."WHERE perso_cat_ID = '$type' ";
	}
	else $requete= $requete."WHERE perso_cat_ID LIKE '%' ";
	if($organisme)
		$requete= $requete."AND org_ID = '$organisme' ";
	if($service)
		$requete= $requete." AND service_ID = '$service' ";
	if($alerte)
	{
		$requete= $requete." AND alerte <> 'o' ORDER BY delai_route ASC";
	}
	else
		$requete = $requete." ORDER BY Pers_Nom ASC";
	//print($requete."<BR>");
	$resultat = ExecRequete($requete,$connexion);
	$_style = "A5";
	$modifier=StrToLower($modifier);
	while($i = LigneSuivante($resultat))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		TblDebutLigne("$_style");

		// Affichage des données de la ligne
		$identifiant = $i->Pers_ID;
		TblCellule("<a href=\"intervenant_saisie.php?personnelID=$identifiant
		&back=intervenants_selection.php
		&type=$type
		&organisme=$organisme
		&alerte=$alerte
		\">$modifier</a>");
		//TblCellule("zzz");
		TblCellule("$i->Pers_Nom");
		TblCellule("$i->Pers_Prenom");
		if($i->alerte=="o")
			TblCellule("<INPUT TYPE=\"CHECKBOX\" CHECKED onClick='coche($i->Pers_ID,0)'>");//name=\"cb\" VALUE=\"$i->Pers_ID\"
		else
			TblCellule("<INPUT TYPE=\"CHECKBOX\" onClick='coche($i->Pers_ID,1)'>");

		if($i->arrive=="o")
			TblCellule("<INPUT TYPE=\"CHECKBOX\" CHECKED onClick='coche_arrive($i->Pers_ID,0)'>");//name=\"cb\" VALUE=\"$i->Pers_ID\"
		else
			TblCellule("<INPUT TYPE=\"CHECKBOX\" onClick='coche_arrive($i->Pers_ID,1)'>");
		// affectation ?
		if($i->localisation_ID > 0)
		{
			$requete = "SELECT local_nom FROM localisation WHERE localisation_ID = '$i->localisation_ID'";
			$resultat2 = ExecRequete($requete,$connexion);
			$k = LigneSuivante($resultat2);
			TblCellule("$k->local_nom");
		}
		else
			TblCellule(" ");

		$requete = "SELECT valeur,confidentialite_ID
			FROM contact
			WHERE identifiant_contact = '$identifiant'
			AND nature_contact_ID ='1'
			AND type_contact_ID IN('1','2','4')
			ORDER BY type_contact_ID DESC";
		$resultat3 = ExecRequete($requete,$connexion);
		for($i=0;$i<3;$i++)
		//while($rub=mysql_fetch_array($resultat3))
		{
			$rub=mysql_fetch_array($resultat3);
			if(!$rub['valeur']) $rub['valeur']="&nbsp;";
			/*
			if($rub['confidentialite_ID']>2)
				TblCellule("**********");
			else
			*/
				TblCellule(NumTel($rub['valeur']));
		}
		TblFinLigne();
	}
	TblFin();
}
//=============================================================================
//	SelectSecteurs()	Crée une liste déroulante avec la liste des secteurs
//						ambulances privées
//						$connexion 		variable de connexion
//						$item_select	type_ID du secteur
//						Au retour, secteur_ID contient le type_ID du secteur
//=============================================================================
function SelectSecteur($connexion,$item_select)
{
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT secteur_apa_ID,secteur_apa_nom FROM secteur_apa ORDER BY secteur_apa_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"secteur_apa_ID\" size=\"1\">");
	$mot = 'Aucun secteur';
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[secteur_apa_ID]\" ");
		if($item_select == $rub[secteur_apa_ID]) print(" SELECTED");
		print(">$rub[secteur_apa_nom]</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
/**
* Liste des secteurs contenus dans la table secteur_adps
* @param $connexion paramètres de connexion
* @param $item_select item sélectionné par défaut
* @return secteur_ID n° du secteur sélectionné
*/
function SelectSecteurPds($connexion,$item_select)
{
	$requete="SELECT secteur_adps_ID,secteur_adps_nom FROM secteur_adps ORDER BY secteur_adps_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"secteur_pds_ID\" size=\"1\">");
	$mot = 'Aucun secteur';
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[secteur_adps_ID]\" ");
		if($item_select == $rub[secteur_adps_ID]) print(" SELECTED");
		print(">$rub[secteur_adps_nom]</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	ListeCommunes()	Crée un tableau des communes d'un secteur ambulances privées
//						$connexion 		variable de connexion
//						$item_select	type_ID du secteur
//						$secteur		nature du secteur: apa,pds
//=============================================================================
function Liste_des_communes($connexion,$item_select,$secteur='apa')
{
	TblDebut(0,"50%");
	$_style = "A2";
	TblDebutLigne("$_style");
		TblCellule("<B>INSEE</B>");
		TblCellule("<B>Commune</B>");
	TblFinLigne();
	// lire les enregistrement
	if($secteur=='apa')
		$requete="SELECT com_ID, com_nom FROM commune WHERE secteur_apa_ID = '$item_select' ";
	else if($secteur=='pds')
		$requete="SELECT com_ID, com_nom FROM commune WHERE secteur_adps_ID = '$item_select' ";
	$resultat = ExecRequete($requete,$connexion);
	$_style = "A5";
	while($rub=mysql_fetch_array($resultat))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		TblDebutLigne("$_style");
		TblCellule($rub['com_ID']);
		TblCellule($rub['com_nom']);
		TblFinLigne();
	}
	@mysql_free_result($resultat);
}
//================================================================================================
//	select_medicalisation()		Crée une liste déroulante avec les modes de médicalisation
//		$connexion 	variable de connexion
//		$item_select	mode de médicalisation sélectionné
//		Au retour $devenir contient le mode de médicalisation sélectionné
//================================================================================================
function select_medicalisation($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT medicalisation_ID,medicalisation_nom FROM medicalisation";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"devenir\" size=\"1\" onChange='$onChange'>");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[medicalisation_ID]\" ");
			if($item_select == $rub['medicalisation_ID']) print(" SELECTED");
			print("> $rub[medicalisation_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_contamination()	Crée une liste déroulante
//		$connexion variable de connexion
//		$item_select	conta_ID sélectionné
//		Au retour $name contient l'conta_ID sélectionné
//=======================================================================================
function select_contamination($connexion,$item_select,$langue,$name,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	//$requete="SELECT Hop_ID,hop_nom FROM hopital";
	$requete="SELECT conta_ID,conta_nom FROM contamination";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"$name\" size=\"1\" onChange='$onChange'>");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[conta_ID]\" ");
			if($item_select == $rub['conta_ID']) print(" SELECTED");
			print("> $rub[conta_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_gravite()	Crée une liste déroulante de gravité
//		$connexion variable de connexion
//		$item_select	gravite_ID sélectionné
//		Au retour $gravite contient l'conta_ID sélectionné
//=======================================================================================
function select_gravite($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT gravite_ID,gravite_nom FROM gravite";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"gravite\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE=\"0\">-- ? --</OPTION> \n ");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[gravite_ID]\" ");
			if($item_select == $rub['gravite_ID']) print(" SELECTED");
			print("> $rub[gravite_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_ville()	Crée une liste déroulante des villes
//		$connexion variable de connexion
//		$item_select	ville_ID sélectionné
//		Au retour id_ville contient l'ville_ID sélectionné
//=======================================================================================
function select_ville($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT ville_ID,ville_nom,ville_zip FROM ville ORDER BY ville_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"id_ville\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE=\"0\">--nouvelle--</OPTION> \n ");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[ville_ID]\" ");
			if($item_select == $rub['ville_ID']) print(" SELECTED");
			if(!$rub['ville_zip']) $rub['ville_zip']="00000";
			$mot=$rub['ville_zip']." ". Security::db2str($rub['ville_nom']);
			print(">$mot</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
// fait la même chose sauf que le nom de la variable de retour peut être modifée par l'appelant
// sinon retourne id_ville par défaut
function select_ville2($connexion,$item_select,$langue,$onChange="",$name="id_ville")
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT ville_ID,ville_nom,ville_zip FROM ville ORDER BY ville_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"$name\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE=\"0\">--nouvelle--</OPTION> \n ");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[ville_ID]\" ");
			if($item_select == $rub['ville_ID']) print(" SELECTED");
			if(!$rub['ville_zip']) $rub['ville_zip']="00000";
			$mot=$rub['ville_zip']." ".$rub['ville_nom'];
			print(">$mot</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
/**
*	Crée une liste de villes appartenants aux départements passés dans le tableau $departement
*	$dep="'67','57'"; par exemple 
*	@return villeID
*	modifié le 17/8/2011: ajout de villeID à la place de $name
*/
function select_ville_dep($connexion,$item_select,$dep,$onChange="")
{
	$requete="SELECT ville_ID,ville_nom,ville_zip FROM ville WHERE departement_ID IN (".$dep.") ORDER BY ville_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"villeID\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE=\"0\">--nouvelle--</OPTION> \n ");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[ville_ID]\" ");
			if($item_select == $rub['ville_ID']) print(" SELECTED");
			if(!$rub['ville_zip']) $rub['ville_zip']="00000";
			$mot=$rub['ville_zip']." ".$rub['ville_nom'];
			print(">$mot</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_zone()	Crée une liste déroulante des zones
//		$connexion variable zone_ID sélectionné
//		Au retour id_zone contient la zone_ID sélectionnée
//=======================================================================================
function select_zone($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT zone_ID,zone_nom FROM zone ORDER BY zone_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"id_zone\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE=\"0\">--nouvelle--</OPTION> \n ");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[zone_ID]\" ");
			if($item_select == $rub['zone_ID']) print(" SELECTED");
			print("> $rub[zone_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_territoire()	Crée une liste déroulante des zones
//		$connexion variable zone_ID sélectionné
//		Au retour id_zone contient la zone_ID sélectionnée
//=======================================================================================
function select_territoire_sante($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT territoire_ID,territoire_nom FROM territoire ORDER BY territoire_ID";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"id_territoire\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE=\"0\">--nouvelle--</OPTION> \n ");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[territoire_ID]\" ");
			if($item_select == $rub['territoire_ID']) print(" SELECTED");
			print("> $rub[territoire_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_zone_proximite()	Crée une liste déroulante des zones
//		$connexion variable zone_ID sélectionné
//		Au retour id_zone contient la zone_ID sélectionnée
//=======================================================================================
function select_zone_proximite($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT z_proximite_ID,z_proximite_nom FROM zone_proximite ORDER BY z_proximite_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"id_zone_p\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE=\"0\">--nouvelle--</OPTION> \n ");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[z_proximite_ID]\" ");
			if($item_select == $rub['z_proximite_ID']) print(" SELECTED");
			print("> $rub[z_proximite_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_region()	Crée une liste déroulante des régions
//		$connexion variable region_ID sélectionné
//		Au retour id_region contient la region_ID sélectionnée
//=======================================================================================
function select_region($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT region_ID,region_nom FROM region ORDER BY region_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"id_region\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE=\"0\">--nouvelle--</OPTION> \n ");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[region_ID]\" ");
			if($item_select == $rub['region_ID']) print(" SELECTED");
			print("> $rub[region_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_pays()	Crée une liste déroulante des pays
//		$connexion variable region_ID sélectionné
//		Au retour id_pays contient le pays_ID sélectionnée
//=======================================================================================
function select_pays($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT pays_ID,pays_nom FROM pays ORDER BY pays_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"id_pays\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE=\"0\">--nouveau--</OPTION> \n ");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[pays_ID]\" ");
			if($item_select == $rub['pays_ID']) print(" SELECTED");
			print("> $rub[pays_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_type_etablissement()	Crée une liste déroulante des types
//		$connexion variable de connexion
//		$item_select	type_etablissement_ID sélectionné
//		Au retour id_type_etablissement contient le type_etablissement_ID sélectionné
//=======================================================================================
function select_type_etablissement($connexion,$item_select,$langue,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT type_etablissement_ID,type_etablissement_nom FROM type_etablissement";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"id_type_etablissement\" size=\"1\" onChange='$onChange'>");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[type_etablissement_ID]\" ");
			if($item_select == $rub['type_etablissement_ID']) print(" SELECTED");
			print("> $rub[type_etablissement_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	select_territoire()	Crée une liste déroulante avec la liste des communes
//				appartenant au territoire d'une APA
//				$connexion variable de connexion
//				$item_select	Hop_ID de l'hopital sélectionné
//				Au retour $territoire_id contient l'ID de la commune sélectionné
//=============================================================================
function select_territoire($connexion,$organisme,$langue,$change="")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT apa_territoire.com_ID,delai,com_nom
			FROM apa_territoire,commune
			WHERE org_ID = '$organisme'
			AND commune.com_ID = apa_territoire.com_ID
			ORDER BY com_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"territoire_id\" size=\"10\" onChange='$change'>");
	while($rub=mysql_fetch_array($resultat))
	{
		$mot = $rub['com_nom']." (".$rub['delai'].")";
		print("<OPTION VALUE=\"$rub[com_ID]\"> $mot </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	select_specialite()
//=============================================================================
/**
*Affiche un eliste déroulante des spécialités.
*Les données sont contenues dans la table specialite.Si le niveau d'autorisation est
*inférieur à 2, la liste ne condiendra q'un seul item
*@package utilitairesHTML.php
*@return int ID_specialite: specialite_ID sélectionnée
*@param string variable de connexion.
*@param int ID de la spécialité courante.
*@param string langue ou pays courant.
*@param string action à entreprendre si la sélection change (facultatif).
*@version 1.0
*/
function select_specialite($connexion,$item_select,$langue,$change="")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT specialite_ID, specialite_nom FROM specialite";
	if($_SESSION["autorisation"]>1)
		$requete .=" ORDER BY specialite_nom";
	else
		$requete .=" WHERE specialite_ID = '$special'";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_specialite\" size=\"1\" onChange='$change'>");

	if($langue)
		$mot = $string_lang['AUTRE'][$langue];
	else
		$mot = "[autre]";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		$mot = $rub['specialite_nom'];
		print("<OPTION VALUE=\"$rub[specialite_ID]\" ");
		if($item_select == $rub['specialite_ID']) print(" SELECTED");
		print("> $mot </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	evenement_courant()
//=============================================================================
/**
*Retourne les caractéristiques de l'évènement courant sous forme d'un tableau.
*@package utilitairesHTML.php
*@return array tableau de valeurs
*@param string variable de connexion.
*@param int identifiant de l'évènement.
*@version 1.0
*/
function evenement_courant($connexion,$evenement_ID)
{
	// évènement courant
	$requete = "SELECT * FROM evenement WHERE evenement_ID = '$evenement_ID'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	@mysql_free_result($resultat);
	return $rub;
}
//=============================================================================
/**
*SelectDepartement()	Crée une liste déroulante avec la liste des départements
*@package utilitairesHTML.php
*@param	$connexion variable de connexion
*@param	$item_select	service_ID du service sélectionné
*@param	$multiple: autorise ou non la sélection multiple. Si $multiple est > 0
		$multiple indique le nombre de lignes à afficher.
*@return	Au retour $depart contient le service_ID du service sélectionné
*		En cas de sélection multiple retourne le tableau $depart[]
*@version 1.0
*/
//=============================================================================
function SelectDepartement($connexion,$item_select,$langue,$multiple=0)
{
	// lit la liste des hôpitaux dans la base de données
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT departement_ID,departement_nom,region_nom
			FROM departement,region
			WHERE departement.region_ID = region.region_ID
			ORDER BY region_nom";
	$resultat = ExecRequete($requete,$connexion);
	if($multiple)
		print("<select name=\"depart[]\" size=\"$multiple\" multiple>");
	else
		print("<select name=\"depart\" size=\"1\"");
	$mot = $string_lang['TOUS'][$langue];
	print("<OPTION VALUE = \"0\">-- $mot --</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[departement_ID]\" ");
			if($item_select == $rub['departement_ID']) print(" SELECTED");
			$mot=$rub['departement_nom']." (".$rub['departement_ID'].") ".$rub['region_nom'];
			print(">$mot</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectTypeOrganisme()Crée une liste déroulante avec la liste des types
//						 d'Organismes possibles
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'organisme sélectionné
//						Au retour, localisation_type contient le type_ID
//=============================================================================
function SelectStructureTemporaire($connexion,$item_select,$langue) //localisation_type
{
	require 'utilitaires/globals_string_lang.php';
	require_once("login/init_security.php");
	// lit la liste des hôpitaux dans la base de données
	$requete="SELECT ts_ID,ts_nom FROM temp_structure WHERE ts_active ='o' ORDER BY ts_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"localisation_type\" size=\"1\">");
	//$mot = $string_lang['AUCUN'][$langue];
	$mot="--- ? ---";
	print("<OPTION VALUE = \"20\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[ts_ID]\" ");
		if($item_select == $rub['ts_ID']) print(" SELECTED");
		print(">".Security::db2str($rub[ts_nom])."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectStatus()Crée une liste déroulante avec la liste des status possibles
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'organisme sélectionné
//						Au retour, status_type contient le status_ID
//=============================================================================
function SelectStatus($connexion,$item_select,$langue) //status_type
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT * FROM victime_status";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"status_type\" size=\"1\">");
	//$mot = $string_lang['AUCUN'][$langue];
	$mot="Inconnu";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[victime_status_ID]\" ");
		if($item_select == $rub['victime_status_ID']) print(" SELECTED");
		print(">$rub[victime_status_nom]</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectStatus()Crée une liste déroulante avec la liste des fonctions
//			$connexion 		variable de connexion
//			$item_select	fonction_ID de l'organisme sélectionné
//			Au retour, id_fonction contient le type_ID
//=============================================================================
function SelectFonction($connexion,$item_select,$langue) //id_fonction
{
	require 'utilitaires/globals_string_lang.php';
	$requete="SELECT * FROM fonction";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"id_fonction\" size=\"1\">");
	//$mot = $string_lang['AUCUN'][$langue];
	$mot="Inconnu";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[fonction_ID]\" ");
		if($item_select == $rub['fonction_ID']) print(" SELECTED");
		print(">$rub[fonction_nom]</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectMG67()Crée une liste déroulante avec la liste des médecins du BR
//			$connexion 		variable de connexion
//			$item_select	fonction_ID de l'organisme sélectionné
//			Au retour, med_id contient le type_ID du médecin
//=============================================================================
function SelectMG67($connexion,$item_select) //med_id
{
	$requete="SELECT med_ID, med_nom, med_adresse FROM mg67 ORDER BY med_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"med_id\" size=\"1\">");
	$mot="Inconnu";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[med_ID]\" ");
		if($item_select == $rub['med_ID']) print(" SELECTED");
		print(">".$rub['med_nom']."  ".$rub['med_adresse']."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

//=============================================================================
//	SelectGroupe()Crée une liste déroulante avec la liste des groupes de discipline
//			$connexion 		variable de connexion
//			$item_select	fonction_ID de l'organisme sélectionné
//			Au retour, groupe_id contient le type_ID du groupe
//=============================================================================
function SelectGroupe($connexion,$item_select) //groupe_id
{
	$requete="SELECT groupe_ID, groupe_nom FROM groupe_discipline ORDER BY groupe_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"id_groupe\" size=\"1\">");
	$mot="Inconnu";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[groupe_ID]\" ");
		if($item_select == $rub['groupe_ID']) print(" SELECTED");
		print(">".$rub['groupe_nom']."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectGroupe()Crée une liste déroulante avec la liste des groupes de discipline
//			$connexion 		variable de connexion
//			$item_select	fonction_ID de l'organisme sélectionné
//			Au retour, groupe_id contient le type_ID du groupe
//=============================================================================
function SelectDiscipline($connexion,$item_select) //discipline_id
{
	$requete="SELECT discipline_ID, discipline_nom FROM discipline ORDER BY discipline_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"id_discipline\" size=\"1\">");
	$mot="Inconnu";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[discipline_ID]\" ");
		if($item_select == $rub['discipline_ID']) print(" SELECTED");
		print(">".$rub['discipline_nom']."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

//=============================================================================
//	SelectGroupe()Crée une liste déroulante avec la liste des groupes de discipline
//			$connexion 		variable de connexion
//			$item_select	fonction_ID de l'organisme sélectionné
//			Au retour, groupe_id contient le type_ID du groupe
//=============================================================================
function SelectCentrale($connexion,$item_select) //id_centrale
{
	$requete="SELECT centrale_ID, centrale_nom FROM centrale ORDER BY centrale_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"id_centrale\" size=\"1\">");
	$mot="Inconnu";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[centrale_ID]\" ");
		if($item_select == $rub['centrale_ID']) print(" SELECTED");
		print(">".$rub['centrale_nom']."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	setOuiNon()	Crée une liste déroulante avec oui et non
//		$connexion 		variable de connexion
//		$item_select	'o' ou 'n'
//		Au retour, $o_n contient 'o' ou 'n'
//=============================================================================
function setOuiNon($connexion,$item_select,$langue="FR")
{	

	require 'utilitaires/globals_string_lang.php';
	?>
	<SELECT NAME ="o_n" size="1">
		<option value="o" <?php if($item_select == 'o') print(" SELECTED");?> ><?php echo $string_lang['OUI'][$langue];?></option>
		<option value="n" <?php if($item_select == 'n') print(" SELECTED");?> ><?php echo $string_lang['NON'][$langue];?></option>
	</select>
	<?php
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

?>
