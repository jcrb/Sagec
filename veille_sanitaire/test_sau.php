<?php
// teste aggrégation des données des SAU
// test_sau.php
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
include("../date.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

function sau($texte,$date1,$date2,$connexion)
{
		$requete = "SELECT veille_sau.service_ID,
							date,
							SUM(inf_1_an) as inf_1_an,
							SUM(sup_75_an) as sup_75_an,
							SUM(entre1_75) as entre1_75,
							SUM(hospitalise) as hospitalise,
							SUM(uhcd) as uhcd,
							SUM(transfert) as transfert,
							Hop_finess,
							Hop_nom
					FROM veille_sau,hopital,service
					WHERE date BETWEEN '$date1' and '$date2'
					AND veille_sau.service_ID = service.service_ID
					AND service.Hop_ID = hopital.Hop_ID
					GROUP BY Hop_finess, date
					ORDER BY Hop_finess
					";
	print($requete."<br>");
	$texte = "<?xml version = \"1.0\" encoding=\"ISO-8859-1\"?>\r\n";
	$texte.="<SAU>";
	$resultat = ExecRequete($requete,$connexion);
	while($sau = mysql_fetch_array($resultat))
	{
		print(date("Y/m/d",$sau['date'])." ".$sau['Hop_finess']." ".$sau['Hop_nom']." ".$sau[inf_1_an]." ".$sau[sup_75_an]." ".$sau[entre1_75]." ".$sau[hospitalise]." ".$sau[uhcd]." ".$sau[transfert]."<br>");
	
		$texte.="<ETAB_SERV>\r\n";
			$texte.="<DESCSERV>\r\n";
					$texte.="<id_etab>".$sau['Hop_finess']."</id_etab>";      // n° Finess de l'établissement'
					$texte.="<id_serv>SAU</id_serv>";
				$texte.="</DESCSERV>\r\n";
				$texte.="<INDICATEURS>\r\n";
					$texte.="<JOURNEE>\r\n";
						$passages = $sau['inf_1_an']+$sau['sup_75_an']+$sau['entre1_75'];
						$date = date("Y/m/d",$sau['date']);
						$texte.="<jour>".$date."</jour>\r\n";                           // jour
						$texte.="<urg>".$passages."</urg>\r\n";                         // nb total de primo passage
						$texte.="<urg1a>".$sau['inf_1_an']."</urg1a>\r\n";              // moins de 1 an
						$texte.="<urg75a>".$sau['sup_75_an']."</urg75a>\r\n";           // plus de 75 ans
						$texte.="<hosp>".$sau['hospitalise']."</hosp>\r\n";             // hospitalisés service mco
						$texte.="<uhcd>".$sau['uhcd']."</uhcd>\r\n";                    // hospitalisé en Uhcd
						$texte.="<transferts>".$sau['transfert']."</transferts>\r\n";   // transférés
				$texte.="</JOURNEE>\r\n";
		$texte.="</INDICATEURS>\r\n";
		$texte.="</ETAB_SERV>\r\n";
	}
	$texte.="</SAU>";
	return $texte;
}

$texte = "";
$date1 = fDate2unix("01/01/2007");
$date2 = fDate2unix("07/01/2007");
$texte = sau($texte,$date1,$date2,$connexion);
$fp = fopen("sau.xml", 'w+');
fputs($fp, $texte);
fclose($fp);
        
echo 'Export XML effectue !<br><a href="sau.xml">Voir le fichier</a>';

?>