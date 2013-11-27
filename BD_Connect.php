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
//---------------------------------------------------------------------------------------------------------
//
//	programme: 		BD_Connect.php
//	date de création: 	25/12/2003
//	auteur:			jcb
//	description:
//	version:		1.0
//	maj le:			25/12/2003							 //
//---------------------------------------------------------------------------------------------------------
// ouverture d'une session
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");

print("Serveur source: ".getenv("SERVER_NAME")."<BR>");
print("Serveur destination: ".SERVEUR_DISTANT."<BR>");
print("<BR>");
print("Tables de la base: ".BASE2."<BR>");
print("<BR>");

//$connexion = Connexion(NOM2,PASSE2,BASE2,SERVEUR_DISTANT);
$connexion = mysql_connect(SERVEUR_DISTANT,NOM2,PASSE2);
if(!$connexion)
{
	echo("Désolé, connexion au serveur ".SERVEUR_DISTANT." impossible\n");
	exit();
}

// connexion à la base
	if(!mysql_select_db(BASE2,$connexion))
{
	echo("Désolé, connexion à la base BASE2 impossible\n");
	echo"<B>Message de MySql: </B>".mysql_error($connexion);
	exit();
}

$requete = "SHOW TABLES";
$resultat = ExecRequete($requete,$connexion);

while($rub=mysql_fetch_array($resultat))
{
	print($rub[0]."<BR>");
	$requete = "SHOW FULL COLUMNS FROM ".$rub[0];
	$col = ExecRequete($requete,$connexion);
	while($item=mysql_fetch_array($col))
	{
		print(" - ".$item[0]);
		print(" [".$item[1]."]");
		print("<BR>");
	}
}
?>
