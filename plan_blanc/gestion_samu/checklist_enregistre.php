<?php
/**
*	checklist_enregistre.php
*	enregistre une tache faite
* 	une tache faite ne peut Ãªtre invalidÃ©e dans cette version
*	TODO: mettre un message dans la main courante. Un champ 'message_ID' a Ã©tÃ© crÃ©Ã© dans tache pour lier la tache et le message
*/
session_start();
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");

	$date = uDateTime2MySql(time());

// on récupère le tableau des cases cochées 
$fait = $_REQUEST['fait'];
//print_r($fait);

$requete = "SELECT tache_ID FROM tache WHERE tache_faite = 'o'";
$resultat = ExecRequete($requete,$connexion);
while($rep=mysql_fetch_array($resultat))
{
	$coche[]=$rep[tache_ID];
}
// case venant d'etre cochée
if(count($coche)>0){
	$result = array_diff($fait,$coche);
} else $result = $fait;
//print_r($result);

// case venant d'Ãªtre dÃ©cochÃ©
$decoche = array_diff($coche,$fait);
//print_r($decoche);

if($result)
{ 
	// on le linéarise pour le rendre compatible avec la méthode IN de mysql 
	$comma_separated = implode("','", $result);
	// on met à o les enregistrements dont l'ID est dans le tableau linéarisé
	$requete = "UPDATE tache SET tache_faite='o',tache_heure='$date' WHERE tache_ID IN('$comma_separated')";
	$resultat = ExecRequete($requete,$connexion);
	// mise à  jour de la main courante
	$requete = "SELECT tache_message,tache_ID FROM tache WHERE tache_ID IN('$comma_separated')";
	$resultat = ExecRequete($requete,$connexion);
	while($rep=mysql_fetch_array($resultat))
	{
		$requete = "INSERT INTO `pma`.`livrebord` (`LB_ID` ,`org_ID` ,`LB_Expediteur` ,`LB_Date` ,`LB_Message` ,`LB_visible` ,`localisation_ID` ,`iqr`)
								VALUES (NULL , '$_SESSION[organisme]', '$_SESSION[member_id]', '$date', '$rep[tache_message]', 'o', '0', '1')";
								
		$resultat = ExecRequete($requete,$connexion);
		$messageID = mysql_insert_id();
		$requete = "UPDATE tache SET message_ID = $messageID WHERE tache_ID = $rep[tache_ID]";
		ExecRequete($requete,$connexion);
	}
	mysql_close();
}

if($decoche)
{
	// on le linÃ©arise pour le rendre compatible avec la mÃ©thode IN de mysql 
	$comma_separated = implode("','", $decoche);
	// on met Ã  o les enregistrements dont l'ID est dans le tableau linÃ©arisÃ©
	$requete = "UPDATE tache SET tache_faite='n',tache_heure='$date' WHERE tache_ID IN('$comma_separated')";
	$resultat = ExecRequete($requete,$connexion);
	// mise Ã  jour de la main courante
	$requete = "SELECT tache_faite FROM tache WHERE tache_ID IN('$comma_separated')";
	$resultat = ExecRequete($requete,$connexion);
	while($rep=mysql_fetch_array($resultat))
	{
		/* si un message existe, il est masquÃ© mais pas supprimÃ© du LB */
		if($rep['tache_faite'])
		{
			$requete = "UPDATE livrebord SET LB_visible = 'n' WHERE LB_ID = $rep[tache_faite]";
			ExecRequete($requete,$connexion);
		}
	}
	mysql_close();
}
//header("Location:checklist.php");
header("Location:../../crise/CheckList/Check_list.php");
exit;
?>
