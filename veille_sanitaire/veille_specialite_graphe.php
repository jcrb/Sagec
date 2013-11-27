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
*	@programme 		veille_specialite_graphe.php
*	@date de création: 	20/01/2007
*	@author jcb
*	@version $Id$
*	@update le 20/01/2007
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once '../phplot/phplot.php';
/*
$param="jour\tdate\taffaires\tmoyenne\tecart-type\tSt\tCusum\n";
*/
$data = array();
$fp = fopen('data.txt','r');
$N=0;
$y = array();
while(!feof($fp))
{
	$x = fgets($fp,1020);
	if($x)
	{
		$y = explode("\t",$x);
		$data[$N][0] = $y[0];// date
		$data[$N][1] = (int)$y[1];// valeur
		if($N > 7)
		{
			$sommeX = 0;
			$sommeX2 = 0;
			for($i=$N-7;$i<$N;$i++)
			{
				$sommeX += $data[$i][1];
				$sommeX2 += $data[$i][1]*$data[$i][1];
			}
			$data[$i][2] = $sommeX/7;
			$data[$i][3] = $data[$i][2] + 1.96*sqrt(($sommeX2-$sommeX * $sommeX / 7)/6);
		}
		$N++;
	}
}
//print_r($data);
// écart-type
//$sigma = 1.96;

//create a PHPlot object with 800x600 pixel image
$plot =& new PHPlot(1000,600);
// dessine un cadre
$plot->SetImageBorderType('plain');
// Neutralise l'affichage automatique (uniquement pour les dessins complexes
//$plot->SetPrintImage(0);
// définition de la première zone de dessin
//$plot->SetPlotAreaPixels(80, 40, 900, 350);
	$plot->SetDataValues($data);
	//Set titles
	//$plot->SetTitle("Activité du ".$service."\nDossiers céés");
	$plot->SetXTitle('Jours');
	$plot->SetYTitle('Lits disponibles');
	$plot->SetLegend(array('Lits disponibles', 'moyenne mobile (7 jours)','Limite sup (95%)'));
	//Turn off X axis ticks and labels because they get in the way:
	$plot->SetXTickLabelPos('none');
	//$plot->SetXTickPos('none');
	$plot->SetNumXTicks(10);
	$plot->SetXLabelAngle(90);
	//Draw it
	$plot->DrawGraph();
/*
// définition de la deuxième zone de dessin
	$plot->SetPlotAreaPixels(80, 450, 900, 600);
	//préparation des valeurs
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
	$plot->SetLegend(array('Résidus cumulés'));
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
*/
// Affichage
//$plot->PrintImage();
?>