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
  * programme: 			cc_ckecklist.php
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
$titre_principal = "Direction Générale - Check-liste";
include_once("cc_top.php");
include_once("cc_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require("cc_utilitaires.php");

$fonction = $_REQUEST['fonction_id'];
$fonction_nom = $_REQUEST['fonction_nom'];
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
	<script src="../ajax/jquery-courant.js"></script>
	<script>
		function ischeck(val)
		{
			var c;
			if($('#'+ val).attr('checked'))	// le # permet de désigner un élément par son ID
					c = 1;							// c = 1 si la case est cochée
			else
					c = 0;			
			$.ajax({
   			type: "POST",
   			url: "cc_update.php",
   			data:"id="+val + "&check="+c,	
   			success: function(msg){}
   		})
		}
	</script>
</head>

<body onload="">

<form name="checklist" action= "cc_checklist_enregistre.php" method = "get">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Liste des taches [<?php echo $fonction_nom;?>]</legend>
		
	

<?php
$requete = "SELECT * FROM tache_DG WHERE tache_fonction = '$fonction' ORDER BY tache_priorite";
$resultat = ExecRequete($requete,$connexion);
$path = $path."tache_nouvelle.php?tacheID=";

?>
<table>
	<?php while($rep = mysql_fetch_array($resultat)){?>
	<tr>
		<td id="tdLeft" bgcolor="#FFFF66"><?php echo security::db2str($rep['tache_nom']);?></td>
		<td id="tdLeft" bgcolor="#FFFF99"><?php echo security::db2str($rep['tache_comment']);?></td>
		<td id="tdLeft" bgcolor="#FFFF99"><?php echo security::db2str($rep['tache_heure']);?></td>
		<td  id="tdLeft" bgcolor="#CCFF99">
			<input type="checkbox" id="<?php echo $rep[tache_ID];?>" name="cb" onClick="ischeck(<?php echo $rep[tache_ID];?>)" value="<?php echo $rep[tache_ID];?>"
			<?php if($rep[tache_faite]=='o') print("checked");?></td>
		<?php
			//print(" onchange=\" document.checklist.submit()\"></td>");   
			//$tache = $path.$rep['tache_ID'];
			//print("<td><a href=\"$tache\">M</a></td>");
		?>
	</tr>
	<?php } ?>
</table>
</div>
</form>
</body>
</html>
