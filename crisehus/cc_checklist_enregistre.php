<?php
/**
*	cc_checklist_enregistre.php
*	enregistre une tache faite
* 	une tache faite ne peut �tre invalid�e dans cette version
*	TODO: mettre un message dans la main courante. Un champ 'message_ID' a �t� cr�� dans tache pour lier la tache et le message
*	PROCEDURE OBSOLETE REMPLACEE PAR cc_update.php
*/
session_start();
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");

	$date = uDateTime2MySql(time()); print($date."<br>");

// on r�cup�re le tableau des cases coch�es 
$fait = $_REQUEST['fait'];
print_r($fait);

$requete = "SELECT tache_ID FROM tache_DG WHERE tache_faite = 'o'";
$resultat = ExecRequete($requete,$connexion);
while($rep=mysql_fetch_array($resultat))
{
	$coche[]=$rep[tache_ID];
}
// case venant d'etre coch�e
if(count($coche)>0){
	$result = array_diff($fait,$coche);
} else $result = $fait;
print_r($result);

// case venant d'être décoché
$decoche = array_diff($coche,$fait);
print_r($decoche);

if($result)
{ 
	// on le lin�arise pour le rendre compatible avec la m�thode IN de mysql 
	$comma_separated = implode("','", $result);
	// on met � o les enregistrements dont l'ID est dans le tableau lin�aris�
	$requete = "UPDATE tache_DG SET tache_faite='o',tache_heure='$date' WHERE tache_ID IN('$comma_separated')";
	$resultat = ExecRequete($requete,$connexion);
	// mise � jour de la main courante
	$requete = "SELECT tache_message,tache_ID FROM tache_DG WHERE tache_ID IN('$comma_separated')";
	$resultat = ExecRequete($requete,$connexion);
	while($rep=mysql_fetch_array($resultat))
	{
								
		$requete = "INSERT INTO livrebord_service
	 		VALUES('','$_SESSION[organisation]','$auteur','$date','$rep[tache_message]','2','o','')"; 
								
		$resultat = ExecRequete($requete,$connexion);
		$messageID = mysql_insert_id();
		$requete = "UPDATE tache_DG SET message_ID = $messageID WHERE tache_ID = $rep[tache_ID]";
		ExecRequete($requete,$connexion);
	}
	mysql_close();
}

if($decoche)
{
	// on le linéarise pour le rendre compatible avec la méthode IN de mysql 
	$comma_separated = implode("','", $decoche);
	// on met à o les enregistrements dont l'ID est dans le tableau linéarisé
	$requete = "UPDATE tache_DG SET tache_faite='n',tache_heure='$date' WHERE tache_ID IN('$comma_separated')";
	$resultat = ExecRequete($requete,$connexion);
	// mise à jour de la main courante
	$requete = "SELECT tache_faite FROM tacheDG WHERE tache_ID IN('$comma_separated')";
	$resultat = ExecRequete($requete,$connexion);
	while($rep=mysql_fetch_array($resultat))
	{
		/* si un message existe, il est masqué mais pas supprimé du LB */
		if($rep['tache_faite'])
		{
			$requete = "UPDATE livrebord_service SET LBS_visible = 'n' WHERE LBS_ID = $rep[tache_faite] AND LBS_groupe='2'";
			ExecRequete($requete,$connexion);
		}
	}
	mysql_close();
}
//header("Location:cc_checklist.php");

//exit;
?>
