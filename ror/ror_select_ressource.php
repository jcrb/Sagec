<?php
/**
*	ror_select_ressource.php
*/

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include_once("ror_top.php");
include_once("ror_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."utilitaires/liste.php");
require($backPathToRoot."login/init_security.php");

$location = $_REQUEST['locTypeId'];
$ressourceType = $_REQUEST['resTypeId'];
$data = $_REQUEST['data'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="../top.css" type="text/css" media="all" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="">

<form name="" action= "ror_save_choix.php" method = "get">
	<input type="hidden" name="locTypeId" value="<? echo $location;?>">
	<input type="hidden" name="resTypeId" value="<? echo $ressourceType;?>">
	
	<div id="div2">
		<fieldset id="field1">
		<legend><? echo "choix";?> </legend>
		<p>Sélectionner les ressources associées au type de localisation <b><? echo $location;?></b> et au type de ressource <b><? echo $ressourceType;?></b></p><br>
<?php

if(isset($_REQUEST['resTypeId']))
{
	$data = Array();
	
	$requete = "SELECT ressource_ID FROM ror_locationtype_ressource WHERE ressourcetype_ID = '$ressourceType' AND locationtype_ID = '$location'";
	$resultat = ExecRequete($requete,$connexion);
	while($rep = mysql_fetch_array($resultat))
	{
		$data[] = $rep['ressource_ID'];
	}
	
	$requete = "SELECT * FROM ror_ressource WHERE ressource_type_ID = '$_REQUEST[resTypeId]'";
	$resultat = ExecRequete($requete,$connexion);
	while($rep = mysql_fetch_array($resultat))
	{
		?>
		<input type="checkbox" name="data[]" value="<?php echo $rep[ror_ressource_ID];?>"
		<? if (in_array($rep[ror_ressource_ID], $data)) echo 'checked'; ?> >
		<?php echo SECURITY::db2str($rep[ressource_nom]); ?>
		<br>
		<?php
	}
}
?>
	</fieldset>
	<input type="submit" name="ok" id="submit" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	</div>
</form>
</body>
</html>