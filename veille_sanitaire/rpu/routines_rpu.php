<?php
/**
*	routines_rpu.php
*	teste les données de la table rpu
*	@TODO préciser un intervalle de temps
*/
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");
require($backPathToRoot."classe_stat.php");

$finess = "670000397";	// Sélestat

/*
*	affiche les données d'une requête sous forme de tableau
*	@data $intitule intitulé des colonnes
*	@data $resultat resultat de la requete MySql
*/ 
function table($intitule,$resultat)
{
	?>
		<table background-color="#ddd">
			<tr>
				<?php
					for($i=0;$i<sizeof($intitule);$i++)
					{
						print("<th>$intitule[$i]</th>");
					}
				?>
			</tr>
			
			<?php 
				while($rep=mysql_fetch_array($resultat))
				{
					print("<tr>");
						print("<th>$rep[0]</th>");
						for($i=1;$i<sizeof($intitule);$i++)
						{
							print("<td>$rep[$i]</td>");
						}
					print("</tr>");
				}
			?>
		</table>
		<br>
	<?php 
}

/**
*	compte la répartition des consultants par sexe
*/
function sexe()
{
	global $connexion;
	global $finess;
	$categorie = array();
	
	$requete = "SELECT sexe, COUNT(sexe) AS sumsexe FROM rpu 
					WHERE finess = '$finess' 
					GROUP BY sexe
					ORDER BY sexe";
	$resultat = ExecRequete($requete,$connexion);
	$resultat2 = ExecRequete($requete,$connexion);
	?>
	<table>
		<tr>
			<td><?php
				// tableau HTML
				$intitule = array("Sexe","nombre");
				table($intitule,$resultat2);
			?></td>
			<td><?php
				// Pie Graph 
				while($rep=mysql_fetch_array($resultat))
				{
					$categorie[$rep['sexe']] = $rep['sumsexe'];
				}
				$w =urlencode(serialize($categorie));
				$titre = "Passages - Répartition par sexe";
				print("<img src=\"showpiegraph.php?titre=$titre&val=$w\"> ");
			?></td>
		</tr>
	</table>
	<?php 
}

/**
*	Supprime les caractères invisibles contenus dans le nom des villes
*	Evite qu'une ville apparaisse 2 fois avec un décompte différent
*/
function nettoie()
{
	global $connexion;
	$requete = "SELECT rpu_ID, ville , zip,motif,
						LENGTH(ville) AS lv,
						LENGTH(zip) AS lz,
						LENGTH(motif) AS lm
					FROM rpu ORDER BY ville";
	$resultat = ExecRequete($requete,$connexion);
	while($rep=mysql_fetch_array($resultat))
	{
		// corrige la ville
		$chaine = preg_replace("/\\x0|[\x01-\x1f]/U","",$rep[ville]); 
		if($rep[lv] != strlen($chaine))
		{
			$requete = "UPDATE rpu SET ville = '$chaine' WHERE rpu_ID = '$rep[rpu_ID]'";
			ExecRequete($requete,$connexion);
		}
		// corrige le code postal 
		$chaine = preg_replace("/\\x0|[\x01-\x1f]/U","",$rep[zip]); 
		if($rep[lz] != strlen($chaine))
		{
			$requete = "UPDATE rpu SET zip = '$chaine' WHERE rpu_ID = '$rep[rpu_ID]'";
			ExecRequete($requete,$connexion);
		}
		// corrige le motif 
		$chaine = preg_replace("/\\x0|[\x01-\x1f]/U","",$rep[motif]); 
		if($rep[lm] != strlen($chaine))
		{
			$requete = "UPDATE rpu SET motif = '$chaine' WHERE rpu_ID = '$rep[rpu_ID]'";
			ExecRequete($requete,$connexion);
		}
	}
	
}

/**
  *	compte la répartition des consultants par commune
  */
function commune()
{
	global $connexion; //
	global $finess;
	$requete = "SELECT ville, COUNT(ville) AS sumsexe, LENGTH(ville) AS lv
					FROM rpu
					WHERE finess = '$finess'
					GROUP BY ville
					ORDER BY sumsexe";
	$resultat = ExecRequete($requete,$connexion);
	$intitule = array("Commune","nombre","Size");
	table($intitule,$resultat);
}

