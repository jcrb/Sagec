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
//	programme: 		langue_enregistre.php
//	date de création: 	10/04/2005
//	auteur:			jcb
//	description:		service à modifier
//	version:			1.0
//	maj le:			10/04/2005
//
//--------------------------------------------------------------------------------------------------------
/** Variables transmises
*@param $langue langue parlée
*@param $personne_id identifiant de la personne
*/
//--------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_hopital'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$requete = "SELECT * FROM langue_parlee WHERE Pers_ID = '$_GET[personne_id]' AND langue_ID = '$_GET[id_langue]'";
$resultat = ExecRequete($requete,$connexion);
//print($requete);
if(mysql_num_rows($resultat)==0)
{
	$requete="INSERT INTO langue_parlee VALUES('$_GET[personne_id]','$_GET[id_langue]')";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete);
}
header("Location:../intervenant_saisie.php?personnelID=$_GET[personne_id]&echo=1 TARGET=_PARENT");
?>
