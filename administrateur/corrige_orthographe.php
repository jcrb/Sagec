<?php
/**
  *	corrige_orthographe.php
  *
  *	transforme des caractères UTF8 en iso standard
  */
  
  	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$backPathToRoot = "../";
	require($backPathToRoot."dbConnection.php");
	require("utilitaires_table.php");
	
	if($_REQUEST['ok'])
	{
		$table = $_REQUEST['table'];
		$champ = $_REQUEST['champ'];

		$requete[] = "UPDATE ".$table." SET ".$champ." = REPLACE(".$champ.",'Ã©','".utf8_encode('é')."')";
		
		//$requete[] = "UPDATE ".$table." SET ".$champ." = REPLACE(".$champ.",'?','é')";
		for($i=0; $i<sizeof($requete);$i++)
		{
			ExecRequete($requete[$i],$connexion);
		}
		echo 'terminé !';
	}
?>

<html>
	<head>
<meta http-equiv="content-type" content="ype" cont; charset=UTF-8" >
		<title>Correction</tittle>
	</head>
	
	<body>
		<form name="correction" method="post" action="">
			<table>
				<tr>
					<td>nom de la table</td>
					<td><input type="text" name="table"></echo></td> <!-- retourne table -->
				</tr>
				<tr>
					<td>nom du champ</td>
					<td><input type="text" name="champ"></echo></td> <!-- retourne table -->
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><INPUT TYPE="submit" NAME="ok" VALUE="valider"></td>
				</tr>
			</table>
		</form>
	</body>
	
</html>
	