/**
  *	compte le nb de personnes venues d'un autre département
  */
  function autre_departement()
  {
  	global $connexion;
  	
  	$requete = "SELECT sexe, count(*)
  							FROM rpu
  							WHERE zip <'67000'|| zip > '67999'
  							GROUP BY sexe
  							";
  	$resultat = ExecRequete($requete,$connexion);
  	$intitule = array("sexe","Nb de passages (Hors département)");
		table($intitule,$resultat);
  }
  
/**
  *	nombre de personnes venues d'un autre secteur sanitaire
  */
  
/**
  *	dénombre le nombre de passages par jour
  */
function passages()
{
	global $connexion;
	global $finess;
					
	$requete = "SELECT DATE_FORMAT(date_entree,'%Y-%M-%d')AS date, COUNT(date_entree) AS passages FROM rpu 
					WHERE finess = '$finess'
					GROUP BY date
					ORDER BY date_entree";
	$resultat = ExecRequete($requete,$connexion);
	$intitule = array("Date","Nb de passages");
	table($intitule,$resultat);

	// Graphe 
	print("<table>");
	print("<tr><th><img src=\"passages.php\"></th></tr> ");
	print("</table>");
}

/**
*	dénombre le nombre de passages par jour pour une CCAM donnée
*	modèle pour les autres fonctions
*/
function passages_par_ccam()
{
	global $connexion;
	global $finess;
					
	$requete = "SELECT DATE_FORMAT(date_entree,'%Y-%M-%d')AS date, COUNT(date_entree) AS passages FROM rpu 
					WHERE finess = '$finess'
					AND TRIM(diag_principal) LIKE 'J1%'
					GROUP BY date
					ORDER BY date_entree";
	$resultat = ExecRequete($requete,$connexion);
	$intitule = array("Date","Nb de passages");
	table($intitule,$resultat);
}

/**
 *	passages par mois
 */
function passageByMonth()
{
	global $connexion;
	global $finess;
	$requete = "SELECT MONTH(date_entree)AS date, count(*) FROM rpu
					WHERE finess = '$finess' 
					AND date_entree > '2009-01-00' 
					AND date_entree < '2010-01-01'
					GROUP BY MONTH(date_entree) 
					ORDER BY date_entree";
	$resultat = ExecRequete($requete,$connexion);
	$intitule = array("Mois","Nb de passages");
	table($intitule,$resultat);
}

function passageByWeek()
{
	global $connexion;
	global $finess;
	$week = array();
	$requete ="SELECT count(*) as nb, semaine.num_semaine 
					FROM semaine
  					LEFT JOIN rpu
   				ON semaine.num_semaine = weekofyear(date_entree)
   				WHERE finess = '$finess'
   				AND date_entree > '2009-01-00' 
					AND date_entree < '2010-01-01'
   				AND TRIM(diag_principal) LIKE '%J1%'
					GROUP BY semaine.num_semaine";
	$resultat = ExecRequete($requete,$connexion);
	$intitule = array("Semaine","Nb de passages");
	//table($intitule,$resultat);
	print("<table>");
		print("<tr><th>Semaine</th><th>Passages</th></tr>");
	while($rep=mysql_fetch_array($resultat))
	{
		$week[$rep[num_semaine]] = $rep[nb];
		print("<tr><th>".$rep[num_semaine]."</th><td>".$rep[nb]."</td></tr>");
		//print($rep[num_semaine]." -> ".$rep[nb]."<br>");
	}
	print("</table>");
	// Graphe 
	print("<table>");
	$w = urlencode(serialize($week));
	print("<tr><th><img src=\"showgraph.php?week=$w\"></th></tr> ");
	print("</table>");
}

