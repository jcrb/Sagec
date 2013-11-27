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
//	programme: 		deces_liste.php
//	date de cr?ation: 	23/03/2005
//	auteur:			jcb
//	description:		liste des passages au SAU
//	version:			1.0
//	maj le:			23/03/2005
//
//--------------------------------------------------------------------------------------------------------
/** Variables transmises
*@param $debut date de d?but de la fermeture
*@param $fin date de fin de la fermeture
*@param $lits_fermes nombre de lits ferm?s
*/
//--------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_hopital'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../../pma_connect.php");
require("../../pma_connexion.php");
require("../../pma_requete.php");
require("../../date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
include("deces_sup.php");

$requete="SELECT * FROM veille_dg WHERE org_ID = '$_SESSION[organisation]' ORDER BY date DESC";
$resultat = ExecRequete($requete,$connexion);

print("<table>");
print("<tr>");
	print("<td>Modifier</td>");
	print("<td>date</td>");
	print("<td><div align=\"center\">total</div></td>");
	print("<td><div align=\"center\">age > 75 ans</div></td>");
print("</tr>");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td><a href=\"deces.php?$erreur=0&enregistrement=$rub[veille_dg_ID]\">modifier</a></td>");
		print("<td>".date("j/m/Y",$rub[date])."</td>");
		print("<td><div align=\"center\">$rub[nb_tot_dcd]</div></td>");
		print("<td><div align=\"center\">$rub[nb_dcd_sup75]</div></td>");
	print("</tr>");
}
print("</table>");
?>
