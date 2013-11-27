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
//	programme: 		lits_dispo.php
//	date de création: 	24/08/2005
//	auteur:			jcb
//	description:
//	version:		1.2
//	modifié le		30/08/2005
//
//---------------------------------------------------------------------------------------------------------
// Création / mise à jour d'un service
// appelé par Service_maj. Le service_ID est transmis par la variable $ttservice qui vaut 0
// pour un nouveau service
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include("arh_utilitaires.php");

print("<html>");
print("<head>");
print("<title>F2T</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<body>");
// variables globales
global $connexion;
global $DEBUG;

// initialisations
$DEBUG = false;// mettre à true pour affichage des messages

$date = $_GET['date'];
//$date1=fDatetime2unix($date);
//$type_jour=date("w",$date1);// dimanche = 0
print(tableau_compact($date));

print("</body>");
print("</html>");
?>