function passageByWeek2()
{
	global $connexion;
	global $finess;
	$week = array();
	$week2 = array();
	$requete ="SELECT count(*) as nb, semaine.num_semaine 
					FROM semaine
  					LEFT JOIN rpu
   				ON semaine.num_semaine = weekofyear(date_entree)
   				WHERE finess = '$finess' 
   				AND date_entree > '2009-01-00' 
					AND date_entree < '2010-01-01'
   				AND TRIM(diag_principal) LIKE 'J1%'
					GROUP BY semaine.num_semaine";
	$resultat = ExecRequete($requete,$connexion);
	
	$requete2 ="SELECT count(*) as nb2, semaine.num_semaine 
					FROM semaine
  					LEFT JOIN rpu
   				ON semaine.num_semaine = weekofyear(date_entree)
   				WHERE finess = '$finess' 
   				AND date_entree > '2009-01-00' 
					AND date_entree < '2010-01-01'
   				AND TRIM(diag_principal) LIKE 'J1%'
   				AND mode_sortie = 6
					GROUP BY semaine.num_semaine";
	$resultat2 = ExecRequete($requete2,$connexion);

	print("<table>");
		print("<tr><th>Semaine</th><th>Passages</th><th>hospitalisation</th></tr>");
		
	while($rep=mysql_fetch_array($resultat))
	{
		$week[$rep[num_semaine]] = $rep[nb];// total des cas
		$rep2=mysql_fetch_array($resultat2);
		$week2[$rep[num_semaine]] = $rep2[nb2];// total des hospitalisés
		
		print("<tr><th>".$rep[num_semaine]."</th><td>".$rep[nb]."</td><td>".$rep2[nb2]."</td></tr>");
		print("<tr><th>".$rep[num_semaine]."</th><td>".$rep[nb]."</td><td>".$rep2[nb2]."</td></tr>");
	}
	print("</table>");
	
	// Graphe 
	print("<table>");
	$w = urlencode(serialize($week));
	$w2 = urlencode(serialize($week2));
	print("<tr><th><img src=\"showgraph2.php?week=$w&week2=$w2\"></th></tr> ");

	print("</table>");
}

/**
  * 	Graphe de l'objet surveillance
  *		@data year 	année pleine où commence le graphe
  *		@data week	n° de la semaine correspondant à la première semaine de l'
  *								année pleine. Par ex. si les données commencent la semaine 47
  *								de 2008 et que l'année pleine est 2009, alors week = 7
  */
  function surveillance()
  {
		global $connexion;
		global $finess;
		
		$cim10 = "J1%";
		$titre = "Syndrome respiratoire viral";
	
		$requete ="SELECT count(*) as nb, YEARWEEK(date_entree) as date
						 FROM rpu
						 WHERE finess = '$finess' 
   					 AND TRIM(diag_principal) LIKE '$cim10'
   					 GROUP BY date
   					 ORDER BY date
   					 ";
  $resultat = ExecRequete($requete,$connexion);
  // nb de lignes retournées correspond au nombre de semaines
  $num_rows = mysql_num_rows($resultat);
  
  // on récupère la première ligne pour déterminer le mois et l'année de départ
  $rep=mysql_fetch_array($resultat);
  $years = substr($rep['date'], 0,4);
  $week = substr($rep['date'], -2);
  // premier jour
  $data[] = $rep['nb'];	// nb de cas
  $state[] = 0;					// etat ou 0
  while($rep=mysql_fetch_array($resultat))
	{
		//echo $rep['date']."  ".$rep['nb']."<br>";
		$data[] = $rep['nb'];
		$state[] = 0;
	}
	// transformation des array en string
	$ob = "observed<-c(".implode(",",$data).")";
	$st = "state<-c(".implode(",",$state).")";
	
	$fp = fopen("surveillance.R","w");
	fwrite($fp,"png(filename=\"surveillance.png\",width=1000,height=500)\n");
	fwrite($fp,"library(surveillance)\n");
	fwrite($fp,"weeks<-c(1:".$num_rows.")\n");
	fwrite($fp,$ob."\n");
	fwrite($fp,$st."\n");
	fwrite($fp,"x<-create.disProg(weeks,observed,state)\n");
	/** codage en dur de week @TOTO à corriger */
	$week = 6;
	$years = 2009;
	fwrite($fp,"plot(x,\"".$titre."\",xaxis.years=TRUE,startyear=".$years.",firstweek=".$week.",col=\"blue\",ylab=\"Nombre de cas\",xlab=\"Temps\",legend.opts=NULL)\n");
	fclose($fp);
	exec("Rscript surveillance.R");
	echo("<img src='surveillance.png' />");
}
	
