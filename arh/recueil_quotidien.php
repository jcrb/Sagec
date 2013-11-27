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
//	programme: 		recueil_quotidien.php
//	date de création: 	20/08/2005
//	auteur:			jcb
//	description:		Calcul des données pour le recueil quotidien ARH
//
//
//	version:			1.1
//	maj le:			20/08/2005
//	maj le:			3/11/2005 correction pour l'heure d'hiver
//
//--------------------------------------------------------------------------------
//
session_start();
if(!$_SESSION['auto_arh'])header("Location:../logout.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include("arh_utilitaires.php");
$langue = $_SESSION['langue'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
print("<head>");
print("<title>F2T</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");



//================================================================================
print("<BODY>");
print("<FORM name=\"arh\" method=\"post\" action=\"\">");
print(entete()."<br>");
$date=$_GET['date'];
print(samu_urgences($date));
?>
