<?php
/**
*	blocnote_menu2.php
*/
session_start();
$backPathToRoot = "../";
require($backPathToRoot."html.php");
$BackToRoot = "../";
require_once $backPathToRoot."autorisations/droits.php";

function entete($titre,$back="")
{
	global $backPathToRoot;//print($back);
	if($back=="")
		$back = $backPathToRoot."login2.php";
	$a = "<a href=\"blocnote_lire.php?back=$back\" target=\"\">Lire</a>";
	$b = "<a href=\"blocnote_afficher.php?back=$back\" target=\"\">Afficher</a>";
	$c = "<a href=\"\" target=\"_blank\">Imprimer</a>";
	$d = "<a href=\"bloc_note.php?back=$back\" target=\"\">Nouveau message</a>";
	$e = "<a href=\"$back\" target=\"\" >retour</a>";
	$f = "<a href=\"blocnote_enregistre.php?back=$back\" target=\"\">Sauvegarder</a>";
	
	if($_SESSION['autorisation']>9)
	{
		$f = "<a href=\"blocnote_imprime.php\" target=\"\">Sauvegarder</a>";
	}
	
	if(est_autorise("MCS_MODIFICATION"))
	{
		$menu= $a.' | '.$b.' | '.$c.' | '.$f.' | '.$d.' | '.$f.' | '.$e;
	}
	else if(est_autorise("MCS_ECRITURE"))
	{
		$menu= $a.' | '.$b.' | '.$c.' | '.$d.' | '.$e;
	}
	else if (est_autorise("MCS_LECTURE"))
	{
		$menu= $a.' | '.$b.' | '.$c.' | '.$e;
	}
	
	if($_SESSION['service']==111 || $_SESSION['service']==64)
	{
		
	}
	
	

	entete_sagec2($titre,"center",$menu,$backPathToRoot);
}