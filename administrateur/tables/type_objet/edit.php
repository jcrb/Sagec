<?  
/**
*	edit.php administrateur/tables/type_objet
*/
$backPathToRoot = "../../../";
include($backPathToRoot.'dbConnection.php');
  
if (isset($_GET['type_objet_ID']) ) { 
$type_objet_ID = (int) $_GET['type_objet_ID']; 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "UPDATE `type_objet` SET  `type_objet_nom` =  '{$_POST['type_objet_nom']}'   WHERE `type_objet_ID` = '$type_objet_ID' "; 
mysql_query($sql) or die(mysql_error()); 
echo (mysql_affected_rows()) ? "Edited row.<br />" : "Nothing changed. <br />"; 
echo "<a href='list.php'>Back To Listing</a>"; 
} 
$row = mysql_fetch_array ( mysql_query("SELECT * FROM `type_objet` WHERE `type_objet_ID` = '$type_objet_ID' ")); 
?>

<form action='' method='POST'> 
<p><b>Type Objet Nom:</b><br /><input type='text' name='type_objet_nom' value='<?= stripslashes($row['type_objet_nom']) ?>' /> 
<p><input type='submit' value='Edit Row' /><input type='hidden' value='1' name='submitted' /> 
</form> 
<? } ?> 