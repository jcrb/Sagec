<?php
/**
 *		cc_update.php
 *		Valide une case cochée ou décochée
 *		Si la case est cochée, le message associé à la tache est mis dans la main courante
 *		Si la case est décochée, le message associé est masqué. Si la case est recochée, un
 *		nouvel enregistrement est créé dans livre de bord. Permet de conserver un historique des annulations
 */
session_start();
$backPathToRoot = "../";
require $backPathToRoot."dbConnection.php";
require($backPathToRoot."date.php");

$date = uDateTime2MySql(time());
$groupe = 3;

$id  = $_REQUEST['id'];
$check = $_REQUEST['check'];

echo 'ID = '.$id.' ';
echo 'Check = '.$check;


if($check==1){
	$requete = "UPDATE tache_cod SET tache_faite='o',tache_heure='$date' WHERE tache_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	// mise à  jour de la main courante
	$requete = "SELECT tache_message,tache_ID FROM tache_cod WHERE tache_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	$rep=mysql_fetch_array($resultat);
	$requete = "INSERT INTO livrebord_service
	 				VALUES('','$_SESSION[organisation]','$_SESSION[member_id]','$date','$rep[tache_message]','$groupe','o','')"; 				
	$resultat = ExecRequete($requete,$connexion);
	$messageID = mysql_insert_id();
	$requete = "UPDATE tache_cod SET message_ID = $messageID WHERE tache_ID = '$id'";
	ExecRequete($requete,$connexion);
	mysql_close();
}
else{
	$requete = "UPDATE tache_cod SET tache_faite='n',tache_heure='$date' WHERE tache_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	// mise à jour de la main courante
	$requete = "SELECT message_ID FROM tache_cod WHERE tache_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	$rep=mysql_fetch_array($resultat);
	/* si un message existe, il est masqué mais pas supprimé du LB */
	if($rep['message_ID'])
	{
		$requete = "UPDATE livrebord_service SET LBS_visible = 'n' WHERE LBS_ID = $rep[message_ID] AND LBS_groupe='$groupe'";
		ExecRequete($requete,$connexion);
	}
	mysql_close();
}


return "msg = 'ok'";
?>