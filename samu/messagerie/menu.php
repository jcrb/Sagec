<?php
/**
*	menu.php
*/
session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$langue = $_SESSION['langue'];
	$backPathToRoot = "../../";
	require_once($backPathToRoot."date.php");
	require_once $backPathToRoot."autorisations/droits.php";

	
	$jour = jour_de_la_semaine(time(),$langue).' '.jour_du_mois(time()).' '.mois_courant(time(),$langue).' '.date("Y",time());
	
	/** semaine paire */
	$semaine = semaine_courante(time());
		if($semaine % 2 == 0){
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Liste des messages</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
</head>

<div id="div1">
	<ul id="menu">
		<li id="intertitre">Menu principal</li>
		<li><a href="messages.php">@</a></li>
		<li><a href="aujourdui.php">Aujourd'hui</a></li>
		<?php if(est_autorise("MCS_ECRITURE")||est_autorise("MCS_MODIFICATION")){?>
			<li><a href="bloc_note.php">Nouveau</a></li>
			<?php } ?>
		<?php if(est_autorise("TOP_ECRITURE")||est_autorise("TOP_MODIFIER")){?>
			<li><a href="../xtop/xtop_main.php">TOP</a></li>
			<?php } ?>
		<li><a href="message_lire.php">Lire</a></li>
		<li><a href="archives_lire.php">Archives</a></li>
		<li><a href="mode_emploi.php">SAGEC Mode d'emploi</a></li>
		<li><a href="../samu_main.php">Quitter</a></li>
	</ul>
</div>

<div id="annonce">
	<p><u><?php echo $jour;?></u></p>
	<p>semaine: <?php echo semaine_courante(time());?></p>
	<p>   jour: <?php echo jour_de_annee(time());?></p>
	<p><u>astreinte DSM: </u><i><?php echo $dsm;?></i></p>
	<p><u>SOS mains: </u><i><?php echo $sos_main;?></i></p>
	<p><u>CNH:</u><i><?php echo $cnh;?></i></p>
	<p><u>IPM:</u><i><?php echo $ipm;?></i></p>
	<p><u>Réa:</u><i><?php echo $ipm;?></i></p>
</div>




