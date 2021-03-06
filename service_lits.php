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
// along with Foobar; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//												
//	programme: 			service_lits.php		
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

print("<html>");
print("<head>");
	print("<title> Gestion des Lits </title>");
	print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");
	
print("<body style=\"background-color:#CCFFFF\">");
print("<FORM NAME=\"lits\" ACTION=\"service_enregistre2.php\" METHOD=\"GET\">");
print("<INPUT TYPE=\"Hidden\" NAME=\"back\" VALUE=\"$_GET[back]\">");
print("<INPUT TYPE=\"Hidden\" NAME=\"service\" VALUE=\"$_GET[select_service]\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
// $service est une variable de session
if($_GET['select_service'])
	$service = $_GET['select_service'];
$un_service = nom_service($service,$connexion);

// Affichage de l'entete
entete_service("Wissembourg",$un_service);
menu_service("1",$back);
//print("<HR>");
$requete = "SELECT * FROM lits WHERE service_ID='$service'";
$resultat = ExecRequete($requete,$connexion);
$rub = LigneSuivante($resultat); 

TblDebut(0,"100%");
	// ligne 2: lits et respirateur
	TblDebutLigne();
	print("<TD>");
		print("<fieldset>");
		print("<legend>Lits</legend>");
		TblDebut(0,"75%");
			TblDebutLigne();
				TblCellule("Lits disponibles");
				TblCellule("<INPUT TYPE=\"TEXT\" NAME = \"nb_lits\" SIZE=\"2\" VALUE=\"$rub->lits_sp\">");
			TblFinLigne();
			TblDebutLigne();
				TblCellule("Lits en isolement");
				TblCellule("<INPUT TYPE=\"TEXT\" NAME = \"lits_isole\" SIZE=\"2\" VALUE=\"$rub->lits_pneg\">");
			TblFinLigne();
		TblFin();
		print("</fieldset>");
	print("</TD>");
	print("<TD>");
		print("<fieldset>");
		print("<legend>Respirateurs disponibles</legend>");
		TblDebut(0,"100%");
			TblDebutLigne();
				TblCellule("Adultes");
				TblCellule("<INPUT TYPE=\"TEXT\" NAME = \"nb_respi_adulte\" SIZE=\"2\" VALUE=\"$rub->lits_respi\">");
			TblFinLigne();
			TblDebutLigne();
				TblCellule("Enfants");
				TblCellule("<INPUT TYPE=\"TEXT\" NAME = \"nb_respi_ped\" SIZE=\"2\" VALUE=\"$rub->lits_respi_ped\">");
			TblFinLigne();
		TblFin();
		print("</fieldset>");
	print("</TD>");
	coordonnee_service();
	TblFinLigne();
TblFin();

// validation si autoris� � faire des modifications
validation("Validez",$back);

//if($back)
//	print("<A HREF = \"$back\">Retour</A>");
	
print("</FORM>");
print("</HTML>");
?>
