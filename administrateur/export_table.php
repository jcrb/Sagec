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
$langue = $_SESSION['langue'];
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");
$tab = "\t";
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

//----------------------- fichier -------------------------------
//$racine="/tmp/sagec/";
$racine="";
$v = $racine.$_GET['table'].".txt";
$fp = fopen($v,"w");
//---------------------------------------------------------------
// nombre de colonnes de la table: $num_rows
$requete = "SHOW COLUMNS FROM $_GET[table]";
$resultat = ExecRequete($requete,$connect);
$num_rows = mysql_num_rows($resultat);
// lecture de la table
$requete = "SELECT * FROM $_GET[table]";
$resultat = ExecRequete($requete,$connect);
while($rub=mysql_fetch_array($resultat))
{
	$ligne = implode("\t",$rub)."\n";
	/*
	for($i=0;$i<$num_rows;$i++)
	{
		$ligne.=$rub[$i].$tab;
	}
	$ligne.= "\n";
	*/
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
