<?  
/**
*	new.php administrateur/tables/type_objet
*/
$backPathToRoot = "../../../";
include($backPathToRoot.'dbConnection.php');
 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "INSERT INTO `type_objet` ( `type_objet_nom`  ) VALUES(  '{$_POST['type_objet_nom']}'  ) "; 
mysql_query($sql) or die(mysql_error()); 
echo "Added row.<br />"; 
echo "<a href='list.php'>Back To Listing</a>"; 
} 
?>

<form action='' method='POST'> 
<p><b>Type Objet Nom:</b><br /><input type='text' name='type_objet_nom'/> 
<p><input type='submit' value='Add Row' /><input type='hidden' value='1' name='submitted' /> 
</form> 