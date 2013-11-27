<?php
/**
*	apa_liste_victimes.php
*/
session_start();
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."date.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="fr" />
  <title>Liste des victimes</title>
  <LINK REL="stylesheet" HREF="apa.css" TYPE ="text/css">
  <style type="text/css" media="screen">@import url(../sig/css/normal.css);</style>
   <!--[if IE]><style type="text/css" media="screen">@import url(../sig/css/ie.css);</style><![endif]-->
   <!--[if lte IE 6]><style type="text/css" media="screen">@import url(../sig/css/ie6.css);</style><![endif]-->
</head>

<body>
	<div id="en-tete">
 		<ul>
  			<li><a href="apa_nouvelle_victime.php"><span>Nouveau</span></a></li>
  			<li id="actif"><a href="apa_liste_victimes.php"><span>Liste</span></a></li>
  			<li><a href=""><span></span></a></li>
  			<li><a href=""><span></span></a></li>
 		</ul>
 	</div>
<?php

$tri=$_GET['tri'];//	

$requete="SELECT *  
 	FROM victime,gravite,pays
 	WHERE gravite = gravite_ID
 	AND victime.org_createur_ID = '$_SESSION[organisation]'
 	AND victime.pays_ID = pays.pays_ID 
	";

	$requete .= " AND evenement_ID = '$_SESSION[evenement]' ";// uniuement évènement courant

	switch($tri)
		{
			case 'id':$requete.="ORDER BY victime_ID";break;
			case 'nom':$requete.="ORDER BY nom";break;
			case 'prenom':$requete.="ORDER BY prenom";break;
			case 'sexe':$requete.="ORDER BY sexe";break;
			case 'age':$requete.="ORDER BY age2,age1";break;
			case 'gravite':$requete.="ORDER BY gravite";break;
			case 'position':$requete.="ORDER BY localisation_ID";break;
			case 'service':$requete.="ORDER BY service_ID";break;
			case 'hop':$requete.="ORDER BY Hop_ID";break;
			case 'pays':$requete.="ORDER BY Hop_ID";break;
			case 'nationalite':$requete.="ORDER BY pays_nom";break;
			default:$requete.="ORDER BY victime_ID";
		}
$resultat = ExecRequete($requete,$connexion);
//print($requete);
?>
<div id="divTable">
<table id="table">
	<tr class="table-entete">
		<td>Identifiant</td>
		<td>Nom</td>
		<td>Prenom</td>
		<td>Age</td>
		<td>&nbsp;</td>
	</tr>
<?php
	while($rep=mysql_fetch_array($resultat))
	{
		?>
		<tr>
			<td><?php echo $rep[no_ordre] ?></td>
			<td><?php echo $rep[nom] ?></td>
			<td><?php echo $rep[prenom] ?></td>
			<td><?php echo $rep[age1] ?></td>
			<td><a href="apa_fiche_victime.php?no_victime=<?php echo $rep[no_ordre]?>">voir</a></td>
		</tr>
		<?php
	}
	?>
</table>
</div>

</body>
<?php
?>
</html>
