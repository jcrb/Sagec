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
/**
*	programme: 		veille_liste.php
*	date de cr�ation: 	22/05/2005
*	auteur:			jcb
*	description:		liste les infos SAMU
*	@version 1.1 $Id: veille_liste.php 22 2007-03-12 17:13:10Z jcb $
*	maj le:			13/06/2005
*/
//--------------------------------------------------------------------------------------------------------
/** Variables transmises
*@param $debut date de d�but de la fermeture
*@param $fin date de fin de la fermeture
*@param $lits_fermes nombre de lits ferm�s
*/
//--------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_sagec'])header("Location:../logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma2.css\" TYPE =\"text/css\"></HEAD>");

$requete="SELECT * FROM veille_samu WHERE service_ID = '$_SESSION[service]' ORDER BY date DESC";
//print($requete);
$resultat = ExecRequete($requete,$connexion);

print("<table bgcolor=\"\" width=\"75%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" class=\"Style22\">");
print("<tr bgcolor=\"yellow\">");
	print("<th>Modifier</th>");
	print("<th>date</th>");
	print("<th><div align=\"center\">affaires</div></th>");
	print("<th><div align=\"center\">primaires</div></th>");
	print("<th><div align=\"center\">secondaires</div></th>");
	print("<th><div align=\"center\">n�onat</div></th>");
	print("<th><div align=\"center\">TIIH</div></th>");
	print("<th><div align=\"center\">ASSU</div></th>");
	print("<th><div align=\"center\">VSAV</div></th>");
	print("<th><div align=\"center\">conseils</div></th>");
	print("<th><div align=\"center\">Med</div></th>");
print("</tr>");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td><a href=\"veille.php?service=$_SESSION[service]&enregistrement=$rub[veille_samu_ID]\">modifier</a></td>");
		print("<td><div align=\"right\">".date("j/m/Y",$rub[date])."</div></td>");
		print("<td><div align=\"center\">$rub[nb_affaires]</div></td>");
		print("<td><div align=\"center\">$rub[nb_primaires]</div></td>");
		print("<td><div align=\"center\">$rub[nb_secondaires]</div></td>");
		print("<td><div align=\"center\">$rub[nb_neonat]</div></td>");
		print("<td><div align=\"center\">$rub[nb_tiih]</div></td>");
		print("<td><div align=\"center\">$rub[nb_apa]</div></td>");
		print("<td><div align=\"center\">$rub[nb_vsav]</div></td>");
		print("<td><div align=\"center\">$rub[conseils]</div></td>");
		print("<td><div align=\"center\">$rub[nb_med]</div></td>");
	print("</tr>");
}
print("</table>");
print("<HTML>");
?>
