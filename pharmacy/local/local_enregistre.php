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
/**													
*	programme 			local_enregistre.php
*	@date de création: 	30/01/2005
*	@author:			jcb
*	description:		enregistre une zone de stockage
*	@version:			1.0 - $ $
*	maj le:				28/07/2005
*	@package			Sagec
*/
//------------------------------------------------------------------------------------------------------
//
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
$backPathToRoot = "../../";
//if(!$_SESSION['auto_sagec'] && $_SESSION[autorisation]==10)header("Location:../logout.php");
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

print_r($_REQUEST);
//
$id = Security::str2db($_REQUEST['id']);
$local = Security::str2db($_REQUEST['local']);
$nom = Security::str2db($_REQUEST['nom']);
$batiment = Security::str2db($_REQUEST['batiment']);
$organisme = Security::str2db($_REQUEST['org']);
$etage = Security::str2db($_REQUEST['etage']);

	if(strlen($id)>0)// c'est une mise à jour
	{
		$requete = "UPDATE stockage SET
				stockage_nom = '$nom',
				stockage_etage = '$etage',
				stockage_local = '$local',
				org_ID = '$organisme',
				stockage_batiment_ID = '$batiment',
				WHERE stockage_ID = '$id'";
		//$resultat = ExecRequete($requete,$connexion);
	}
	else // c'est un nouveau local
	{
		$requete = "INSERT INTO stockage VALUES('','$nom','$etage','$local','$organisme','$batiment')";
		//$resultat = ExecRequete($requete,$connexion);
		$local = mysql_insert_id();
	}

print($requete);
//header("Location: local_saisie.php?local=$local");
?>
