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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		reporting_graphe.php
//	date de création: 	29/07/2005
//	auteur:			jcb
//	description:		choix des éléments de reporting
//	version:			1.0
//	maj le:			29/07/2005
//
//--------------------------------------------------------------------------------------------------------
session_start();
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../date.php");
//include("../utilitaires/table.php");
require("../classe_stat.php");
require_once "../classe_dessin.php";
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//
$date1 = fDate2unix($_GET['date1']);
$date2 = fDate2unix($_GET['date2']);
//	Occupation des Lits de réanimation ,organisme,ville
$requete = "SELECT date, lits_dispo,lits_journal.service_ID
			FROM lits_journal, service
			WHERE lits_journal.service_ID = service.service_ID ";
			if($_GET['service']==1)
				$requete .= "AND service.Type_ID = '$_GET[type_s]' ";
			else{
				$ttservice = $_GET['ttservice'];
				for($i=0;$i<sizeof($ttservice)-1;$i++)
					$liste .= $ttservice[$i].",";
				$liste .= $ttservice[sizeof($ttservice)-1];
				$requete .= " AND lits_journal.service_ID IN(".$liste.")";
			}
			/*
			$depart = $_GET['depart'];
			if(!in_array(0, $depart))// on sélectionné des départements
			{
				for($i=0;$i<sizeof($depart)-1;$i++)
					$liste2 .= $depart[$i].",";
				$liste2 .= $depart[sizeof($depart)-1];
				$requete .= " AND lits_journal.service_ID = service.service_ID";
				$requete .= " AND service.org_ID = organisme.org_ID";
				$requete .= " AND organisme.ville_ID = ville.ville_ID";
				$requete .= " AND ville.departement_ID IN(".$liste2.")";
			}
			*/
			$requete .= " AND date BETWEEN '$date1' AND '$date2'";
			$requete .= " ORDER BY date";
$resultat = ExecRequete($requete,$connexion);
//print($requete);
//
while($rub=mysql_fetch_array($resultat))
{
	$lits[$rub['service_ID']]=$rub['lits_dispo'];
	$total = 0;
	reset($lits);
	while($elem=each($lits))
	{
		$total+=$elem['value'];
	}
	$lits_dispo[$rub[date]] = $total;
}
//
while($elem=each($lits_dispo))
{
	$d = $elem['key'];
	$t = $elem['value'];
	//print(uDatetime2French($d)." -> ".$t."<br>");
}
// zone réservée au dessin:
$image_width = 800;// 365 -730-1095
$image_heigth = 400;//800 * 2;//$_GET[zoom];//800 553
//Initialisation de la zone de dessin
$jour = 24*60*60;//secondes
$clefs = array_keys($lits_dispo);
$date1 = $clefs[0]-$jour;
$date2 = $date2+$jour;//$clefs[sizeof($clefs)-1]+$jour;
$nb_jour =($date2-$date1)/$jour;
$U_haut = max($lits_dispo)+5;
$U_bas = 0;
$U_gauche = $date1;
$U_droit = $date2;// nb de jours, 1 année = 365 jours
$dfc = new CDessin($image_heigth,$image_width,$U_haut,$U_gauche,$U_bas,$U_droit);
//marges
$haute = 20;
$basse = 100;
$gauche = 35;
$droite = 20;
$dfc->setMarges($haute,$basse,$gauche,$droite);
// Allocation des couleurs
$vert_clair = imagecolorAllocate($dfc->pic,0x99,0xff,0x66);
$vert = imagecolorAllocate($dfc->pic,0x00,0xff,0x00);
$orange = imagecolorAllocate($dfc->pic,0xff,0x66,0x00);
$rouge = imagecolorAllocate($dfc->pic,0xff,0x00,0x00);
$bleu = imagecolorAllocate($dfc->pic,0x00,0x66,0xff);
// grilles
$dfc->grilleH($U_haut,$U_bas,1,10,$U_gauche,$U_droit,$vert_clair,$vert_clair);
$xinc = 1*$jour;// 30jours
$xinter = 1;//intervalle entre 2 graduations en jours
$dfc->grilleV($U_gauche,$U_droit,$xinc,$xinter,$U_bas,$U_haut,$vert,$vert_clair);
$mot="Nombre de lits disponibles";
$y=(400+strlen($mot)*5)/2;
$dfc->pprint($mot,10,$y,0,0,0,10,'C',90);
$mot= "Disponibilité des lits de réanimation (période du ".$_GET['date1']." au ".$_GET['date2'].")";
$dfc->pprint($mot,($droite+$gauche)/2,10,0,0,0,10,'L',0);
//
$dfc->$couleur_courante = $rouge;
reset($lits_dispo);
$elem=each($lits_dispo);
$x = $elem['key'];
$y = 0;//$elem['value'];
reset($lits_dispo);
$dfc->va_en($x,$y);
while($elem=each($lits_dispo))
{
	$x = $elem['key'];
	$y = $elem['value'];
	$dfc->trace_vers($x,$y);
}
$dfc->trace_vers($U_droit,0);
//
$dfc->affiche_image();
//

?>
