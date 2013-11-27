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
  * programme: 			manif_voir.php
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
$titre_principal = "Manifestations sportives";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

/**
  *	ordre des tris
  */
$tri_ordre = $_REQUEST['tri_ordre'];
$tri_item = $_REQUEST['tri_item'];

switch($tri_item){
	case tri_date:$tri_item="manif_debut";break;
	case tri_nom:$tri_item="manif_nom";break;
	case tri_no:$tri_item="manif_ID";break;
	case tri_ville:$tri_item="ville_nom";break;
	default:$tri_item="manif_debut";
}

if($tri_ordre=="" || $tri_ordre=="ASC") $tri_ordre = "DESC";else $tri_ordre = "ASC";

$requete = "SELECT manifestation.*,ville_nom
				FROM manifestation LEFT OUTER JOIN ville ON ville.ville_ID = manifestation.manif_ville_ID
				ORDER BY ".$tri_item." ".$tri_ordre;
$resultat = ExecRequete($requete,$connexion);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="manif_voir" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Liste </legend>
		<table>
			<tr>
				<th><a href="manif_voir.php?tri_ordre=<?php echo $tri_ordre;?>&tri_item=tri_no">numéro</a></th>
				<th><a href="manif_voir.php?tri_ordre=<?php echo $tri_ordre;?>&tri_item=tri_date">date</a></th>
				<th><a href="manif_voir.php?tri_ordre=<?php echo $tri_ordre;?>&tri_item=tri_nom"">Nom</a></th>
				<th><a href="manif_voir.php?tri_ordre=<?php echo $tri_ordre;?>&tri_item=tri_ville"">Commune</a></th>
				<th>Voir/modifier</th>
			</tr>
			<?php while($rep = mysql_fetch_array($resultat)){ ?>
			<tr>
				<td><?php echo $rep['manif_ID'];?></td>
				<td><?php echo $rep['manif_debut'];?></td>
				<td><?php echo Security::db2str($rep['manif_nom']);?></td>
				<td><?php echo Security::db2str($rep['ville_nom']);?></td>
				<td><a href="manif_new.php?manifID=<?php echo $rep[manif_ID];?>">voir/modifier</a></td>
			</tr>
			<?php } ?>
		</table>
	</fieldset>
	
</div>

<?php
?>

</form>
</body>
</html>