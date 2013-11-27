<?php
/*
*	dsa_edit.php
*/
$backPathToRoot = "../";
include($backPathToRoot.'dbConnection.php'); 
include_once("top.php");
include_once("menu.php");

if (isset($_GET['dsa_ID']) ) { 
$dsa_ID = (int) $_GET['dsa_ID']; 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "UPDATE `dsa` SET  `dsa_type` =  '{$_POST['dsa_type']}' ,  `organisme_ID` =  '{$_POST['organisme_ID']}' ,  `ville_ID` =  '{$_POST['ville_ID']}' ,  `dsa_lat` =  '{$_POST['dsa_lat']}' ,  `dsa_lng` =  '{$_POST['dsa_lng']}' ,  `dsa_adresse` =  '{$_POST['dsa_adresse']}' ,  `dsa_nb` =  '{$_POST['dsa_nb']}' ,  `dsa_modele` =  '{$_POST['dsa_modele']}' ,  `dsa_marque_ID` =  '{$_POST['dsa_marque_ID']}' ,  `dsa_comment` =  '{$_POST['dsa_comment']}' ,  `dsa_site` =  '{$_POST['dsa_site']}' ,  `dsa_tel` =  '{$_POST['dsa_tel']}' ,  `dsa_acces` =  '{$_POST['dsa_acces']}' ,  `med_referent` =  '{$_POST['med_referent']}'   WHERE `dsa_ID` = '$dsa_ID' "; 
mysql_query($sql) or die(mysql_error()); 
echo (mysql_affected_rows()) ? "Edited row.<br />" : "Pas de modifications. <br />"; 
echo "<a href='dsa_list.php'>Back To Listing</a>"; 
} 
$row = mysql_fetch_array ( mysql_query("SELECT * FROM `dsa` WHERE `dsa_ID` = '$dsa_ID' ")); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Nouveau DSA</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<script  type="text/javascript" src="utilitaires.js"></script>
</head>

<body onload="document.getElementById('sn').focus()">

<form action='' method='POST'> 
<div id="div2">
<p><b>Dsa Type:</b><br /><input type='text' name='dsa_type' value='<?= stripslashes($row['dsa_type']) ?>' /> 
<p><b>Organisme ID:</b><br /><input type='text' name='organisme_ID' value='<?= stripslashes($row['organisme_ID']) ?>' /> 
<p><b>Ville ID:</b><br /><input type='text' name='ville_ID' value='<?= stripslashes($row['ville_ID']) ?>' /> 
<p><b>Dsa Lat:</b><br /><input type='text' name='dsa_lat' value='<?= stripslashes($row['dsa_lat']) ?>' /> 
<p><b>Dsa Lng:</b><br /><input type='text' name='dsa_lng' value='<?= stripslashes($row['dsa_lng']) ?>' /> 
<p><b>Dsa Adresse:</b><br /><input type='text' name='dsa_adresse' value='<?= stripslashes($row['dsa_adresse']) ?>' /> 
<p><b>Dsa Nb:</b><br /><input type='text' name='dsa_nb' value='<?= stripslashes($row['dsa_nb']) ?>' /> 
<p><b>Dsa Modele:</b><br /><input type='text' name='dsa_modele' value='<?= stripslashes($row['dsa_modele']) ?>' /> 
<p><b>Dsa Marque ID:</b><br /><input type='text' name='dsa_marque_ID' value='<?= stripslashes($row['dsa_marque_ID']) ?>' /> 
<p><b>Dsa Comment:</b><br /><input type='text' name='dsa_comment' value='<?= stripslashes($row['dsa_comment']) ?>' /> 
<p><b>Dsa Site:</b><br /><input type='text' name='dsa_site' value='<?= stripslashes($row['dsa_site']) ?>' /> 
<p><b>Dsa Tel:</b><br /><input type='text' name='dsa_tel' value='<?= stripslashes($row['dsa_tel']) ?>' /> 
<p><b>Dsa Acces:</b><br /><input type='text' name='dsa_acces' value='<?= stripslashes($row['dsa_acces']) ?>' /> 
<p><b>Med Referent:</b><br /><input type='text' name='med_referent' value='<?= stripslashes($row['med_referent']) ?>' /> 
<p><input type='submit' value='Edit Row' /><input type='hidden' value='1' name='submitted' /> 
</div>
</form> 
<? } ?> 


</body>
</html>