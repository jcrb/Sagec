<?php
/**
*	ror_gabarit.php
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="top.css" type="text/css" media="all" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<?php
/**
*	genere_select("plan", "ppi","ppi_ID","ppi_name",$connect);
*	@data $name nom de la liste. C'est également le nom de la variable de retour
*	@data $table nom de la table dans la base de données
*	@data	$value nom du champ de la table qui servira à  renseigner VALUE de OPTION
*	@data $key   nom du champ de la table qui servira à  renseigner le nom affiché dans la liste
*	@data $connect variable de connexion
*	@data	$where complément pour la requete SQL
*	@data $origin tableau permettant d'imposer les premiers items ($origin = array('--?--'=>'0');)
*	@data $id	identifiant du code HTML
*	@data $selected valeur de $value permettant de sélectionner l'item par défaut de la liste
*/


$table = "ror_location_type";
$name = "locTypeId";
$value = "ror_location_type_ID";
$key = "ror_location_type_nom";
$selected1 = 99;//$location;
$where = " ORDER BY ".$key;

$table2 = "ror_ressource_type";
$name2 = "resTypeId";
$value2 = "ressource_type_ID";
$key2 = "ressource_type_nom";
$multiple2 = false;
$selected2 = 99;//$ressourceType;
$where2 = " ORDER BY ".$key2;
$todo = 'xxx';
/*
$table3 = "ror_ressource";
$name3 = "resId";
$value3 = "ror_ressource_ID";
$key3 = "ressource_nom";
$multiple3 = false;
$selected3 = 99;//$ressourceType;
$where3 = " ORDER BY ".$key3;
*/
?>
<body onload="">

<form name="" action= "ror_select_ressource.php" method = "get">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend><? echo $string_lang['ORGANISME'][$langue];?> </legend>
		<p>
			<label for="nom" title="nom">Type de localisation:</label>
			<?php genere_select($name,$table, $value, $key,$connexion, $where, $origin, $id, $selected1, $multiple, $class='', $style='');?>
			<a href="">ajouter un nouveau type</a>
		</p>
		<p>
			<label for="nom" title="nom">Type de ressource:</label>
			<?php genere_select($name2,$table2, $value2, $key2,$connexion, $where2, $origin2, $id2, $selected2, $multiple2, $class2='', $style2='',$todo);?>
			<a href="">ajouter un nouveau type</a>
		</p>

	</fieldset>
	<input type="submit" name="ok" id="submit" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
</div>
</form>
</body>
</html>