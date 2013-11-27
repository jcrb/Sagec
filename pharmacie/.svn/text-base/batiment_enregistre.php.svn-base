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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		batiment_enregistre.php
//	date de création: 	28/07/2005
//	auteur:			jcb
//	description:		enregistre un batiment bouveau ou modifié
//	version:			1.0
//	maj le:			28/07/2005
//
//--------------------------------------------------------------------------------------------------------
//
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require '../utilitaires/globals_string_lang.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
if($_GET['maj'])
{
	$requete="UPDATE stockage_batiment SET stockage_batiment_nom='$_GET[nom]' WHERE stockage_batiment_ID='$_GET[maj]'";
	$resultat = ExecRequete($requete,$connexion);
}
else
{
	$requete="INSERT INTO stockage_batiment VALUES('','$_GET[nom]')";
	$maj = mysql_insert_id();
}
header("Location:batiment_saisie.php?maj=$maj");
?>
