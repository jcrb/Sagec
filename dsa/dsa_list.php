<?php
/**
  *	dsa_list.php
  *
  * @package Sagec
  * @author JCB
  * @copyright 2008
  *
  */
$backPathToRoot = "../";
include($backPathToRoot.'dbConnection.php'); 
include_once($backPathToRoot."login/init_security.php");
include_once("top.php");
include_once("menu.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Nouveau DSA</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<script  type="text/javascript" src="utilitaires.js"></script>
	<link href="dsa.css" rel="stylesheet" type="text/css" />
	<script  type="text/javascript" src="../ajax/jquery-courant.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('table.sortable tbody tr:odd').addClass('odd');
			$('table.sortable tbody tr:even').addClass('even');
		});
	</script>
</head>

<body>
<form name="saisie" action="" method="post">
<div id="div2">
<?php
echo "<table class=\"sortable\" >"; 
echo "<tr>"; 
echo "<th><b>ID</b></th>"; 
echo "<th><b>Type</b></th>"; 
echo "<th><b>Organisme</b></th>"; 
echo "<th><b>Ville</b></th>"; 
echo "<th><b>Lat</b></th>"; 
echo "<th><b>Lng</b></th>"; 
echo "<th><b>Adresse</b></th>"; 
echo "<th><b>Nb</b></th>"; 
echo "<th><b>Modele</b></th>"; 
echo "<th><b>Marque ID</b></th>"; 
echo "<th><b>Comment</b></th>"; 
echo "<th><b>Site</b></th>"; 
echo "<th><b>Tel</b></th>"; 
echo "<th><b>Acces</b></th>"; 
echo "<th><b>Referent</b></th>"; 
echo "<th><b>&nbsp;</b></th>";
echo "</tr>"; 

$result = mysql_query("SELECT dsa.*,org_nom,ville_nom
			 FROM `dsa`,organisme,ville
			 WHERE dsa.organisme_ID = organisme.org_ID
			 AND dsa.ville_ID = ville.ville_ID
			 ORDER BY ville_nom
			 ") 
			 
			 or trigger_error(mysql_error()); 

while($row = mysql_fetch_array($result))
{ 
	foreach($row AS $key => $value) 
	{ 
		$row[$key] = Security::db2str($value); 
	} 
	if($row[dsa_comment]=="") $row[dsa_comment]="&nbsp;";
	
echo "<tr>";  
echo "<td valign='top'><a href=dsa_nouveau.php?dsa_id={$row['dsa_ID']}>" . nl2br( $row['dsa_ID']) . "</a></td>";  
echo "<td valign='top'>" . nl2br( $row['dsa_type']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['org_nom']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['ville_nom']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['dsa_lat']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['dsa_lng']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['dsa_adresse']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['dsa_nb']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['dsa_modele']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['dsa_marque_ID']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['dsa_comment']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['dsa_site']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['dsa_tel']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['dsa_acces']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['med_referent']) . "</td>";  
/**
echo "<td valign='top'><a href=dsa_delete.php?dsa_ID={$row['dsa_ID']}>Delete</a></td> "; 
*/
echo "</tr>"; 
} 
echo "</table>"; 
?>
</div>

<div id="footer">
	DSA
</div>

</form>
</body>
</html>