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
/**													
*	programme: 			service_menu.php							
*	date de création: 	15/04/2004								
*	@author:			jcb									
*	description:		affiche un choix d'options		
*	@version:			1.1- $Id: service_menu.php 25 2008-01-13 10:17:33Z jcb $								
*	maj le:				03/09/2005
*	@package			Sagec								
*/												
//--------------------------------------------------------------------------------------------------------
session_start();
require '../utilitaires/globals_string_lang.php';
$langue = $_SESSION['langue'];

print("<html>");
print("<head>");
print("<title> menu service </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY>");

print("<fieldset CLASS=\"time_v\">");
$mot=$string_lang["POSSIBILITE"][$langue];
print("<legend>$mot</legend>");
print("<UL>");
	/*
	// PAGE EXISTE - NEUTRALISEE POUR CAUSE DE TRAVAUX
	print("<LI>");
		$mot = $string_lang["INFORMATION"][$langue];
		print("<A HREF =\"../evenement/evenement_courant.php\" TARGET=\"midle\">$mot</A>");
	*/
	print("<LI>");
		$mot=$string_lang["LITS_DISPO"][$langue];
		print("<A HREF =\"service_liste.php\" TARGET=\"midle\">$mot</A>");
	print("<LI>");
		$mot=$string_lang["PERSONNEL_DISPO"][$langue];
		print("<A HREF =\"service_pret_personnel.php\" TARGET=\"midle\">$mot</A>");
	print("<LI>");
		$mot=$string_lang["MATERIEL_DISPO"][$langue];
		print("<A HREF =\"service_pret_materiel.php\" TARGET=\"midle\">$mot</A>");
	if($_SESSION["auto_hopital"] && $_SESSION["autorisation"] > 1)
	{
		print("<LI>");
		$mot=$string_lang["ADMINISTRATEUR"][$langue];
		print("<A HREF =\"epidemio/deces.php\" TARGET=\"midle\">$mot</A>");
		
		if($_SESSION["autorisation"] > 2)
		{
			print("<LI>");
			$mot=$string_lang["SAISIE_RAPIDE"][$langue];
			print("<A HREF =\"epidemio/saisie_rapide.php\" TARGET=\"midle\">$mot</A>");
		}

		print("<LI>");
		$mot=$string_lang["STATISTIQUES"][$langue];
		print("<A HREF =\"epidemio/stat_service.php\" TARGET=\"midle\">$mot</A>");
	}
print("</UL>");
print("</fieldset>");

if($langue=='FR')
{
	print("<fieldset CLASS=\"time_r\">");
	print("<legend>Prévision de fermeture</legend>");
	print("<UL>");
	print("<LI>");
		$mot=$string_lang["NOUVEAU"][$langue];
		print("<A HREF =\"service_fermeture.php\" TARGET=\"midle\">$mot</A>");
	print("<LI>");
		$mot=$string_lang["RECAPITULATIF_LOCAL"][$langue];
		print("<A HREF =\"fermeture_locale.php\" TARGET=\"midle\">$mot</A>");
	print("<LI>");
		$mot=$string_lang["RECAPITULATIF_REGIONAL"][$langue];
		print("<A HREF =\"fermeture_regionale.php\" TARGET=\"midle\">$mot</A>");
	print("</UL>");
	print("</fieldset>");
}

print("<fieldset CLASS=\"time_r\">");
$mot=$string_lang["BESOINS_URGENT"][$langue];
print("<legend>$mot</legend>");
print("<UL>");
	print("<LI>");
		$mot=$string_lang["BESOINS_MAT"][$langue];
		print("<A HREF =\"service_besoin_materiel.php\" TARGET=\"midle\">$mot</A>");
	print("<LI>");
		$mot=$string_lang["BESOINS_PER"][$langue];
		print("<A HREF =\"service_besoin_personnel.php\" TARGET=\"midle\">$mot</A>");
	print("<LI>");
		$mot=$string_lang["DEGATS"][$langue];
		print("<A HREF =\"service_degats.php\" TARGET=\"midle\">$mot</A>");
print("</UL>");
print("</fieldset>");
print("<UL>");
	if($langue=='FR')
	{
		print("<LI>");
		//$mot=$string_lang["AIDE"][$langue];
		print("<A href=\"../../docs/connect.pdf\" TARGET=\"midle\">AIDE</A>");
	}
	print("<LI>");
		$mot=$string_lang["BLOCNOTE"][$langue];
		print("<A HREF = \"service_bloc_note.php\" TARGET=\"midle\">$mot</A>");
	print("<LI>");
		$mot=$string_lang["VICTIMES"][$langue];
		print("<A HREF = \"liste_victimes.php\" TARGET=\"midle\">$mot</A>");
	print("<LI>");
		$mot=$string_lang["VICTIMES"][$langue]." OTAN";
		print("<A HREF = \"hop_saisie_victime.php\" TARGET=\"midle\">$mot</A>");
	print("<LI>");
		$mot=$string_lang["QUITTER"][$langue];
		print("<A HREF = \"../langue.php\" TARGET=\"_parent\">$mot</A>");
print("</UL>");

print("</BODY>");

print("</html>");
?>
