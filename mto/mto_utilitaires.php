<?php
/**
  *	mto_utilitaires.php
  *	ensemble de routines pour l'analyse des donn�es m�t�o
  *	@author JCB
  *	@creation: 
  */

/** codes attribu�s par le fournisseur de donn�es */

define("PARTNER_ID", "1004409465");
define("KEY_ID", "7ddce928bdbf5560");

include("classe_weather.php");

/**
  *	Affiche le fichier contenant les donn�es MTO
  *	$weather est une instance de la classe Weather
  */
function afficheXML($weather){
	$weather->afficheWeatherXML();
}

/**
  *	utilitaire
  *	d�termine la liste des stations dont le pr�fixe pays est sprefixe
  *	Allemagne = GMXX
  */
function listeStation($prefixe)
{
	global $connexion;
	$weather = new Weather(PARTNER_ID, KEY_ID);
	$err = FALSE;
	$i = 1;
	print('<table>');
	//for($i=560;$i<590;$i++)
	while($err == FALSE && $i < 555)
	{
		print('<tr>');
		$val = substr('0000'.$i,-4,4);
		$station = $prefixe.$val;
		
		$weather->getWeather($station);
		$data = $weather->getWeatherXML();
		if(isset($data))
		{
			$p = new SimpleWeatherXML($data);
			//print("station: ".$p."<br>");
			if($p)
			{
				print('<td>'.$i.'</td>');
				print('<td>'.$station.'</td>');
				print('<td>'.$p->stationNom.'</td>');
				print('<td>'.$p->stationLat.'</td>');
				print('<td>'.$p->stationLon.'</td>');
				print('</tr>');
				$station_nom = mysql_real_escape_string($p->stationNom);
				$requete = "INSERT INTO station_mto VALUES('','$station_nom','$station','$p->stationLat','$p->stationLon')";
				/** par s�curit� la ligne suivante est comment�e pour �viter un enregistrement accidentel */
				//$result = ExecRequete($requete,$connexion);
			}
			$i++;
		}
		else $err = TRUE;
		//if($i > 10) $err = TRUE;
	}
	print('</table>');
}

/**
  *	R�cup�re les donn�es m�t�o de la station
  *	dont l'indicatif est indiqu� par $code
  *	Par d�faut retourne les donn�es de Strasbourg
  */
function GetLastDataStationXX($code="FRXX0095")
{
/** initialise un objet Weather */
	$weather = new Weather(PARTNER_ID, KEY_ID);
/** recherche les donnes de la station pass�e en argument */
	$weather->getWeather($code);
/** $data est une string contenant le fichier xml */
	$data = $weather->getWeatherXML();
/** utilisation de la classe SimpleWeatherXML qui exploite SimpleXml pour r�cup�rer les r�sultats */
	$p = new SimpleWeatherXML($data);
	return $p;
}

function printLastData($p)
{
	echo "temp�rature: ".$p->getTemperature()." �C<br>";
	echo "vitesse du vent: ".$p->vitVentKmh." Km/h soit ";
	echo $p->vitVentMps." m/s<br>";
	echo "raffales: ".$p->getRaffales()."<br>";
	echo "direction du vent: ".$p->dirVentDeg."� (".$p->dirVentTxt.")<br>";
	echo "pression athmosph�rique: ".$p->getPression()." ".$p->getUnitePression()."<br>";
	echo "Evolution des pressions: ".$p->getStabilite()."<br>";
	echo "humidit� relative: ".$p->getHumidite()."%"."<br>";
	echo "visibilit�: ".$p->getVisibilite()."<br>";
	echo "UV Force: ".$p->getUVvaleur()." (indice: ".$p->getUVforce().")<br>";
	echo "Point de ros�e: ".$p->getDewPoint()." �C<br>";
	echo "derni�re mesure le: ".$p->lastMesure;
}

/**
  * recherche la sation m�t�o la plus proche
  * retourne les derni�res donn�es
  */
function lePlusProche($lat,$lng)
{
	global $connexion;
	$ref = 1000;
	$requete = "SELECT *
					FROM station_mto
					";
	$result = ExecRequete($requete,$connexion);
	while($rep=mysql_fetch_array($result))
	{
		$d = ($rep['station_lat']-$lat)*($rep['station_lat']-$lat)+($rep['station_lng']-$lng)*($rep['station_lng']-$lng);
		if($d < $ref)
		{
			$ref = $d;
			$code = $rep['station_code'];
			$nom = $rep['station_name'];
			$lt = $rep['station_lat'];
			$lg = $rep['station_lng'];
		}
	}
	echo 'station la plus proche: '.$nom.'<br>';
	return GetLastDataStationXX($code);
}

?>