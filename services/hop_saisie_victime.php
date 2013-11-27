<?php
/**
* hop_saisie_victime.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_service'])header("Location:logout.php");
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>formulaire zones</title>
	<meta http-equiv="content-type" content="""text/ht; charset=ISO-8859-1" >
	<link href="../../css/formstyle.css" rel="stylesheet" type="text/css" />
</head>

<body  onload="document.getElementById('noVictime').focus()">
	<form id="catalogue" action="hop_affiche_victime.php" method="post">
		<input type="hidden" name="victimeID" value="<?php echo($victimeID); ?>">
		<div id="content">
			<fieldset id="coordonnees">
			<legend> Enregistrement Victime </legend>
			<p>
				<label for="noVictime" title="code_barre">Identifiant Pre-Hospitalier :</label>
				<input type="text" id="noVictime" name="noVictime" title="code_barre" value="<?php echo($noVictime); ?>"/>
				<span class="exemple">ex : code barre</span>
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