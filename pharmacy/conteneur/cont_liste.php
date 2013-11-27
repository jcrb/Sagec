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
  * programme: 			local_liste.php
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
$backPathToRoot = "../../";
$titre_principal = "Locaux de stockage - Liste";
$sousmenu = "<a href='../pharmacy_main.php'>Pharmacie</a> > <a href='local_main.php'>Stockage</a> > <a href=''>Liste</a>";
include_once("local_top.php");
include_once("local_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$requete = "SELECT stockage.*,org_nom,stockage_batiment_nom
				FROM stockage,organisme,stockage_batiment
				WHERE stockage.org_ID = organisme.org_ID
				AND stockage.stockage_batiment_ID = stockage_batiment.stockage_batiment_ID
				";
			$resultat = ExecRequete($requete,$connexion);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="../div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
	<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>
</head>

<form name="" action= "" method = "post">

<div id="div2">

	<fieldset id="field1">
		<legend><? echo 'Ajouter un local de stockage';?> </legend>
		<p><a href="">Nouveau</a></p>
	</fieldset>
	
	<fieldset id="field1">
		<legend><? echo 'Liste des zones de stockage';?> </legend>
			<table>
				<tr>
					<th>ID</th>
					<th>Batiment</th>
					<th>Etage</th>
					<th>Local</th>
					<th>Organisme</th>
					<th>Local</th>
				</tr>
				<?php while($rep = mysql_fetch_array($resultat)){?>
				<tr>
					<td><a href='local_new.php?id=<?php echo $rep['stockage_ID'];?>'><?php echo $rep['stockage_ID'];?></a></td>
					<td><?php echo $rep['stockage_batiment'];?></td>
					<td><?php echo $rep['stockage_etage'];?></td>
					<td><?php echo $rep['stockage_local'];?></td>
					<td><?php echo $rep['org_nom'];?></td>
					<td><?php echo $rep['stockage_batiment_nom'];?></td>
				</tr>
				<?php };?>
			</table>
		
	</fieldset>

	
</div>
</form>
</body>
</html>