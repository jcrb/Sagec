<?php
/**
*	test1.php
*/
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../../";
require($backPathToRoot."pma_connect.php");
require($backPathToRoot."pma_connexion.php");
require($backPathToRoot."pma_requete.php");
require_once($backPathToRoot."phplot/phplot.php");
require $backPathToRoot.'date.php';
require $backPathToRoot.'classe_stat.php';
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

//print_r($_REQUEST);

$selection = $_REQUEST['radio'];// région, département, entité, établissement
$item  = $_REQUEST['id_item'];// ID de l'item sélectionné. Dépend de $delection 

$indicateur1 = $_REQUEST['indic1'];
$indicateur2 = $_REQUEST['indic2'];
$indicateur2 = $_REQUEST['indic3'];
$indicateur4 = $_REQUEST['indic4'];

$valeur1 = $_REQUEST['valeur1'];// nb = comptage,mm=moyenne mobile
$valeur2 = $_REQUEST['valeur2'];
$valeur3 = $_REQUEST['valeur3'];
$valeur4 = $_REQUEST['valeur4'];

$Du =  $_REQUEST['du'];
$Au =  $_REQUEST['au'];
$moyenne = $_REQUEST['moyenne'];
$lissage = $_REQUEST['lissage'];
$nb_jour =  $_REQUEST['lissage'];

$restitution = $_REQUEST['restitution'];
/** test */
$valeur = 'nombre';
$Du = mysqlDateTime2unix("2007-01-01");print("date1 ".uDate2Frenchdatetime($Du).'<br>');
$Au = mysqlDateTime2unix("2007-01-31");print("date1 ".uDate2Frenchdatetime($Au).'<br>');
$Du = $Du-$lissage*24*60*60; // on recule de 7 jours pour la moyenne lissée
print_r($_REQUEST);print('<br>');

$n = array();

print("Sélection: ".$selection."<br>");
print("Indicateur: ".$indicateur."<br>");
print("Item: ".$item."<br>");

select($indicateur1,$valeur1,$item,$selection,$restitution,$Du,$Au);

function select($indicateur,$valeur,$item,$selection,$restitution,$Du,$Au)
{
	global $connexion;
	if($indicateur=="passage") $indicateur = "inf_1_an + sup_75_an + entre1_75";
	switch($selection)
	{
	case 'region':
		$requete = "SELECT region_nom FROM region WHERE region_ID = '$item'";
		$resultat = ExecRequete($requete,$connexion);
		$rep = mysql_fetch_array($resultat);
		$titre= "Région ".$rep[region_nom];
		
		// selectionner les valeurs issues de tous les SAU de la région
		$requete="SELECT date,SUM(".$indicateur.")AS somme
				FROM veille_sau,adresse,ville,hopital,service
				WHERE veille_sau.service_ID = service.service_ID
				AND service.Hop_ID = hopital.Hop_ID 
				AND adresse_ID = ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.region_ID = '$item'
				AND date >= '$Du' AND date <= '$Au'
				GROUP BY date
				ORDER BY date ASC
				";
		$titre = "Ensemble des services d'urgence\n".$titre;
		break;
		
	case 'departement':
		// selectionner les valeurs issues de tous les SAU de la région
		$requete="SELECT date,SUM(".$indicateur.") FROM veille_sau,adresse,ville,hopital,service
				WHERE veille_sau.service_ID = service.service_ID
				AND service.Hop_ID = hopital.Hop_ID 
				AND adresse_ID = ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID = '$item'
				AND date >= '$Du' AND date <= '$Au'
				GROUP BY date
				ORDER BY date ASC
				";
		$titre = "Services d'urgence\ndu département ";
		break;
		
	case 'etablissement':
		// Etablisement sélectionné = $item 
		$requete="SELECT date,SUM(".$indicateur.") 
				FROM veille_sau,hopital,service
				WHERE veille_sau.service_ID = service.service_ID
				AND service.Hop_ID = hopital.Hop_ID 
				AND hopital.Hop_ID = '$item'
				AND date >= '$Du' AND date <= '$Au'
				GROUP BY date
				ORDER BY date ASC
				";
		$titre = "Services d'urgence\ndu département ";
		
		break;
		
	case 'entite':
		// récupère le nom du service 
		$requete = "SELECT service_nom FROM service WHERE service_ID = '$item'";
		$resultat = ExecRequete($requete,$connexion);
		$rep = mysql_fetch_array($resultat);
		$service = $rep['service_nom'];
		
		// selectionner les valeurs issues du SAU $item 
		$requete = "SELECT date,".$indicateur." 
						FROM veille_sau 
						WHERE service_ID = '$item' 
						AND date >= '$Du' AND date <= '$Au'
						GROUP BY date
						ORDER BY date ASC
						";
		$titre = $service ;
		break;
	}// end switch
	print($requete);
	$resultat = ExecRequete($requete,$connexion);
	while($rep = mysql_fetch_array($resultat))
	{
		$n[] = $rep;
	}
	calcule($n);
	if($restitution=='Courbe')
		graphe($n,$titre);
	else
		affiche($n,$titre);
}

