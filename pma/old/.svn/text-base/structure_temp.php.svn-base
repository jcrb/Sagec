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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		structure_temp.php
//	date de création: 	22/10/2005
//	auteur:			jcb
//	description:
//	version:		1.0
//	modifié le		22/10/2005
//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require '../utilitaires/globals_string_lang.php';
include("../utilitaires/table.php");
include("../utilitairesHTML.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<!DOCTYPE html PUBLIC \"-//W3C/DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">");
print("<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">");

print("<head>");
	print("<title>titre évocateur</title>");
	print("<meta http-equiv=\"Content-type\" content=\"text/html; charset = iso-8859-15\" />");
	print("<meta http-equiv=\"Content-Style-Type\" content=\"text/css\" />");
	print("<meta http-equiv=\"Content-Language\" content=\"fr\" />");
	print("<link rel=\"stylesheet\" type=\"text/css\" href=\"../pma.css\">");// compléter avec l'adresse de la feuille de style
print("</head>");

print("<body>");
print("<form name=\"pma\" method=\"get\" action=\"\">");
print("<FIELDSET>");
print("<LEGEND class=\"time\"> Identification</LEGEND>");
TblDebut(0,"100%","1","0",time_v);
	TblDebutLigne();
		TblCellule($string_lang['NOM'][$langue].":");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$rub->ts_nom\" NAME=\"nom\" SIZE = \"30\"> ");
		TblCellule($string_lang['TYPE'][$langue].":");
		print("<TD>");
			SelectLocalisation($connexion,$rub->ts_localisation,$langue,'');//$org_type contient le type_ID
		print("</TD>");
		TblCellule("LOCALISATION");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$rub->ts_nom\" NAME=\"nom\" SIZE = \"30\"> ");
		
		$mot = $string_lang['VALIDER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\"> ");
	TblFinLigne();

	TblDebutLigne();
		print("<td><input type=\"checkbox\" name=\"reuse\"> structure permanente<td>");
	TblFinLigne();
TblFin();
print("</FIELDSET>");
print("</form>");	
print("</body>");

print("</html>");
?>