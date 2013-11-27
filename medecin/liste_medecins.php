<?php
/**
*	liste_medecins.php
* 	liste des médecins présent dans la base
*/
session_start();
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");

$tri = $_REQUEST['tri'];
if(!isset($tri)) $tri = "med_ID";
$sens = "DESC";
$sens = $_REQUEST['sens'];
if($sens =="DESC") $sens="ASC"; else $sens="DESC";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<meta http-equiv="Content-Language" content="fr" />
  	<title>Liste des médecins</title>
  	<LINK REL="stylesheet" HREF="apa.css" TYPE ="text/css">
  	<style type="text/css" media="screen">@import url(../sig/css/normal.css);</style>
</head>
<body>
<form name="" method="post" action="">
<?php
	$requete = "SELECT mg67.*, ville_nom 
					FROM mg67, ville
					WHERE mg67.ville_ID = ville.ville_ID  
					ORDER BY ".$tri." ".$sens;
	$resultat = ExecRequete($requete,$connexion);
	print($requete."<br>");
	
?>
<div id="divTable">
<table id="table">
	<tr class="table-entete">
		<td>Identifiant</td>
		<td><a href="liste_medecins.php?tri=med_nom&sens=$sens">Nom</a></td>
		<td>Adresse</td>
		<td><a href="liste_medecins.php?tri=ville_nom&sens=$sens"">Ville</a></td>
		<td>&nbsp;</td>
	</tr>
<?php
	while($rep=mysql_fetch_array($resultat))
	{
		?>
		<tr>
			<td><?php echo $rep[med_ID] ?></td>
			<td><?php echo $rep[med_nom] ?></td>
			<td><?php echo $rep[med_adresse] ?></td>
			<td><?php echo $rep[ville_nom] ?></td>
			<td><a href="med_maj.php?idMed=<?php echo $rep[med_ID]?>">voir</a></td>
		</tr>
		<?php
	}
	?>
</table>
</div>
</form>
</body>
</html>