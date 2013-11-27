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
*	@programme 		histogramme_artichow.php
*	@date de création: 	01/03/2007
*	@author jcb
*	@version $Id$
*	@update le 01/03/2007
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once "../artichow/BarPlot.class.php";
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("classe_histogramme.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$nbDeClasses = 6; 	// nb de classes de l'histogramme
$etendue = 10;			// étendue d'une classe
$borneInf = 0;			// limite inférieure pour le recueil des données 
$mode = 'VALEUR'; // les résultats sont exprimés en % alternative = valeur absolue VALEUR, CUMUL, PCUMUL 
$h = new CHistogramme($nbDeClasses,$etendue,$borneInf,$mode);
$choix = 'SPECIALITE'; // choix de la table SPECIALITE_ID ou TYPE_ID 
$service = 6; // dépend de la valeur de $choix 
$titre = "Réanimation médicale";
if($choix == 'TYPE')
{
	$requete="SELECT DATE_FORMAT(FROM_UNIXTIME(date),'%e/%m/%Y'),date,SUM(lits_dispo) 
				FROM lits_journal,service
				WHERE lits_journal.service_ID = service.service_ID
				AND service.type_ID = '$service'
				GROUP BY 1
				ORDER BY 2";
}
else
{
	$requete="SELECT DATE_FORMAT(FROM_UNIXTIME(date),'%e/%m/%Y'),date,SUM(lits_dispo) 
				FROM lits_journal,service
				WHERE lits_journal.service_ID = service.service_ID
				AND service.specialite_ID = '$service'
				GROUP BY 1
				ORDER BY 2";
}

$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		$h->addData($rub[2]);
	}				

$data = $h->arraySimple();
$name = $h->piedDeColonne();
//print_r($data);
$graph = new Graph(400,400);
//$graph->border->hide(); // pour masquer le cadre 
$plot = new BarPlot($data);

$plot->title->set($titre);

$plot->setXAxisZero(TRUE);
$plot->xAxis->setLabelText($name);
$plot->xAxis->title->set("Lits disponibles");

if($mode == "POURCENTAGE")
	$plot->yAxis->title->set("valeurs en %");
else
	$plot->yAxis->title->set("valeurs absolues");
$plot->yAxis->title->move(-4, 0);// écarte vers la gauche le titre de l'axe

$plot->setBarColor(new Color(240,130,20));
$graph->add($plot);
$graph->draw();
?>