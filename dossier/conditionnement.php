<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 		conditionnement.php
//	date de cr?ation: 	06/02/2005
//	auteur:			jcb
//	description:		saisies de constantes
//	version:			1.0
//	maj le:			06/02/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

print("<FORM name =\"APA\"  ACTION=\"constantes_enregistre2.php\" METHOD=\"get\">");
print("&nbsp;<BR>");
//--------------------------------------------- Horodatage ----------------------------------------------
/*
print("<fieldset>");
print("<legend>Horodatage</legend>");
print("<table bgcolor=\"#ccccff\" width=\"75%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	//$aujourdhui = date("d/m/Y");
	$maintenant = strtotime("now");
	//print($maintenant);
	$date = date("Y-m-d",$maintenant);
	print("<TD>date <input type=\"text\" name=\"date\" size=\"10\" value=$date></TD>");
	$heure = date("H:i:s",$maintenant);
	print("<TD>heure <input type=\"text\" name=\"heure\" size=\"10\" value=$heure></TD>");
	print("<TD>dossier <input type=\"text\" name=\"dossier\" size=\"10\" value=$_GET[dossier]></TD>");
	print("<TD><input type=\"submit\" name=\"valider\" value=\"valider\"></TD>");
print("</TR>");
print("</table>");
//--------------------------------------------- Valider -------------------------------------------------------
//print("<table width=\"15%\">");
//print("<TR><TD><input type=\"submit\" name=\"valider\" value=\"valider\"></TD></TR>");
//print("</table>");
print("</fieldset>");
*/
//--------------------------------------------- Monitoring ----------------------------------------------
print("<fieldset>");
print("<legend>Monitoring</legend>");
print("<table bgcolor=\"#ccccff\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	print("<TD><input type=\"checkbox\" name=\"scope\"> Scope</TD>");
	print("<TD><input type=\"checkbox\" name=\"scope\"> PANI</TD>");
	print("<TD><input type=\"checkbox\" name=\"scope\"> Oxym�tre</TD>");
	print("<TD><input type=\"checkbox\" name=\"scope\"> Capnographe</TD>");
	print("<TD><input type=\"checkbox\" name=\"scope\"> Pression invasive</TD>");
print("</TR>");
print("</table>");
print("</fieldset>");
//--------------------------------------------- Position -----------------------------------------------------
print("<fieldset>");
print("<legend>Position / immobilisation</legend>");
print("<table bgcolor=\"#ccccff\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" class=\"Style22\">");
print("<TR>");
	print("<TD><input type=\"checkbox\" name=\"demi_assis\"> Demi-assis</TD>");
	print("<TD><input type=\"checkbox\" name=\"allong�\"> Allong�</TD>");
	print("<TD><input type=\"checkbox\" name=\"tren\"> Trendelenbourg</TD>");
	print("<TD><input type=\"checkbox\" name=\"pls\"> PLS</TD>");
	print("</TR><TR>");
	print("<TD><input type=\"checkbox\" name=\"coquille\"> Coquille</TD>");
	print("<TD><input type=\"checkbox\" name=\"coquillep\"> Coquille partiel</TD>");
	print("<TD><input type=\"checkbox\" name=\"collier\"> Collier cervical</TD>");
	print("<TD><input type=\"checkbox\" name=\"contention\"> Contention</TD>");
	print("<TD><input type=\"checkbox\" name=\"attelle\"> Attelle</TD>");
print("</TR>");
print("<TR>");
	print("<TD><input type=\"checkbox\" name=\"cpelv\"> Ceinture pelvienne</TD>");
print("</TR>");
print("</table>");
print("</fieldset>");
//--------------------------------------------- R�a cardio -----------------------------------------------------
print("<fieldset>");
print("<legend>R�animation cardiaque</legend>");
print("<table bgcolor=\"#ccccff\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" class=\"Style22\">");
print("<TR>");
	print("<TD><input type=\"checkbox\" name=\"attelle\"> MCE</TD>");
	print("<TD><input type=\"checkbox\" name=\"attelle\"> Cardiopompe</TD>");
	print("<TD><input type=\"checkbox\" name=\"attelle\"> DSA</TD>");
	print("<TD><input type=\"checkbox\" name=\"attelle\"> Def.manuelle</TD>");
	print("</TR><TR>");
	print("<TD><input type=\"checkbox\" name=\"attelle\"> Entrainement �lectro-systolique externe</TD>");
	print("<TD> mA <input type=\"text\" name=\"ma\" size=\"10\" value=\"\"></TD>");
	print("<TD> Fc <input type=\"text\" name=\"fc\" size=\"10\" value=\"\"></TD>");
	print("<TD> mode <input type=\"text\" name=\"mo\" size=\"10\" value=\"\"></TD>");
	print("</TR><TR>");
	print("<TD><input type=\"checkbox\" name=\"contrep\"> Contrepulsion</TD>");
	print("<TD><input type=\"checkbox\" name=\"pm\"> Planche � masser</TD>");
	print("<TD><input type=\"checkbox\" name=\"ca\"> Coeur artificiel</TD>");
print("</TR>");
print("</table>");
print("</fieldset>");
//--------------------------------------------- Sondages drainages -----------------------------------------------------
print("<fieldset>");
print("<legend>Sondage-Drainage</legend>");
print("<table bgcolor=\"#ccccff\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" class=\"Style22\">");
print("<TR>");
	print("<TD><input type=\"checkbox\" name=\"sng\"> Sonde gastrique</TD>");
	print("<TD> op�rateur <input type=\"text\" name=\"op11\" size=\"20\" value=\"\"></TD>");
	print("</TR><TR>");
	print("<TD><input type=\"checkbox\" name=\"sun\"> Sonde urinaire</TD>");
	print("<TD> op�rateur <input type=\"text\" name=\"op2\" size=\"20\" value=\"\"></TD>");
	print("</TR><TR>");
	print("<TD><input type=\"checkbox\" name=\"drainTho\"> Drain thoracique</TD>");
	print("<TD> op�rateur <input type=\"text\" name=\"op3\" size=\"20\" value=\"\"></TD>");
print("</TR>");
print("</table>");
print("</fieldset>");
?>
