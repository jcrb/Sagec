<? session_start();
//----------------------------------------- SAGEC --------------------------------------------------------

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
//---------------------------------------------------------------------------------------------------------
//
//	programme: 			Lits_Table.php
//	date de création: 		07/10/2003
//	auteur:				jcb
//	description:			Affiche un tableau avec tous les lits disponibles, sans distinction d'hôpital
//						ou de type de spécialité. Les services sont affichés par nombre de lits disponibles 
//						décroissants. Le tableau est rafraichi toutes les 30 secondes
//	version:				1.2
//	maj le:				4/01/2004
//	appelé par:			
// 	Variables transmises
//---------------------------------------------------------------------------------------------------------
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
<HTML>
<HEAD>
  <META NAME="author JCB" >
  <TITLE>Bilan</TITLE>
  		<comment> rafraichissement automatique toutes les 30 secondes </comment>
		<meta http-equiv="refresh" content="30">
	</HEAD>
<BODY>
	<p></p>
	<FORM name = "lits" ACTION ="Lits_Table.php">
<?php
// Lits_Table.php
require "utilitairesHTML.php";
require("pma_connect.php");
require("pma_connexion.php");
require("menu_gestion_lits.php"); 

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
print("<HTML><HEAD><TITLE>Etat des lits</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");
MenuLits($langue);
Table_Lits2($connexion,0,0,$langue);
print("<p><input type=\"submit\" name=\"mise_a_jour\" value=\"Mettre a jour\" border=\"0\"></p>");
print("<p></p></FORM></BODY></HTML>");
?>
