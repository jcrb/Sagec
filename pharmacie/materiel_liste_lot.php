<?php
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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		materiel_liste_lot.php
//	date de création: 	30/10/2004
//	auteur:			jcb
//	description:		Liste des médicaments répertoriés
//	version:			1.0
//	maj le:			30/10/2004
//
//--------------------------------------------------------------------------------------------------------

session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
//include("../utilitairesHTML.php");
include("utilitaires_MED.php");

print("<html>");
print("<head>");
print("<title> Médicaments </title>");
//print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = stylesheet TYPE = \"text/css\" HREF = \"pharma.css\">");
print("</head>");

print("<BODY BGCOLOR=\"#ffffff\" >");
print("<FORM name =\"Services\"  ACTION=\"medicament_enregistre\" METHOD=\"GET\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$tri = $_REQUEST['tri'];

$requete = "SELECT med_lot_ID, special_nom,med_lot_qte, med_lot_perime,lot_nom
				FROM med_lot,med_specialite,med_psm
				WHERE med_lot.categorie = '2'
				AND special_ID = medic_ID
				AND lot_ID = conteneur_ID
				";
$resultat = ExecRequete($requete,$connexion);
print("<table width=\"100%\">");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td>$rub[med_lot_ID]</td>");
		print("<td>$rub[special_nom]</td>");
		print("<td>$rub[med_lot_qte]</td>");
		print("<td>$rub[med_lot_perime]</td>");
		print("<td>$rub[lot_nom]</td>");
	print("</tr>");
}
print("</table>");

print("</FORM>");
print("</html>")
?>