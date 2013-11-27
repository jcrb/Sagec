<?php
/**
  *	dci_list.php
  */
  
$backPathToRoot = "../";
include($backPathToRoot.'dbConnection.php'); 
echo "<table border=1 >"; 
echo "<tr>"; 
echo "<td><b>Dci ID</b></td>"; 
echo "</tr>"; 
$result = mysql_query("SELECT * FROM `med_dci`") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<tr>";  
echo "<td valign='top'>" . nl2br( $row['dci_nom']) . "</td>";  
echo "<td valign='top'><a href=dci_edit.php?dci_ID={$row['dci_ID']}>Edit</a></td><td><a href=dci_delete.php?dci_ID={$row['dci_ID']}>Delete</a></td> "; 
echo "</tr>"; 
} 
echo "</table>"; 
echo "<a href=dci_new.php>New Row</a>";  
?>