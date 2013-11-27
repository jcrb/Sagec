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
//													//
//	programme: 		service_head.php							//
//	date de cr�ation: 	15/04/2004								//
//	auteur:			jcb									//
//	description:		Affiche un ent�te		//
//	version:		1.0									//
//	maj le:			15/04/2004								//
//													//
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
include("../utilitaires/table.php");
include("../html.php");
require '../utilitaires/globals_string_lang.php';
require_once("../utilitairesHTML.php");

print("<html>");
print("<head>");
print("<title> SAGEC 67 </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

$menu = DateHeure($langue);
entete_sagec2($_SESSION["hopital"],"center",$menu,"../");

/*
print("<TABLE WIDTH=\"100%\">");
print("<TR>");
print("<TD>");
	TblCellule("<B>SAGEC 67</B>",1,1,"TITRE");
print("</TD>");
print("<TD>");
	print($string_lang["HOPITAL"][$langue]);
print("</TD>");
print("<TD>");
	print("<H3>".$_SESSION["hopital"]."</H3>");
print("</TD>");
print("<TD class=\"time\">");
	print(DateHeure($langue));
print("</TD>");
print("</TR>");
print("</TABLE>");
*/
print("</html>");
?>
