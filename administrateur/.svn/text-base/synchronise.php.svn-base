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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		synchronise.php
//	date de création: 	17/11/2005
//	auteur:			jcb
//	description:		client XML-RPC
//	version:		1.0
//	maj le:			17/11/2005
//
//--------------------------------------------------------------------------------------------------------
include('../hxp/IXR_Library.inc.php');
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

// Specifying a HXP server by URL (port 80 is assumed):
// Appelle le serveur des HUS
$client = new IXR_Client('http://sagec67.chru-strasbourg.fr/SAGEC67/hxp/serveur.php');

//test
//$client = new IXR_Client('http://localhost/SAGEC67_v3/hxp/serveur.php');

/*
if (!$client->query('Sagec.Methods',$header)){
	die('Something went wrong '.$client->getErrorCode().' : '.$client->getErrorMessage());
}
$reponse = $client->getResponse();
print_r($reponse);
*/

$header['usr'] = 'jcb';//DRKFriburg
$header['pw'] = 'jcb';
$header['lang'] = 'FR';
if (!$client->query('Sagec.lits',$header)){
	die('Etwas ging falsch '.$client->getErrorCode().' : '.$client->getErrorMessage());
}
$reponse = $client->getResponse();
$n = count($reponse);
/*
echo '<TABLE BORDER=1>';
echo "<TR>";
	echo "<TD>Hôpital</TD>";
	echo "<TD>Ville</TD>";
	echo "<TD>Service</TD>";
	echo "<TD>Specialité</TD>";
	echo "<TD>Lits autorisés</TD>";
	echo "<TD>Lits disponibles</TD>";
	echo "<TD>Lits libérables</TD>";
	echo "<TD>MAJ</TD>";
echo "</TR>";

for($i=0;$i<$n;$i++)
{
	echo "<TR>";
	echo "<TD>".$reponse[$i][0]."</TD>";
	echo "<TD>".$reponse[$i][7]."</TD>";
	echo "<TD>".$reponse[$i][1]."</TD>";
	echo "<TD>".$reponse[$i][2]."</TD>";
	echo "<TD><div align=\"right\">".$reponse[$i][3]."</div></TD>";
	echo "<TD><div align=\"right\">".$reponse[$i][4]."</div></TD>";
	echo "<TD><div align=\"right\">".$reponse[$i][5]."</div></TD>";
	echo "<TD><div align=\"right\">".date('j/m/Y',$reponse[$i][6])."</div></TD>";
	echo "</TR>";
}
echo '</TABLE>';
print("<br><br>");
*/
for($i=0;$i<$n;$i++)
{
	$nom_hopital =  addslashes($reponse[$i][0]);//échappe les caractères indésirables, not apostrophe
	$requete = "SELECT Hop_ID FROM hopital WHERE Hop_nom = '$nom_hopital'";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	$hopital = $rub['Hop_ID'];
	/*
	while($rub=mysql_fetch_array($resultat))
	{
		print($nom_hopital."  ".$rub['Hop_ID']."<br>");
	}*/
	$nom_service =  addslashes($reponse[$i][1]);//échappe les caractères indésirables, not apostrophe
	$requete = "SELECT service_ID FROM service WHERE service_nom ='$nom_service' AND Hop_ID = '$hopital'";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	$service = $rub['service_ID'];
	//print($requete." ".$service."<br>");
	
	//print($nom_hopital."  ".$rub['Hop_ID']." ".$nom_service." ".$service."<br>");
	$litsdispo = $reponse[$i][4];
	$litsauto = $reponse[$i][3];
	$litsliberable = $reponse[$i][5];
	$maj = $reponse[$i][6];
	$litsoccupes = $litsauto - $litsdispo;
	$requete = "UPDATE lits SET lits_sp = '$litsauto',lits_dispo = '$litsdispo',lits_liberable ='$litsliberable',lits_occ='$litsoccupes',date_maj = '$maj'
			WHERE service_ID = '$service'";
	print($requete."<br>");
	$resultat = ExecRequete($requete,$connexion);
}
?>
