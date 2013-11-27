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
//	programme: 		deces_sup.php
//	date de création: 	06/02/2005
//	auteur:			jcb
//	description:		Fonctionalité permise à l'administrateur
//	version:			1.0
//	maj le:			06/02/2005
//
//--------------------------------------------------------------------------------
//
//session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//require("../html.php");
require '../../utilitaires/globals_string_lang.php';
require("../../pma_connect.php");
require("../../pma_connexion.php");
require("../../pma_requete.php");
$langue = $_SESSION['langue'];
$service = $_GET['service'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../service2.css\" TYPE =\"text/css\"></HEAD>");
$requete="SELECT service_nom FROM service WHERE service_ID = '$_GET[service]'";
$resultat = ExecRequete($requete,$connexion);
$rub = mysql_fetch_array($resultat);
$mot=$string_lang["NOUVEAU"][$langue];
$a = "<a href=\"deces.php?service=$service\">$mot</a>";
$mot=$string_lang["LISTE"][$langue];
$b = "<a href=\"deces_liste.php?service=$service\">$mot</a>";
$mot=$string_lang["STATISTIQUES"][$langue];
$c = "<a href=\"\">$mot</a>";
$menu= $a." | ".$b." | ".$c;

print("<table >");
print("<tr><td>".$rub['service_nom']."</td>");
print("<td>$menu</td></tr>");
print("</table>");
print("<br>");
?>
