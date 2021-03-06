<?php
/**
*	ror_hopitaux.php
*/
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");

$requete = "SELECT Hop_nom,Hop_ID,departement_nom,ville_nom,total_lits,valeur,niveau_planBlanc
				FROM hopital,adresse,ville,departement,contact
				WHERE adresse_Id = adresse.ad_ID
				AND hopital.niveau_planBlanc > '0'
				AND adresse.ville_ID = ville.ville_ID
				AND ville.region_ID = '42'
				AND ville.departement_ID = departement.departement_ID
				AND contact.type_contact_ID = '1'
				AND nature_contact_ID = '5'
				AND contact_nom  LIKE CONVERT( _utf8 '%standard%' USING latin1 )
				AND identifiant_contact = hopital.Hop_ID
				ORDER BY departement_nom,ville.ville_ID,niveau_planBlanc
				";

$resultat = ExecRequete($requete,$connexion);
//print($requete);
print("<p>Tableau R�gional des Etablissements</p>");
print("<table border=\"1\" cellspacing=\"0\">");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td><a href=\"../hopital.php?ID_hopital=$rub[Hop_ID]\">$rub[Hop_ID]</a></td>");
		print("<td>$rub[departement_nom]</td>");
		print("<td>$rub[ville_nom]</td>");
		print("<td>$rub[Hop_nom]</td>");
		print("<td align=\"right\">$rub[niveau_planBlanc]</td>");
		print("<td align=\"right\">$rub[valeur]</td>");
		print("<td align=\"right\">$rub[total_lits]</td>");
	print("</tr>");
}
print("</table>");
?>