/**
*	cusum sur les infections respiratoires
*/
function testeCusum()
{
	global $connexion;
	$cusum = array();
	$requete = "SELECT count(*)AS nb, dayofyear(date_entree) AS date FROM rpu
					WHERE date_entree > '2009-01-00'
   				AND TRIM(diag_principal) LIKE 'J1%'
   				GROUP BY date
   				Order BY date
   				";
   $resultat = ExecRequete($requete,$connexion);
   
   $cs = new CStat();
   $i = 1;
   while($rep=mysql_fetch_array($resultat))
	{
		/** on récupère dans cstat le nb de consultant
		  * comme il n'y en a pas tous les jours, il faut
		  * insérer 0 les jours sans
		  */
		while($rep[date] > $i)
		{
			$cs->addx(0);
			//print($i."  0 ++ <br>");
			$i++;
		}
		//print($rep[date]."  ".$rep[nb]."<br>");
		$cs->addx($rep[nb]);
		$i++;
	}
	/** idem our compléter l'année */
	while($i < 366)
	{
		$cs->addx(0);
		//print($i."  0 --<br>");
		$i++;
	}
	$cusum = $cs->cusum(1);//CUSUM type 1 => lissage sur 7 jours 
	/*
	$intitule = array("Date","Cusum");
	table($intitule,$cusum);
	*/
	print("moyenne: ".$cs->moyenne()."<br>");
	print("ecart-type: ".$cs->ecart_type()."<br>");
	print("taille: ".$cs->size()."<br>");
	print("taille du CUSUM: ".sizeof($cusum)."<br>");
	?>
	<table>
		<tr>
			<td>Jour</td>
			<td>nb.de cas</td>
			<td>CUSUM</td>
		</tr>
	<?php 
		for($i=0;$i<sizeof($cusum);$i++)
		{?>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $cs->vx[$i];?></td>
				<td><?php printf("%3.2f",$cusum[$i]);?></td>
			</tr>
		<?php } ?>
	</table>
	<?php
}


/**
*	diagnostic principal
*/
function diag_principal($diag_specifique="")
{
	global $connexion;
	global $finess;
	$requete = "SELECT TRIM(diag_principal) AS diag,COUNT(TRIM(diag_principal))as nb_diag
					FROM rpu ";
					if($diag_specifique)
						$requete .= "WHERE diag_principal LIKE '$diag_specifique' ";
					$requete .= "GROUP BY diag
					ORDER BY diag
					";
	$resultat = ExecRequete($requete,$connexion);				
	?><table border="1" cellspacing="0"><tr><td>Diagnostic</td><td>nombre</td></tr><?php 
	while($rep=mysql_fetch_array($resultat))
	{
		?><tr><?php
			?><td><?php print($rep[diag]);
			?></td><td align="center"><?php print($rep[nb_diag]);?></td>
			<td><?php print(strlen($rep[diag]));?></td>
		</tr><?php
	}
	?></table><?php
}

