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
/**
*	programme: 		synoptique_tendances.php
*	description:	synoptiqque des urgences
*	date de création: 	06/02/2005
*	auteur:			jcb
*	@version:		$Id: synoptique_tendances.php 32 2008-02-17 15:14:17Z jcb $
*	maj le:			06/02/2005
*/
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require "../classe_dessin.php";
$langue = $_SESSION['langue'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//=============================================  grille  ==================================
function grilleH($dfc,$ymin,$ymax,$ystep,$c1,$c2,$xmin,$xmax)
{
	$dfc->$couleur_courante = $vert_clair;
	// lignes horizontales tracées toutes les 10 points
	for($i = $ymin;$i<$ymax;$i+=$ystep)
	{
		if($i%50 ==0)//ligne principale
		{
			$dfc->$couleur_courante = $c1;
			$dfc->ecrire($i,$xmin,$i,-30,5,$c1,10);
		}
		else
		{
			$dfc->$couleur_courante = $c2;
		}
		$dfc->line($xmin,$i,$xmax,$i);
	}
}
//grilleH($dfc,0,$U_haut,1,$vert,$vert_clair,$tmin,$tmax)
function grilleV($dfc,$xmin,$xmax,$xstep,$c1,$c2,$ymin,$ymax)
{
	// lignes verticales tracées toutes les heures
	//$t0 = date("H",$tmin)+1;
	//$tdepart = strtotime($t0);
	$oneDay = 86400;
	for($i=$xmin; $i<$xmax; $i+=$xstep)
	{
		if($i%$oneDay==0)
		{
			$dfc->$couleur_courante = $c1;
			//$dfc->line($i,$ymin,$i,$ymax);
		}
		else
		{
			$dfc->$couleur_courante = $c2;
		}
		$dfc->line($i,$ymin,$i,$ymax);
	}
}
//====================================================================================================
// sélectionner les enregistrements correspondants à un service
$service = "3";
$oneDay = 86400;//24h en secondes
$requete = "SELECT date,lits_dispo FROM lits_journal WHERE service_ID = '$service' ORDER BY date";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat)){
	$t[]=$rub['date'];
	$v[]=$rub['lits_dispo'];
}
$tmin = min($t);
$dx = date("Y-m-d",$tmin);
$tmin = strtotime($dx);
$tmax = max($t)+$oneDay;
$vmin = min($v);
$vmax = max($v);
//Initialisation de la zone de dessin pour la fc et PA
$U_haut = $vmax + 1;
$U_bas = 0;
$U_gauche = $tmin;
$U_droit = $tmax;
$image_width = 800;
$image_heigth = 400;
// Création d'une feuille de dessin
$dfc = new CDessin($image_heigth,$image_width,$U_haut,$U_gauche,$U_bas,$U_droit);
$rouge = imagecolorAllocate($dfc->pic,0xff,0x00,0x00);
$bleu = imagecolorAllocate($dfc->pic,0x00,0x00,0xff);
$vert = imagecolorAllocate($dfc->pic,0x00,0xff,0x00);
$vert_clair = imagecolorAllocate($dfc->pic,0x99,0xff,0x66);
// grille horizontale
grilleH($dfc,0,$U_haut,1,$vert,$vert_clair,$tmin,$tmax);
// grille verticale
grilleV($dfc,$tmin,$tmax,$oneDay,$vert,$vert_clair,-0.1,0.1);
// tracé de la ligne
$dfc->$couleur_courante = $rouge;
for($i = 1; $i < count($t); $i++){
	//$dfc->line($t[$i-1],$v[$i-1],$t[$i],$v[$i]);
	$dfc->line($t[$i-1],$v[$i-1],$t[$i],$v[$i-1]);
	$dfc->line($t[$i],$v[$i-1],$t[$i],$v[$i]);
}
// affichage du dessin
$t0 = date("d/M/Y",$tmin);
$t1 = date("d/M/Y",$tmax);
$dfc->affiche_image("Service - ".$t0." au ".$t1);
?>
