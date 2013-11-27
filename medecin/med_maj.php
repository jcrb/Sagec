<?php
/**
*	med_maj.php
*/
session_start();
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."utilitairesHTML.php");

include($backPathToRoot."adresse_ajout.php");
include_once ("../utilitaires/globals_string_lang.php");
include_once ("../utilitaires/google/utilitaires_carto.php");
include("../contact_main.php");

$med = $_REQUEST['idMed'];

function plage($i)
{
	print($i);
	?>
		<select name="h" size=1">
			<option value="1" <?php echo $i;if($i==1)echo 'SELECTED';?> >Lundi</option>
			<option value="2" <?php if($i==2)echo 'SELECTED';?> >Mardi</option>
			<option value="3" <?php if($i==3)echo 'SELECTED';?> >Mercredi</option>
			<option value="4" <?php if($i=4)echo 'SELECTED';?> >Jeudi</option>
			<option value="5" <?php if($i==5)echo 'SELECTED';?> >Vendredi</option>
			<option value="6" <?php if($i==6)echo 'SELECTED';?> >Samedi</option>
			<option value="7" <?php if($i==7)echo 'SELECTED';?> >dimanche</option>
		</select>
	<?php
	echo ' de ';
	print("<select>");
		for($i=0;$i<24;$i++){
			print("<option value=$i>$i</option>");
		}
	print("</select>");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>formulaire médecin</title>
	<meta http-equiv="content-type" content="""text/ht; charset=ISO-8859-15" >
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<meta http-equiv="Content-Language" content="fr" />
	<link href="./../../css/formstyle.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
</head>

<body onload="document.getElementById('nom').focus()">

<form id="catalogue" action="med_enregistre.php" method="post">
<?php
if(isset($med))
{
	$requete = "SELECT mg67.*, ville_nom 
					FROM mg67, ville
					WHERE mg67.ville_ID = ville.ville_ID  
					AND med_ID = '$med'";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete."<br>");
	$rep=mysql_fetch_array($resultat);
}
?>
<div id="formtitle">Fiche médecin (création/maj)</div>

<div id="content">
	<fieldset id="coordonnees">
	<legend>Identité</legend>
		<p><label for="nom">nom: </label>
			<input id="nom" type="text" name="nom" size="30" value="<?php echo($rep[med_nom]);?>">
		</p>
		<p><label for="prenom">prénom: </label>
			<input id="prenom" type="text" name="prenom" size="30" value="<?php echo($rep[med_prenom]);?>">
		</p>
		<p><label for="prenom">adresse: </label>
			<input id="prenom" type="text" name="prenom" size="30" value="<?php echo($rep[med_adresse]);?>">
		</p>
		
		<p><label for="spe">spécialité: </label>
			<input id="prenom" type="text" name="prenom" size="30" value="<?php echo($rep[med_prenom]);?>">
		</p>
	</fieldset>
	
	<fieldset  id="coordonnees">
		<legend><? echo $string_lang['ADRESSE'][$langue];?> </legend>
		<p>
			<label for="z1" title="z1">Zone 1:</label>
			<input type="text" name="z1" id="z1" title="z1" value="<? echo $ad[ad_zone1];?>" size="30" onFocus="_select('z1');" onBlur="deselect('z1');"/>
		</p>
		<p>
			<label for="z2" title="z2">Zone2:</label>
			<input type="text" name="z2" id="z2" title="z2" value="<? echo $ad[ad_zone2];?>"size="30" onFocus="_select('z2');" onBlur="deselect('z2');"/>
		</p>
		<p>
		<label for="ville">ville: </label>
		<?php
			$dep="'67','57'";
			select_ville_dep($connexion,$rep[ville_ID],$dep,$onChange=""); 
		?>
		</p>
		<p>
			<label for="zip" title="zip">code postal:</label>
			<input type="text" name="zip" id="zip" title="zip" value="<? echo $ad['zip'];?>" size="6" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="latitude" title="latitude">Latitude:</label>
			<input type="text" name="latitude" id="latitude" title="latitude" value="<? echo $ad[ad_latitude];?>" size="15" onFocus="_select('latitude');" onBlur="deselect('latitude');"/>
			<? echo dec2min($ad[ad_latitude]);?>
		</p>
		<p>
			<label for="longitude" title="longitude">Longitude:</label>
			<input type="text" name="longitude" id="longitude" title="longitude" value="<? echo $ad[ad_longitude];?>" size="15" onFocus="_select('longitude');" onBlur="deselect('longitude');"/>
			<? echo dec2min($ad[ad_longitude]);?>
		</p>
		<input type="hidden" name="adresse_ID" value="<? echo $organisme->adresse_ID;?>">
	</fieldset>
	
	<fieldset  id="coordonnees" >
		<legend><? echo $string_lang['CONTACT'][$langue];?> </legend>
		<span>
		<?php
		//===============================  affichage des contacts  ==============================================
		$service_caracid=$_REQUEST[orgID];
		$type=0;//nouveau
		$nature=2;//nature_contact = organisme
		$back="'../organisme/organisme_saisie.php'";//adresse de retour
		$variable="'orgID'";// variable de retour
		if($_REQUEST['orgID'])
			contact($service_caracid,$type,$nature,$contact_id,$back,$variable,$_REQUEST['orgID'],'','../../../html/sagec3/');
		//=======================================================================================================
		?>
		</span>
	</fieldset>
	<!-- HORAIRES -->
	<fieldset  id="coordonnees" >
		<legend> Horaires du Cabinet</legend>
		<?
			for($i=1; $i<8;$i++)
			{
				plage($i); 
				print("<br>");
			}
		?>
	</fieldset>
</div>

<div id="formfooter">
		<p>			
			<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
			<input type="submit" name="BtnSubmit" id="dupliquer" value="Dupliquer" />
			<input type="reset" name="BtnClear" id="annul" value="Annuler" />
		</p>
	</div>
	</form>
</body>

</html>