/**
*	lecture CIM10
*	inpiut: code RPU
*	retourne le libellé du code, SID (systematic identifier, LID
*/
function libelle_CIM10($code)
{
	global $connexion;
	$requete = "SELECT libelle,LID,cim10_master.SID
					FROM cim10_libelle, cim10_master
					WHERE abbrev = '$code'
					AND cim10_master.SID = cim10_libelle.SID";
	$resultat = ExecRequete($requete,$connexion);
	print("<table>");
	while($rep=mysql_fetch_array($resultat))
	{
		print("<tr>");
			print("<td>$code</td>");
			print("<td>$rep[LID]</td>");
			print("<td>$rep[SID]</td>");
			print("<td>$rep[libelle]</td>");
		print("</tr>");
	}
	print("</table>");
}
/**
*	function age
*	calcule l'age des consultants
*/
function age()
{
	global $connexion;
	$requete = "SELECT date_entree, date_naissance,
   				(YEAR(date_entree)-YEAR(date_naissance)) AS age,
   				COUNT(*) AS a, sexe
    				FROM rpu 
    				WHERE ((date_entree > 0) AND (date_naissance > 0))
    				AND date_entree > date_naissance
    				AND date_entree BETWEEN '2009-01-01 00:00:00' AND '2010-01-01 00:00:00'
    				GROUP BY age,sexe
   				ORDER BY age
    				";
	$resultat = ExecRequete($requete,$connexion);
	?>
	<table>
		<tr>
			<th>Age</th>
			<th>Hommes</th>
			<th>Femmes</th>
			<th>Total</th>
		</tr>
	<?php
	
	while($rep=mysql_fetch_array($resultat))
	{
		print("<tr>");
			print("<td>$rep[age]</td>");
			//print("<td>$rep[sexe]</td>");
			if($rep[a]=="")$rep[a]=0;
			print("<td>$rep[a]</td>");
			
			$tranche_age = $rep[age];
			
			/** décompte des hommes */
			$total = $rep[a];
			$totalHomme += $total;
			$r_hommes[$tranche_age] = $total;	// pour R 
			
			/** décompte des femmes */
			$rep=mysql_fetch_array($resultat);
			if($rep[a]=="")$rep[a]=0;
			print("<td>$rep[a]</td>");
			$total += $rep[a];
			$totalFemme += $rep[a];
			$r_femmes[$tranche_age] = $rep[a];	// pour R 
			
			/** total pour l'age */
			$grandTotal += $total;
			
			/** pour R */
			if($tranche_age > 0)
				$r_ages[] = $tranche_age;
			
			print("<td>$total</td>");
		print("</tr>");
	}
	print("<tr>");
		print("<td>&nbsp;</td>");
		print("<td>$totalHomme</td>");
		print("<td>$totalFemme</td>");
		print("<td>$grandTotal</td>");
	print("</tr>");
	print("</table>");
	
	/** pyramide des ages */
	$h = implode(",",$r_hommes);
	$f = implode(",",$r_femmes);
	$a = implode(",",$r_ages);
	
	$titre = '"Population des consultants\n SAU Selestat"';
	$step = 5;
	
	$commandeR = "png(filename=\"pyramide.png\", width=1000, height=800)\n";
	$commandeR .= "options(echo=TRUE)\n";
	$commandeR .= "# pyramide des ages \n";
	$commandeR .= "library (pyramid)\n";
	$commandeR .= "ages<-c(".$a.")\n";
	$commandeR .= "hommes<-c(".$h.")\n";
	$commandeR .= "femmes<-c(".$f.")\n";
	$commandeR .= "data<-data.frame(hommes, femmes, ages)\n";
	$commandeR .= "pyramid(data,Rlab=\"Femmes\",Llab=\"Hommes\",Cstep=".$step.",main=".$titre.")\n";
	$commandeR .= "q('no')";
	
	$fp = fopen("pyramide.R","w");
	chmod("pyramide.R", 0777);
	fwrite($fp,$commandeR);
	fclose($fp);
	exec("Rscript pyramide.R resultats.txt");
	echo("<img src='pyramide.png' />");
	chmod("pyramide.png", 0777);
	
	$commandeR = "options(echo=FALSE)\n";
	$commandeR .= "ages<-c(".$a.")\n";
	$commandeR .= "hommes<-c(".$h.")\n";
	$commandeR .= "femmes<-c(".$f.")\n";
	$commandeR .= "d<-ages * hommes/100\n";
	$commandeR .= "print(summary(d))\n";
	$commandeR .= "q('no')";
	$fp = fopen("mydata.R","w");
	chmod("mydata.R", 0777);
	fwrite($fp,$commandeR);
	fclose($fp);
	/** méthode 1: création d'un fichier conrenant les résultats */
		//echo exec('R CMD BATCH --slave "mydata.R" "results.txt" ');
		//chmod("results.txt", 0777);
	/** méthode 2: récupération dorecte dans une variable de flux
			--no-save: pas d'écriture dans R
			-- slave: supprime l'entête de R
	*/
	$out = array();
	$cmd = "R --no-save --slave <<END\n ";
	exec($cmd.$commandeR, $out);
	?>
	<table>
	<?
		foreach ($out as $value)
		{
			$t = explode(" ",$value);
			?><tr><?
				for($i=0;$i<sizeof($t);$i++)
				{
					?>
						<td><?echo $t[$i];?></td>
					<?
				}
				?>
			</tr>
			<?
		}
	?>
	</table>
	<?
}

