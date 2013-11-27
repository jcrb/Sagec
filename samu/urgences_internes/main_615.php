<?php
/**
  *	main.php
  *	recherche de la localisation d'une UF à partir de son code
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require_once $backPathToRoot."autorisations/droits.php";
include_once("top_615.php");
include_once("menu_615.php");

$code = $_REQUEST['nom'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>615</title>
	<link rel="stylesheet" href="../div.css" type="text/css" media="all" />
	<link rel="stylesheet" href="../top.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend><? echo $string_lang['ORGANISME'][$langue];?> </legend>
		<p>
			<label for="nom" title="nom">Code UF:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo $code;?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
	</fieldset>
	<!-- champ de type BUTTON -->
	<p><input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/></p><br/>
	
	<?php
		if(isset($code))
		{
			$uf_recherche = "%".$code."%";
			$requete = "SELECT uf.*,service_nom, Hop_nom,consignes
							FROM uf,service,hopital,urg_interne
							WHERE uf_code LIKE '$uf_recherche'
							AND uf.service_ID = service.service_ID
							AND uf.Hop_ID = hopital.Hop_ID
							AND urg_interne.urg_int_ID = uf.uf_urgence
							";
							/*
			$requete = "SELECT uf_nom, service_nom,Hop_nom,consignes
							FROM uf,service,hopital,urg_interne
							WHERE uf_code LIKE '$uf_recherche'
							AND uf.service_ID = service.service_ID
							AND uf.Hop_ID = hopital.Hop_ID
							AND urg_interne.urg_int_ID = uf.uf_urgence
							";*/
			$resultat = ExecRequete($requete,$connexion);
			$rep = mysql_fetch_array($resultat);
			
	?>
		<fieldset id="field1">
		<legend><? echo 'Localisation';?> </legend>
		<p>
			<label for="intitule" title="intitule">Nom UF:</label>
			<input type="text" name="intitule" id="intitule" title="intitule" value="<? echo $rep['uf_nom'];?>" size="50" onFocus="_select('intitule');" onBlur="deselect('intitule');"/>
		</p>
		<p><label for="service" title="service">Service:</label><?php echo $rep['service_nom'];?></p>
		<p><label for="hop" title="hop">Hôpital:</label><?php echo $rep['Hop_nom'];?><br></p>
		<p><label for="hop" title="hop">Batiment:</label><?php echo $rep['batiment_nom'];?><br></p>
		<p><label for="hop" title="hop">Etage:</label><?php echo $rep['etage'];?><br></p>
		<p><label for="hop" title="hop">URGENCE:</label><?php echo $rep['consignes'];?><br></p>
	</fieldset>
	<?php
		}
	?>
</div>
</html>