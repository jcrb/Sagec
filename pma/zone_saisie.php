<?php
/**
*	zone_saisie.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
$zoneID = $_REQUEST['zoneID'];

if($_REQUEST['BtnSubmit'] == 'Valider')
{
	$nom = Security::esc2Db($_REQUEST['nom']);
	$fichier = Security::esc2Db($_REQUEST['fichier']);
	$trait = Security::esc2Db($_REQUEST['trait']);
	$fond = Security::esc2Db($_REQUEST['fond']);
	$transparence = Security::esc2Db($_REQUEST['transparence']);
	$val = Security::esc2Db($_REQUEST['val']);
	$etat = Security::esc2Db($_REQUEST['etat']); print("etat: ".$etat);
	$zoneID = Security::esc2Db($_REQUEST['zoneID']);
	$objet = Security::esc2Db($_REQUEST['objet']);
	$ep = Security::esc2Db($_REQUEST['ep']);
	/**
	*	Mise à jour / creation du fichier
	*/
	$file = "zones/".$fichier;
	if (file_exists($file))
		file_put_contents($file,$val);
	else
	{
		$fp=fopen($file,"w"); 
		fclose($fp);
		chmod ($file, 0777);
		file_put_contents($file,$val);
	}
	/**
	* Mise à jour de la base de données
	*/
	if($zoneID)
	{
		$requete = "UPDATE zone_enveloppe SET 
						zenveloppe_nom = '$nom',
						zenveloppe_file = '$fichier',
						zenveloppe_couleurTrait = '$trait',
						zenveloppe_couleurFond = '$fond',
						zenveloppe_transparence = '$transparence',
						zenveloppe_active = '$etat',
						zenveloppe_objet = '$objet',
						zenveloppe_epaisseur = '$ep'
						WHERE zenveloppe_ID = '$zoneID'";
		ExecRequete($requete,$connexion);
	}
	else
	{
		$requete = "INSERT INTO zone_enveloppe VALUES('','$nom','$fichier','$transparence','$trait','$fond','$etat','$objet','$ep')";
		ExecRequete($requete,$connexion);
		$zoneID = mysql_insert_id();				
	}
	//print($requete);
}

if($zoneID)	// c'est une mise à jour
{
	$requete = "SELECT * FROM zone_enveloppe WHERE zenveloppe_ID = '$zoneID'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>formulaire zones</title>
	<meta http-equiv="content-type" content="text/html"; charset=ISO-8859-1" >
	<link href="../../css/formstyle.css" rel="stylesheet" type="text/css" />
</head>

<body onload="document.getElementById('nom').focus()">
	<form id="catalogue" action="zone_saisie.php" method="post">
	<input type="hidden" name="zoneID" value="<?php echo($zoneID); ?>">
	
	<div id="formtitle">Enregistrer une Zone</div>
	<div id="content">
	<fieldset id="coordonnees">
		<legend>Zone</legend>
		<p>
			<label for="nom" title="Intitulé de la zone">Nom :</label>
			<input type="text" id="nom" name="nom" title="Intitulé de la zone" value="<?php echo($rub[zenveloppe_nom]); ?>"/>
			<span class="exemple">ex : PMC-zone rouge</span>
		</p>
		<p>
			<label for="fichier">Fichier :</label>
			<input type="text" id="fichier" name="fichier" size="50" value="<?php echo($rub[zenveloppe_file]);?>"/>
		</p>
		<p>
			<label for="trait">Couleur du trait :</label>
			<input type="text" id="trait" name="trait" value="<?php echo($rub[zenveloppe_couleurTrait]);?>"/>
			<a href="#" class="help" title="Notez bien votre adresse complète!"></a>
		</p>
		<p>
			<label for="ep">Epaisseur du trait :</label>
			<input type="text" id="ep" name="ep" value="<?php echo($rub[zenveloppe_epaisseur]);?>"/>
		</p>
		<p>
			<label for="fond">Couleur du fond :</label>
			<input type="text" id="fond" name="fond" value="<?php echo($rub[zenveloppe_couleurFond]);?>"/>
			<a href="#" class="help" title="Notez bien votre adresse complète!"></a>
		</p>
		<p>
			<label for="transparence">Transparence :</label>
			<input type="text" id="transparence" name="transparence" size="10" value="<?php echo($rub[zenveloppe_transparence]);?>" />
			<span class="exemple">0 à 100 (100 = opaque)</span>
		</p>
		<p>
			<label for="objet">Objet :</label>
			<input type="radio" id="objet" name="objet" value="P" <?php if($rub[zenveloppe_objet]=='P') echo 'checked';?> />Polygone
			<input type="radio" id="objet" name="objet" value="L" <?php if($rub[zenveloppe_objet]=='L') echo 'checked';?> />Ligne
	
		</p>
	</fieldset>
	<br />
	
	<fieldset id="coordonnees">
		<legend>Valeurs</legend>
		<p>
			<?php
				$file = "zones/".$rub[zenveloppe_file];
				if(file_exists($file))
					$data = file_get_contents($file);
				else
					$data = "Il n'y a pas de données associées à cette zone";
			?>
			<label for="val">Latitude/Longitude :</label>
			<textarea id="val" name="val" rows="10" cols="40" value=""><?php echo $data ?></textarea>
			<span class="exemple">dégrés décimaux</span>
		</p>
	</fieldset>
	<br />
	
	<fieldset id="typecat">
		<legend>Etat</legend>		
		<p><span class="exemple">Sélectionnez l'état de la zone :</span><br />
			<input type="radio" name="etat" id="actif" value="o" <?php if($rub[zenveloppe_active]=='o') echo('checked');?> > Actif<br />
			<input type="radio" name="etat" id="inactif" value="n" <?php if($rub[zenveloppe_active]=='n') echo('checked');?> > Inactif<br />		
		</p>
	</fieldset>
	
	</div>
	<div id="formfooter">
		<p>			
			<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
			<input type="reset" name="BtnClear" id="annul" value="Annuler" />
		</p>
	</div>
	</form>
</body>

</html>
