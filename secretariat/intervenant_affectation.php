<?php
/**
  *	intervenant_affectation.php
  */
  
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
include($backPathToRoot."utilitairesHTML.php");
include($backPathToRoot."date.php");
$langue = $_SESSION['langue'];

$id = $_REQUEST[id];// identifiant
$nom = $_REQUEST[nom];
$prenom = $_REQUEST[prenom];

$requete = "SELECT * FROM perso_affectation WHERE personnel_ID = '$id'";
$resultat = ExecRequete($requete,$connexion);
$rep= mysql_fetch_array($resultat);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="affectation" action= "affectation_enregistre.php" method = "get">
<input type="hidden" name="personnelID" value="<?php echo $id; ?>">
<input type="hidden" name="affectationID" value="<?php echo $rep[affectation_ID]; ?>">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Affectation</legend>
		<p>
			<label for="nom" title="nom">Nom:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo $nom;?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="prenom" title="prenom">Prénom:</label>
			<input type="text" name="prenom" id="prenom" title="prenom" value="<? echo $prenom;?>" size="50" onFocus="_select('prenom');" onBlur="deselect('prenom');"/>
		</p>
		<p>
			<label for="loc" title="nom">Localisation:</label>
			<?php SelectStructureTemporaire($connexion,$rep['location_ID'],$langue); ?><!-- localisation_type -->
		</p>
		<p>
			<label for="vec" title="Vecteur assigné à la personne">Vecteur:</label>
			<?php SelectVecteurEngages($connexion,$rep['vecteur_ID']); ?><!-- retourne vecteur_engage_ID -->
		</p>
		<p>
			<label for="fonction" title="mission">Fonction:</label>
			<?php SelectFonction($connexion,$rep['fonction_ID'],$langue);?><!-- retourne id_fonction -->
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Horaires de service</legend>
		<p>
			<label for="h1" title="HH:MM">heure d'alerte:</label>
			<input type="text" name="h1" id="h1" title="h1" value="<? echo usdate2fdate($rep['heure_alerte']);?>" size="50" onFocus="_select('h1');" onBlur="deselect('h1');"/>
			<input type="button" value="..." class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=affectation&elem=h1&heure=true','Calendrier','width=200,height=280')">
		</p>
		<p>
			<label for="h2" title="HH:MM">heure d'arrivée:</label>
			<input type="text" name="h2" id="h2" title="h2" value="<? echo usdate2fdate($rep['heure_arrive']);?>" size="50" onFocus="_select('h2');" onBlur="deselect('h2');"/>
			<input type="button" value="..." class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=affectation&elem=h2&heure=true','Calendrier','width=200,height=280')">
		</p>
		<p>
			<label for="h1" title="HH:MM">heure de départ:</label>
			<input type="text" name="h3" id="h3" title="31" value="<? echo usdate2fdate($rep['heure_depart']);?>" size="50" onFocus="_select('h3');" onBlur="deselect('h3');"/>
			<input type="button" value="..." class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=affectation&elem=h3&heure=true','Calendrier','width=200,height=280')">
		</p>
	</fieldset>
	
	<!-- champ de type TextArea -->
	<fieldset id="field1">
		<legend> Moyens de communication </legend>
		<p>
			<label for="p1" title="portatif 1">Portatif 1:</label>
			<input type="text" name="p1" id="p1" title="p1" value="<?php echo $rep['portatif1'];?>" size="50" onFocus="_select('p1');" onBlur="deselect('p1');"/>
		</p>
		<p>
			<label for="p2" title="portatif 2">Portatif 2:</label>
			<input type="text" name="p2" id="p2" title="p2" value="<?php echo $rep['portatif2'];?>" size="50" onFocus="_select('p2');" onBlur="deselect('p2');"/>
		</p>
		<p>
			<label for="tel1" title="tel 1">Tel 1:</label>
			<input type="text" name="tel1" id="tel1" title="tel1" value="<?php echo $rep['tel1'];?>" size="50" onFocus="_select('tel1');" onBlur="deselect('tel1');"/>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<p>
			<label for="rem" title="rem">Remarque:</label>
			<textarea name="rem" id="rem" rows="2" cols="60"><?php echo $rep['remarque'];?></textarea>
		</p>
	</fieldset>
	
	
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>

<?php
?>

</form>
</body>
</html>