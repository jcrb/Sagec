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
*	@programme 		graphe_artichow.php
*	@date de création: 	01/03/2007
*	@author jcb
*	@version $Id$
*	@update le 01/03/2007
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once "../artichow/LinePlot.class.php";
require_once "../artichow/Graph.class.php";
//require_once "../artishow/Tools.class.php";
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../date.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	//$today = date('U');
	$today = today();
	$todayMoins30 = time()-60*60*24*30;
	// récupère la date en format unix et la met au format jour-mois-année
	$requete="SELECT DATE_FORMAT(FROM_UNIXTIME(veille_sau.date),'%e/%m/%Y'),
				veille_sau.date,
				SUM(inf_1_an),
				SUM(sup_75_an),
				SUM(entre1_75),
				SUM(hospitalise)
				FROM veille_sau
				WHERE veille_sau.date > '$todayMoins30'
				AND veille_sau.date < '$today'
				GROUP BY 1
			ORDER BY 2";

	$resultat = ExecRequete($requete,$connexion);
	/**
	* 	$data = somme des trois catégories de patients
	*	$data2 = nombre d'hospitalisés
	*	$date = date au format jour/mois
	*/
	while($rub=mysql_fetch_array($resultat))
	{
		$data[] = $rub[2]+$rub[3]+$rub[4];
		$data2[] = $rub[5];
		$date[] = date('d/m',$rub[1]);
	}

//print_r($date);

$legende=array('passages','hospitalisations');
$graph = new Graph(800,600);
$graph->setAntiAliasing(TRUE);
$graph->title->set("Activité des urgences les 30 derniers jours"); 
$group = new PlotGroup();
// On agrandit un peu les marges à gauche,droite,haut,bas
// Cela permettra d'afficher correctement un titre sur les axes
$group->setPadding(60, 40,60,60);
// On ajoute une couleur de fond à ce groupe de Plot
$group->setBackgroundColor(new Color(240, 240, 240));
// première ligne avec les passages
$plot = new LinePlot($data);
$plot->setXAxisZero(TRUE);
$plot->setFillColor(new Color(240,130,20));
$group->legend->add($plot, "Passages",2);
$group->add($plot);
// ligne des hospitalisations
$plot = new LinePlot($data2);
$plot->setFillColor(new Color(0,130,20));
$group->axis->bottom->label->setAngle(45);
$group->axis->bottom->setLabelText($date);// mets les dates
$group->axis->left->setTitlePosition(0.25);
$group->axis->left->title->set("Serveur ARH 67 - Sagec67");
$group->axis->left->title->move(-12, 0);// écarte vers la gauche le titre de l'axe
//$group->legend->add($plot, "Hospitalisations", Legend::BACKGROUND);
$group->legend->add($plot, "Hospitalisations", 2);
$group->legend->setPosition(0.25, 0.20);
$group->legend->shadow->smooth(TRUE);
$group->add($plot);
$graph->add($group);
$graph->addAbsLabel(new Label('SAGEC - Serveur ARH',new Tuffy(15),new Color(255, 0, 0,50),45), new Point(300,300));
$graph->draw();
?>