function graphe($n,$titre)
{
	/**
	/* transforme un tableau bidimentionnel en mono
	/* $date = date du jour au format UNIX
	/* $val = valeur correspondante
	/* les tableaux sont ensuite implosés pour être transmis
	*/
	
	$date = array();
	$val = array();
	global $lissage;
	//global $moylisse;
	global $Stat;
	// on récupère les dates et les valeurs
	foreach($n as $a)
	{
		$date[] = $a[0];
		$val[] = $a[1];$i++;
	}
	// on enlève les 7 premières valeurs
	//$moylisse = array_slice ($moylisse, $lissage);// fait par affiche. A décommenter sinon 
	$date = array_slice ($date, $lissage);
	$val = array_slice ($val, $lissage);

	$d = implode(",",$date);
	$v = implode(",",$val);
	//$ml = implode(",",$moylisse);
	$ml = implode(",",$Stat->mlisse);print($ml);
	$titre = urlencode($titre);
	?>
	<img src="fig1.php?v=<?php echo $v.'&d='.$d.'&ml='.$ml.'&titre='.$titre;?>" border=0 align=center width=600 height=300> 
	<?php
}

function calcule($n)
{
	global $moylisse;
	$moylisse=array();
	global $moyenne;
	global $Stat;
	// fichier où enregistrer les données et les exporter
	$f=fopen('cusum.txt',"w");
	fwrite($f,"Données SAU HUS hors pédiatrie");
	$param="jour\tdate\taffaires\tmoyenne\tecart-type\tSt\tCusum\n";
	fwrite($f,$param);
	// création d'un objet statistique et remplissage
	$Stat = new CStat();
	for($i=0;$i<sizeof($n);$i++) $Stat->addx($n[$i][1]);
	// calcul du CUSUM 
	$Stat->cusum(1);
	$moylisse = $Stat->mlisse;
}

