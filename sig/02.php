<?php
/**
*	02.html
*/
$backPathToRoot = "../"; 
include($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."dbConnection.php");
include_once("way_utilitaires.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="fr" />
  <title>Créer un menu à onglets avec CSS</title>
  <style type="text/css" media="screen">@import url(css/normal.css);</style>
   <!--[if IE]><style type="text/css" media="screen">@import url(css/ie.css);</style><![endif]-->
   <!--[if lte IE 6]><style type="text/css" media="screen">@import url(css/ie6.css);</style><![endif]-->
</head>

<body>
	<div id="en-tete">
 		<ul>
  			<li><a href="way_saisie.php"><span>Nouveau</span></a></li>
  			<li id="actif"><a href="02.php"><span>Liste</span></a></li>
  			<li><a href="03.php"><span>Outils</span></a></li>
  			<li><a href="04.php"><span>En savoir plus</span></a></li>
 		</ul>
 	</div>
 	
 	<div id="liste">
 		<table>
 			<th>
 				<td>ID</td>
 				<td>nom</td>
 				<td>type</td>
 				<td>ferme</td>
 				<td>trait</td>
 				<td>fond</td>
 				<td>transparence</td>
 			</th>
 		<?php
 			$requete = "SELECT * FROM way ORDER BY way_nom";
 			$resultat = ExecRequete($requete,$connexion);
 			while($rep = mysql_fetch_array($resultat))
 			{
 				?>
 				<tr>
 					<td><?php print($rep['way_ID']);?></td>
 					<td><?php print($rep['way_nom']);?></td>
 					<td><?php print($rep['way_type']);?></td>
 					<td><?php print($rep['way_ferme']);?></td>
 					<td><?php print($rep['way_trait']);?></td>
 					<td><?php print($rep['way_fond']);?></td>
 					<td><?php print($rep['way_transparence']);?></td>
 					<td><a href="way_saisie.php?wayID=<?php echo($rep['way_ID']);?>"> modifier </a></td>
 				</tr>
 				<?php
 			}
 		?>
 		</table>
 	</div>
</body>

</html>