<?php
/**
* maj_tache.php
* @author JCB
* @date    nov 2007
* @version $Id$
*/
session_start();
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$erreur = 0;
$action = $_REQUEST['ok'];
$tache = $_REQUEST['order'];

//print("action: ".$action."<br>");
//print("tache: ".$tache."<br>");
if($action == 'Modifier')
{
	$back="creer_tache.php?tacheID=".$tache ;
	header("Location:$back");
}
else
{
	if($action == 'Supprimer')
	{
		$requete = "DELETE FROM taches_crra WHERE tache_ID = '$tache'";
		$resultat = ExecRequete($requete,$connexion);
	}

	else if($action == 'Tache faite')
	{
		$now = date("Y-m-d H:i:s");
		$requete = "UPDATE taches_crra SET statut = '1',last_time = '$now',effecteur_ID='$_SESSION[member_id]' WHERE tache_ID = '$tache'";
		$resultat = ExecRequete($requete,$connexion);
	}

	header("Location:lire_tache.php");
}
?>