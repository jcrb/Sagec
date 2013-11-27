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
  * programme: 			dossier_cata_nouveau_enregstre.php
  * date de création: 	26/06/2012
  * auteur:					jcb
  * description:			Crée un nouveau dossier s'il nexiste pas puis passe la main à
  *							dossier_cata_saisie.php
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
$titre_principal = "Dossier victimes - Nouvelle Victime";
include_once("dossier_cata_utilitaires.php");
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");

$identifiant = $_REQUEST['nom'];
$poste = $_REQUEST['poste'];
$pma = explode(";",$_REQUEST['id_pma']);

$_SESSION['dossier_courant'] = $identifiant;
$_SESSION['PMA'] = $pma[1];
$_SESSION['PMA_ID'] = $pma[0];
$_SESSION['PMA_POSTE'] = $poste;

header("Location:dossier_cata_saisie.php?identifiant=$identifiant&poste=$poste&pma=$pma[1]&pmaid=$pma[0]&new=true");

?>