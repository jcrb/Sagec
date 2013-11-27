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
//	programme: 		feuille_soins.php
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
require("../html.php");
require "../classe_dessin.php";
require("../pma_connect.php");
require("../pma_connexion.php");
require("../utilitaires_dessin.php");
require("../pma_requete.php");
//
// zone réservée au dessin:
$image_width = 900;//660 * 2;//$_GET[zoom];//660 440
$image_heigth = 400;//800 * 2;//$_GET[zoom];//800 553
// patient
$victime=$_GET['dossier'];
//sélection des données
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete = "SELECT date,exam_ID,resultat FROM dm_constantes2 WHERE victime_ID = '$victime' ORDER BY date";
$resultat = ExecRequete($requete,$connexion);
$tmin=strtotime("now");
$tmax=0;
/*
	Les données sont chargées sous la forme de 2 tablaux é double indices:
	$t[n°examen][n°d'ordre] = heure de réalisation avec
		- n°examen = 1 pour la fc, 2=PAS, etc...
		- n°d'ordre = 0,1,2....,n
	$r[nœexamen][nœd'ordre] = valeur du résultat de l'examen
	ex:
	$t[fc][0] = 10:30	$r[fc][0] = 100
	$t[fc][1] = 10:40	$r[fc][1] = 80
	$t[fc][2] = 10:50	$r[fc][2] = 85
*/
while($rub = mysql_fetch_array($resultat))
{
	if($tmin > $rub['date'])$tmin = $rub['date'];
	if($tmax < $rub['date'])$tmax = $rub['date'];
	$t[$rub['exam_ID']][]=$rub['date'];//date
	$r[$rub['exam_ID']][]=$rub['resultat'];//resultat
	//$h = date("Y-m-d H:i:s",$rub['date']);
	//print($rub['exam_ID']." ".$h." ".$rub['resultat']."<br>");
}

//@mysql_free_result($resultat);
$tx = $tmin;// $tx = heure de la 1ère graduation pleine
while($tx%1200!=0)$tx++;
if($tmax-$tx < 3600)$tmax = $tx+3600+60;
//if($tmin==$tmax)$tmax=$tmin+3600;
//Initialisation de la zone de dessin pour la fc et PA
$U_haut = 250;
$U_bas = 0;
$U_gauche = $tmin;
$U_droit = $tmax;
//
$dfc = new CDessin($image_heigth,$image_width,$U_haut,$U_gauche,$U_bas,$U_droit);
$rouge = imagecolorAllocate($dfc->pic,0xff,0x00,0x00);
$bleu = imagecolorAllocate($dfc->pic,0x00,0x00,0xff);
$vert = imagecolorAllocate($dfc->pic,0x00,0xff,0x00);
$vert_clair = imagecolorAllocate($dfc->pic,0x99,0xff,0x66);
$jaune = imagecolorAllocate($dfc->pic,0xff,0xff,0x00);
$orange = imagecolorAllocate($dfc->pic,0xff,0x66,0x00);
$bleuclair = imagecolorAllocate($dfc->pic,0xcc,0xcc,0xff);
//imagecolortransparent($dfc->pic, $orange);
$dfc->setMarges(20,20,40,10);
//print($dfc->a8." ".$dfc->a9);
//

//=============================================  grille  ==================================
$dfc->couleur_courante = $vert_clair;
// lignes horizontales tracées toutes les 10 points
for($i = 0;$i<250;$i+=10)
{
	if($i%50 ==0)
	{
		$dfc->couleur_courante = $vert;
		$dfc->ecrire($i,$tmin,$i,-30,5,$vert,10);
	}
	else
	{
		$dfc->couleur_courante = $vert_clair;
	}
	$dfc->line($tmin,$i,$tmax,$i);
}

// lignes verticales tracées toutes les heures
$t0 = date("H",$tmin)+1;
$tdepart = strtotime($t0);
//$dfc->$couleur_courante = $vert;

for($i=$tx;$i<$tmax;$i+=1200)
{
	if($i%3600==0)
	{
		$dfc->couleur_courante = $vert;
		$dfc->ecrire($t0."h",$i,$U_bas,-6,12,$vert,10);
		$t0++;
		if($t0>23)$t0=0;
	}
	else
	{
		$dfc->couleur_courante = $vert_clair;
	}
	$dfc->line($i,$U_bas,$i,$U_haut);
}

//====================================  affichage des examens  ========================================
// Pression artérielle
$p1 = 2; //PAS
$p2 = 3; //PAD
$dfc->couleur_courante = $bleu;
for($i=0;$i<count($t[$p1]);$i++)
{
	$dfc->va_en($t[$p1][$i],$r[$p1][$i]);
	$dfc->trace_vers($t[$p1][$i],$r[$p2][$i]);
	$dfc->cercle($t[$p1][$i],$r[$p1][$i],$rayon,$bleu, "","","1");
	$dfc->cercle($t[$p1][$i],$r[$p2][$i],$rayon,$bleu, "","","1");
		//$dfc->cercle($t[$i],$pad[$i],$rayon,$bleu, "","","1");
		//$dfc->cercle($t[$i],$pas[$i],$rayon,$bleu, "","","1");
		if($i>0)
		{
			$dfc->line($t[$p1][$i-1],$r[$p1][$i-1],$t[$p1][$i],$r[$p1][$i]);
			$dfc->line($t[$p2][$i-1],$r[$p2][$i-1],$t[$p2][$i],$r[$p2][$i]);
			//
			$poly=array($t[$p1][$i-1],$r[$p1][$i-1],
			$t[$p1][$i],$r[$p1][$i],
			$t[$p2][$i],$r[$p2][$i],
			$t[$p2][$i-1],$r[$p2][$i-1]
			);
			//print_r($poly);
			$pl2 = $dfc->polygoneU2E($poly);
			$dfc->dessine_polygone($pl2, $bleuclair, $bleu);
		}
}
// fréquence cardiaque
$p1 = 1;
$rayon = 8;
for($i=0;$i<count($t[$p1]);$i++)
{
	$dfc->cercle($t[$p1][$i],$r[$p1][$i],$rayon,$rouge, "","","1");
	if($i>0)
	{
		$dfc->couleur_courante = $rouge;
		$dfc->line($t[$p1][$i-1],$r[$p1][$i-1],$t[$p1][$i],$r[$p1][$i]);
	}
}
//
// EtCO2
$dfc->couleur_courante = $bleu;
$p1 = 6; //etco2
for($i=0;$i<count($t[$p1]);$i++)
{
	$dfc->cercle($t[$p1][$i],$r[$p1][$i],$rayon,$jaune, "","","1");
	if($i>0)
	{
		$dfc->couleur_courante = $jaune;
		$dfc->line($t[$p1][$i-1],$r[$p1][$i-1],$t[$p1][$i],$r[$p1][$i]);
	}
}
// SaO2
$p1 = 5; //SaO2
for($i=0;$i<count($t[$p1]);$i++)
{
	$dfc->cercle($t[$p1][$i],$r[$p1][$i],$rayon,$orange, "","","1");
	if($i>0)
	{
		$dfc->couleur_courante = $orange;
		$dfc->line($t[$p1][$i-1],$r[$p1][$i-1],$t[$p1][$i],$r[$p1][$i]);
	}
}

// affichage du dessin
$dfc->affiche_image("Patient - ".$victime." ".$tx."/".$tmin."/".$tmax);


?>
