<?php
/**
* hop_affiche_victime.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_service'])header("Location:logout.php");
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");

$noVictime = Security::esc2Db($_REQUEST['noVictime']);// manque MAJUSCULE 
$requete = "SELECT victime_ID,nom, prenom,nip FROM victime WHERE no_ordre = '$noVictime'";
$resultat = ExecRequete($requete,$connexion);
$rub = mysql_fetch_array($resultat);
$victimeID = $rub[victime_ID];
$titre="VICTIME CONNUE";
// si le dossier n'existe pas, on le créé
if(!$victimeID)
{
	$requete = "INSERT INTO victime (victime_ID,no_ordre,conta_N,conta_B,conta_C,pays_ID,gravite,evenement_ID,org_createur_ID,heure_creation,nip,localisation_ID) 
						VALUES ('','$noVictime',1,1,1,999,'11','$_SESSION[evenement]','$_SESSION[organisation]','$date','$nip',7)";
	$resultat = ExecRequete($requete,$connexion);
	print($requete.'<br>');
	$victimeID = mysql_insert_id();
	$titre = "NOUVELLE VICTIME";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>formulaire zones</title>
	<meta http-equiv="content-type" content="""text/ht; charset=ISO-8859-1" >
	<link href="../../css/formstyle.css" rel="stylesheet" type="text/css" />
</head>

<body  onload="document.getElementById('noVictime').focus()">
	<form id="catalogue" action="hop_enregistre_victime.php" method="post">
		<input type="hidden" name="victimeID" value="<?php echo($victimeID); ?>">
		<div id="content">
			<fieldset id="coordonnees">
			<legend><?php echo($titre); ?></legend>
			<p>
				<label for="noVictime" title="code_barre">Identifiant Pre-Hospitalier :</label>
				<input type="text" id="noVictime" name="noVictime" title="code_barre" value="<?php echo($noVictime); ?>"/>
				<span class="exemple">ex : code barre</span>
			</p>
			
			</fieldset>
			<br />
		</div>

		<div id="content">
			<fieldset id="coordonnees">
			<legend> Enregistrement Victime </legend>
			<p>
				<label for="nip" title="NIP">NIP Hospitalier :</label>
				<input type="text" id="nip" name="nip" title="NIP" value="<?php echo($rub[nip]); ?>"/>
			</p>
			<p>
				<label for="nom" title="nom">Nom :</label>
				<input type="text" id="nom" name="nom" title="nom" value="<?php echo($rub[nom]); ?>"/>
			</p>
			<p>
				<label for="prenom" title="prenom">Prenom :</label>
				<input type="text" id="prenom" name="prenom" title="prenom" value="<?php echo($rub[prenom]); ?>"/>
			</p>
			</fieldset>
			<br />
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