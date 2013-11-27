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
//
//----------------------------------------- SAGEC ---------------------------------------------
//
//	programme: 		allemagne.php
//	date de création: 	31/01/2004
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			31/01/2004
//
//---------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../carto_utilitaires.php');
require "../classe_dessin.php";
/**
/* Lit les coordonnées d'un pays et retourne un objet polygone le contenant
*/
function lire_pays($nom)
{
	$fp = ouvre_fichier($nom);
	$p = new polygone();
	$p->file2polygone($fp);
	fclose($fp);
	$p->enveloppe();
	return $p;
}
/**
/* dessine le contour d'un pays et peint le polygone avec $couleur
/* $d = objet de dessin
/* $p = objet polygone en coord.réelles
*/
function dessine_pays($d,$p,$couleur)
{
	$dp = $d->polygoneU2E($p->getPolygone());
	$d->dessine_polygone($dp,$couleur,"");
}

/*
// lit la carte de france
$fp = ouvre_fichier("../carto/france.txt");
$p = new polygone();
$p->file2polygone($fp);
fclose($fp);
$p->enveloppe();
// lit la carte de l'Allemagne
$fp = ouvre_fichier("../carto/allemagne.txt");
$p2 = new polygone();
$p2->file2polygone($fp);
fclose($fp);
$p2->enveloppe();
$e = $p2->getEnveloppe();
//enveloppe globale
$e = $p->add_enveloppe($e);
// lire la carte de Suisse
$fp = ouvre_fichier("../carto/suisse.txt");
$p3 = new polygone();
$p3->file2polygone($fp);
fclose($fp);
$p3->enveloppe();
//enveloppe globale
$e = $p->add_enveloppe($p3->getEnveloppe());
*/
$france = lire_pays("../carto/europe.txt");
$e = $france->getEnveloppe();
//$allemagne = lire_pays("../carto/allemagne.txt");
//$e = add_enveloppe($france->getEnveloppe(),$allemagne->getEnveloppe());
/*
$suisse = lire_pays("../carto/suisse.txt");
$e = add_enveloppe($e,$suisse->getEnveloppe());
$pologne = lire_pays("../carto/pologne.txt");
$e = add_enveloppe($e,$pologne->getEnveloppe());
$italie1 = lire_pays("../carto/italie1.txt");
$e = add_enveloppe($e,$italie1->getEnveloppe());
$espagne1 = lire_pays("../carto/espagne1.txt");
$e = add_enveloppe($e,$espagne1->getEnveloppe());
$portugual = lire_pays("../carto/portugual.txt");
$e = add_enveloppe($e,$portugual->getEnveloppe());
$belgique = lire_pays("../carto/belgique.txt");
$e = add_enveloppe($e,$belgique->getEnveloppe());
$paysbas = lire_pays("../carto/paysbas.txt");
$e = add_enveloppe($e,$paysbas->getEnveloppe());
*/
//
// zone réservée au dessin:
$image_width = 660;//660 * 2;//$_GET[zoom];//660 440
$image_heigth = 800;//800 * 2;//$_GET[zoom];//800 553
//correction de proportionalité
$univers_h = $e[3] - $e[1];
$univers_w = $e[2] - $e[0];
if($univers_w > $univers_h)
	$image_heigth = $univers_h*$image_width/$univers_w;
else
	$image_width = $image_heigth*$univers_w/$univers_h;
//======================= Initialisation de la zone de dessin =================================
$d = new CDessin($image_heigth,$image_width,$e[3],$e[0],$e[1],$e[2]);
$peachpuff = imagecolorAllocate($d->pic,0xFF,0xda,0xB9);
$moccasin = imagecolorAllocate($d->pic,0xFF,0xE4,0xB5);
$bleu = imagecolorAllocate($d->pic,0x00,0x00,0xff);
$rouge = imagecolorAllocate($d->pic,0xff,0x00,0x00);
/*
// dessine la France
$dp = $d->polygoneU2E($p->getPolygone());
$couleur = $moccasin;
$d->dessine_polygone($dp,$couleur,"");
// dessine l'Allemagne
$dp = $d->polygoneU2E($p2->getPolygone());
$couleur = $peachpuff;
$d->dessine_polygone($dp,$couleur,"");
// dessine la Suisse
$dp = $d->polygoneU2E($p3->getPolygone());
$couleur = $peachpuff;
$d->dessine_polygone($dp,$couleur,"");
*/
dessine_pays($d,$france,$moccasin);
/*
dessine_pays($d,$allemagne,$peachpuff);
dessine_pays($d,$suisse,$peachpuff);
dessine_pays($d,$pologne,$peachpuff);
dessine_pays($d,$italie1,$peachpuff);
dessine_pays($d,$espagne1,$peachpuff);
dessine_pays($d,$portugual,$peachpuff);
dessine_pays($d,$belgique,$peachpuff);
dessine_pays($d,$paysbas,$peachpuff);
*/
// strasbourg
$x=8250;
$y=-13950;
$d->cercle($x,$y,$rayon="5",$rouge, $bleu,"","o");
// brest
$x=4825;
$y=-13200;
$d->cercle($x,$y,$rayon="5",$rouge, $bleu,"","o");
//
$d->affiche_image("Cartographie SAMU 67 - Europe");
?>
