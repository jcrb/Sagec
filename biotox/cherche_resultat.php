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
  * programme: 			cherche_resultat.php
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
$titre_principal = "Biotox-Résultat de la recherche";
$sousmenu = "";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require $backPathToRoot."autorisations/droits.php";

$ville_ID = $_REQUEST['type_ville'];
$materiel_ID = $_REQUEST['type_materiels'];

$requete = "SELECT dotation_ID,dotation.ville_ID,ville_nom,dotation_qte, materiel_nom,fournisseur_nom , acheteur_nom, date_achat,marque_nom,stockage_batiment_nom
			FROM ville, materiel,marque,fournisseur,acheteur,dotation LEFT OUTER JOIN stockage_batiment
				ON stockage_batiment_ID = dotation.stockage_ID
			WHERE ville.ville_ID = dotation.ville_ID";
			if($ville_ID > 0)
				$requete .= " AND ville.ville_ID = '$ville_ID' ";
$requete .= " AND materiel.materiel_ID = dotation.materiel_ID ";
			if($materiel_ID > 0)
				$requete .= " AND materiel.materiel_ID = '$materiel_ID'"; //dotation.materiel_ID 

$requete .= " AND marque.marque_ID = dotation.marque_ID
			AND fournisseur.fournisseur_ID = dotation.fournisseur_ID
			AND acheteur.acheteur_ID = dotation.acheteur_ID
			ORDER BY ville_ID, dotation.materiel_ID
			";			
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
	
	<link rel="stylesheet" href="../js/css/jquery.dataTables.css" />
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>
	<script src="../js/startDataTables.js"></script>
</head>

<body onload="">

<form name="" action= "" method = "post">

<div id="div2">
	<table id="table_hop" >  <!-- width="100%"  style="table-layout:fixed" -->
		<thead>
		<tr>
			<th>ville</th>
			<th>materiel</th>
			<th>localisation</th>
			<th>marque</th>
			<th>quantité</th>
			<th>fournisseur</th>
			<th>acheteur</th>
			<th>date</th>
			<?php if(est_autorise("BIOTOX_ECRIRE")){?>
				<th>modifier</th>
			<?php } ?>
		</tr>
		</thead>
		<tboby>
			<?php while($rub=mysql_Fetch_Array($resultat)){?>
			<tr>
				<td><? echo Security::db2str($rub['ville_nom']);?></td>
				<td><? echo Security::db2str($rub['materiel_nom']);?></td>
				<td><? echo Security::db2str($rub['stockage_batiment_nom']);?></td>
				<td><? echo Security::db2str($rub['marque_nom']);?></td>
				<td><? echo Security::db2str($rub['dotation_qte']);?></td>
				<td><? echo Security::db2str($rub['fournisseur_nom']);?></td>
				<td><? echo Security::db2str($rub['acheteur_nom']);?></td>
				<td><? echo Security::db2str($rub['date_achat']);?></td>
				<?php if(est_autorise("BIOTOX_ECRIRE")){?>
					<td><a href="dotation_biotox.php?dotation_id=<? echo $rub[dotation_ID];?>">modifier</td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tboby>
	</table>
</div>

<?php
?>

</form>
</body>
</html>