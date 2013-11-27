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
//	programme: 		badges.php
//	date de création: 	18/08/2008
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			18/08/2008
//
//---------------------------------------------------------------------------------------------
/**
* RÃ¨gles applicables Ã  la saisie des victimes
* 
* Limiter le nombre d'hÃ´pital Ã  afficher
*/
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
$path="../";
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require($path."dbConnection.php");
include_once($path."pdf/PDF_badge.php");
include_once($path."pdf/codebarre_utilitaires.php");

$nom = $_REQUEST[ch];
$nom = implode("','",$nom);

/**
*	calcule le code EAN 13
* cette fct a été relocalisée dans pdf/codebarre_utilitaires.php 

function code($persoID,$orgID,$pays=30)
{
	$organisme = substr("000".$orgID,-3);
	$service = "000";
	$individu = substr("0000".$persoID,-4);
	$code = $pays.$organisme.$service.$individu;
	for($i=strlen($code)-1;$i >0; $i-=2)
	{
		(int)$a = 3 * (int)$code[$i];
		(int)$b = (int)$code[$i-1];
		$mot = (int)$mot + (int)$a + (int)$b;
		//print($mot."<BR>");
	}
	$clef = 0;
	while(($mot+$clef) % 10 != 0)
	{
		$clef++;
	}
	return $code = $code.$clef;
}
*/

$badge = new PDF_badge();
$badge->AddPage();
$badge->SetFont("Arial","",12);
$badge->margeS = 10;
$color = "rouge";
$distance_interbadge = 5;

$requete = "SELECT Pers_ID,Pers_Nom, Pers_Prenom,perso_cat_nom,personnel.perso_cat_ID,org_nom,organisme.org_ID,service_nom, service.service_ID,photo
				FROM personnel,perso_cat,organisme,service
				WHERE personnel.perso_cat_ID = perso_cat.perso_cat_ID
				AND organisme.org_ID = personnel.org_ID
				AND service.service_ID = personnel.service_ID
				AND Pers_ID IN ('$nom')
				";
$resultat = ExecRequete($requete,$connexion);
// preparation PDF
$nbBadges = mysql_num_rows($resultat);
$nbPages = ceil($nbBadges/10);
$nbBadgesFaits = 0;
$stop = false;

// execution 

for($k = 0; $k< $nbPages; $k++)
{
	$badge->margeS = 10;
	$badge->margeG = 10;
	
	for($i=0;$i<2;$i++)
	{
		$badge->margeS = 10;
		for($j = 0; $j<5;$j++)
		{
			$rub=mysql_fetch_array($resultat);
			$nom = $rub[Pers_Nom];
			$prenom = $rub[Pers_Prenom];
			$fonction = $rub[perso_cat_nom];
			$pays=30;
			$code = code($rub[Pers_ID],$rub[org_ID],$pays);
			$hopital = $rub[org_nom];
			$service = $rub[service_nom];
			$photo = $rub[photo];
			
			switch($rub[perso_cat_ID])
			{
				case 1:case 10: case 11:$color = "bleu";break;// medecin
				case 2:case 3: case 4: case 12:$color = "vert";break;// ide
				case 5:$color = "rouge";break;// ambulanciers
				case 6:$color = "jaune";break;// parm  
				case 7:$color = "mauve";break;// secretaire
				case 8:$color = "mauve";break;// logisticien
				default:$color = "orange";
			}	
			
			//$color="ocre";
			$badge->imprime_badge($nom,$prenom,$fonction,$code,$hopital,$service,$color,$photo);
			$nbBadgesFaits++;
			if($nbBadgesFaits == $nbBadges)
			{
				$stop = true;
				break;
			}
			$badge->margeS += $badge->badge_heigth + $distance_interbadge;
		}
		if($stop) break;
		$badge->margeG += $badge->badge_width +10;
	}
	if($stop) break;
	$badge->AddPage();
}
$badge->Output();

?>