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
  * programme: 			new_materiel_enregistre.php
  * date de création: 	08/08/2012
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

$ID = $_REQUEST[id];
$nom = Security::str2db($_REQUEST['nom']);
$adr = Security::str2db($_REQUEST['adr']);

if($ID > 0){ // mise à jour
	
	$requete = "UPDATE materiel
					SET materiel_nom = '$nom'
					WHERE materiel_ID = '$ID'";
	$reponse = ExecRequete($requete,$connexion);
	//echo $requete;
}
else 
{
	// creation d'un fournisseur 
	$requete = "INSERT 
					INTO materiel(materiel_ID,materiel_nom) 
					VALUES('','$nom');
					";
	$reponse = ExecRequete($requete,$connexion);
	$ID = mysql_insert_id();
}
header("Location:materiel_biotox.php?id=$ID");
?>