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
//	programme: 		dossier_med.php
//	date de cr�ation: 	12/11/2004
//	auteur:			jcb
//	description:		Fonctionalit� permise � l'administrateur
//	version:			1.2
//	maj le:			14/10/2004
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../"; 
require($backPathToRoot."html.php");
require($backPathToRoot."utilitaires/liste.php");
include_once($backPathToRoot."dbConnection.php");

$dossier = $_REQUEST['dossier'];print($dossier);

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

print("<FORM name =\"DM\"  ACTION=\"dossier_enregistre.php\" METHOD=\"get\">");
print("<input type=\"hidden\" name=\"dossier\" value=\"$dossier\"/>");

//================================== partie administration hospitali�re ========================================

print("<br>");
//--------------------------------------------- Etat Neuro -----------------------------------------------------
print("<fieldset>");
print("<legend>Etat neurologique</legend>");
print("<table bgcolor=\"#ccccff\" width=\"50%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	print("<TD><input type=\"checkbox\" name=\"coma\" value=\"\">Coma</TD>");
	print("<TD><input type=\"checkbox\" name=\"pci\" value=\"\">PC initiale</TD>");
	print("<TD>Glasgow <input type=\"text\" name=\"glasgow\" size=\"2\" value=\"15\"></TD>");
print("</TR>");
print("</table>");
print("</fieldset>");
//--------------------------------------------- Etat Respi -----------------------------------------------------
print("<fieldset>");
print("<legend>Etat respiratoire</legend>");
print("<table bgcolor=\"#ccccff\" width=\"50%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	print("<TD><input type=\"checkbox\" name=\"iot\" value=\"\">Intubation</TD>");

print("</TR>");
print("</table>");
print("</fieldset>");
//--------------------------------------------- Etat Circulatoire ----------------------------------------------
print("<fieldset>");
print("<legend>Etat circulatoire</legend>");
print("<table width=\"100%\"><TR>");
print("<TD>");
print("<table bgcolor=\"#ccccff\" width=\"50%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	print("<TD>PA <input type=\"text\" name=\"pas\" size=\"3\"> / <input type=\"text\" name=\"pad\" size=\"3\"> mmHg</TD>");
	print("<TD>Fc <input type=\"text\" name=\"fc\" size=\"3\" value=\"100\"></TD>");
print("</TR>");
print("</table>");
print("</TD>");

print("<TD>");
print("<table bgcolor=\"#ccccff\" width=\"50%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	print("<TD>VVP <input type=\"text\" name=\"vvp\" size=\"1\" value=\"2\"></TD>");
print("</TR>");
print("</table>");

print("</TD>");
print("</table>");
print("</fieldset>");
//--------------------------------------------- L�sions 2 ---------------------------------------------------
print("<fieldset>");
print("<legend>L�sions traumatiques</legend>");
print("<table bgcolor=\"#ccccff\" width=\"75%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" class=\"Style22\">");
$lesion_max = 4;
for($i=0; $i<$lesion_max;$i++)
{
	print("<tr>");
		print("<td>L�sion ");
			genere_select2(lesion,lesion, lesion_ID,lesion_nom, $connexion," ORDER BY lesion_nom", $origin, $id, $selected, $class, $style);
		print("</td>");
		print("<td>Localisation ");
			genere_select2(local,lesion_localisation, lesionloc_ID,lesionloc_nom, $connexion,'', $origin, $id, $selected,$class, $style);
		print("</td>");
		print("<td>C�t�</td>");
		print("<td>Surface</td>");
		print("<td>Profondeur</td>");
	print("</tr>");
}
print("</table>");
print("</fieldset>");
//--------------------------------------------- L�sions -----------------------------------------------------
/*
print("<fieldset>");
print("<legend>L�sions traumatiques</legend>");
print("<table bgcolor=\"#ccccff\" width=\"75%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" class=\"Style22\">");
$t=array();
print("<TR>");
	print("<TD>&nbsp;</TD>");
	print("<TD>contusion</TD>");
	print("<TD>dermabrasion</TD>");
	print("<TD>plaie</TD>");
	print("<TD>entorse</TD>");
	print("<TD>luxation</TD>");
	print("<TD>fracture ferm�e</TD>");
	print("<TD>fracture ouverte</TD>");
	print("<TD>amputation</TD>");
	print("<TD>br�lure</TD>");
print("</TR>");
$n=9;
print("<TR>");
	print("<TD>face</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD height=\"10\"><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>cr�ne</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>cou ant�rieur</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>cou post�rieur</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>thorax ant.</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>thorax.post</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>abdomen ant.</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>abdomen post.</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>fesses</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>OGE</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>cuisse droite</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>cuisse gauche</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>jambe droite</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>jambe gauche</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>cheville droite</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>cheville gauche</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>pied droit</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>pied gauche</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");

print("<TR>");
	print("<TD>�paule droite</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>�paule gauche</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>bras droit</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>bras gauche</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>avant-bras droit</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>avant-bras gauche</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>coude droit</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>coude gauche</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>poignet droit</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>poignet gauche</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>main droite</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>main gauche</TD>");
	for($i=0;$i<$n;$i++)
		print("<TD><div align=\"center\"><input type=\"checkbox\" name=\"t[][$i]\"></div></TD>");
print("</TR>");
print("</table>");
print("</fieldset>");
*/
print("<INPUT TYPE=\"SUBMIT\" VALUE=\"VALIDER\" NAME=\"ok\" SIZE = \"30\" ");

print("</FORM>");
?>