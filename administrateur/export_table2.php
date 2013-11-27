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
//
//	programme: 		export_table.php
//	date de création: 	12/02/2005
//	auteur:			jcb
//	description:		export de données du serveur vers l'utilisateurs
//	version:			1.0
//	maj le:			12/02/2005
//
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");
$tab = "\t";
$maxLignes = 13796/2; // correspond à un fichier de 2M0 pour les RPU


//----------------------- fichier -------------------------------
$etablissement = Security::str2db($_REQUEST["etablissement"]);
$date1 = Security::str2db($_REQUEST["date1"]);
$date2 = Security::str2db($_REQUEST["date2"]);
$table = Security::str2db($_REQUEST["table"]);
$v = $table.".txt";
$fp = fopen($v,"w");

$date1 = fdate2usdate($date1);
$date2 = fdate2usdate($date2);

//---------------------------------------------------------------
/** pour les test */
//$maxLignes = 10;
$etablissement = "670000397";
//$date1 = "2009-08-06";
//$date2 = "2009-12-31";
/** end test */

// lecture de la table
$requete = "SELECT * FROM $table ";
				WHERE finess = '$etablissement'
				AND date_jour BETWEEN '$date1' AND '$date2'
				ORDER BY date_jour
				";
				//echo $requete;
			
				
$resultat = ExecRequete($requete,$connexion);
$num_rows = mysql_num_rows($resultat);
//echo "nb.colonnes: ".$num_rows."<br>";
if($num_rows > $maxLignes)
	 $num_rows = $maxLignes;
	 
//$resultat = ExecRequete($requete,$connexion);
for($i=0; $i< $num_rows; $i++)
{
	$rub=mysql_fetch_array($resultat);
	$ligne = implode("\t",$rub)."\n";
	fwrite($fp,$ligne);
	//print($ligne.'<br>');
}
fclose($fp);

header("Content-disposition: filename=".basename($v));
header("Content-type: application/octetstream");
header("Pragma: no-cache");
header("Expires: 0");
readfile("$v");
exit();

?>
