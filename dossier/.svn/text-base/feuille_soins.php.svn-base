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
$victime="123";
//sélection des données
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete = "SELECT date,heure,fc,pad,pas FROM dm_constantes WHERE victime_ID = '$victime' ORDER BY heure";
$resultat = $resultat = ExecRequete($requete,$connexion);
while($rub = mysql_fetch_array($resultat))
{
	$t[] = strtotime($rub[heure]);
	$fc[] = $rub[fc];
	$pas[] = $rub[pas];
	$pad[] = $rub[pad];
}
/*
for($i=0;$i<sizeof($t);$i++)
{
	print($fc[$i]."  ".$pas[$i]."  ".$pad[$i]."<br>");
}
*/
//Initialisation de la zone de dessin pour la fc et PA
$U_haut = 250;
$U_bas = 0;
$U_gauche = min($t);
$U_droit = max($t);
$dfc = new CDessin($image_heigth,$image_width,$U_haut,$U_gauche,$U_bas,$U_droit);
$rouge = imagecolorAllocate($dfc->pic,0xff,0x00,0x00);
$bleu = imagecolorAllocate($dfc->pic,0x00,0x00,0xff);
$vert = imagecolorAllocate($dfc->pic,0x00,0xff,0x00);
$vert_clair = imagecolorAllocate($dfc->pic,0x99,0xff,0x66);
$dfc->setMarges(20,20,40,10);
// grille
$dfc->$couleur_courante = $vert_clair;
// lignes horizontales
for($i = 0;$i<250;$i+=10)
{
	if($i%50 ==0)
	{
		$dfc->$couleur_courante = $vert;
		$dfc->ecrire($i,$t[0],$i,-40,-10,$vert);
	}
	else
	{
		$dfc->$couleur_courante = $vert_clair;
	}
	$dfc->line($t[0]-150,$i,$t[sizeof($t)-1],$i);
}
// lignes verticales tracées toutes les heures
$t0 = date("H",$t[0])+1;
$tmin = strtotime($t0);
//$dfc->$couleur_courante = $vert;
/*
for($i=$tmin;$i<$t[sizeof($t)-1];$i+=3600)
{
	$dfc->line($i,$U_bas,$i,$U_haut);
	$dfc->ecrire($t0,$i,$U_bas,-2,5,$vert);
	$t0++;
}*/
$tx = $t[0];
while($tx%1200!=0)$tx++;
for($i=$tx;$i<$t[sizeof($t)-1];$i+=1200)
{
	if($i%3600==0)
	{
		$dfc->$couleur_courante = $vert;
		$dfc->ecrire($t0,$i,$U_bas,-2,5,$vert);
		$t0++;
	}
	else
	{
		$dfc->$couleur_courante = $vert_clair;
	}
	$dfc->line($i,$U_bas,$i,$U_haut);
}
//
$rayon = 8;
for($i=0;$i<sizeof($t);$i++)
{
	if($pad[$i]!=0 && $pas[$i]!=0)
	{
		$dfc->$couleur_courante = $bleu;
		$dfc->va_en($t[$i],$pas[$i]);
		$dfc->trace_vers($t[$i],$pad[$i]);
		$dfc->cercle($t[$i],$pad[$i],$rayon,$bleu, "","","1");
		$dfc->cercle($t[$i],$pas[$i],$rayon,$bleu, "","","1");
		if($i>0)
		{
			$dfc->line($t[$i-1],$pas[$i-1],$t[$i],$pas[$i]);
			$dfc->line($t[$i-1],$pad[$i-1],$t[$i],$pad[$i]);
		}
	}
	$dfc->cercle($t[$i],$fc[$i],$rayon,$rouge, "","","1");
	if($i>0)
	{
		$dfc->$couleur_courante = $rouge;
		$dfc->line($t[$i-1],$fc[$i-1],$t[$i],$fc[$i]);
	}

}
// affichage du dessin
$dfc->affiche_image("Patient - ".$victime);
//$dfc->affiche_image("Patient - ".date("H",$t[0]));
?>