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
//	programme: 		hop2service.php
//	date de création: 	30/08/05
//	auteur:			jcb
//	description:		Met l'ID de l'hopital dans la rubrique correspondante des services
//	version:		1.0
//	maj le:			30/08/05
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

$requete = "SELECT Hop_ID, org_ID FROM hopital";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$requete = "UPDATE service SET Hop_ID = '$rub[Hop_ID]' WHERE service.org_ID = '$rub[org_ID]'";
	print($requete."<br>");
	ExecRequete($requete,$connexion);
}

?>