<? 
/**
*	list.php administrateur/tables/type_objet
*/
$backPathToRoot = "../../../";
include($backPathToRoot.'dbConnection.php'); 
 
echo "<table border=1 >"; 
echo "<tr>"; 
echo "<td><b>Type Objet ID</b></td>"; 
echo "<td><b>Type Objet Nom</b></td>"; 
echo "</tr>"; 
$result = mysql_query("SELECT * FROM `type_objet`") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<tr>";  
echo "<td valign='top'>" . nl2br( $row['type_objet_ID']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['type_objet_nom']) . "</td>";  
echo "<td valign='top'><a href=edit.php?type_objet_ID={$row['type_objet_ID']}>Edit</a></td><td><a href=delete.php?type_objet_ID={$row['type_objet_ID']}>Delete</a></td> "; 
echo "</tr>"; 
} 
echo "</table>"; 
echo "<a href=new.php>New Row</a>";   
?>