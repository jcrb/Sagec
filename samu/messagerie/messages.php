<?php
/**
  *	messages.php
  */
  
  	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$langue = $_SESSION['langue'];
	include_once("top.php");
	include_once("menu.php");
	$backPathToRoot = "../../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Cartographie</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="stylesheet" href="../top.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>

<body onload="">

<form name="" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Documentation </legend>
		<p>
			
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend> Nouveau </legend>
		<p>
			Création d'un nouveau <font color="red"><b>message</b></font>.</br>
			Il n'y a pas de règles formelles concernant les messages. Toutes les informations pouvant intéresser la collectivité sont acceptables.</br>
			<i><u>Ce n'est pas un forum de discussion.</u> Les informations doivent rester brèves et concises</i></br>
			Pour modifier l'aspect du message, utilisez les outils de la barre des menus.
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend> Lire </legend>
		<p>
			Lire les messages des <u>20 derniers jours</u>.</br>
			<b>[M]</b>odifier un message</br>
			<b>[R]</b>épondre à un message</br>
			<b>[S]</b>upprimer un message <i>dont on est l'auteur</i></br>
			Les messages plus anciens sont automatiquement archivés. On peut trier les messages par date ou par auteur.
			Pour les consulter, utilisez la rubrique <b>Archives</b>
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend> Archives </legend>
		<p>
			Lecture des messages archivés.</br>
			On peut trier les messages par date ou par auteur.
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Codes service Utiles </legend>
		<table width="50%">
		<tr>
			<th>&nbsp;</th>
			<th>NHC</th>
			<th>HTP</th>
		</tr>
			<td>Urgences Médicales</td>
			<td>2051</td>
			<td>6108</td>
		<tr>
		</tr>
			<td>Urgences Chirurgicales</td>
			<td>2052</td>
			<td>6118</td>
		<tr>
		</tr>
		<tr>
			<td>Réanimation Médicale</td>
			<td>2136</td>
			<td>6251</td>
		</tr>
		<tr>
			<td>Réanimation Chirurgicale</td>
			<td>2131</td>
			<td>6361</td>
		</tr>
		<tr>
			<td>USIC</td>
			<td>1101</td>
			<td>&nbsp;</td>
		</tr>
		</table>
	</fieldset>


<?php
$datetime1 = new DateTime('2009-10-01');
$datetime2 = new DateTime('2009-10-07');
$interval = $datetime1->diff($datetime2);
echo "test";
echo $interval->format('%R%a days');
?>
</div>

</form>
</body>
</html>