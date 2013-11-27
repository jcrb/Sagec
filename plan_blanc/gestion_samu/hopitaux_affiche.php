<?php
/**
*	hopitaux_affiche.php
*	affiche la liste des hôpitaux dont on veut le nombre de lits par spécialité
*	une case à cocher permet de sélectionner les hôpitaux qui apparaitront
*	dans le formulaire PARM
*/
session_start();
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
$visible = array();
$listeID = 4;//NE PAS MODIFIER

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>Hopital</title>
	<meta http-equiv="content-type" content="ontent="t; charset=ISO-8859-1" 8>
	<link href="formstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<form id="catalogue" action="hopitaux_visible_enregistre.php" method="post">
	<p>Cochez les cases correspondants aux hôpitaux que l'on souhaite interroger</p>
<?php

// on récupère la liste des hôpitaux actifs
$requete = "SELECT Hop_ID from hopital_visible WHERE org_ID = '$_SESSION[organisation]' AND liste_ID = '$listeID'";
$resultat = ExecRequete($requete,$connexion);
while($rep=mysql_fetch_array($resultat))
{
	$hopVisible[] = $rep[Hop_ID];
}

$requete = "SELECT Hop_nom, Hop_ID from hopital ORDER BY Hop_nom";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
while($rep = mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td bgcolor=\"#FFFF66\">".$rep[Hop_ID]."</td>");
		print("<td bgcolor=\"#FFFF99\" id=\"inverse\"><label for=\"$rep[Hop_ID]\">".Security::db2str($rep[Hop_nom])."</label></td>");
		//print("<td bgcolor=\"#FFFFCC\">".$rep[pb_spe_short]."</td>");
		
		print("<td  bgcolor=\"#CCFF99\"><input type=\"checkbox\" name =\"visible[]\" value=\"$rep[Hop_ID]\" id=\"$rep[Hop_ID]\" ");
		if (in_array($rep[Hop_ID], $hopVisible)) echo 'checked';
		print("></td>");
	print("</tr>");
}
print("</table>");
?>

<p>
	<div>
		<input type="submit" name="ok" value ="valider">
	</div>
</p>