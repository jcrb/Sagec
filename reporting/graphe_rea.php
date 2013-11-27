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
* 	
*	@programme 		graphe_rea.php
*						Dessine un graphe
*	@date de création: 	01/03/2008
*	@author jcb
*	@version $Id$
*	@update le 01/03/2008
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
//
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// Vérification de l'existence des données ou exit si elles n'existent pas
$data = $_REQUEST['values'];
$titre = $_REQUEST['titre'];
$date = $_REQUEST['date'];
$mode = $_REQUEST['mode'];
if(isset($data)===FALSE) exit;
// Récupération des données sérialisées
if(!$datas = unserialize(stripslashes($data))) print("erreur");
if(!$dates = unserialize(stripslashes($date))) print("erreur");
// Vérifie que les données sont correctes
if(is_array($datas)===FALSE) exit;

require_once "../artichow/LinePlot.class.php";
// Création d'une courbe basique
$plot = new LinePlot($datas);
$plot->setFillColor(new Color(240,130,20));
if($mode == 'pc')
{
	$plot-> setYMax(100);
	$plot->yAxis->title->set("% de lits occupés");
}
else
{
	$plot->yAxis->title->set("Lits disponibles");
}
//$plot->axis->bottom->setLabelText($date);// mets les dates
// n'affiche qu'un label x sur 5
$plot->xAxis->setLabelText($dates);
$plot->xAxis->setLabelInterval(5);
$plot->title->setPadding(3, 3, 3, 3);
$plot->title->move(-20,2);
$plot->title->set($titre);

// Création du graphique
$graph = new Graph(500,400);
//$graph->title->set($titre);
$graph->setAntiAliasing(TRUE);

$graph->add($plot);
// Affichage du graphe
$graph->draw();
?>