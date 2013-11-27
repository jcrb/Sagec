<?php
/**
  *	dsa_enregistre.php
  *
  *	Crée ou modifie un enregistrement dans la table DSA
  * 	@package Sagec
  * 	@author JCB
  * 	@copyright 2008
  */
$backPathToRoot = "../";
include($backPathToRoot.'dbConnection.php'); 
include_once($backPathToRoot."login/init_security.php");

//print_r(Security::str2db($_REQUEST);

if (isset($_REQUEST['ok'])) 
{ 
	foreach($_REQUEST AS $key => $value) 
	{ 
		$_REQUEST[$key] = Security::str2db($value); 
	}

	$dsa_id = $_REQUEST['dsa_id'];
	
	if($dsa_id > 0)
	{
		$sql = "UPDATE dsa SET 
					dsa_type = '{$_REQUEST['type']}' ,
					`organisme_ID`= '{$_REQUEST['orgID']}',  
		`ville_ID`= '{$_REQUEST['ville_id']}',  
		`dsa_lat`= '{$_REQUEST['dsa_lat']}',  
		`dsa_lng`='{$_REQUEST['dsa_lng']}' ,  
		`dsa_adresse`= '{$_REQUEST['adresse']}',  
		`dsa_nb`= '{$_REQUEST['dsa_nb']}',  
		`dsa_modele`= '{$_REQUEST['modele']}',  
		`dsa_marque_ID`= '{$_REQUEST['marque_ID']}',  
		`dsa_comment`= '{$_REQUEST['comment']}' ,  
		`dsa_site`= '{$_REQUEST['site']}',  
		`dsa_tel`= '{$_REQUEST['tel']}',  
		`dsa_acces`= '{$_REQUEST['acces']}' ,  
		`med_referent` = '{$_REQUEST['med_referent']}'
					
					WHERE dsa_ID = '$dsa_id'";
		mysql_query($sql) or die(mysql_error()); 
		echo "L'enregistrement a été mis à jour.<br />"; 
		print("Update");
	}
	else
	{
		$sql = "INSERT INTO `dsa` 
		(
		`dsa_type` ,  
		`organisme_ID` ,  
		`ville_ID` ,  
		`dsa_lat` ,  
		`dsa_lng` ,  
		`dsa_adresse` ,  
		`dsa_nb` ,  
		`dsa_modele` ,  
		`dsa_marque_ID` ,  
		`dsa_comment` ,  
		`dsa_site` ,  
		`dsa_tel` ,  
		`dsa_acces` ,  
		`med_referent`  
		) 
		VALUES(			
		'{$_REQUEST['type']}' ,  
		'{$_REQUEST['orgID']}' ,  
		'{$_REQUEST['ville_id']}' ,  
		'{$_REQUEST['dsa_lat']}' ,  
		'{$_REQUEST['dsa_lng']}' ,  
		'{$_REQUEST['adresse']}' ,  
		'{$_REQUEST['dsa_nb']}' ,  
		'{$_REQUEST['modele']}' ,  
		'{$_REQUEST['marque_ID']}' ,  
		'{$_REQUEST['comment']}' ,  
		'{$_REQUEST['site']}' ,  
		'{$_REQUEST['tel']}' ,  
		'{$_REQUEST['acces']}' ,  
		'{$_REQUEST['med_referent']}'  
		) "; 
		mysql_query($sql) or die(mysql_error()); 
		echo "Une ligne a été ajoutée à la base de donnée.<br />"; 
	}
	echo "<a href='dsa_list.php'>Back To Listing</a>"; 
} 
?>