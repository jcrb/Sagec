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
//	programme: 		dessine_graphe_veille_samu2.php Utilise PHPlot
//	date de cr�ation: 	03/02/2007
//	@author:			jcb
//	description:		Graphe de tendance de l'activit� du SAMU
//	@version $Id$
//	maj le:			03/02/2007
* 	@package Sagec
*/
//-----------------------------------------------------------------------------
//session_start();
//ini_set('display_errors','1');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("../date.php");
require_once("../phplot/phplot.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require '../classe_stat.php';
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete = stripslashes($_REQUEST['requete']);
$service = $_REQUEST['service'];
$resultat = ExecRequete($requete,$connexion);
// lecture des donn�es
$n = 0;
$data = array();
while($rub=mysql_fetch_array($resultat))
{
	$data[] = $rub;
	$data[$n]['date'] = uDate2French($rub['date']);
	$data[$n][0] = uDate2French($rub['date']);
	//$data[$n]['nb_dossier'] = $rub['dossier'];
	$n++;
}
// si moyenne liss�e
$plissage = 7;
$debut = 0;
$sigma = 1.96;
// calcul de la premi�re moyenne
$Stat = new CStat();
for($j=$plissage; $j<$n;$j++)
{
	$Stat->clear();
	$debut = $j-$plissage;
	$fin = $debut + $plissage;
	for($i=$debut;$i<$fin;$i++)
	{
		$Stat->addx($data[$i][1]);
	} 
	$mean = $Stat->moyenne(); // moyenne
	$sd = $Stat->ecart_type(); // // �cart-type
	$data[$j][2] = $mean;
	$data[$j][3] = $mean+$sigma*$sd;
	$data[$j][4] = $mean-$sigma*$sd;
}

//print_r($data);
if($service=='111')
	$titre = "SAMU 67";
	elseif($service=='152')
	$titre = "SAMU 68";
	else $titre = "SAMU 67 & du SAMU 68";
$soustitre = "test";
//create a PHPlot object with 800x600 pixel image
$plot =& new PHPlot(1000,700);
// dessine un cadre
$plot->SetImageBorderType('plain');
// Neutralise l'affichage automatique (uniquement pour les dessins complexes
//$plot->SetPrintImage(0);
// d�finition de la premi�re zone de dessin
	//$plot->SetPlotAreaPixels(80, 40, 900, 350);
	$plot->SetDataValues($data);
	//Set titles
	$plot->SetTitle("Activit� du ".$titre."\n".$soustitre);
	$plot->SetXTitle('Jours');
	$plot->SetYTitle('Dossiers cr��s');
	$plot->SetYTickIncrement(100);
	$plot->SetLegend(array('dossiers', 'moyenne mobile (7 jours)','Limite sup (95%)'));
	//Turn off X axis ticks and labels because they get in the way:
	$plot->SetXTickLabelPos('none');
	$plot->SetXTickPos('none');
	$plot->SetNumXTicks(10);
	$plot->SetXLabelAngle(90);
	//Draw it
	$plot->DrawGraph();
?>

