<?php
// teste_rea.php (carto2)
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

// sélectionne le nombre de places disponibles dans les services de réa adulte
// calcule le total par ville
// retourne le nom de la ville, ses coord.Lambert et le nb de lits disponibles dans la spécialité.

$liste = "(67,68)";
$requete = "SELECT service_nom,Hop_nom,SUM(lits_dispo),ville_nom,ville_LambertX, ville_LambertY
		FROM service,hopital,lits,ville,adresse
		WHERE service.type_ID = '2'
		AND service.hop_ID = hopital.Hop_ID
		AND lits.service_ID = service.service_ID
		AND ville.ville_ID = adresse.ville_ID
		AND adresse.ad_ID = hopital.adresse_ID
		AND ville.departement_ID IN $liste
		GROUP BY ville_nom
		";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
while($rub = mysql_fetch_array($resultat)){
	print("<tr>");
	print("<td>".$rub['ville_nom']."<td>");
	print("<td>".$rub['ville_LambertX']."<td>");
	print("<td>".$rub['ville_LambertY']."<td>");
	//print("<td>".$rub['Hop_nom']."<td>");
	//print("<td>".$rub['service_nom']."<td>");
	print("<td>".$rub[2]."<td>");
	print("</tr>");
}
print("</table>");
?>