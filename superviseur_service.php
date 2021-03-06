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
//	programme: 			superviseur_service.php		
//	date de cr�ation: 	25/12/2003		
//	auteur:				jcb										
//	description:		
//  s'inspire de:															 			
//	version:			1.0																				 
//	maj le:				25/12/2003																	 //
//																										 
//---------------------------------------------------------------------------------------------------------
// ouverture d'une session
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["auto_hopital"])
{
	print("<H2>Vous n'�tes pas autoris� � acc�der � cette zone</H2><BR>");
	echo "<a href = \"login2.php\"><H1>Continuer</H1></a><br>";
	exit();
}
require 'utilitaires/globals_string_lang.php';
require("utilitaires/table.php");
require("service_entete.php");
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
	print("<title> Synoptiques </title>");
	print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<body style=\"background-color:#CCFFFF\">");
print("<FORM NAME=\"Superviseur\" ACTION=\"service_lits.php\" METHOD=\"GET\">");
// adresse de retour
print("<INPUT TYPE=\"Hidden\" NAME = \"back\" VALUE =\"superviseur_service.php\">");

// Affichage de l'entete
entete_superviseur($_SESSION['hopital']);	
menu_superviseur($_SESSION['autorisation']);

//print("<HR>");
// s�lectionne un service particulier ou tous
TblDebut(0,"50%");
	TblDebutLigne();
		$mot = $string_lang['SELECTIONNER_SERVICE'][$langue];
		TblCellule($mot);
		print("<TD>");
			liste_des_services($_SESSION['organisation'],$connexion,$item_select,"superviseur_service.php");
		print("</TD>");
		//$mot = $string_lang['VALIDER'][$langue];
		//TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\" ");
	TblFinLigne();
TblFin();
?>
