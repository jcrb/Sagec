<?php
// liste_hopitaux.php
/**
 * Documents the class following
 * @package Sagec
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require '../utilitairesHTML.php';
require("../pma_connect.php");
require("../pma_connexion.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

/**
/* Liste des hôpitaux d'Alsace
*/
function hopitaux_alsace($connexion)
{
	/**
	/* AFFICHE LA LISTE DES HÔPITAUX D'ALSACE ET POUR CHACUN LE TOTAL DE LITS DISPONIBLES
	*/	
	$requete = "SELECT Hop_nom,hop_finess,COUNT(lits_dispo)
				FROM hopital,adresse,ville,lits
				WHERE lits.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID IN ('67','68')
				GROUP BY Hop_nom
				ORDER BY Hop_nom
				";
	$resultat = ExecRequete($requete,$connexion);
	$somme=0;
	print("<table>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<tr>");
		print("<td>".$rub['Hop_nom']."</td>");
		print("<td>".$rub[2]."</td>");//'lits_dispo'
		print("</tr>");
		$somme += $rub[2];
	}
	print("<tr>");
		print("<td>Total</td>");
		print("<td>".$somme."</td>");
	print("</tr>");
	print("</table>");
}

function services_alsace($connexion,$type_service)
{
	/**
	/* AFFICHE LA LISTE DES HÔPITAUX D'ALSACE ET POUR CHACUN LE TOTAL DE LITS DISPONIBLES par service
	*/	

	/** Liste les hôpitaux et groupe le total par service */
	/*$requete = "SELECT Hop_nom,hop_finess,COUNT(lits_dispo),service_nom
				FROM hopital,adresse,ville,lits,service
				WHERE lits.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID IN ('67','68')
				AND lits.service_ID = service.service_ID
				AND service.Type_ID IN ($type_service) 
				GROUP BY Hop_nom
				ORDER BY Hop_nom
				";*/
	/** liste de façon détaillée les services et les lits */
	$requete = "SELECT Hop_nom,hop_finess,lits_dispo,service_nom
				FROM hopital,adresse,ville,lits,service
				WHERE lits.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID IN ('67','68')
				AND lits.service_ID = service.service_ID
				AND service.Type_ID IN ($type_service) 
				ORDER BY Hop_nom
				";
	$resultat = ExecRequete($requete,$connexion);
	$somme=0;
	print("<table>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<tr>");
		print("<td>".$rub['Hop_nom']."</td>");
		print("<td>".$rub['service_nom']."</td>");
		print("<td>".$rub[2]."</td>");//'lits_dispo'
		print("</tr>");
		$somme += $rub[2];
	}
	print("<tr>");
		print("<td>Total</td>");
		print("<td>".$somme."</td>");
	print("</tr>");
	print("</table>");
}

function litsDispoParSpecialite_service($connexion,$date1,$date2,$type_service)
{
	$requete = "SELECT date,lits_journal.service_ID,lits_dispo,service_nom,Hop_nom
				FROM lits_journal, service,hopital,ville,adresse
				WHERE lits_journal.service_ID = service.service_ID
				AND date BETWEEN '$date1' and '$date2'
				AND service.Type_ID IN ($type_service)
				AND service.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID IN ('67','68')
				ORDER BY Hop_nom,service_nom, date
				";
	$resultat = ExecRequete($requete,$connexion);
	print("<table border=\"1\">");
		print("<tr>");
			print("<td>hopital</td>");
			print("<td>service</td>");
			for($i = $date1;$i <= $date2; $i += 24*3600)
			{
				print("<td>".date("d/m/Y",$i)."</td>");
			}
		print("</tr>");
	$rub=mysql_fetch_array($resultat);
	print("<tr>");
		print("<td>".$rub['Hop_nom']."</td>");
		print("<td>".$rub['service_nom']."</td>");
		print("<td>".$rub['lits_dispo']."</td>");
		$service_courant = $rub['service_nom'];
		$date_courante;
		$tot=array();
		$j = 0;
		$tot[$j] += $rub['lits_dispo'];
	while($rub=mysql_fetch_array($resultat))
	{
		if($service_courant == $rub['service_nom'])
		{
			print("<td>".$rub['lits_dispo']."</td>");
			$j++;
			$tot[$j] += $rub['lits_dispo'];
		}
		else
		{
			print("</tr>");
			print("<tr>");
				print("<td>".$rub['Hop_nom']."</td>");
				print("<td>".$rub['service_nom']."</td>");
				print("<td>".$rub['lits_dispo']."</td>");
				$service_courant = $rub['service_nom'];
				$j = 0;
				$tot[$j] += $rub['lits_dispo'];
		}
	}
	print("</tr>");
	// ligne des totaux
	print("<tr>");
		print("<td>TOTAL</td>");
		print("<td>&nbsp;</td>");
		$max = sizeof($tot);
		for($i = 0;$i < $max; $i++)
		{
			print("<td>".$tot[$i]."</td>");
		}
	print("</tr>");
	print("<table>");
}