function affiche($n,$titre)
{
	global $moylisse;
	global $lissage;
	$moylisse=array();
	global $moyenne;
	global $Stat;
	// fichier où enregistrer les données et les exporter
	$f=fopen('cusum.txt',"w");
	fwrite($f,"Données SAU HUS hors pédiatrie");
	$param="jour\tdate\taffaires\tmoyenne\tecart-type\tSt\tCusum\n";
	fwrite($f,$param);
	// création d'un objet statistique et remplissage
	$Stat = new CStat();
	for($i=0;$i<sizeof($n);$i++)
		$Stat->addx($n[$i][1]);
	print("moyenne: ".$Stat->moyenne()."<br>"); // moyenne
	print("écart-type: ".$Stat->ecart_type()."<br>"); // // écart-type
	// calcul du CUSUM 
	$Stat->cusum(1);
	
	/**
	*	AFFICHAGE
	*/
	
	print($titre."<br>");
	print("<table border=\"1\" cellspacing=\"0\">");
		print("<tr>");
			print("<th>Jour</th>");
			print("<th>Date</th>");
			print("<th>Passages</th>");
			print("<th>Lissage</th>");
			print("<th>Ecart-type</th>");
			print("<th>Cusum</th>");
		print("</tr>");
		$cumul = 0;
		for($i=$lissage;$i<sizeof($n);$i++)
		{
			print("<tr>");
			//if($jour)
				$j = $n[$i]['date'];
				$jour_semaine = jour_de_la_semaine($j);
				$french_date = uDate2French($j);
			print("<td align=\"right\">".$jour_semaine."</td>");
			print("<td>".$french_date."</td>");
			//print("<td align=\"right\">".$n[$i][1]."</td>");
			print("<td align=\"right\">".number_format($n[$i][1], 2, ',', ' ')."</td>");
			print("<td align=\"right\">".number_format($Stat->mlisse[$i], 2, ',', ' ')."</td>");
			if(isset($moyenne))
				$moylisse[] = $Stat->mlisse[$i];// pour le graphe 
			print("<td align=\"right\">".number_format(sqrt($Stat->vlisse[$i]), 2, ',', ' ')."</td>");
			print("<td align=\"right\">".number_format($Stat->cusum[$i], 2, ',', ' ')."</td>");
			$cumul += $Stat->cusum[$i];
			if($cumul>50) $cumul=0;
			print("<td align=\"right\">".number_format($cumul, 2, ',', ' ')."</td>");
			print("</tr>");
			
			//$param = $jour_semaine."\t".$french_date."\t".$n[$i]['1']."\t".$Stat->mlisse[$i]."\t".sqrt($Stat->vlisse[$i])."\t"."\t"."\n";
			if($i%10==0)$date = $french_date;else $date='';
			$param = ""."\t".$date."\t".$n[$i]['1']."\t".$Stat->mlisse[$i]."\t".sqrt($Stat->vlisse[$i])."\t"."\t"."\n";
			fwrite($f,$param);
		}
	print("</table>");
	fclose($f);
	//print_r($Stat->mlisse);
	print("<a href=\"cusum_graphe.php?service=$service&recul=50\">Graphe</a><br>");
	
	$date = array();
	$val = array();
	
	// on récupère les dates et les valeurs
	foreach($n as $a)
	{
		$date[] = $a[0];
		$val[] = $a[1];$i++;
	}
	// on enlève les 7 premières valeurs
	//$moylisse = array_slice ($moylisse, $lissage);
	$date = array_slice ($date, $lissage);
	$val = array_slice ($val, $lissage);

	$d = implode(",",$date);
	$v = implode(",",$val);
	$ml = implode(",",$moylisse);
	$titre = urlencode($titre);
	?>
	<img src="fig1.php?v=<?php echo $v.'&d='.$d.'&ml='.$ml.'&titre='.$titre;?>" border=0 align=center width=600 height=300> 
	<?php
}

/**
SQL> --Performing a Moving Average
SQL>
SQL> --The following query computes the moving average of the sales amount between the current month and the previous three months:
SQL>
SQL> SELECT
  2   date, SUM(amount) AS date_amount,
  3   AVG(SUM(amount)) OVER
  4    (ORDER BY date ROWS BETWEEN 7 PRECEDING AND CURRENT ROW)
  5    AS moving_average
  6  FROM veille_SAU
  7  GROUP BY date
  8  ORDER BY date;
  */

function dessine_graphe($n,$nom="")
{

	$service = $nom;
	//create a PHPlot object with 800x600 pixel image
	$plot =& new PHPlot(1000,700);
	// dessine un cadre
	$plot->SetImageBorderType('plain');
	// Neutralise l'affichage automatique (uniquement pour les dessins complexes
	$plot->SetPrintImage(0);
// définition de la première zone de dessin
	$plot->SetPlotAreaPixels(80, 40, 900, 650);
	$plot->SetDataValues($n);
	//$plot->SetPlotAreaWorld(NULL, 0, NULL, 200);
	//Set titles
	$plot->SetTitle("Activité du ".$service."\nDossiers céés");
	$plot->SetXTitle('Jours');
	$plot->SetYTitle('Dossiers créés');
	$plot->SetPrecisionY(0);
	$plot->SetLegend(array('dossiers', 'moyenne mobile (7 jours)','Limite sup (95%)'));
	//Turn off X axis ticks and labels because they get in the way:
	$plot->SetXTickLabelPos('none');
	//$plot->SetXTickPos('none');
	$plot->SetNumXTicks(10);
	$plot->SetXLabelAngle(90);
	//Draw it
	$plot->DrawGraph();
	// Affichage
	$plot->PrintImage();

}

?>