<?php
/**
*	services_selection.php
*	affiche la liste des hôpitaux dont on veut le nombre de lits par spécialité
*	une case à cocher permet de sélectionner les hôpitaux qui apparaitront
*	dans le formulaire PARM
*/
session_start();
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
$visible = array();
$listeID = 4;//NE PAS MODIFIER
$hopID = $_REQUEST[hopID];
$serviceVisible = array();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
	<title>Hopital</title>
	<meta http-equiv="content-type" content="ontent="t; charset=ISO-8859-1" 8>
	<link href="formstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<form id="catalogue" action="services_visible_enregistre.php" method="post">
	<p>Cochez les cases correspondants aux services que l'on souhaite interroger</p>
	<input type="hidden" name="hopID" value="<?php echo $hopID; ?>" >
<?php

// on récupère la liste des hôpitaux actifs
$requete = "SELECT service_ID from service_visible WHERE org_ID = '$_SESSION[organisation]' AND liste_ID = '$listeID' AND Hop_ID = '$hopID'";
$resultat = ExecRequete($requete,$connexion);
while($rep=mysql_fetch_array($resultat))
{
	$serviceVisible[] = $rep[service_ID];
}

$requete = "SELECT service_nom, service_ID from service WHERE Hop_ID = '$hopID' ORDER BY service_nom";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
while($rep = mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td bgcolor=\"#FFFF66\">".$rep[service_ID]."</td>");
		print("<td bgcolor=\"#FFFF99\">".$rep[service_nom]."</td>");
		//print("<td bgcolor=\"#FFFFCC\">".$rep[pb_spe_short]."</td>");
		
		print("<td  bgcolor=\"#CCFF99\"><input type=\"checkbox\" name =\"visible[]\" value=\"$rep[service_ID]\" ");
		if (in_array($rep[service_ID], $serviceVisible)) echo 'checked';
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