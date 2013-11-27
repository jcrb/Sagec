<?php
/**
  *	annuaire_affiche.php
  *
  *	affiche les champs visibles de la table annuaire
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>100) header("Location:../logout.php");
include($backPathToRoot."dbConnection.php");
require $backPathToRoot."autorisations/droits.php";

include_once("top.php");

$requete = "SELECT * FROM annuaire WHERE annu_visible = 'o' ORDER BY annu_titre1,annu_type";
$resultat = ExecRequete($requete,$connexion);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Annuaire actif</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body>
<form name="" action= "" method = "post">
<input type="hidden" name="back" value="<?php echo $back;?>">
<?php if(est_autorise("OLD_SAGEC")){?>	
	<a href="<?php echo $backPathToRoot.'./annuaire/annuaire_ajoute.php';?>">Ajouter</a>
<?php } ?>
<table border="1" width="50%">
<tr>
	<th>Titre 1</th>
	<th>Titre 2</th>
	<th>Type</th>
	<th>Valeur</th>
	<th>Modifier</th>
	<th>Supprimer</th>
</tr>
<?php while($rub=mysql_fetch_array($resultat)){ ?>
<tr>
	<td><?php echo $rub[annu_titre1];?></td>
	<td><?php echo $rub[annu_titre2];?></td>
	<!--
	<td><select name="annu">
		<option value = "1"><?php if($rub[annu_type]==1) echo 'Tel';?></option>
		<option value = "2"><?php if($rub[annu_type]==2) echo 'Fax';?></option>
		<option value = "3"><?php if($rub[annu_type]==3) echo 'Mel';?></option>
		</select></td>
	-->
	<td>
	<?php
		switch($rub[annu_type]){
			case 1: echo 'Tel';break;
			case 2: echo 'Fax';break;
			case 3: echo 'Mel';break;
		}
	?>
	</td>
	<td><?php echo $rub[annu_valeur];?></td>
	<td><a href="../annuaire/annuaire_ajoute.php?id=<?echo $rub[annu_ID].'&back=invite/annuaire_invite.php';?>">[M]</a></td>
	<td><a href="">[S]</a></td>
<?php } ?>
</tr>
</table>
</form>
</body>
</html>