/**
* retourne le nombre de lits disponibles dans une spécialité, entre 2 dates
*/
function litsDispoParSpecialite_hopital($connexion,$date1,$date2,$type_service)
{
	$requete = "SELECT date,lits_journal.service_ID,lits_dispo,service_nom,Hop_nom
				FROM lits_journal, service,hopital,ville,adresse
				WHERE lits_journal.service_ID = service.service_ID
				AND date BETWEEN '$date1' and '$date2'
				AND service.Type_ID IN ($type_service)
				AND service.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID IN ('67','68')
				ORDER BY Hop_nom,date,service_nom 
				";
	$resultat = ExecRequete($requete,$connexion);
	
	print("<table>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<tr>");
		print("<td>".date("d/m/Y",$rub['date'])."</td");
		print("<td>".$rub['Hop_nom']."</td");
		print("<td>".$rub['service_nom']."</td");
		print("<td>".$rub['lits_dispo']."</td");
		print("</tr>");
	}
	print("</table>");
	
	print("<table border=\"1\">");
		print("<tr>");
			print("<td>hopital</td>");
			//print("<td>service</td>");
			for($i = $date1;$i <= $date2; $i += 24*3600)
			{
				print("<td>".date("d/m/Y",$i)."</td>");
			}
		print("</tr>");

	$rub=mysql_fetch_array($resultat);
	print("<tr>");
		print("<td>".$rub['Hop_nom']."</td>");
		$hop_courant = $rub['Hop_nom'];
		$date_courante= date("d/m/Y",$rub['date']);
		$tot=array();
		$j = 0;
		$tot[$j] += $rub['lits_dispo'];
		$lits = $rub['lits_dispo'];

	while($rub=mysql_fetch_array($resultat))
	{
		if($hop_courant == $rub['Hop_nom'])
		{
			if($date_courante == date("d/m/Y",$rub['date']))
			{
				$lits += $rub['lits_dispo'];
			}
			else
			{
				print("<td>".$lits."</td>");
				$tot[$j] += $lits;
				$lits = $rub['lits_dispo'];
				$date_courante =date("d/m/Y",$rub['date']);
				$j++;
				
			}
		}
		else
		{
			print("<td>".$lits."</td>");
			$tot[$j] += $lits;
			print("</tr>");
			print("<tr>");
				print("<td>".$rub['Hop_nom']."</td>");
				$hop_courant = $rub['Hop_nom'];
				$lits = $rub['lits_dispo'];
				$j = 0;
		}
	}
	print("</tr>");
	// ligne des totaux

	print("<tr>");
		print("<td>TOTAL</td>");
		//print("<td>&nbsp;</td>");
		$max = sizeof($tot);
		for($i = 0;$i < $max; $i++)
		{
			print("<td>".$tot[$i]."</td>");
		}
	print("</tr>");

	print("<table>");
}

