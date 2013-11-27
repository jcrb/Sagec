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
/**											
*	programme: 		blocnote_enregistre.php							
* date de création: 	18/08/2003								
*	auteur:			jcb								
*	description:		Enregistre une information textuelle					
*	@version:		$Id: blocnote_enregistre.php 36 2008-02-22 16:05:49Z jcb $																					
*	maj le:			08/04/2004								
*/													
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");

$cell_crise = 16; // $_SESSION[localisation]
$groupe = 3; // table livre_bord_groupe

$montexte = Security::str2db($_REQUEST['montexte']);
$date = Security::str2db($_REQUEST['date']);
$auteur = Security::str2db($_REQUEST['auteur']);
$event = 0;

if($_REQUEST['montexte']) // pour ne pas enregistrer une phrase vide
{
	//$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	$query = "INSERT INTO points_situation
	 		VALUES('','$date','$auteur','$event','$montexte')";
	$result = ExecRequete($query,$connexion);
}
//L'instruction provoque le retour automatique vers le bloc-note
header("Location: point_situation.php");
?>
