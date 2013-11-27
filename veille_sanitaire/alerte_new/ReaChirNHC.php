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
  * programme: 			ReaChirNHC.php
  * date de création: 	05/08/2012
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
$titre_principal = "Rea. Chir. NHC";
$sousmenu = "";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Point  de situation</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
	<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>
</head>

<body onload="">

<?php
/* création de lits disoinibles */
function create_lits()
{
	$date_depart = 1209852000; // 7/4/2008
	$service = '613';
	global $connexion;
	for($i=1;$i<30;$i++)
	{
		$n=rand(0,9);
		$date = $date_depart + un_jour * $i;
		$lits = $n;
		//$requete = "INSERT INTO lits_journal VALUES('$date','$service','$lits','')";
		$requete = "INSERT INTO `pma`.`lits_journal` (`date` ,`service_ID` ,`lits_dispo` ,`user_ID`)VALUES ('$date','$service','$lits','')";
		$reponse = ExecRequete($requete,$connexion);
		echo $requete.'<br>';
	}
}
	//create_lits();
	$date1 = 1209852000;
	$date2 = $date1 + sept_jour*100;//AND date BETWEEN '$date1' AND '$date2'
	$requete = "SELECT date,lits_dispo
					FROM lits_journal
					WHERE service_ID = '612'
					";
					echo $requete.'<br>';
	$reponse = ExecRequete($requete,$connexion);
	while($rep = mysql_fetch_array($reponse))
	{
		echo $rep['date'].'  '.  uDatetime2French($rep['date']).'  '.$rep['lits_dispo'].'<br>';
	}
?>

</form>
</body>
</html>
