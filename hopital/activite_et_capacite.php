<?php
/**
 * activite_et_capacite.php
 *
 * @version $Id: lanxes.js 38 2008-02-27 21:07:19Z jcb $
 * @package Sagec
 * @author JCB
 * @copyright 2007
 */

$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."date.php");
include_once($backPathToRoot."classe_stat.php");

$recul = 7;
$organisme = 85; 	//HUS
$Samu67 = 111;		// samu68 = 152
$sau = 1;
$date1 = fDate2unix("15/12/2007");
$date2 = $date1 - ($recul)*24*3600;

$cstat = new CStat();

print("date ".$date1."<br>");

/**
*	analyse
*	$s objet de type CStat
*/
function analyse($s,$n,$nb_affaires_courantes)
{
	print("<table>");
		print("<tr><td>moyenne des ".$n." jours précédants: </td><td>".$s->moyenne()."</td></tr>");
		print("<tr><td>ecart-type ".$n." jours précédants: </td><td>".$s->ecart_type()."</td></tr>");
		print("<tr><td>centrage </td><td>".($nb_affaires_courantes-$s->moyenne())/$s->ecart_type()."</td></tr>");
		print("<tr><td>variation </td><td>".($nb_affaires_courantes/$s->moyenne()-1)."</td></tr>");
	print("</table>");
}

/**
*	SAMU
*/
print("<br>Activité du SAMU 67 <br><br>");
$requete = "SELECT date,nb_affaires, nb_primaires, nb_secondaires, nb_tiih
				FROM veille_samu
				WHERE service_ID = '$Samu67'
				AND date BETWEEN '$date2' AND '$date1'
				";
	$resultat = ExecRequete($requete,$connexion);
	print("<table>");
	$n = $somme = $somme2 = 0;
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td>".uDate2French($rub[date])."</td>");
		print("<td>$rub[nb_affaires]</td>");
		print("<td>$rub[nb_primaires]</td>");
		print("<td>$rub[nb_secondaires]</td>");
		print("<td>$rub[nb_tiih]</td>");
	print("</tr>");
	
	if($n < $recul)
	{
		$n++;
		$cstat->addx($rub[nb_affaires]);
	}
	$nb_affaires_courantes = $rub[nb_affaires];
}
print("</table>");
analyse($cstat,$n,$nb_affaires_courantes);
$cstat->clear();

/**
*	SAU
*/

$date1 = uDate2MySql($date1);
$date2 = uDate2MySql($date2);
print("<br> SAU <br>");
print("<br> Services concernés: ");
$requete = "SELECT service_nom FROM service WHERE org_ID = '$organisme' AND Type_ID = '$sau' AND Priorite_Alerte <> 9";
$resultat = ExecRequete($requete,$connexion);
$n = $somme = $somme2 = 0;
while($rub=mysql_fetch_array($resultat))
{
	print($rub[service_nom]."  ");
}
print("<br>");

$requete = "SELECT date,SUM(passage) AS passages,SUM(hosp) AS hosps
				FROM veille_SAU
				WHERE org_ID = '$organisme'
				AND date BETWEEN '$date2' AND '$date1'
				GROUP BY date
				ORDER BY date
				"; 
				//print($requete);
$resultat = ExecRequete($requete,$connexion);
print("<table>");
$n = $somme = $somme2 = 0;
$cstat2 = new CStat();
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td>".usdate2fdate($rub[date])."</td>");
		print("<td>$rub[passages]</td>");
		print("<td>$rub[hosps]</td>");
		print("<td>".$rub[hosp]/$rub[passage]."</td>");
	print("</tr>");
	
	if($n < $recul)
	{
		$n++;
		$cstat->addx($rub[passages]);
		$cstat2->addx($rub[hosps]);
	}
	$nb_passages_courants = $rub[passages];
	$nb_hosp_courantes = $rub[hosps];
}
print("</table>");
analyse($cstat,$n,$nb_passages_courants);
analyse($cstat2,$n,$nb_hosp_courantes);
$cstat->clear();
$cstat2->clear();

/**
*	Réanimations, soins intensifs et continus
*/

?>