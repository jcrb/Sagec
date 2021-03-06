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
//	programme: 			dump_database.php
//	date de cr�ation: 	06/01/2006
//	auteur:				jcb
//	description:		r�cup�rer les donn�es d'une base
//	version:			1.0
//	maj le:				06/01/2006
//
//--------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");
require("utilitaires_table.php");
require("../utilitaires/zipfile.php");
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
//
$database = 'pma2';
$file_name="pma2_data.sql";
//
$fp = fopen($file_name,"w");
//
$requete = "SHOW TABLES";
$resultat = ExecRequete($requete,$connect);
while($rub=mysql_fetch_array($resultat))
//for($j=0;$j<10;$j++)
{
	//$rub=mysql_fetch_array($resultat);
	$table = $rub[0];
	//print("-- table: ".$table."<br>");
	fwrite($fp,"--\n");
	fwrite($fp,"-- table: ".$table."\n");
	fwrite($fp,"--\n");
	$requete2 = "SHOW COLUMNS FROM ".$table;
	$resultat2 = ExecRequete($requete2,$connect);
	$mot="INSERT INTO ".$table." (";
	$col = mysql_fetch_array($resultat2);
	$mot .= "`".$col[0]."`";
	while($col=mysql_fetch_array($resultat2))
	{
		$mot .= ",`".$col[0]."`";
	}
	$mot .= ") VALUES (";
	$requete3 = "SELECT * FROM ".$table;
	$resultat3 = ExecRequete($requete3,$connect);
	while($val= mysql_fetch_array($resultat3))
	{
		$mot2 = $mot;
		$x= str_replace ("'", "\'", $val[0]);
		$mot2 .= "'".$x."'";
		for($i=1;$i<sizeof($val)/2;$i++)
		{
			$x= str_replace ("'", "\'", $val[$i]);
			$mot2 .= ","."'".$x."'";
		}
		$mot2 .= ");";
		//print($mot2."<br>");
		fwrite($fp,$mot2."\n");
	}
}
fclose($fp);
/**
*	Compression du fichier au format Zip
*/
//print("compression des donn�es <br>");
$data =  implode("",file($file_name));
$gzdata = gzencode($data, 9);
$fp = fopen($file_name.".gz", "w");
fwrite($fp, $gzdata);
fclose($fp);
//print("Termin� <br>");

header("Content-disposition: filename=".basename($file_name));
header("Content-type: application/octetstream");
header("Pragma: no-cache");
header("Expires: 0");
readfile("$file_name");
unlink($file_name);
unlink($file_name.".gz");
exit();

?>