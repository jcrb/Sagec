<?php
/**
  *	liste_ppi.php
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
include_once($backPathToRoot."dbConnection.php");

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/entete_gris.css" />
		<link rel="stylesheet" type="text/css" href="../css/menu_gris.css" />
		<link rel="stylesheet" type="text/css" href="./pma.css">
		<link rel="shortcut icon" href="./images/sagec67.ico" />
		<link REL=\"stylesheet\" HREF=\"../ppi/ppi.css\" TYPE =\"text/css\">
		<title>plans</title>
	</head>
	
	<body>
	<form name="" action="">
	<p>Sélectionner un Plan</p>
	<div id="">
		<ul id="menu_ppi">
		<?php
			$requete = "SELECT ppi_ID,ppi_nom,ppi_dossier FROM ppi ORDER BY ppi_ID";
			$resultat = ExecRequete($requete,$connexion);
			while($rub=mysql_fetch_array($resultat))
			{
				if(!$rub['ppi_dossier']) $rub['ppi_dossier'] = "ppi_dow/ppi_dow.php";
				$path = "../ppi/".$rub['ppi_dossier'];
				$dest = $path."?id=".$rub['ppi_ID']."&nom=".$rub['ppi_nom'];
				print("<li><a href=\"$dest\" target=\"middle\">".$rub['ppi_nom']."</a>");
			}
		?>
		</ul>
	</div>
<?php
?>
</form>
</body>
</html>