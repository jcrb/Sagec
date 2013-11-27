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
//	programme: 		graphe_lits.php
//	date de création: 	06/02/2005
//	auteur:			jcb
//	description:		saisies de constantes
//	version:			1.0
//	maj le:			06/02/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("../html.php");
require_once "../classe_dessin.php";
//require("../pma_connect.php");
//require("../pma_connexion.php");
require_once("../utilitaires_dessin.php");
require_once("../pma_requete.php");
/** Dessine une grillehorizontale
*@param $d adresse de la zone de dessin
*@param $ymax ordonnée la plus haute
*@param $ymin ordonnée la plus basse
*@param $yinc incrément entre 2 lignes
*@param $yinter ligne horizontale intermédiaire plus épaisse. 0 pour ne pas en mettre
*@param $xmin abcisse minimale du trait
*@param $xmax abcisse maximale du trait
*@param $c1 couleur du trait usuel
*@param $c2 couleur du trait épais
*/
function grilleH($d,$ymax,$ymin,$yinc,$yinter,$xmin,$xmax,$c1,$c2)
{
	// lignes horizontales tracées toutes les 10 points
	for($i = $ymin;$i<$ymax;$i+=$yinc)
	{
		if($yinter !=0 && $i%$yinter ==0)
		{
			$d->$couleur_courante = $c2;
			$decal_x = -30;
			$decal_y = 5;
			$d->ecrire($i,$xmin,$i,$decal_x,$decal_y,$c2,10);
		}
		else
		{
			$dfc->$couleur_courante = $c1;
		}
		$d->line($xmin,$i,$xmax,$i);
	}
}
function grilleV($d,$xmin,$xmax,$xinc,$xinter,$ymin,$ymax,$c1,$c2)
{
	$jour = 24*60*60;//secondes
	$an = 365*$jour;
	$mois = 31*$jour;
	// lignes verticales tracées toutes les heures
	$tmin = $xmin;
	$tdepart = strtotime($t0);
	for($i=$xmin;$i<$xmax;$i+=$xinc)
	{
		$t0 = date("M",$tmin);
		if($i%$xinter == 0)
		{
			$d->$couleur_courante = $c2;
			$d->ecrire($t0,$i,$ymin,-6,12,$c2,10);
		}
		else
		{
			$dfc->$couleur_courante = $c1;
		}
		$d->line($i,$ymin,$i,$ymax);
		$tmin += $mois;
		if($tmin>$an)$tmin=1;
	}
}
// zone réservée au dessin:
$image_width = 900;//660 * 2;//$_GET[zoom];//660 440
$image_heigth = 200;//800 * 2;//$_GET[zoom];//800 553
//Initialisation de la zone de dessin
$U_haut = 100;
$U_bas = 0;
$U_gauche = 0;
$U_droit = 365;
$dfc = new CDessin($image_heigth,$image_width,$U_haut,$U_gauche,$U_bas,$U_droit);
// Allocation des couleurs
$vert_clair = imagecolorAllocate($dfc->pic,0x99,0xff,0x66);
$vert = imagecolorAllocate($dfc->pic,0x00,0xff,0x00);
$orange = imagecolorAllocate($dfc->pic,0xff,0x66,0x00);
// grille
grilleH($dfc,$U_haut,$U_bas,10,50,$U_gauche,$U_droit,$vert_clair,$vert_clair);
$xinc = 30;// 30jours
$xinter = 15;
grilleV($dfc,$U_bas,$U_droit,$xinc,$xinter,$U_bas,$U_haut,$vert,$vert_clair);
//dessin histogramme
$ferme = explode("|", $_GET['ferme']);
$essai = $_GET['essai'];
for($i=0;$i<count($ferme)-2;$i+=3)
{
	$dfc->rectangle($ferme[$i],$ferme[$i+2],$ferme[$i+1],0,$orange);
}
// affichage du dessin
$dfc->affiche_image("$essai");
?>