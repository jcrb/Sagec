<?php
/**
  *	intervenant_liste.php
  */
  
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal="Secrétariat - Liste des personnels";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require_once($backPathToRoot."autorisations/droits.php");

// si $actif = 'o' alors on n'affiche que les personnels actifs 
$actif = $_REQUEST['actif'];

$requete = "SELECT Pers_ID,Pers_Nom, Pers_Prenom,rpps,perso_cat_nom 
				FROM personnel,perso_cat 
				WHERE personnel.perso_cat_ID = perso_cat.perso_cat_ID";
				
				if($actif == 'o')
					$requete .= " AND visible = 'o' ";
					
				$requete .=" ORDER BY Pers_Nom";
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
	<script  type="text/javascript" src="../ajax/jquery-courant.js"></script>
	<script>
		$(document).ready(function(){
			$('tr:odd').addClass('alt');
		});
	</script>
</head>

<body >

<form name="" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Liste des intervenants</legend>
		<table>
		<?php $n=0; while($rep=mysql_fetch_array($resultat)){ $n++ ?>
			<tr>
				<td><i><?php echo $n;?></i></td>
				<td><a href="intervenant_saisie.php?personnelID=<?php echo $rep['Pers_ID']; ?>"><?php echo $rep['Pers_ID'];?></a></td>
				<td><?php echo $rep['Pers_Nom'];?></td>
				<td><?php echo $rep['Pers_Prenom'];?></td>
				<td><?php echo $rep['perso_cat_nom'];?></td>
				<td><a href="intervenant_affectation.php?id=<?php echo $rep['Pers_ID'];?>&nom=<?php echo $rep['Pers_Nom'];?>&prenom=<?php echo $rep['Pers_Prenom'];?>">affecter</td>
				<?php if(est_autorise('DELETE_PERSONNEL'))
				{
					?>
					<td><a href="intervenant_supprime.php?intervenantID=<?php echo $rep['Pers_ID'];?>" onclick="return confirm('Etes vous sûre de vouloir supprimer ce vecteur ?');" >Supprimer</a></td>
					<?php
				}
				?>
			</tr>
			<?php } ?>
		</table>
	</fieldset>
</div>

<?php
?>

</form>
</body>