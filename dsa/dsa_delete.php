<?php
/*
 *	dsa_delete.php
 *
 * @package Sagec
 * @author JCB
 * @copyright 2008
 */
$backPathToRoot = "../";
include($backPathToRoot.'dbConnection.php'); 
$dsa_ID = (int) $_GET['dsa_ID']; 
mysql_query("DELETE FROM `dsa` WHERE `dsa_ID` = '$dsa_ID' ") ; 
echo (mysql_affected_rows()) ? "Row deleted.<br /> " : "Nothing deleted.<br /> "; 
?> 

<a href='dsa_list.php'>Retour au Listing</a>