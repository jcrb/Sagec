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
//---------------------------------------------------------------------------------------------------------
/**
* 	alertes sanitaires
*	@programme 		cusum_graphe.php
*	@date de cr�ation: 	20/01/2007
*	@author jcb
*	@version $Id$
*	@update le 20/01/2007
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once '../../phplot/phplot.php';
/*
$param="jour\tdate\taffaires\tmoyenne\tecart-type\tSt\tCusum\n";
*/
$data = file('cusum.txt');// attention la ligne 0 contient les intitul�s des colonnes
if($_REQUEST['service']==111) $service="SAMU 67";else $service="SAMU 68";
// recul: nombre de jours repr�sent�s. Par d�faut les 50 derniers
if(!$_REQUEST['recul']) $recul = 50; else $recul = $_REQUEST['recul'];
// �cart-type
$sigma = 1.96;
$N=sizeof($data);
$debut = $N-$recul;
//$fin = $n-1;

// r�cup�ration des donn�es du fichier
$j = 0;
$n = array();
$ymin = 100000; // pour d�terminer le seuil minimal de l'axe des Y
//for($i = $debut; $i< $fin;$i++)
for($i = 1; $i< $N;$i++)
{
	$x = explode("\t",$data[$i]);
	$n[$j][0]=$x[1];
	$n[$j][1]=(double)$x[2];// nb d'affaires
	if($n[$j][1] < $ymin) $ymin = $n[$j][1];
	$n[$j][2]=(double)$x[3];// moyenne liss�e
	$n[$j][3]=(double)$x[3] + $sigma*(double)$x[4];// �cart � 95%
	$j++;
}
//d�termine la valeur minimale pour Y arrondi � la dizaine ou centaine inf�rieure
$val = $ymin;
$xc = 0;
while($val > 10)
{
	$val = $val/10;
	$xc++;
}
$val = floor($val);
$ymin = $val*pow(10,$xc);
//create a PHPlot object with 800x600 pixel image
$plot =& new PHPlot(1000,700);
// dessine un cadre
$plot->SetImageBorderType('plain');
// Neutralise l'affichage automatique (uniquement pour les dessins complexes
$plot->SetPrintImage(0);
// d�finition de la premi�re zone de dessin
	$plot->SetPlotAreaPixels(80, 40, 900, 350);
	
	//$plot->SetPlotType('area');

	$plot->SetDataValues($n);
	$plot->SetPlotAreaWorld(NULL, $ymin, NULL, NULL);
	//Set titles
	$plot->SetTitle("Activit� du ".$service."\nDossiers c��s");
	$plot->SetXTitle('Jours');
	$plot->SetYTitle('Dossiers cr��s');

	$plot->SetYTickIncrement(100);
	$plot->SetLegend(array('dossiers', 'moyenne mobile (7 jours)','Limite sup (95%)'));
	//Turn off X axis ticks and labels because they get in the way:
	$plot->SetXTickLabelPos('none');
	$plot->SetXTickPos('none');

	//$plot->SetNumXTicks(10);
	$plot->SetXLabelAngle(90);
	//Draw it
	$plot->DrawGraph();

// d�finition de la deuxi�me zone de dessin
	$plot->SetPlotAreaPixels(80, 450, 900, 600);
	//pr�paration des valeurs
	$j = 0;
	$m = array();
	//for($i =  $debut; $i< $fin;$i++)
	for($i = 1; $i< $N;$i++)
	{
		$x = explode("\t",$data[$i]);
		$m[$j][0]=$x[1];// date
		$m[$j][1]=(double)$x[6];// Cusum
		$j++;
	}
	$plot->SetDataValues($m);
	$plot->SetPlotAreaWorld(NULL, 0, NULL, 6);
	$plot->SetYTitle('CUSUM');
	$plot->SetYTickIncrement(0.5);
	$plot->SetLegend(array('R�sidus cumul�s'));
	//Turn off X axis ticks and labels because they get in the way:
	$plot->SetXTickLabelPos('none');
	//$plot->SetXTickPos('none');
	$plot->SetNumXTicks(10);
	$plot->SetXLabelAngle(90);
	$plot->SetDataColors(array('blue'));
	$plot->DrawGraph();
// ligne alerte
	$j = 0;
	//for($i = $debut; $i< $fin;$i++)
	for($i = 1; $i< $N;$i++)
	{
		$x = explode("\t",$data[$i]);
		$m[$j][0]=$x[1];// date
		$m[$j][1]=2;// Cusum
		$j++;
	}
	$plot->SetDataValues($m);
	$plot->SetDataColors(array('red'));
	$plot->SetPlotType('lines');
	$plot->SetLegend(array('Alerte'));
	$plot->DrawGraph();

// Affichage
$plot->PrintImage();
?>