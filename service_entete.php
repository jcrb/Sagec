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
//	programme: 			service_entete.php		
//	date de création: 	25/12/2003		
//	auteur:				jcb										
//	description:		
//  s'inspire de:															 			
//	version:			1.0																				 
//	maj le:				25/12/2003																	 //
//																										 
//---------------------------------------------------------------------------------------------------------
// ouverture d'une session
session_start();
require 'utilitaires/globals_string_lang.php';
require("utilitaires/table.php");
require("utilitaires/html.php");

function entete_service($hopital,$service)
{
	TblDebut(0,"100%");
	// ligne 1: nom hopital et du service
		TblDebutLigne();
			TblCellule("<H2>Hôpital de ".$hopital. "</H2>",1,1,"TITRE");
			TblCellule("<H2>Service de ".$service. "</H2>",1,1,"TITRE");
			$mot = "Disponibilité le ".ma_date()." à ".heure();
			TblCellule("<B><valign=\"top\">$mot</B>");
		TblFinLigne();
	TblFin();
}

function menu_service($i="",$back="")
{
	$c=array("","","","","","");
	$c[$i]="A1";
	TblDebut(1,"100%");
		TblDebutLigne();
			//$mot = strToUpper($string_lang['LIT'][$langue]);
			$mot="Lits";
			TblCellule("<div align=\"center\"><a href=\"service_lits.php?back=$back\"><B>$mot</B></a>",1,1,"$c[1]");
			TblCellule("<div align=\"center\"><a href=\"service_personnel.php?back=$back\"><B>Personnels</B></a>",1,1,"$c[2]");
			TblCellule("<div align=\"center\"><a href=\"superviseur_lits.php?back=$back\"><B>Matériel</B></a>",1,1,"$c[3]");
			TblCellule("<div align=\"center\"><a href=\"service_synoptique.php?back=$back\"><B>Antidotes</B></a>",1,1,"$c[4]");
			TblCellule("<div align=\"center\"><a href=\"service_synoptique.php?back=$back\"><B>Antibiotiques</B></a>",1,1,"$c[5]");
			TblCellule("<div align=\"center\"><a href=\"logout.php?back=$back\"><B>Quitter</B></a>",1,1,"$c[6]");
		TblFinLigne();
	TblFin();
}

// Retourne le nom d'un service dont on connait l'identifiant
function nom_service($ID_service,$connexion)
{
	$requete = "SELECT service_nom FROM service WHERE service_ID = '$ID_service'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	return $rub[service_nom];
}

function entete_superviseur($hopital)
{
	TblDebut(0,"100%");
	// ligne 1: nom hopital et du service
		TblDebutLigne();
			TblCellule("<H2>Hôpital de ".$hopital. "</H2>",1,1,"TITRE");
			TblCellule("<H2>Supervision</H2>",1,1,"TITRE");
			$mot = "Disponibilité le ".ma_date()." à ".heure();
			TblCellule("<B><valign=\"top\">$mot</B>");
		TblFinLigne();
	TblFin();
}

function menu_superviseur($i="")
{
	$c=array("","","","","","");
	$c[$i]="A1";
	TblDebut(1,"100%");
		TblDebutLigne();
			//$mot = strToUpper($string_lang['LIT'][$langue]);
			TblCellule("<div align=\"center\"><a href=\"superviseur_synoptique.php\"><B>Synoptiques</B></a>",1,1,"$c[1]");
			TblCellule("<div align=\"center\"><a href=\"superviseur_service.php\"><B>Accès aux services</B></a>",1,1,"$c[2]");
		TblFinLigne();
	TblFin();
}
function menu_superviseur_service($i="")
{
	$c=array("","","","","","");
	$c[$i]="A1";
	TblDebut(1,"100%");
		TblDebutLigne();
			//$mot = strToUpper($string_lang['LIT'][$langue]);
			$mot="Lits";
			TblCellule("<div align=\"center\"><a href=\"superviseur_lits.php\"><B>$mot</B></a>",1,1,"$c[1]");
			TblCellule("<div align=\"center\"><a href=\"superviseur_synoptique.php\"><B>Personnels</B></a>",1,1,"$c[2]");
			TblCellule("<div align=\"center\"><a href=\"superviseur_synoptique.php\"><B>Matériel</B></a>",1,1,"$c[3]");
			TblCellule("<div align=\"center\"><a href=\"superviseur_synoptique.php\"><B>Antidotes</B></a>",1,1,"$c[4]");
			TblCellule("<div align=\"center\"><a href=\"superviseur_synoptique.php\"><B>Antibiotiques</B></a>",1,1,"$c[5]");
		TblFinLigne();
	TblFin();
}

