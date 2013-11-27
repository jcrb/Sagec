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
  * programme: 			liste_materiel_biotox.php
  * date de cr�ation: 	08/08/2012
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
$titre_principal = "Biotox - Fournisseurs";
$sousmenu = "";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require $backPathToRoot."autorisations/droits.php";

	$requete = "SELECT * FROM materiel";
	$resultat = ExecRequete($requete,$connexion);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>fournisseur_voir</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
	<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>
	
	<link rel="stylesheet" href="../js/css/jquery.dataTables.css" />
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>
	<script src="../js/startDataTables.js"></script>
</head>
<body onload="">

<form name="" action= "" method = "post">

<?php if(est_autorise("BIOTOX_ECRIRE")){?>
	<p><a href="new_materiel_biotox.php?id=0">NOUVEAU MATERIEL BIOTOX</a></p>
<?php } ?>

<div id="div2">
	<table id="table_hop" >  <!-- width="100%"  style="table-layout:fixed" -->
		<thead>
		<tr>
			<th>ID</th>
			<th>materiel</th>
			<?php if(est_autorise("BIOTOX_ECRIRE")){?>
			<th>modifier</th>
			<?php } ?>
		</tr>
		</thead>
		<tboby>
			<?php while($rub=mysql_Fetch_Array($resultat)){?>
			<tr>
				<td><? echo Security::db2str($rub['materiel_ID']);?></td>
				<td><? echo Security::db2str($rub['materiel_nom']);?></td>
				<?php if(est_autorise("BIOTOX_ECRIRE")){?>
				<td><a href="new_materiel_biotox.php?id=<?php echo Security::db2str($rub['materiel_ID']);?>">modifier</a></td>
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