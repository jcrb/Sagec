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
/**													
*	programme: 			liste_victime.php
*	date de création: 	15/06/2003
*	@author:			jcb
*	description:		Affiche la liste des victimes
*	@version:			1.3 - $Id: liste_victime.php 14 2006-10-04 09:30:25Z jcb $
*	maj le:				15/08/2005: affiche uniquement les victimes en rapport avec l'évènement courant
*	@package			Sagec
*/
//--------------------------------------------------------------------------------------------------------
session_start();
if(!$_SESSION['auto_sagec'] && !$_SESSION['auto_victime'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("login/init_security.php");
	
?>
<HTML>
	<HEAD>
		<TITLE>Connexion à MySQL</TITLE>
		<LINK REL=stylesheet HREF="pma.css" TYPE ="text/css">
		<link rel="shortcut icon" href="../images/sagec67.ico" />
	</HEAD>
<BODY>

<?php
require("pma_constantes.php");
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require("utilitaires/table.php");
require("en_tete.php");
require("utilitairesHTML.php");
require 'utilitaires/globals_string_lang.php';
require 'date.php';

function cellule($mot,$langue)
{
	require 'utilitaires/globals_string_lang.php';
	$mot = $string_lang[$mot][$langue];
	TblCellule("<B>$mot</B>");
}

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$event = evenement_courant($connexion,$_SESSION['evenement']);
entete($member_id,$langue);
print($event['evenement_nom'].": ");
$mot = dateHeureComplete(time(),$langue);
print($mot);

$tri=$_GET['tri'];//	

/**
SELECT 
	victime_ID,nom,prenom,no_ordre,sexe,age1,age2,gravite,localisation_ID,Hop_ID,service_ID,conta_N,conta_B,
	conta_C,gravite_couleur,gravite_nom,pays_nom
	*/
$requete="SELECT *  
 	FROM victime,gravite,pays
 	WHERE gravite = gravite_ID
 	AND victime.pays_ID = pays.pays_ID 
	";

	$requete .= " AND evenement_ID = '$_SESSION[evenement]' ";// uniuement évènement courant

	switch($tri)
		{
			case 'id':$requete.="ORDER BY victime_ID";break;
			case 'nom':$requete.="ORDER BY nom";break;
			case 'prenom':$requete.="ORDER BY prenom";break;
			case 'sexe':$requete.="ORDER BY sexe";break;
			case 'age':$requete.="ORDER BY age2,age1";break;
			case 'gravite':$requete.="ORDER BY gravite";break;
			case 'position':$requete.="ORDER BY localisation_ID";break;
			case 'service':$requete.="ORDER BY service_ID";break;
			case 'hop':$requete.="ORDER BY Hop_ID";break;
			case 'pays':$requete.="ORDER BY Hop_ID";break;
			case 'nationalite':$requete.="ORDER BY pays_nom";break;
			default:$requete.="ORDER BY victime_ID";
		}
$resultat = ExecRequete($requete,$connexion); 

TblDebut(0,"100%");
$_style = "A2";
TblDebutLigne("$_style");
	cellule("n°",$langue);
	if($_SESSION['auto_sagec'])
		cellule("MODIFIER",$langue);
	//cellule("N°",$langue);
	$mot = StrToUpper($string_lang['NOM'][$langue]);
	TblCellule("<a href=\"liste_victime.php?tri=id\"><B>N°</B></a>");
	cellule("",$langue);
	//cellule("NOM",$langue);
	$mot = StrToUpper($string_lang['NOM'][$langue]);
	TblCellule("<a href=\"liste_victime.php?tri=nom\"><B>$mot</B></a>");
	//cellule("PRENOM",$langue);
	$mot = StrToUpper($string_lang['PRENOM'][$langue]);
	TblCellule("<a href=\"liste_victime.php?tri=prenom\"><B>$mot</B></a>");
	//cellule("SEXE",$langue);
	$mot = StrToUpper($string_lang['SEXE'][$langue]);
	TblCellule("<a href=\"liste_victime.php?tri=sexe\"><B>$mot</B></a>");
	//cellule("AGE",$langue);
	$mot = StrToUpper($string_lang['AGE'][$langue]);
	TblCellule("<a href=\"liste_victime.php?tri=age\"><B>$mot</B></a>");

	$mot = StrToUpper($string_lang['PAYS'][$langue]);
	TblCellule("<a href=\"liste_victime.php?tri=nationalite\"><B>$mot</B></a>");

	//cellule("GRAVITE",$langue);
	$mot = StrToUpper($string_lang['GRAVITE'][$langue]);
	TblCellule("<a href=\"liste_victime.php?tri=gravite\"><B>$mot</B></a>");
	//cellule("POSITION",$langue);
	$mot = StrToUpper($string_lang['POSITION'][$langue]);
	TblCellule("<a href=\"liste_victime.php?tri=position\"><B>$mot</B></a>");
	//cellule("HOPITAL",$langue);
	$mot = StrToUpper($string_lang['HOPITAL'][$langue]);
	TblCellule("<a href=\"liste_victime.php?tri=hop\"><B>$mot</B></a>");
	// pays
	$mot = StrToUpper($string_lang['PAYS'][$langue]);
	TblCellule("<a href=\"liste_victime.php?tri=pays\"><B>$mot</B></a>");
	//cellule("SERVICE",$langue);
	$mot = StrToUpper($string_lang['SERVICE'][$langue]);
	TblCellule("<a href=\"liste_victime.php?tri=service\"><B>$mot</B></a>");
TblFinLigne();

$_style = "A1";
$compteur = 1;
while($victime = LigneSuivante($resultat))
{
	//if($_style=="A1")$_style="A0";
	//else $_style="A1";
	//TblDebutLigne("$_style");// $_style
	
	$c = "#".$victime->gravite_couleur;
	print("<TR bgcolor=\"$c\" class=\"Style23\">");
	// numérotation de la ligne 
	print("<td>$compteur</td>");
	$compteur++;
	// MODFIER: on appelle Tri2 avec comme paramètre le n° d'ordre contenu
	// dans la variable 'identifiant' qui est attendue par Tri2
	$identifiant = $victime->no_ordre;
	if($_SESSION['auto_sagec'])
	{
		$mot = $string_lang['MODIFIER'][$langue];
		TblCellule("<a href=\"victimes_saisie.php?identifiant=$identifiant\">$mot</a>");
	}
	// Affichage des données de la ligne
	TblCellule("$victime->no_ordre");
	print("<TD>");
		if($victime->conta_N > 1)
		{
		$image = "photos/radio.jpeg";
		print("<img src=\"$image\" alt=\"chim\" height=\"18\" width=\"20\"align=\"middle\" border=\"0\">");
		}
		if($victime->conta_B > 1)
		{
		$image = "photos/biotox.jpeg";
		print("<img src=\"$image\" alt=\"chim\" height=\"18\" width=\"20\"align=\"middle\" border=\"0\">");
		}
		if($victime->conta_C > 1)
		{
		$image = "photos/biotox.jpeg";
		print("<img src=\"$image\" alt=\"chim\" height=\"18\" width=\"20\"align=\"middle\" border=\"0\">");
		}
	print("</TD>");

	TblCellule("$victime->nom");
	TblCellule("$victime->prenom");
	$sexe = $item_sexe[$victime->sexe];
	$mot = $string_lang[$sexe][$langue];
	TblCellule("$mot");
	if($victime->age1=='0')
	{
		$mot = $string_lang[strtoupper($victime->age2)][$langue];
		TblCellule($mot);
	}
	else TblCellule("<div align=\"center\">$victime->age1</div>");
	// pays d'origine
	TblCellule("<div align=\"center\">$victime->pays_nom</div>");
	//$gravite = $item_gravite2[$victime->gravite];
	TblCellule("<div align=\"center\">$victime->gravite_nom</div>");
	//$requete="SELECT local_nom FROM localisation WHERE localisation_ID = '$victime->localisation_ID'";
	$requete="SELECT ts_nom FROM temp_structure WHERE ts_ID = '$victime->localisation_ID'";
	$resultat2 = ExecRequete($requete,$connexion);
	$localisation = LigneSuivante($resultat2);
	//$mot = $string_lang[strtoupper($localisation->local_nom)][$langue];
	$mot = $localisation->ts_nom;
	TblCellule("<div align=\"center\">".$mot."</div>");
	
	//$hopital = ChercheNomHopital($victime->Hop_ID,$connexion);
	//TblCellule($hopital->Hop_nom);
	
	$rub = ChercheVilleHopital($victime->Hop_ID,$connexion);
	print("<td>[".$rub['ville_nom']."] ".Security::db2str($rub['Hop_nom'])."</td>");
	print("<td>".$rub['iso2']."</td>");
	
	$service = ChercheService($victime->service_ID,$connexion);
	TblCellule(Security::db2str($service->service_nom));
	TblFinLigne();
}
TblFin();
//echo("<B>$med->nom_med</B>"."  ".$med->nom_famille."<BR>\n");
?>
	</BODY>
</HTML>
