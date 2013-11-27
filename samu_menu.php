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
// 
/**													
*	programme 			samu_menu.php
*	@date de création: 	15/08/2005
*	@author:			jcb
*	description:		
*	@version:			1.0 - $Id: samu_menu.php 43 2008-03-13 22:41:12Z jcb $
*	maj le:				15/08/2005
*	@package			Sagec
*/
session_start();
//if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include ("menu_sagec.php");
require 'utilitaires/globals_string_lang.php';
include("utilitaires/table.php");

print("<html>");
print("<head>");
print("<title> Aides à la régulation </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<body>");
entete_sagec($titre="Aides à la régulation","center","./");

print("<hr>");// barre horizontale
TblDebut(0,"100%",0);
	$_style = "A2";
	TblDebutLigne("$_style");
		//$mot = strToUpper($string_lang['HOPITAUX'][$langue]);
		$mot="Médecin de garde";
		TblCellule("<div align=\"center\"><a href=\"medecin/med_de_garde.php\"><B>$mot</B></a>");
		$mot="ASSU CUS";
		TblCellule("<div align=\"center\"><a href=\"tr_cus/tourDeRole_frameset.php\"><B>$mot</B></a>");
		$mot="COMMUNES";
		TblCellule("<div align=\"center\"><a href=\"moyens_commune.php\"><B>$mot</B></a>");
		$mot="ADRESSE";
		TblCellule("<div align=\"center\"><a href=\"cherche_adresse.php\"><B>$mot</B></a>");
		//TblCellule("<div align=\"center\"><a href=\"pds/moyens_communes.php\"><B>$mot</B></a>");
		$mot="TOXIQUES";
		TblCellule("<div align=\"center\"><a href=\"chimie/recherche_produit.php\"><B>$mot</B></a>");
		$mot="CARTOGRAPHIE";
		TblCellule("<div align=\"center\"><a href=\"carto2/newcarto_main.php\"><B>$mot</B></a>"); //carto_frameset.php
		$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"sagec67.php\"><B>menu</B>");
	TblFinLigne();
	TblDebutLigne("$_style");
		TblCellule("&nbsp;");
		?>
		<td><div align="center"><a href="http://ordigard.ordre.medecin.fr" target="_blank"><B>Ordigarde</B></DIV></td>
		<?php 
		TblCellule("<div align=\"center\"><a href=\"pds/blocnote_pds_lire.php\"><B>INFORMATIONS</B></DIV>");
		TblCellule("<div align=\"center\"><a href=\"offre_soins/index.php\"><B>Offre de soins</B></DIV>");
		TblCellule("&nbsp;");
		TblCellule("&nbsp;");
		TblCellule("&nbsp;");
	TblFinLigne();
TblFin();

//print("langue: ".$langue);
print("<div align=\"left\">");
	print("<a href=\"utilitaires/google/geolocalise.php\">Mise à jour de la table mg67</a>");
print("</div>");
print("</body>");
print("</html>");
?>
