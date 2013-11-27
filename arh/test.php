<?php
$backPathToRoot = "../";
require_once($backPathToRoot."dbConnection.php");
require_once($backPathToRoot."date.php");

$type_service = 7;	//médecine

function lits_medecine($type_service,$connexion)
{
	$requete = "SELECT service.service_ID, service_nom, lits_journal.date as date,SUM(lits_journal.lits_dispo) as lits_dispo,SUM(lits_sp) as lits_sp, territoire_sante
					FROM service, lits_journal,ville, hopital,adresse,lits
					WHERE service.Type_ID = '$type_service'
					AND priorite_alerte <> 9
					AND lits_journal.service_ID = service.service_ID
					AND lits.service_ID = service.service_ID
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					GROUP BY date, territoire_sante
					ORDER BY date, territoire_sante
					";
	$resultat = ExecRequete($requete,$connexion);
	print("<table border=\"1\" cellspacing=\"0\">");
	/*
		print("<tr>");
			print("<th>date</th>");
			print("<th>territoire 1</th>");
			print("<th>territoire 1</th>");
			print("<th>territoire 2</th>");
			print("<th>territoire 2</th>");
			print("<th>territoire 3</th>");
			print("<th>territoire 3</th>");
			print("<th>territoire 4</th>");
			print("<th>territoire 4</th>");
		print("</tr>");
	$i = 1;
	while($rub = mysql_fetch_array($resultat))
	{
		if(uDate2French($rub['date'])==$date_courante)
		{
			for($j=$i;$j++;$j<5)
				{
					if($rub[territoire_sante]==$j)
					{
						print("<td>".$rub[lits_dispo]."</td>");
						print("<td>".$rub[lits_sp]."</td>");
						$i = $j;
						break;
					}
					else
					{
						print("<td>&nbsp;</td>");
						print("<td>&nbsp;</td>");
					}
				}
		}
		else
		{
			$date_courante = uDate2French($rub['date']);
			print("<tr>");
				print("<td>".uDate2French($rub[date])."</td>");
				for($i=1;$i++;$i<5)
				{
					if($rub['territoire_sante']==$i)
					{
						print("<td>".$rub[lits_dispo]."</td>");
						print("<td>".$rub[lits_sp]." - ".$rub['territoire_sante']."</td>");
						break;
					}
					else
					{
						print("<td>&nbsp;</td>");
						print("<td>&nbsp;</td>");
					}
				}
			print("</tr>");
		}
	}
		*/
		print("<tr>");
			print("<th>date</th>");
			print("<th>territoire</th>");
			print("<th>Lits dispo</th>");
			print("<th>Lits totaux</th>");
		print("</tr>");
	while($rub = mysql_fetch_array($resultat))
	{
		print("<tr>");
			print("<td>".uDate2French($rub[date])."</td>");
			print("<td>".$rub[territoire_sante]."</td>");
			print("<td>".$rub[lits_dispo]."</td>");
			print("<td>".$rub[lits_sp]."</td>");
		print("</tr>");
	}
	print("</table>");
}

lits_medecine($type_service,$connexion);
?>