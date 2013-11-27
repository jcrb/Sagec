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
  * programme: 			sau.php
  * date de crÃ©ation: 	03/08/2012
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
$titre_principal = "Point de situation - Services d'urgence";
$sousmenu = "Services d'urgence";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Point  de situation</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
	<!--<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>-->
	
	<link rel="stylesheet" href="../../js/css/jquery.dataTables.css" />
	<script src="../../js/jquery.js"></script>
	<script src="../../js/jquery.dataTables.min.js"></script>
	<script src="startDataTables.js"></script>
</head>

<body onload="">
	<?php
	/*
		Hop_SAU = 'o'
		Hop_Rea  = 'o'
		Hop_DZ != ''
		Hop_Scanner  = 'o'
		Hop_ReaPed  = 'o'
	*/
		$objet = "Hop_SAU = 'o'";
		$requete = "SELECT Hop_nom,Hop_ID, departement_ID
						FROM hopital,adresse,ville";
						
		$requete .=" WHERE ".$objet."
						AND hopital.adresse_ID = adresse.ad_ID
						AND adresse.ville_ID = ville.ville_ID
						AND ville.region_ID = '42'
						ORDER BY ville.departement_ID
						";
		$reponse = ExecRequete($requete,$connexion);
	?>
	<div id = "">
		<fieldset id="">
		<table id="table_hop" >  <!-- width="100%"  style="table-layout:fixed" -->
		<thead>
			<tr>
				<th>Hôpital</th>
				<th>Identifiant</th>
				<th>Département</th>
			</tr>
		</thead>
		<tboby>
			<?php while($rub = mysql_fetch_array($reponse)){?>
			<tr>
				<td><?php echo Security::db2str($rub['Hop_nom']);?></td>
				<td><?php echo $rub['Hop_ID'];?></td>
				<td><?php echo $rub['departement_ID'];?></td>
			</tr>
			<?php } ?>
		</tboby>
		</table>
	</div>

</form>
</body>
</html>
