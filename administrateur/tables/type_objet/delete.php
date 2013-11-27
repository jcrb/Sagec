<?  
/**
*	delete.php administrateur/tables/type_objet
*/
$backPathToRoot = "../../../";
include($backPathToRoot.'dbConnection.php');
 
$type_objet_ID = (int) $_GET['type_objet_ID']; 
mysql_query("DELETE FROM `type_objet` WHERE `type_objet_ID` = '$type_objet_ID' ") ; 
echo (mysql_affected_rows()) ? "Row deleted.<br /> " : "Nothing deleted.<br /> "; 
?> 

<a href='list.php'>Back To Listing</a>