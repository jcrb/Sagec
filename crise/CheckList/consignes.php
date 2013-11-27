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
  * programme: 			consignes.php
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
include_once("top.php");
include_once("menu.php");

require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");

/** récupère le n° du plan de secours */
$plan = $_REQUEST['plan'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>check-list</title>
	<link rel="stylesheet" href="../div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../ajax/jquery-courant.js"></script>
	<script>
		function ischeck(val,plan)
		{
			var c;
			if($('#'+ val).attr('checked'))	// le # permet de désigner un élément par son ID
					c = 1;							// c = 1 si la case est cochée
			else
					c = 0;			
			$.ajax({
   			type: "POST",
   			url: "update.php",
   			data:"id="+val + "&check="+c + "&plan=" + plan,
   			success: function(msg){
     			alert( "Data Saved: " + msg );	// msg reprend tous les éléments "imprimés" par print et echo dans le fichier update
   		}})
		}
	</script>
</head>

	<body>
	<form name="check" command="post" action="../../plan_blanc/gestion_samu/checklist_enregistre.php">
<?php
	$requete = "SELECT tache.*, tache_scenario.validation 
				FROM tache,tache_scenario
				WHERE tache_scenario.scenario_ID = '$plan'
				AND tache.tache_ID = tache_scenario.tache_ID
				ORDER BY tache_priorite";
	$resultat = ExecRequete($requete,$connexion);

print("<table>");
$path = $path."tache_nouvelle.php?tacheID=";
while($rep = mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td bgcolor=\"#FFFF66\">".security::db2str($rep[tache_nom])."</td>");
		print("<td bgcolor=\"#FFFF99\">".security::db2str($rep[tache_comment])."</td>");
		print("<td bgcolor=\"#FFFF99\">".security::db2str($rep[tache_heure])."</td>");
		
		print("<td  bgcolor=\"#CCFF99\"><input type=\"checkbox\" name=\"cb\" id=\"$rep[tache_ID]\" ");
		if($rep['validation']=='1') print("checked");
		print(" onchange=\" ischeck($rep[tache_ID],$plan);\"></td>");
		//$tache = $path.$rep['tache_ID'];
		//print("<td><a href=\"$tache\">M</a></td>");
	print("</tr>");
}
print("</table>");
?>
</form>
</body>
</html>


