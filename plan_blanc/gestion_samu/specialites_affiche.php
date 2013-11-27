<?php
/**
*	specialites_affiche.php
*	affiche la liste des spécialités dont on veut le nombre de lits
*	une case à cocher permet de sélectionner les spécialités qui apparaitront
*	dans le formulaire hospitalier
*	Permet également de modifier des intitulés mais pas de les supprimer
*/
session_start();
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
$visible = array();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>Hopital</title>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<link href="../formstyle.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" media="print, embossed" href="../impression.css">
</head>

<body>
	<form id="catalogue" action="specialite_visible_enregistre.php" method="post">
	<p>Cochez les cases correspondants aux spécialités que l'on souhaite voir apparaître dans les formulaires</p>
<?php
$requete = "SELECT * FROM planblanc_specialite ORDER BY pb_spe_ID";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
while($rep = mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td bgcolor=\"#FFFF66\">".$rep[pb_spe_ID]."</td>");
		print("<td bgcolor=\"#FFFF99\"><label for=\"$rep[pb_spe_short]\">".$rep[pb_spe_nom]."</label></td>");
		print("<td bgcolor=\"#FFFFCC\"><label for=\"$rep[pb_spe_short]\">".$rep[pb_spe_short]."</label></td>");
		/** Utilisation de label permet de sélectionner une case en cliquant sur le nom */
		print("<td  bgcolor=\"#CCFF99\"><input type=\"checkbox\" name =\"visible[]\" value=\"$rep[pb_spe_ID]\" id=\"$rep[pb_spe_short]\" ");
			if($rep[pb_spe_visible]) echo 'checked';print("></td>");
			
		//print("<td>".$rep[pb_spe_comment0]."</td>");
		//print("<td>".$rep[pb_spe_comment1]."</td>");
		//print("<td>".$rep[pb_spe_comment2]."</td>");
		print("<td bgcolor=\"\" class=\"noprint\"><a href=\"specialite_nouvelle.php?speID=$rep[pb_spe_ID]\">modifier</a></td>");
	print("</tr>");
}
print("</table>");
?>

<p>
	<div>
		<input type="submit" class="noprint" name="ok" value ="valider">
	</div>
</p>
<p>
	<div>
		<input type="submit" class="noprint" name="ok" value ="Ajouter">
	</div>
</p>

</body>
</html>