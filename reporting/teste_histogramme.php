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
*	@programme 		teste_histogramme.php
*	@date de création: 	01/03/2007
*	@author jcb
*	@version $Id$
*	@update le 01/03/2007
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once '../phplot/phplot.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("classe_histogramme.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$nbDeClasses = 10;
$etendue = 10;
$borneInf = 0;
$mode = 'POURCENTAGE';
$h = new CHistogramme($nbDeClasses,$etendue,$borneInf,$mode);
$requete="SELECT DATE_FORMAT(FROM_UNIXTIME(date),'%e/%m/%Y'),date,SUM(lits_dispo) 
				FROM lits_journal,service
				WHERE lits_journal.service_ID = service.service_ID
				AND service.type_ID = 2
				GROUP BY 1
				ORDER BY 2";
				
$requete="SELECT DATE_FORMAT(FROM_UNIXTIME(date),'%e/%m/%Y'),date,SUM(lits_dispo) 
				FROM lits_journal,service
				WHERE lits_journal.service_ID = service.service_ID
				AND service.specialite_ID = 3
				GROUP BY 1
				ORDER BY 2";
				
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		//print($rub[2]." *** ");
		$h->addData($rub[2]);
	}

$data = $h->array2phplot();
//print_r($data);
//print("<br>".$h->frequence());
//create a PHPlot object with 800x600 pixel image
$plot =& new PHPlot(1000,600);
// dessine un cadre
$plot->SetImageBorderType('plain');
$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);
# Turn off X tick labels and ticks because they don't apply here:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
switch($mode){
	case 'POURCENTAGE':
		$plot->SetYTitle("% d'occupation");
		$plot->SetYTickIncrement(5);
		break;
	case 'PCUMUL':
		$plot->SetYTitle("% d'occupation cumulé");
		$plot->SetYTickIncrement(10);
		break;
	default:
		$plot->SetYTitle("Jours");
		$plot->SetYTickIncrement(10);
		break;
}
$plot->SetXTitle("Lits disponibles par jour");
$plot->SetTitle('Disponibilité des lits de Réanimation et Soins Intensifs');
$plot->DrawGraph();
?>