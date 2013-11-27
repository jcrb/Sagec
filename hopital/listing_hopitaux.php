<?php
/**
 * listing_hopitaux.php
 *
 * @version $Id: lanxes.js 38 2008-02-27 21:07:19Z jcb $
 * @package Sagec
 * @author JCB
 * @copyright 2007
 */

$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");

$requete = "SELECT Hop_nom,ad_zone1,ad_zone2,zip, ad_longitude,ad_latitude,ville_nom,total_lits
				FROM hopital,adresse, ville
				WHERE hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.pays_ID = 9
				ORDER BY ville_nom
				";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td>$rub[Hop_nom]</td>");
		print("<td>$rub[ad_zone1]</td>");
		print("<td>$rub[ad_zone2]</td>");
		print("<td>$rub[zip]</td>");
		print("<td>$rub[ville_nom]</td>");
		print("<td>$rub[ad_longitude]</td>");
		print("<td>$rub[ad_latitude]</td>");
		print("<td>$rub[total_lits]</td>");
	print("</tr>");
}
print("</table>");
?>