function teste_demande_arh($connexion)
{
	// pour le test, la journée est le 19 octobre 2005 et les 6 jours qui précèdent
	$date2 = strtotime("2005/10/19");
	$intervalle = 6; //en jours
	$date1 = $date2 - $intervalle*24*3600;

	// Activité pré-hospitalière
	print("<br>Activité des SAMU<br><br>");

	$requete = "SELECT DISTINCT date,veille_samu.service_ID,nb_affaires,nb_vsav,nb_apa,nb_primaires,nb_secondaires,Hop_finess
				FROM veille_samu,hopital,service
				WHERE veille_samu.service_ID = service.service_ID
				AND service.Hop_ID = hopital.Hop_ID
				AND date BETWEEN '$date1' and '$date2'
				ORDER BY Hop_finess,date
				";

	$resultat = ExecRequete($requete,$connexion);
	print("<table border=\"1\">");
		print("<tr>");
			print("<td>date</td>");
			print("<td>Finess</td>");
			print("<td>Service</td>");
			print("<td>Affaires</td>");
			print("<td>VSAV</td>");
			print("<td>APA</td>");
			print("<td>SMUR</td>");
		print("</tr>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<tr>");
			$date = date("Y/m/d",$rub['date']);
			print("<td>".$date."</td>");     // établissement
			print("<td>".$rub['Hop_finess']."</td>");
			print("<td>".$rub['service_ID']."</td>");
			print("<td>".$rub['nb_affaires']."</td>");
			print("<td>".$rub['nb_vsav']."</td>");
			print("<td>".$rub['nb_apa']."</td>");
			$smur = $rub['nb_primaires']+$rub['nb_secondaires'];
			print("<td>".$smur."</td>");
			print("<tr>");
	}
	print("</table>");

	// Activité des SAU
	print("<br>Activité des SAU<br><br>");

	$requete = "SELECT DISTINCT date,veille_sau.service_ID,inf_1_an,sup_75_an,entre1_75,hospitalise,uhcd,transfert,Hop_finess
				FROM veille_sau,hopital,service
				WHERE veille_sau.service_ID = service.service_ID
				AND service.Hop_ID = hopital.Hop_ID
				AND date BETWEEN '$date1' and '$date2'
				ORDER BY Hop_finess,date
				";
	$resultat = ExecRequete($requete,$connexion);
	print("<table border=\"1\">");
		print("<tr>");
			print("<td>date</td>");
			print("<td>Finess</td>");
			print("<td>Service</td>");
			print("<td>Passages</td>");
			print("<td><1an</td>");
			print("<td>>75 ans</td>");
			print("<td>hospitalisé</td>");
			print("<td>UHCD</td>");
			print("<td>Transférés</td>");
		print("</tr>");
	while($sau = mysql_fetch_array($resultat))
	{
		print("<tr>");
			$date = date("Y/m/d",$sau['date']);
			print("<td>".$date."</td>");     // établissement
			print("<td>".$sau['Hop_finess']."</td>");
			print("<td>".$sau['service_ID']."</td>");
			$passages = $sau['inf_1_an']+$sau['sup_75_an']+$sau['entre1_75'];
			print("<td>".$passages."</td>");
			print("<td>".$sau['inf_1_an']."</td>");
			print("<td>".$sau['sup_75_an']."</td>");
			print("<td>".$sau['hospitalise']."</td>");
			print("<td>".$sau['uhcd']."</td>");
			print("<td>".$sau['transfert']."</td>");
		print("<tr>");
	}
	print("</table>");

	print("<br>Disponibilité des lits de pédiatrie<br><br>");
	$pediatrie="3,9,17";
	services_alsace($connexion,$pediatrie);
	$rea = "2,4";
	$ssr = "15";
	$mco = "1,2,3,4,7,8,9,10,11,17,19";

	litsDispoParSpecialite_hopital($connexion,$date1,$date2,$pediatrie);
	//litsDispoParSpecialite($connexion,$date1,$date2,$rea);
	//litsDispoParSpecialite($connexion,$date1,$date2,$ssr);
	//litsDispoParSpecialite($connexion,$date1,$date2,$mco);
}
/*
hopitaux_alsace($connexion);
$rea = "2,4";
services_alsace($connexion,$rea);

*/
teste_demande_arh($connexion);
?>