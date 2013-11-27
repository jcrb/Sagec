<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2004 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC ---------------------------------------------//
//
//	programme: 		org2hopital.php
//	date de création: 	02/08/05
//	auteur:			jcb
//	description:		Met le nom de l'organisme auquel est rattaché un hôpital à cet hopital
//	version:			1.0
//	maj le:			02/08/05
//
//---------------------------------------------------------------------------------------------//
//Liste des vecteurs
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if(!$_SESSION['auto_sagec'] && $_SESSION[autorisation]==10)header("Location:logout.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$requete = "SELECT org_nom, org_ID FROM organisme WHERE organisme_type_ID IN (10,11,12)";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	// caractère d'échappement devant les apostrophes sinon erreur mYsql
	$mot = str_replace ("'", "\'", $rub[org_nom]);
	$requete = "UPDATE hopital SET Hop_nom = '$mot' WHERE hopital.org_ID = '$rub[org_ID]'";
	print($requete."<br>");
	ExecRequete($requete,$connexion);
}

?>