<?php
/**
*	Teste XPATH
*	rpu_xpath.php
*/
$backPathToRoot = "../../";
$path = $backPathToRoot."sagec_echange/statistiques/OLD_RPU_670780691_090527.xml";
$path = "RPU_670780691_090510.xml";

$xml = simplexml_load_file($path);
$finess = $xml->xpath("///FINESS");
print($finess[0]);

$patient = $xml->xpath("///PATIENT");// le nb de / dépend de la profondeur dans l'arborescence 
print("<table border=\"1\" cellspacing=\"0\">");
	print("<tr>");
		print("<th>CP</th>");
		print("<th>Commune</th>");
		print("<th>Naissance</th>");
		print("<th>Sexe</th>");
		print("<th>Entrée</th>");
		print("<th>Mode entrée</th>");
		print("<th>Provenance</th>");
		print("<th>Transport</th>");
		print("<th>Accompagnement</th>");
		print("<th>Motif</th>");
		print("<th>HMed</th>");
		print("<th>Gravité</th>");
		print("<th>Diag principal</th>");
		print("<th>Diag Associés</th>");
		print("<th>Actes</th>");
		print("<th>Sortie</th>");
		print("<th>Mode de sortie</th>");
		print("<th>Destination</th>");
		print("<th>Orientation</th>");
	print("</tr>");
foreach ($patient as $p)
{
	print("<tr>");
		print("<td>".$p->CP."&nbsp;</td>");
		print("<td>".$p->COMMUNE."&nbsp;</td>");
		print("<td>".$p->NAISSANCE."</td>");
		print("<td>".$p->SEXE."&nbsp;</td>");
		print("<td>".$p->ENTREE."&nbsp;</td>");
		print("<td>".$p->MODE_ENTREE."&nbsp;</td>");
		print("<td>".$p->PROVENANCE."&nbsp;</td>");
		print("<td>".$p->TRANSPORT."&nbsp;</td>");
		print("<td>".$p->TRANSPORT_PEC."&nbsp;</td>");
		print("<td>".$p->MOTIF."&nbsp;</td>");
		print("<td>".$p->HMED."&nbsp;</td>");
		print("<td>".$p->GRAVITE."&nbsp;</td>");
		print("<td>".$p->DP."&nbsp;"."</td>");
		
		//$da = $p->xpath("LISTE_DA");
		print("<td>");
		foreach ($p->LISTE_DA->DA as $d)
		{
			print($d);
			print("&nbsp;");
		}
		print("&nbsp;");
		print("</td>");
		
		print("<td>");
		//print(count($p->LISTE_ACTES->ACTE));
		foreach($p->LISTE_ACTES->ACTE as $a)
		{
			print($a);
			print("&nbsp;");
		}
		print("&nbsp;");
		print("</td>");
		
		
		//print("<td>".$p->LISTE_ACTES."&nbsp;</td>");
		print("<td>".$p->SORTIE."&nbsp;</td>");
		print("<td>".$p->MODE_SORTIE."&nbsp;</td>");
		print("<td>".$p->DESTINATION."&nbsp;</td>");
		print("<td>".$p->ORIENT."&nbsp;</td>");

	print("</tr>");
}
print("</table>");
//print_r($xml);

?>