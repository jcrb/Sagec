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
//
//	programme: 		lits_imprime.php
//	date de création: 	22/09/2006
//	auteur:				jcb
//	description:		Imprime la liste des services d'un hôpital donné
//	version:			1.3
//	maj le:				22/09/2006
//
//--------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require "utilitairesHTML.php";
require 'utilitaires/globals_string_lang.php';
require ("services_utilitaires.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
print("<title> menu service </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");
print("<body>");

Table_Lits3($connexion,$_GET['hop'],$_GET['serv'],$_GET['langue'],$_GET['back'],$dpt,$_GET['tri'],'false');
print("</body>");
print("</html>");
?>