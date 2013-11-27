<?php
/**----------------------------------------- SAGEC ---------------------------------
  * This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
  * SAGEC67 is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation; either version 2 of the License, or
  * (at your option) any later version.
  * SAGEC67 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * You should have received a copy of the GNU General Public License
  * along with SAGEC67; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */		
/** ---------------------------------------------------------------------------------
  * programme: 			admin_check_enregistre.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";

require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$nom = Security::str2db($_REQUEST['nom']);
$priorite = Security::str2db($_REQUEST['priorite']);
$fonction = Security::str2db($_REQUEST['fonction_id']);
$comment = Security::str2db($_REQUEST['comment']);
$message = Security::str2db($_REQUEST['message']);
$id = Security::str2db($_REQUEST['id']);

print_r($_REQUEST);

if($id != NULL)
{
	$requete = "UPDATE tache_DG SET
					tache_nom = '$nom',
					tache_priorite = '$priorite',
					tache_comment = '$comment',
					tache_message = '$message',
					tache_fonction = '$fonction'
					WHERE tache_ID = '$id'
					";
	$resultat = ExecRequete($requete,$connexion);
}
else
{
	$requete = "INSERT INTO tache_DG(tache_ID,tache_nom, tache_priorite, tache_comment,tache_message,tache_fonction)
					VALUES('','$nom','$priorite','$comment','$message','$fonction')
					";
	$resultat = ExecRequete($requete,$connexion);
	$id = mysql_insert_id();
}

//echo $requete;

header("Location:admin_check_nouveau.php?tacheID=$id");
?>