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
$backPathToRoot = "../";
//if(!$_SESSION['auto_sagec'] && $_SESSION[autorisation]==10)header("Location:../logout.php");
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
//
$local = $_REQUEST['local'];
if($_REQUEST[ID_batiment] && $_REQUEST[org_type])
{
	if($_REQUEST['local']) // c'est une mise à jour
	{
	$requete = "UPDATE stockage SET
				stockage_batiment_ID = '$_REQUEST[ID_batiment]',
				stockage_etage = '$_REQUEST[etage]',
				stockage_local = '$_REQUEST[piece]',
				org_ID = '$_REQUEST[org_type]'
				WHERE stockage_ID = '$local'";
	$resultat = ExecRequete($requete,$connexion);
	}
	else // c'est un nouveau local
	{
	$requete = "INSERT INTO stockage VALUES('','$_REQUEST[ID_batiment]','$_REQUEST[etage]','$_REQUEST[piece]','$_REQUEST[org_type]')";
	$resultat = ExecRequete($requete,$connexion);
	$local = mysql_insert_id();
	}
}
print($local);
//header("Location: local_saisie.php?local=$local");
?>