/**
*	age_aberrant
*	dossiers où la date de naissance est postérieure à la date de visite
*/
function age_aberrant()
{
	global $connexion;
	$requete = "SELECT rpu_ID,date_entree , date_naissance FROM rpu WHERE date_entree < date_naissance ORDER BY date_entree";
	$resultat = ExecRequete($requete,$connexion);
	$intitule = array("ID RPU","Date entrée","Date Naissance");
	table($intitule,$resultat);
}

/**
*	département d'origine et pays
*/
function origine()
{
	global $connexion;
	$requete = "SELECT LEFT(zip,2) AS z2 , departement_nom,COUNT(*)AS nb 
					FROM rpu, departement
					WHERE departement_ID = TRIM(LEFT(zip,2))
					GROUP BY z2 ORDER BY z2";
	$resultat = ExecRequete($requete,$connexion);
	$intitule = array("Département","nom","nombre");
	table($intitule,$resultat);
}
/**
*	CCMU
*/
function ccmu()
{
	global $connexion;
	$requete = "SELECT ccmu, count(ccmu)  AS nb FROM rpu GROUP BY ccmu ORDER bY ccmu";
	$resultat = ExecRequete($requete,$connexion);
	$intitule = array("CCMU","nombre");
	print("<table>");
	print("<tr>");
	print("<td>");
	table($intitule,$resultat);
	print("</td>");
	print("<td>");
		$resultat = ExecRequete($requete,$connexion);
				// Pie Graph 
				while($rep=mysql_fetch_array($resultat))
				{
					if($rep['ccmu']>0 &&$rep['ccmu']<6)
						$categorie[$rep['ccmu']] = $rep['nb'];
				}
				$w =urlencode(serialize($categorie));
				$titre = "Passages - Répartition par CCMU";
				print("<img src=\"showpiegraph.php?titre=$titre&val=$w\"> ");
	print("</td>");
	print("</tr>");
	print("</table>");
}

/**
*	Motif
*/
function motif()
{
	global $connexion;
	$requete = "SELECT motif, count(motif)  AS nb FROM rpu GROUP BY motif ORDER bY motif";
	$resultat = ExecRequete($requete,$connexion);
	$intitule = array("Motif","nombre");
	table($intitule,$resultat);
}
function motif_court()
{
	global $connexion;
	$requete = "SELECT (LEFT(motif,3))AS  motif_court, count(*) AS nb FROM rpu GROUP BY LEFT(motif,3) ORDER BY nb";
	$resultat = ExecRequete($requete,$connexion);
	$intitule = array("Motif","nombre");
	table($intitule,$resultat);
}
/**
*	transport
*/
function transport()
{
	global $connexion;
	$requete = "SELECT transport, count(transport)  AS nb FROM rpu GROUP BY transport ORDER bY nb";
	$resultat = ExecRequete($requete,$connexion);
	$intitule = array("moyen de transport","nombre");
	table($intitule,$resultat);
}


?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<LINK REL=stylesheet TYPE ="text/css" HREF="rpu.css" >
</head>
<body>
	<p><h2>Analyse de la table RPU pour le SAU de Sélestat (2009)</h2></p>
	<?php
		sexe();
		nettoie();
		
		print("<p>Communes d'origine des patients</p>");
		commune();
		print("<p>Passages</p>");
		passages();
		diag_principal("F1%");
		print("<p>Patients présentant une infection pulmonaire virale </p>");
		libelle_CIM10('J10');
		passages_par_ccam();
		print("<p>Patients présentant une infection pulmonaire virale </p>");
		passageByWeek();
		passageByMonth();
		print("<p>Consultants versus hospitalisés </p>");
		passageByWeek2();
		
		print("<p>Age des consultants </p>");	// ligne 496
		age();
		age_aberrant();
		
		origine();
		print("<p>Répartition par CCMU</p>");
		ccmu();
		print("<p>Moyens de transport </p>");
		transport();
		print("<p>Motifs de recours </p>");
		motif();
		print("<p>Motifs de recours regroupés</p>");
		motif_court();
		passageByMonth();
		testeCusum();
		surveillance();
		autre_departement();
		
?>
</body>
</html>
