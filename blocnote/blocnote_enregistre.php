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
//													//
//	programme: 		blocnote_enregistre.php							//
//	date de création: 	18/08/2003								//
//	auteur:			jcb									//
//	description:		Enregistre une information textuelle					//
//													//
//	version:		1.4									//
//	maj le:			08/04/2004								//
//													//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../"; 
require($backPathToRoot."dbConnection.php");
include($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");
$back = $_REQUEST['back'];

$montexte = Security::esc2Db($_REQUEST['montexte']);
if(strlen($montexte)>0) // pour ne pas enregistrer une phrase vide
{
	// si c'est une réponse, on reécupère l'identifiant de la question
	$question_ID = $_REQUEST[idQuestion];
	$date = uDateTime2MySql(time());
	$query = "INSERT INTO livrebord
	 		VALUES('','$_SESSION[organisation]','$_REQUEST[auteur]','$date','$montexte','$_REQUEST[visible]','$_SESSION[localisation]','$_REQUEST[irq]')";
	$result = ExecRequete($query,$connexion);
	if($_REQUEST[iqr]=="3") // c'est une réponse => mettre à jour livrebord_QR
	{
		$reponse_ID = mysql_insert_id();
		$requete = "INSERT INTO livrebordQR VALUES('','$question_ID','$reponse_ID')";
		$result = ExecRequete($requete,$connexion);
	}
}
//L'instruction provoque le retour automatique vers le bloc-note
header("Location: blocnote_lire.php?back=$back");
?>
