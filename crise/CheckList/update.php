<?php
/**
  *		update.php
  *		enregistre une tache faite
  * 		une tache faite ne peut être invalidée dans cette version
  *		TODO: mettre un message dans la main courante. Un champ 'message_ID' a été créé dans tache pour lier la tache et le message
 */
session_start();
$backPathToRoot = "../../";
require $backPathToRoot."dbConnection.php";
require($backPathToRoot."date.php");
include($backPathToRoot."login/init_security.php");

$tache  = $_REQUEST['id'];
$check = $_REQUEST['check'];
$plan = $_REQUEST['plan'];
$date = uDateTime2MySql(time());

/*
echo 'ID = '.$id.' ';
echo 'Check = '.$check.' ';
echo 'plan = '.$plan;
*/
	$requete = "UPDATE tache_scenario SET validation = '$check' WHERE tache_ID = '$tache' AND scenario_ID = '$plan' ";
	$resultat = ExecRequete($requete,$connexion);
	
// mise à  jour de la main courante
if($check == 1)
{
	// la tache a été validée
	
	$requete = "SELECT tache_message,tache_ID FROM tache WHERE tache_ID = '$tache' ";
	$resultat = ExecRequete($requete,$connexion);
	$rep=mysql_fetch_array($resultat);
	// protection contre les apostrophes:
	$tache_message = Security::esc2Db($rep['tache_message']);
	$requete = "INSERT INTO `pma`.`livrebord` (`LB_ID` ,`org_ID` ,`LB_Expediteur` ,`LB_Date` ,`LB_Message` ,`LB_visible` ,`localisation_ID` ,`iqr`)
								VALUES (NULL , '$_SESSION[organisme]', '$_SESSION[member_id]', '$date', '$tache_message', 'o', '0', '1')";						
	$resultat = ExecRequete($requete,$connexion);
	$messageID = mysql_insert_id();
	// on mémorise la ligne de la main courante 
	$requete = "UPDATE tache_scenario SET message_ID = '$messageID' WHERE tache_ID = '$tache' AND scenario_ID = '$plan'";
	ExecRequete($requete,$connexion);
	// mémorise la date à laquelle la case a été cochée
	$requete = "UPDATE tache SET tache_heure = '$date' WHERE tache_ID = '$tache'";
	ExecRequete($requete,$connexion);
	// renvoie le message dans ajax
	echo $msg = $date;
}
else
{
	// une tache cochée est décochée => prévoir un message d'alerte
	// on récupère la ligne correspondante dans le livre de bord et on la neutralise avec un message d'annulation
	/* si un message existe, il est masquÃ© mais pas supprimÃ© du LB */
	$requete = "SELECT message_ID FROM tache_scenario WHERE tache_ID = '$tache' AND scenario_ID = '$plan'";
	$resultat = ExecRequete($requete,$connexion);
	$rep=mysql_fetch_array($resultat);
	if($rep['message_ID'])
	{
		$requete = "SELECT LB_Message FROM livrebord WHERE LB_ID = $rep[message_ID]";
		$resultat = ExecRequete($requete,$connexion);
		$rep2 = mysql_fetch_array($resultat);
		echo $msg = $rep2['LB_Message']."<br>"." === ANNULE PAR [".$_SESSION['member_id']."] le ".$date." ===";
		$msg = Security::esc2Db($msg);
		$requete = "UPDATE livrebord SET LB_visible = 'n',LB_Message = '$msg' WHERE LB_ID = '$rep[message_ID]'";
		echo $requete;
		ExecRequete($requete,$connexion);
		// efface la date à laquelle la case a été cochée
		$requete = "UPDATE tache SET tache_heure = '' WHERE tache_ID = '$tache'";
		ExecRequete($requete,$connexion);
	}
}

?>