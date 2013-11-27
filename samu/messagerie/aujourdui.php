<?php
/**
  *	aujourdui.php
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
require_once($backPathToRoot."date.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require_once $backPathToRoot."autorisations/droits.php";
include($backPathToRoot."login/init_security.php");
include_once("top.php");
include_once("menu.php");

/** color: #FF0000; font-family: Verdana; font-weight: bold; font-size: 14px;background-color: #FFFF66; */
function _style($mot)
{
	if($mot == 'ACTIF')
		return 'color: #FF0000;';//actif
	else
		return 'color: #000000;';//inactif 
}

/**
  * semaine paire ou impaire
  * $time: temps en secondes. Si vide utilise l'heure courante
  * return paire ou impaire
  */
function semaine($time='')
{
	if($time=='')$time = time();
	$semaine = semaine_courante($time);
	if($semaine % 2 == 0)
		return 'PAIRE';
	else
		return 'IMPAIRE';
}

$jour = jour_de_la_semaine(time(),$langue).' '.jour_du_mois(time()).' '.mois_courant(time(),$langue).' '.date("Y",time());

	/** ADPC ou CRF */
	$adpc = $crf = 'INACTIF';
	if(jour_de_la_semaine(time(),$langue)=='Samedi' || jour_de_la_semaine(time(),$langue)=='Dimanche')
		$adpc = 'ACTIF';
	if(jour_de_la_semaine(time(),$langue)=='Vendredi')
		$crf = 'ACTIF';
	
	/** semaine paire */
		if(semaine() == 'PAIRE'){
		$dsm = "SAMU 67";
		$sos_main = "CCOM";
	}
	/** semaine impaire */
	else {
		$dsm="SDIS 67";
		$sos_main = "Diaconat";
	}
	/** jour pair */
	if(jour_de_annee(time()) % 2 == 0)
	{
		$ipm = "NHC";
		$cnh = "HTP";
		$ream = "HTP";
	}
	/** jour impair */
	else
	{
		$ipm = "HTP";
		$cnh = "NHC";
		$ream = "NHC";
	}

/**
  *	manifestations du jour
  */
$today = uDate2MySql(time());
$requete = "SELECT * FROM  manifestation WHERE '$today' BETWEEN manif_debut AND manif_fin";
$resultat1 = ExecRequete($requete,$connexion);

$on = $backPathToRoot."images/on.png";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<meta http-equiv="refresh" content="30">
	<title>Liste des messages</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="stylesheet" href="../top.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>
<body>
<form name="" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Informations du jour </legend>
			<table><tr>
				<td><?php echo $jour;?></td>
				<td>semaine: <?php echo semaine_courante(time());?></td>
				<td>jour: <?php echo jour_de_annee(time());?></td>
			</tr></table>
	</fieldset>
	
	<br>
	<table id="table_double"><tr><td>
	<fieldset id="field3">
		<legend> Astreinte</legend>
			<p>
				<label for="nom" title="nom">DSM:</label>
				<input type="text"  value="<? echo $dsm;?>" size="10" />
				<!--<img src="<?php echo $on;?>" alt="on">-->
			</p>
			<p>
				<label for="nom" title="nom">SAMU 67:</label>
				<input type="text"  value="<? echo $samu;?>" size="10" />
			</p>

	</fieldset>
	
	
	<fieldset id="field3">
		<legend>Services de garde </legend>
			<p>
				<label for="nom" title="nom">SOS Mains:</label>
				<input type="text"  value="<? echo $sos_main;?>" size="10" />
			</p>
			<p>
				<label for="nom" title="nom">Réanimation médicale:</label>
				<input type="text"  value="<? echo $ipm;?>" size="10" />
			</p>
			<p>
				<label for="nom" title="nom">IPM:</label>
				<input type="text"  value="<? echo $ipm;?>" size="10" />
			</p>
			<p>
				<label for="nom" title="nom">CNH:</label>
				<input type="text"  value="<? echo $cnh;?>" size="10" />
			</p>
	</fieldset>
	
	<fieldset id="field3">
		<legend>Hélicoptères </legend>
			<p>
			<label for="nom" title="nom">Dragon 67:</label>
			<input type="text"  value="<? echo 'OPERATIONNEL';?>" size="10" />
			</p>
	</fieldset>
	
	
	</td>
	
	<td>
	<fieldset id="field3"> 
		<legend>Premier secours </legend>
			<p>
				<p><label>ADPC 67</label><input type="text" style="<?php echo _style($adpc);?>" value="<?php echo $adpc;?>"></p>
				<p><label>CRF 67</label><input type="text" style="<?php echo _style($crf);?>" value="<?php echo $crf;?>"></p>
			</p>
	</fieldset>
	
	<fieldset id="field3">
		<legend>Protocoles en cours </legend>
			<p>
				<p><label>coeur arrêté</label><input type="text" value="<?php echo 'ACTIF';?>"></p>
				<p><label>cartagène</label><input type="text" value="<?php echo 'ACTIF';?>"></p>
				<p><label>hypothermie </label><input type="text" value="<?php echo 'ACTIF';?>"></p>
				<p><label>Atlantic</label><input type="text" value="<?php echo 'EN ATTENTE';?>"></p>
			</p>
	</fieldset>
	
	</td></tr></table>
	
	<fieldset id="field3">
		<legend> Manifestation du jour <?php echo '('.$today.')';?></legend>
		<p>
			<table>
			<tr>
				<th>numéro</th>
				<th>date</th>
				<th>Nom</th>
				<!--<th>Voir/modifier</th>-->
			</tr>
			<?php while($rep = mysql_fetch_array($resultat1)){ ?>
			<tr>
				<td><?php echo $rep['manif_ID'];?></td>
				<td><?php echo $rep['manif_debut'];?></td>
				<td><?php echo Security::db2str($rep['manif_nom']);?></td>
				<!--<td><a href="manif_new.php?manifID=<?php echo $rep[manif_ID];?>">voir/modifier</a></td>-->
			</tr>
			<?php } ?>
		</table>
		</p>
	</fieldset>
	
</form>
</body>
</html>