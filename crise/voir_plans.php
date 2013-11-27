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
  * programme: 			voir_plans.php
  * date de création: 	11/2010
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
include_once($backPathToRoot."login/init_security.php");

$ppi_id = $_REQUEST['id'];
$ppi_nom = Security::db2str($_REQUEST['nom']);
$titre_principal = $ppi_nom;

include_once("top.php");
include_once("menu_carto.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");

$requete = "UPDATE plan_courant SET plan_ID = '$ppi_id' WHERE plan_courant_ID = 1";
ExecRequete($requete,$connexion);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>plans</title>
	<script>
		var path="../";
		var pathpdf = "../../";
		var path2="../ppi/ppi_dow/";
	</script>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	
	<script src = "../utilitaires/google/key.js"></script>
	<script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
   </script>
	<script src = "../ppi/ppi_dow/ppi_icones.js"></script>
	<script src = "../ppi/ppi_dow/ppi_markers.js"></script>
	<script src = "../ajax/jquery-courant.js"></script>
  	<script src = "../ppi/ppi_dow/ppi_dow_data.php" type="text/javascript"></script>
   	<!-- <script src = "ppi_data.php" type="text/javascript"></script>  -->
   <link href="map.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="map"></div>
	<div id="mouseTrack">SAGEC Alsace</div>
	<!-- le fct time() oblige à  réaafficher la nouvelle image et non celle restant en cache -->
	<div class="transp" id="rose"><img src="../ppi/rose_vent.png?<?echo time()?>"/></div>
	<?php
		print("<div id=\"toolbar2\">");
			print("<table>");
			print("<tr>");
  					print("<td><B>Scénarios</B></td>");
  			
    			//print("<tr><td><input type=\"checkbox\" name=\"mouseTracking\" id=\"mt\" onClick=\"analyseMenu()\"> Geoloc </td></tr>");
    			//print("<tr><td><input type=\"checkbox\" name=\"struct_temp\" id=\"st\" onClick=\"analyseMenu()\"> Structures PPI </td></tr>");
    			//print("<tr>");
    			//$mot = "Rose des Vents";
    			//print("<td><input type=\"checkbox\" name=\"rdv\" id=\"rdv\" onclick=\"analyseMenu()\">".$mot."</td>");
    		print("</tr>");
    	?>
  		
  		<?php 
  			  $requete = "SELECT stocki_nom,stocki_ID
					FROM stockage_industriel,produitsChimiques 
					WHERE ppi_ID = '$ppi_id'
					AND stockage_industriel.produit_ID = produitsChimiques.chem_ID
					";
			$scenarios = ExecRequete($requete,$connexion);
  			while($rub=mysql_fetch_array($scenarios)){$no = $rub['stocki_ID'];?>
			<tr>
				<td><input type="checkbox" name="struct_temp" class="mini" id="<?php echo $no;?>" onClick="analyseMenu(<?php echo $no;?>)"><?php echo $rub['stocki_nom'];?></td>
			</tr>
		<?php } ?>

  		</table>
		</div>
</body>
</html>
