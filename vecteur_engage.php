<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//		
//----------------------------------------- SAGEC --------------------------------------------------------
//																										 //
//	programme: 			vecteur_engage.php																	 	 //
//	date de création: 	31/08/2003																		 //
//	auteur:				jcb																				 //
//	description:		synoptique des moyens disponibles et engagés								 											 //
//	version:			1.0																				 //
//	maj le:				31/08/2003																		 //
//																										 //
//---------------------------------------------------------------------------------------------------------
// 
// connection à la base PMA pour extraire les données nécessaires
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION[langue];

require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
include("vecteurs_menu.php");
include("utilitairesHTML.php");
require 'utilitaires/globals_string_lang.php';

print("<HTML><HEAD><TITLE>Liste des vecteurs</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");

MenuVecteurs($langue);
$mot = $string_lang['LANGUE'][$langue];
setlocale(LC_TIME,$mot);
$dateFR = strFTime("%A %d %B %Y");
$heure = date("H:i");
$mot = $string_lang['MOYENS_ENGAGES'][$langue];
$mot2 = $string_lang['A'][$langue];
print("<H2>$mot ".$dateFR." ".$mot2." ".$heure);
print("</H2>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete="SELECT Vec_Type,Vec_Engage FROM vecteur WHERE Vec_Engage='o'";
$resultat = ExecRequete($requete,$connexion);
$max = 0;
while($g = LigneSuivante($resultat))
{
	$i=$g->Vec_Type;
	$moyen[$i]++;
	if($i>$max)$max = $i;
}

TblDebut(0,"25%");
for($i=1;$i<=$max;$i++)
{
	TblDebutLigne();
		$mot = $string_lang['VOIR'][$langue];
		TblCellule("<div align=\"center\"><a href=\"vecteurs_selection.php?v_type=$i&engage=1\"><B>$mot</B></a>");
		TblCellule(ChercheTypeVecteur($i,$connexion));
		TblCellule($moyen[$i]);
	TblFinLigne();
}
TblFin();
print("</html>");
?>
