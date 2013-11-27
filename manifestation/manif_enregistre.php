<?php
/**----------------------------------------- SAGEC ---------------------------------
  * This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
  * SAGEC67 is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation; either version 2 of the License, or
  * (at your option) any later version.
  * SAGEC67 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * You should have received a copy of the GNU General Public License
  * along with SAGEC67; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */	
/** ---------------------------------------------------------------------------------
  * programme: 			manif_enregistre.php
  * date de création: 	12/06/2011
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
$titre_principal = "Manifestations sportives";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");
//print_r($_REQUEST);

/**
  *	calcul des indices de risques
  */
  function risque($niveau)
  {
  		switch($niveau)
  		{
  			case 1: $c = 0.25; break;
  			case 2: $c = 0.30; break;
  			case 3: $c = 0.35; break;
  			case 4: $c = 0.40; break;
  		}
  		return $c;
  }

$limite = 1E5;
$p1 = Security::str2db($_REQUEST['nombre']);
if($p1 < $limite)$p = $p1;
else $p = $limite + ($p1 - $limite)/2;
$p2 = $_REQUEST['p2'];
$e1 = $_REQUEST['e1'];
$e2 = $_REQUEST['e2'];

$rp2 = risque($_REQUEST['p2']);
$re1 = risque($_REQUEST['e1']);
$re2 = risque($_REQUEST['e2']);

$i = $rp2 + $re1 + $re2;
$ris = ceil($i * $p/1000);

$manifID = Security::str2db($_REQUEST['manifID']);
$name = Security::str2db($_REQUEST['nom']);
$desc = Security::str2db($_REQUEST['desc']);
$date1 = Security::str2db(fdate2usdate($_REQUEST['date1']));
$date2 = Security::str2db(fdate2usdate($_REQUEST['date2']));
$postes = Security::str2db($_REQUEST['postes']);
$moyens = Security::str2db($_REQUEST['moyens']);
$contact = Security::str2db($_REQUEST['contact']);
$validation = Security::str2db($_REQUEST['valide']);
$ville = Security::str2db($_REQUEST['villeID']);
$org = Security::str2db($_REQUEST['org']);
$devenir = Security::str2db($_REQUEST['devenir']);
$validepar = Security::str2db($_REQUEST['validepar']);

/** qualification du dispositif */
	if($ris <= 0.25){$dps = 1;$qualif = "DPS pas obligatoire";}
	else if($ris <= 1.125){$dps = 2;$qualif = "Point d\'alerte et de premiers secours";}
	else if($ris <= 12){$dps = 3;$qualif = "DPS de petite envergure";}
	else if($ris <= 36){$dps = 4;$qualif = "DPS de moyenne envergure";}
	else {$dps = 1;$qualif = "DPS de grande envergure";}

/** nombre de scouristes nécessaires 
	 echo($number & 1); // $number = any integer, 0 = even, 1 = odd 
*/
$nb_secoursites = 0;
if($ris > 1.25 && $ris <= 4) $nb_secoursites = 4;
	else if($ris > 4){
		if($ris & 1)$nb_secoursites = $ris + 1;
		else $nb_secoursites = $ris;
	}


if(strlen($manifID)>0)
{
	$requete = "UPDATE manifestation SET
					manif_nom = '$name',
					manif_description = '$desc',
					manif_debut = '$date1',
					manif_fin = '$date2',
					manif_nb = '$p1',
					manif_itr = '$i',
					manif_dispositif = '$qualif',
					manif_secouristes = '$nb_secoursites',
					manif_risk_public = '$p2',
					manif_risk_environ = '$e1',
					manif_risk_secours = '$e2',
					manif_ps = '$postes',
					manif_moyens = '$moyens',
					manif_contacts = '$contact',
					manif_valide = '$validation',
					manif_ville_ID = '$ville',
					manif_org = '$org',
					manif_devenir = '$devenir',
					manif_validepar = '$validepar'
					WHERE manif_ID = '$manifID'
					";
	$resultat = ExecRequete($requete,$connexion);
}
else
{
	$requete = "INSERT INTO `pma`.`manifestation` (`manif_ID`, `manif_nom`, `manif_description`, `manif_debut`, `manif_fin`, `manif_nb`, `manif_itr`, `manif_dispositif`, `manif_secouristes`, `manif_risk_public`,
	 `manif_risk_environ`, `manif_risk_secours`, `manif_ps`, `manif_moyens`, `manif_contacts`,manif_valide,manif_ville_ID,manif_org,manif_devenir,manif_validepar) 
					VALUES (NULL, '$name', '$desc', '$date1', '$date2', '$p1', '$i', '$qualif', '$nb_secoursites', '$p2', '$e1', '$e2', '$postes', '$moyens', 
					'$contact','$validation','$ville','$org',$devenir,$validepar)
					";
	$resultat = ExecRequete($requete,$connexion);
	$manifID =  mysql_insert_id();
}
//echo $requete;

header("Location:manif_new.php?itr=".$i."&ris=".$ris."&dps=".$qualif."&sec=".$nb_secoursites."&manifID=".$manifID);
?>