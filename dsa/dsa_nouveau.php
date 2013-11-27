<?php
/**
  *	div_test.php
  *
  * @package Sagec
  * @author JCB
  * @copyright 2008  *
  */

$titre_principal = "DSA - Saisie";
include_once("top.php");
include_once("menu.php");
$departement = "67";
$langue = $_SESSION['langue'];
$backpathToRoot = "../";
require_once($backpathToRoot."utilitairesHTML.php");
require_once($backpathToRoot."dbConnection.php");
require_once($backpathToRoot."utilitaires/globals_string_lang.php");
include_once($backpathToRoot."login/init_security.php");

/**
  *	Insertion ou MAJ ?
  */
$dsa_id = $_REQUEST['dsa_id'];print($dsa_id);
if(isset($dsa_id)&&$dsa_id > 0)
{
	$requete = "SELECT * FROM dsa WHERE dsa_ID = '$dsa_id'";
	$result = mysql_query($requete);
	$rep = mysql_fetch_array($result);
	if($rep[dsa_organisme]=="") $rep[dsa_organisme]="287";//  A DEFINIR
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Nouveau DSA</title>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15" />
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
<input type="hidden" name="dsa_id" value="<?echo $dsa_id;?>">

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
			<option value="1" <? if($rep[dsa_type]==1)echo "selected";?> >DSA</option>
			<option value="2" <? if($rep[dsa_type]==2)echo "selected";?> >DAE</option>
			<option value="99" <? if($rep[dsa_type]==99)echo "selected";?> >indéterminé</option>
		</select>
		</p>
		
		<p>
		<?php
		// a terminer pour faire une liste déroulante 
		$sql = "SELECT fournisseur_nom 
					FROM fournisseur,materiel_fournisseur 
					WHERE fournisseur.fournisseur_ID = materiel_fournisseur.fournisseur_ID 
					AND materiel_fournisseur.materiel_ID = 44
					ORDER BY  fournisseur_nom";
		?>
			<label for="type" title="type dsa">Marque:</label>
			<select id="type" name="type" title="type dsa">
			<option value="1" selected="selected">Schiller</option>
			<option value="2">Laerdal</option>
			<option value="3">Philips</option>
			<option value="4">Zoll</option>
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
			<input type="text" name="site" id="site" title="site" size="40" value="<?echo Security::db2str($rep[dsa_site]);?>" onFocus="_select('site');" onBlur="deselect('site');" />
		</p>
		<p>
			<label for="adresse" title="adresse">Adresse:</label>
			<input type="text" name="adresse" id="adresse" title="adresse" size="40" value="<?echo Security::db2str($rep[dsa_adresse]);?>" onFocus="_select('adresse');" onBlur="deselect('adresse');"/>
		</p>
		<p>
			<label for="fsn" title="nom">Ville:</label>
			<?php 
				$departement = '67'."','".'68';	
				$select = $rep['ville_ID'];
				select_ville_france2($connexion,$select,$departement,$langue);/* retourne ville_id */
			?>
			<input type="button" name="geocode" value="geocode" onClick="geocoding();">
		</p>
		<p>
			<label for="tel" title="téléphone">Tel:</label>
			<input type="text" name="tel" id="tel" title="tel" value="<?echo Security::db2str($rep[dsa_tel]);?>" onFocus="_select('tel');" onBlur="deselect('tel');"/>
		</p>
		<p>
			<label for="dsa_lat" title="dsa_lat">Latitude:</label>
			<input type="text" name="dsa_lat" id="dsa_lat" title="latitude" value="<?echo Security::db2str($rep[dsa_lat]);?>" onFocus="_select('dsa_lat');" onBlur="deselect('dsa_lat');"/>
		</p>
		<p>
			<label for="dsa_lng" title="dsa_lng">Longitude:</label>
			<input type="text" name="dsa_lng" id="dsa_lng" title="longitude" value="<?echo Security::db2str($rep[dsa_lng]);?>" onFocus="_select('dsa_lng');" onBlur="deselect('dsa_lng');"/>
		</p>
		<p>
			<label for="type" title="intérieur, extérieur">Accès:</label>
			<select id="type" name="acces" title="intérieur, extérieur">
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
			<?php 
				$org = (int)$rep['organisme_ID'];
				if($org < 1) $org = 287; // correspond à A DEFINIR 
				SelectOrganisme($connexion,$org,$langue);// org_type
			?>
		</p>
		<p>
			<!--
			<label>shelter forname:</label>
			<input type="text" name="shelter_name" id="sn"/>
			-->
		</p>
	</fieldset>
	

	
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<textarea name="comment" id="" rows="2" cols="50"><?echo Security::db2str($rep[dsa_comment]);?></textarea>
	</fieldset>
	
	<input type="submit" name="ok" id="valider" value="Valider"/>

</div>

</form>
</body>
</html>