<?php
if (!isset($_SESSION)){
	session_start();
}
if (!isset($backPathToRoot)){
	$BackToRoot = "./";
}
else
	$BackToRoot = $backPathToRoot;

require_once ($BackToRoot."classes/dao/pool.class.php");

// vérification si session existe

if (!isset($_SESSION["member_login"]) || strlen(trim($_SESSION["member_login"])) == 0)
	// aucun utilisateur n'est connecté
	return;

// charge les droits de l'utilisateur en session 
function charger_droits(){
	$vConnexion = Dao_Pool::getConnexionPdo(); // lève un PDOException s'il y a un problème à la connexion
	
	$vPreparedStatment = $vConnexion->prepare("SELECT D.droit_str 
								FROM utilisateurs U, utilisateurs_droits UD, droits D
								WHERE 
									login = ? 
									AND U.id_utilisateur = UD.id_utilisateur 
									AND UD.id_droits = D.id_droit
									AND supprime = 0");
	$vPreparedStatment->execute(array($_SESSION["member_login"]));
	
	$cpt =0;
	$tbl_droits_utilisateur = array();
	while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
		$tbl_droits_utilisateur[$cpt] = $vLigneObj->droit_str;
		$cpt ++;
	}
	
	$_SESSION["droits_utilisateur"] = $tbl_droits_utilisateur;
}

function est_autorise($doit_str){
	$found = false;
	if (!isset($_SESSION["droits_utilisateur"]))
		charger_droits();
	
	$found = false;	
	foreach	($_SESSION["droits_utilisateur"] as $droit)
	{
		//print($droit."<br>");
		$found = $found || ($droit == $doit_str);
	}
	
	return $found;
}
?>