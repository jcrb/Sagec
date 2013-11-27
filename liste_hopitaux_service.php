<?php
// liste_hopitaux_service.php
/**
 * Documents the class following
 * @package Sagec
 */
require 'utilitairesHTML.php';
require("pma_connect.php");
require("pma_connexion.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

/**
/* Liste des hôpitaux d'Alsace
*/
function hopitaux_services($connexion)
{
	$requete = "SELECT hopital.Hop_nom, hopital.Hop_ID, service_nom,service.service_ID,lits.Hop_ID,lits_ID,Hop_finess,Type_ID
				FROM hopital,service,lits,adresse,ville
				WHERE service.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID IN ('67','68')
				AND service.service_ID = lits.service_ID
				ORDER BY Hop_nom,service_ID
				";
	$resultat = ExecRequete($requete,$connexion);
	print("<table>");
	print("<tr>");
		print("<td>Hop_Nom</td>");
		print("<td>Finessss</td>");
		print("<td>Hop_ID</td>");
		print("<td>service_nom</td>");
		print("<td>service_ID</td>");
		print("<td>service_type</td>");
		print("<td>Hop_ID</td>");
	print("</tr>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<tr>");
		print("<td>".$rub['Hop_nom']."</td>");
		print("<td>".$rub['Hop_finess']."</td>");
		print("<td>".$rub[1]."</td>");
		print("<td>".$rub['service_nom']."</td>");
		print("<td>".$rub['service_ID']."</td>");
		print("<td>".$rub['Type_ID']."</td>");
		print("<td>".$rub[4]."</td>");
		print("</tr>");
		
		if($rub[1] != $rub[4])
		{
			$requete = "UPDATE lits SET Hop_ID = '$rub[1]' WHERE lits_ID = '$rub[lits_ID]'";
			//$resultat2 = ExecRequete($requete,$connexion);
		}
	}
	print("</table>");
}

hopitaux_services($connexion);
?>