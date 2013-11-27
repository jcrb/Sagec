<?php

if (!isset($_SESSION)){
	session_start();
}
if (!isset($BackToRoot)){
	$BackToRoot = "../";
}

$backPathToRoot = "./../";

require_once($backPathToRoot."html.php");
require_once $backPathToRoot."autorisations/droits.php";
require_once $backPathToRoot."login/init_security.php";
//require_once $backPathToRoot."./utilitaires/db_connection.php";

// autorisation d'accès à la page
if (!isset($_SESSION["member_login"]) || strlen(trim($_SESSION["member_login"])) == 0){
	// aucun utilisateur n'est connecté
	header("Location: ".$backPathToRoot."logout.php");
	return;
}
	
if (!est_autorise("GESTION_AUTORISATION")){
	// l'utilisateur n'a pas le droit d'accéder à la page
	header("Location: ".$backPathToRoot."login2.php");
	return;
}

// création du menu
$menu = "<a href='".$backPathToRoot."autorisations/gestion_droits_utilisateurs.php'>Affectation autorisations</a> | <a href='".$backPathToRoot."utilisateurs_liste.php'>Menu principal</a> | <a href='".$backPathToRoot."logout.php' target='_parent'>Quitter</a>";

// mise à jour des autorisations
$req_libelle = null;
if (isset($_REQUEST["droit_libelle"])){
	$req_libelle = security::esc2Db($_REQUEST["droit_libelle"]);
}
$req_desc = null;
if (isset($_REQUEST["droit_desc"])){
	$req_desc = security::esc2Db($_REQUEST["droit_desc"]);
}
$req_id_supprimer = null;
if (isset($_REQUEST["supprimer"])){
	$req_id_supprimer = security::esc2Db($_REQUEST["supprimer"]);
}

$vConnexion = Dao_Pool::getConnexionPdo(); // lève un PDOException s'il y a un problème à la connexion

if (isset ($req_libelle) && strlen($req_libelle) >0 && isset ($req_desc) && strlen($req_desc)){
	// ajout d'un nouveau libellé
	$vPreparedStatment = $vConnexion->prepare("INSERT INTO droits (droit_str, description, supprime) VALUES (?, ?, 0)");
	$vPreparedStatment->execute(array($req_libelle, $req_desc));
}

if (isset ($req_id_supprimer) && strlen($req_id_supprimer)>0){
	// supprimer (desactiver) l'autorisation passé en ID
	$vPreparedStatment = $vConnexion->prepare("UPDATE droits SET supprime=1 WHERE id_droit=?");
	$vPreparedStatment->execute(array($req_id_supprimer));
}

// liste des autorisations
$vPreparedStatment = $vConnexion->prepare("SELECT id_droit, droit_str, description FROM droits WHERE supprime=0");
$vPreparedStatment->execute();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Autorisation - création des autorisations</title>
		<link rel="stylesheet" type="text/css" href="./../../css/entete_gris.css" />
		<link rel="stylesheet" type="text/css" href="./../../css/page_gris.css" />
	</head>
	
	<body>
		<!-- Entête SAGEC -->
		<?php entete_sagec_css("Gestion des autorisations", "center", $menu, $backPathToRoot); ?>
		<br/><br/>
		
		<form action="gestion_droits.php" method="post">
		
			<!-- Ajout d'une autorisation -->
			<center>
				<table class="table_formulaire" width="300px">
					<tr>
						<td colspan="2" class="table_titre">Ajouter une nouvelle autorisation</td>
					</tr>
					<tr>
						<td>Libellé: </td>
						<td><input type="text" name="droit_libelle"/></td>
					</tr>
					<tr>
						<td>Description: </td>
						<td><input type="text" name="droit_desc"/> </td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" value="Ajouter"/></td>
					</tr>
				</table>
			</center>
			<br/><br/>
			
			<!-- liste des autorisations -->
			<center>
				<table class="table_formulaire" width="900px">
					<tr>
						<td colspan="3" class="table_titre">&nbsp;Liste des droits</td>
					</tr>
					<tr>
						<td class="table_titre">&nbsp;Libellé</td>
						<td class="table_titre">&nbsp;Description</td>
						<td class="table_titre">&nbsp;</td>
					</tr>
<?php
$cpt =0;
while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
	$ligne = $cpt%2;
?>
					<tr>
						<td class="ligne_<?php echo $ligne ?>"><?php echo $vLigneObj->droit_str ?></td>
						<td class="ligne_<?php echo $ligne ?>"><?php echo $vLigneObj->description ?></td>
						<td class="ligne_<?php echo $ligne ?>"><a href="gestion_droits.php?supprimer=<?php echo $vLigneObj->id_droit ?>">Supprimer</a></td>
					</tr>
<?php
}
?>
				</table>
			</center>
		</form>
	</body>
</html>