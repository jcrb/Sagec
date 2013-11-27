<?php
/**
  *		cherche_structure.php
  *		$lat				latitude du chantier
  *		$lng				longitude du chantier
  *		$distance		rayon en km du cercle de recherche
  *		$limit			nb max de réponses
  */

require($backPathToRoot."dbConnection.php");

/**
  *		cherche_hopital()
  */
  
$ortodro = "(((acos(sin(('$lat'*pi()/180)) * sin((ad_latitude*pi()/180)) + cos(('$lat'*pi()/180)) * cos((ad_latitude*pi()/180)) * cos((('$lng' - ad_longitude)*pi()/180))))*180/pi())*60*2.133)";
  
function cherche_hopital($lat,$lng,$distance,$limit=20)
{
	global $connexion;
	global $ortodro;
	
	$requete = "SELECT ad_longitude as longitude, ad_latitude as latitude,Hop_nom
							FROM hopital,adresse 
							WHERE hopital.adresse_ID = adresse.ad_id
							AND ad_longitude > 0 && ad_latitude > 0
							AND '$ortodro' <= '$distance'
							ORDER BY '$ortodro' LIMIT "; 
							$requete.= $limit;
	print($requete."<br>");
	$resultat = ExecRequete($requete,$connexion);
	return $resultat;						
}

function cherche_hopital2($lat,$lng,$distance,$limit=10)
{
	global $connexion;
	$requete = "SELECT ad_longitude as longitude, ad_latitude as latitude,Hop_nom,Hop_ID,
							(((acos(sin(('$lat'*pi()/180)) * sin((ad_latitude*pi()/180)) + cos(('$lat'*pi()/180)) * cos((ad_latitude*pi()/180)) * cos((('$lng' - ad_longitude)*pi()/180))))*180/pi())*60*2.133) as DISTANCE
							FROM hopital,adresse 
							WHERE hopital.adresse_ID = adresse.ad_id
							AND ad_longitude > 0 && ad_latitude > 0
							AND hopital.niveau_planBlanc IN ('1','2')
							AND (((acos(sin(('$lat'*pi()/180)) * sin((ad_latitude*pi()/180)) + cos(('$lat'*pi()/180)) * cos((ad_latitude*pi()/180)) * cos((('$lng' - ad_longitude)*pi()/180))))*180/pi())*60*2.133) <= '$distance'
							ORDER BY niveau_planBlanc,DISTANCE
							LIMIT "; 
							$requete.= $limit;
	print($requete."<br>");
	$resultat = ExecRequete($requete,$connexion);
	return $resultat;						
}

/**
  *		cherche_objet()
  *		A partir de la table adresse, cherche tous les éléments présents dans
  *		un rayon donné
  */
function cherche_objet()
{
	global $connexion;
	global $ortodro;
	/* recherche des tables possédant un champ adresse */
	$table = array();
	$champ = "adresse_";
	$champ = "ppi_ID";
	$requete = "SHOW TABLES FROM pma";
	$resultat = ExecRequete($requete,$connexion);
	while($row = mysql_fetch_row($resultat))
	{
		//echo "table : {$row[0]}\n";
		$requete2 = "SHOW COLUMNS FROM $row[0]";
		$resultat2 = ExecRequete($requete2,$connexion);
		while($row2 = mysql_fetch_row($resultat2))
		{
			if(strstr($row2[0],$champ))
			{
				$table[] = $row[0];
				echo $row[0].'<br>';
			}
		}
	}
}


/**
	* test
  */
  
$distance = 100;
$lat = 48.5948;
$lng = 7.80111;
/*
$resultat = cherche_hopital($lat,$lng,$distance);
while($rep = mysql_fetch_array($resultat))
{
	echo stripslashes($rep['Hop_nom']).'<br>';
}

echo '<br>';

$resultat = cherche_hopital2($lat,$lng,$distance,20);
while($rep = mysql_fetch_array($resultat))
{
	echo stripslashes($rep['Hop_nom']).'  ';
	printf("% 01.2f  %s",$rep['DISTANCE'],"km<br>");
}
*/
cherche_objet();
?>
