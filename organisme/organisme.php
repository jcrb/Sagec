<?php
/**
*	div_test.php
*/
include_once("top.php");
include_once("menu.php");
$backpathToRoot = "../";
require_once($backpathToRoot."utilitairesHTML.php");
require_once($backpathToRoot."dbConnection.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>section Organisme</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script type="text/javascript">
	
    	function geocoding()
    	{
			var liste = document.getElementById("ville_id");
			var i = liste.options[liste.selectedIndex].name;
    		var rue = document.getElementById("adresse").value;
    		alert(i);
    	}
    
    </script>
</head>

<body onload="document.getElementById('sn').focus()">
<form name="new_dsa" id="new_dsa" method="post" action="dsa_enregistre.php" onsubmit="return valider();">

<div id="div2">

	<fieldset id="field1">
		<legend> Appareil </legend>
		<!--
		<p><label for="dsa">DSA</label><input type="radio" name="typeDsa" id="dsa" /></p>
		<p><label for="dae">DAE</label><input type="radio" name="typeDsa" id="dae" /></p>
		-->
		<p>
			<label for="type" title="type dsa">Type:</label>
			<select id="type" name="type" title="type dsa">
			<option value="1" selected="selected">DSA</option>
			<option value="2">DAE</option>
			<option value="99">indéterminé</option>
		</select>
		</p>
		
		<p>
			<label for="type" title="type dsa">Marque:</label>
			<select id="type" name="type" title="type dsa">
			<option value="1" selected="selected">Schiller</option>
			<option value="2">Laerdal</option>
			<option value="99">indéterminé</option>
		</select>
		</p>
		
		<p>
			<label for="modele" title="modele">Modèle:</label>
			<input type="text" name="modele" id="modele" title="modele" onFocus="_select('modele');" onBlur="deselect('modele');" />
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Localisation </legend>
		<p>
			<label for="site" title="site">Site:</label>
			<input type="text" name="site" id="site" title="site" onFocus="_select('site');" onBlur="deselect('site');" />
		</p>
		<p>
			<label for="adresse" title="nom">Adresse:</label>
			<input type="text" name="adresse" id="adresse" title="adresse" onFocus="_select('adresse');" onBlur="deselect('adresse');"/>
		</p>
		<p>
			<label for="fsn" title="nom">Ville:</label>
			<?php select_ville_france($connexion,$item_select,$departement,$langue);/* retourne ville_id */?>
			<input type="button" name="geocode" value="geocode" onClick="geocoding();">
		</p>
		<p>
			<label for="fsn" title="nom">Tel:</label>
			<input type="text" name="shelter_name" id="fsn" title="nom" onFocus="_select('fsn');" onBlur="deselect('fsn');"/>
		</p>
		<p>
			<label for="fsn" title="nom">Latitude:</label>
			<input type="text" name="shelter_name" id="fsn" title="nom" onFocus="_select('fsn');" onBlur="deselect('fsn');"/>
		</p>
		<p>
			<label for="fsn" title="nom">Longitude:</label>
			<input type="text" name="shelter_name" id="fsn" title="nom" onFocus="_select('fsn');" onBlur="deselect('fsn');"/>
		</p>
		<p>
			<label for="type" title="type dsa">Accès:</label>
			<select id="type" name="acces" title="type dsa">
			<option value="1" selected="selected">Public</option>
			<option value="2">Semi-public</option>
			<option value="99">Privé</option>
		</select>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Propriétaire </legend>
		<p>
			<label>Organisme:</label>
			<?php SelectOrganisme($connexion,$item_select,$langue);// org_type
			?>
		</p>
		<p>
			<label>shelter forname:</label>
			<input type="text" name="shelter_name" id="sn"/>
		</p>
	</fieldset>
	

	
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<textarea name="" id="" rows="2" cols="50"></textarea>
	</fieldset>
	
	<input type="submit" name="ok" id="valider" value="Valider"/>

</div>

</form>
</body>
</html>