<?php
/**
* enregistrer_tache.php
* @author JCB
* @date
* @version $Id$
*/
session_start();
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$erreur = 0;

$no_dossier = $_REQUEST['noDossier'];
$priorite = $_REQUEST['priorite'];
$statut = 0; // 0 à faire, 1 fait
$vl = $_REQUEST['vl'];
$ar = $_REQUEST['ar'];
$d67 = $_REQUEST['d67'];
$renfort = $_REQUEST['renf'];
$vsav = $_REQUEST['vsav'];
$vlinf = $_REQUEST['vlinf'];
$galien = $_REQUEST['galien'];
$fs = $_REQUEST['fs'];
$assu = $_REQUEST['assu'];
$med = $_REQUEST['med'];
$pol = $_REQUEST['pol'];
$vsp = $_REQUEST['vsp'];
$reg = $_REQUEST['reg'];
$bilan = $_REQUEST['bilan'];
$adm = $_REQUEST['adm'];
$complet = $_REQUEST['comp'];
$close = $_REQUEST['close'];
$transfert = $_REQUEST['transfert'];
$tacheID = $_REQUEST['tacheID'];

if($no_dossier)
{
	if(!$tacheID)
	{
		$today = date("Y-m-d H:i:s"); 
		$requete = "INSERT INTO taches_crra VALUES('',
							'$no_dossier',
							'$priorite',
							'$statut',
							'$vl',
							'$ar',
							'$d67',
							'$renfort',
							'$vsav',
							'$vlinf',
							'$galien',
							'$fs ',
							'$assu',
							'$med',
							'$pol',
							'$vsp',
							'$reg',
							'$bilan',
							'$adm',
							'$complet',
							'$close',
							'$transfert',
							'$today',
							'',
							'$_SESSION[member_id]',
							''
							)";
	}
	else // c'est une mise à jour
	{
		$requete = "UPDATE taches_crra SET
						no_dossier = '$no_dossier',
						priorite = '$priorite',
						statut = '$statut',
						vl = '$vl',
						ar = '$ar',
						d67 = '$d67',
						renfort = '$renfort',
						vsav = '$vsav',
						vlinf = '$vlinf',
						galien ='$galien',
						fs = '$fs ',
						assu = '$assu',
						med = '$med',
						pol = '$pol',
						vsp = '$vsp',
						reg = '$reg',
						bilan = '$bilan',
						adm = '$adm',
						complet = '$complet',
						close = '$close',
						transfert = '$transfert'
						WHERE tache_ID = '$tacheID'";
	}
	//print($requete);
	$resultat = ExecRequete($requete,$connexion);
}

header("Location:lire_tache.php?erreur=$erreur");
?>