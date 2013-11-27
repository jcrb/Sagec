<?php
/**
  *	liste_biotox.php
  */

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "Biotox-Matériel";
$sousmenu = "";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require $backPathToRoot."autorisations/droits.php";

/**
	La jointure externe est nécessaire pour afficher toures les lignes, même elle où
	le lieu de stockage n'est pas renseigné. Elle se fait entre les tables dotation et stockage_batiment
*/
$requete = "SELECT dotation_ID,dotation.ville_ID,ville_nom,dotation_qte, materiel_nom,fournisseur_nom , acheteur_nom, date_achat,marque_nom,stockage_batiment_nom
			FROM ville, materiel,marque,fournisseur,acheteur,dotation LEFT OUTER JOIN stockage_batiment
				ON stockage_batiment_ID = dotation.stockage_ID
			WHERE ville.ville_ID = dotation.ville_ID
			AND materiel.materiel_ID = dotation.materiel_ID
			AND marque.marque_ID = dotation.marque_ID
			AND fournisseur.fournisseur_ID = dotation.fournisseur_ID
			AND acheteur.acheteur_ID = dotation.acheteur_ID
			ORDER BY ville_ID, dotation.materiel_ID
			";	
			
$requete = "SELECT dotation.*,ville_nom,materiel_nom,marque_nom,fournisseur_nom , acheteur_nom,stockage_batiment_nom
				FROM ville,materiel,marque,fournisseur,acheteur,dotation LEFT OUTER JOIN stockage_batiment
				ON stockage_batiment_ID = dotation.stockage_ID
				WHERE ville.ville_ID = dotation.ville_ID
				AND materiel.materiel_ID = dotation.materiel_ID
				AND marque.marque_ID = dotation.marque_ID
				AND fournisseur.fournisseur_ID = dotation.fournisseur_ID
				AND acheteur.acheteur_ID = dotation.acheteur_ID
				";	
$resultat = ExecRequete($requete,$connexion);		
$resultat = ExecRequete($requete,$connexion);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	
	<link rel="stylesheet" href="../js/css/jquery.dataTables.css" />
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>
	<script src="../js/startDataTables.js"></script>
</head>

<body onload="">

<form name="" action= "" method = "post">

<div id="div2">

	<?php if(est_autorise("BIOTOX_ECRIRE")){?>
		</p> <p><a href="dotation_biotox.php?id=0">NOUVELLE DOTATION</a></p>
	<?php } ?>
	
	<table id="table_hop" >  <!-- width="100%"  style="table-layout:fixed" -->
		<thead>
		<tr>
			<th>ville</th>
			<th>materiel</th>
			<th>localisation</th>
			<th>marque</th>
			<th>quantité</th>
			<th>fournisseur</th>
			<th>acheteur</th>
			<th>date</th>
			<?php if(est_autorise("BIOTOX_ECRIRE")){?>
				<th>modifier</th>
			<?php } ?>
		</tr>
		</thead>
		<tboby>
			<?php while($rub=mysql_Fetch_Array($resultat)){?>
			<tr>
				<td><? echo Security::db2str($rub['ville_nom']);?></td>
				<td><? echo Security::db2str($rub['materiel_nom']);?></td>
				<td><? echo Security::db2str($rub['stockage_batiment_nom']);?></td>
				<td><? echo Security::db2str($rub['marque_nom']);?></td>
				<td><? echo Security::db2str($rub['dotation_qte']);?></td>
				<td><? echo Security::db2str($rub['fournisseur_nom']);?></td>
				<td><? echo Security::db2str($rub['acheteur_nom']);?></td>
				<td><? echo Security::db2str($rub['date_achat']);?></td>
				<?php if(est_autorise("BIOTOX_ECRIRE")){?>
					<td><a href="dotation_biotox.php?dotation_id=<? echo $rub[dotation_ID];?>">modifier</td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tboby>
	</table>
</div>

<?php
?>

</form>
</body>
</html>