// Crée une liste déroulante des services d'un hopital
// Le service sélectionné est retourné sous $select_service
// variables	$hopital: org ID
//				$connexion: variable de connexion
//				$item_select: valeur par défaut
//				$back: adresse de retour. Ne sert à rien pour l'instant
// Retiré pour l'instant:
// onChange=\"location.replace('service_lits.php?back=$back&select_service=$select_service')\"
//print("<select name=\"select_service\" size=\"1\" onChange=\"document.Superviseur.submit()\">");
function liste_des_services($hopital,$connexion,$item_select,$back="")
{
	$requete = "SELECT service_nom,service_ID FROM  service WHERE org_ID = '$hopital'";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"select_service\" size=\"1\" onChange=\"document.Superviseur.submit()\">");
	print("<OPTION VALUE = \"0\">[Tous les services] </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[service_ID]\" ");
		if($item_select == $rub[service_ID]) print(" SELECTED");
		print("> $rub[service_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

// Cette fonction est prévue pour ajouter une cellule dans un tableau existant
// La cellule crée comporte 2 lignes pour le téléphone et le fax
// génère 2 variables: $tel1 et $fax
function coordonnee_service()
{
	print("<TD>");
		print("<fieldset>");
		print("<legend>Coordonnées</legend>");
		TblDebut(0,"100%");
			TblDebutLigne();
				TblCellule("Tel:");
				TblCellule("<INPUT TYPE=\"TEXT\" NAME = \"tel1\" SIZE=\"10\">");
			TblFinLigne();
			TblDebutLigne();
				TblCellule("Fax:");
				TblCellule("<INPUT TYPE=\"TEXT\" NAME = \"fax\" SIZE=\"10\">");
			TblFinLigne();
		TblFin();
		print("</fieldset>");
	print("</TD>");
}

function validation($texte,$back="")
{
TblDebut(0,"100%");
	TblDebutLigne();
		TblCellule("<B>Pour être prise en compte, une modification doit toujours être validée</B>");
		TblCellule("<INPUT TYPE=\"SUBMIT\" NAME = \"OK\" VALUE=\"$texte\">");
		if($back)
			TblCellule("<A HREF = \"$back\">Retour</A>");
	TblFinLigne();
TblFin();
}

// Affiche les lits disponibles d'un hopital, ventilés par type d'activité (total des lits de
// médecine, chir, etc).
// variables	$hopital: identifiant unique de l'hopital (hop_ID)
//				$connexion: var de connexion.
// NB: si une spécialité n'existe pas, elle n'pparait pas
function synoptique_lits_par_types($hopital,$connexion)
{
	TblDebut(0,"70%");
		TblDebutLigne();
			TblCellule(" ");
			TblCellule("<DIV ALIGN=\"RIGHT\"><B>Autorisés</B></DIV>");
			print("<TD colspan=\"3\">");
			print("<DIV ALIGN=\"CENTER\" ><B>Disponibles</B></DIV></TD>");
		TblFinLigne();
		TblDebutLigne();
			TblCellule(" ");
			TblCellule(" ");
			TblCellule("<DIV ALIGN=\"RIGHT\"><B>Adultes</B></DIV>");
			TblCellule("<DIV ALIGN=\"RIGHT\"><B>Enfants</B></DIV>");
			TblCellule("<DIV ALIGN=\"RIGHT\"><B>Total</B></DIV>");
		TblFinLigne();

		$requete = "SELECT SUM(lits.lits_sp),SUM(lits.lits_dispo), type_nom
					FROM type_service, lits, service
					WHERE service.service_ID = lits.service_ID
					AND service.Type_ID = type_service.Type_ID
					AND service.org_ID = '$hopital'
					GROUP BY type_service.Type_ID
					";
					//print($requete."<BR>");
		$resultat = ExecRequete($requete,$connexion);
		while($rub=mysql_fetch_array($resultat))
		{
			TblDebutLigne();
			$nom = $rub[type_nom];
			TblCellule($nom);
			//TblCellule("<INPUT TYPE=\"TEXT\" DISABLED NAME = \"$nom\" SIZE=\"2\" VALUE = \"$rub[0]\" >");
			TblCellule("<DIV ALIGN=\"RIGHT\">$rub[0]</DIV>");
			TblCellule(" ");
			TblCellule(" ");
			TblCellule("<DIV ALIGN=\"RIGHT\">$rub[1]</DIV>");
			TblFinLigne();
		}
	TblFin();
}


?>
