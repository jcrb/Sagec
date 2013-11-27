<?php
/**
  *	dsa_cherche.php
  *
  * @package Sagec
  * @author JCB
  * @copyright 2008
  *
  */
  $backPathToRoot = "../";
include($backPathToRoot.'dbConnection.php'); 
include_once("top.php");
include_once("menu.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Nouveau DSA</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<script  type="text/javascript" src="utilitaires.js"></script>
</head>

<body onload="document.getElementById('lat').focus()">
<form name="new_dsa" id="new_dsa" method="get" action="dsa_geoloc.php" onsubmit="return valider();">
<input type="hidden" name="dsa_id" value="<?echo $dsa_id;?>">

<div id="div2">

	<fieldset id="field1">
		<legend> Localisation par GPS </legend>
		
		<p><label for="dsa">degré décimaux</label><input type="radio" name="unite" value="1" id="dsa" selected/>  (7.456239)</p>
		<p><label for="dae">degré, minute, secondes</label><input type="radio" name="unite" value="2" id="dae" />  (7° 43' 33'')</p>
		
		<p>
			<label for="lat" title="latitude">Latitude:</label>
			<input type="text" name="lat" id="lat" title="latitude" onFocus="_select('lat');" onBlur="deselect('lat');" />
		</p>
		<p>
			<label for="lng" title="longitude">Longitude:</label>
			<input type="text" name="lng" id="lng" title="longitude" onFocus="_select('lng');" onBlur="deselect('lng');" />
		</p>
	</fieldset>
	<input type="submit" name="ok" id="valide_gps" value="Valider"/>

	<fieldset id="field1">
		<legend> Localisation par ADRESSE </legend>
		<p>
			<label for="rue" title="rue">N° et rue:</label>
			<input type="text" name="rue" id="rue" title="rue" value='Perigeux' onFocus="_select('rue');" onBlur="deselect('rue');" />
		</p>
		<p>
			<label for="ville" title="ville">Commune:</label>
			<input type="text" name="ville" id="ville" title="ville" value = 'Bischheim'onFocus="_select('ville');" onBlur="deselect('ville');" />
		</p>
		<p>
			<label for="pays" title="pays">Pays:</label>
			<input type="text" name="pays" id="pays" title="pays" value="France" onFocus="_select('pays');" onBlur="deselect('pays');" />
		</p>
	</fieldset>
	<input type="submit" name="ok1" id="valide_adresse" value="Valider"/>
</div>

</form>
</body>
</html>