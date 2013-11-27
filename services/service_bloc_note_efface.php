<?php
/**
*	services/service_bloc_note_efface.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require("database_connect.php");

if($_REQUEST['btn']=="oui")
{
	$requete = "DELETE FROM livrebord_service WHERE org_ID = '$_SESSION[organisation]'";
	$result = ExecRequete($requete,$connect);
	print("Le livre de bord a été effacé");
}
else
{
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
</head>
<body>
<table>
	<tr><td colspan="2">Voulez-vous vraiment effacer le contenu du bloc-note ?</td></tr>
	<tr>
		<td><input type="submit" name="btn" value="oui"></submit></td>
		<td><input type="submit" name="btn" value="non"></submit></td>
	</tr>
</table>
<?php
}
?>
</body>
</html>