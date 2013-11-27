<?php
/**
*	ressource_new.php
*/

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "ROR - Ressources";
$sousmenu = "";
include_once("ror_top.php");
include_once("ror_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."utilitaires/liste.php");;

$table2 = "ror_ressource_type";
$name2 = "resTypeId";
$value2 = "ressource_type_ID";
$key2 = "ressource_type_nom";
$multiple2 = false;
$selected2 = 99;//$ressourceType;
$where2 = " ORDER BY ".$key2;

$ressourceID = $_REQUEST['ressourceID'];

if(isset($ressourceID))
{
	$requete = "SELECT * FROM ror_ressource WHERE ror_ressource_ID = '$ressourceID'";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	$selected2 = $rub['ressource_type_ID'];
}
if(!isset($rub[report_frequency])) $rub[report_frequency]=120;
if(!isset($rub[display_order])) $rub[display_order]=99;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Ressource_new</title>
	<link rel="stylesheet" href="../top.css" type="text/css" media="all" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="">

<form name="ressource_saisie" action= "ressource_save.php" method = "get">
<input type="hidden" name="ressourceID" value="<? echo $ressourceID;?>">
<div id="div2">
		<fieldset id="field1"><legend><? echo "Créer/modifier une ressource";?> </legend>
			<p>
			<label for="nom" title="nom">intitulé:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo Security::db2str($rub[ressource_nom]);?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"
			required placeholder="Nom de la ressource est obligatoire"/>
			</p>
			<p>
			<label for="nom" title="nom">Type de ressource:</label>
			<?php genere_select($name2,$table2, $value2, $key2,$connexion, $where2, $origin2, $id2, $selected2, $multiple2, $class2='', $style2='');?>
			<a href="">ajouter un nouveau type</a>
			</p>
			<p>
			<label for="freq" title="freq">Fréquence de mesure:</label>
			<input type="range" name="freq" id="freq" title="freq" size="2" value="<? echo $rub[report_frequency];?>" size="50" min="0" max="999" step="1" onFocus="_select('freq');" onBlur="deselect('freq');"/>
			</p>
			<p>
			<label for="visible">visible :</label>
			<input type="checkbox" id="visible" name="visible" <?php if($rub['visible']=='o') echo(' CHECKED')?> />
			<p>
			<label for="ordre" title="ordre">ordre d'affichage:</label>
			<input type="text" name="ordre" id="ordre" title="ordre" value="<? echo $rub[display_order]?>" size="2" onFocus="_select('ordre');" onBlur="deselect('ordre');"/>
			</p>
		</p>
		</fieldset>
		<input type="submit" name="ok" id="submit" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
</div>
</form>
</body>
</html>