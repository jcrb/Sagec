<?php
/**
  *	ppi_meteo.php
  *
  *	affiche le dernier bulletion météo de la station $station
  *	$station = code Metar de la station météo
  */
  session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../"; 
include($backPathToRoot."dbConnection.php");
include($backPathToRoot."mto/mto_utilitaires.php");
include("rose.php");

  	$station = $_REQUEST['station'];
  	$ppi_ID = $_REQUEST['ppi_ID'];
  	
  	$requete = "SELECT * FROM station_mto WHERE station_code = '$station'";
  	$resultat2 = ExecRequete($requete,$connexion);
	$rub2= mysql_fetch_array($resultat2);
	$p = GetLastDataStationXX($station);
	
	//echo $p;
	
	$couverture = $p->getCouverture();
	switch($couverture)
	{
		case 'Fair':$couverture = 'Temps clair';
		case 'Few':$couverture = 'Quelques nuages';
		case 'Scattered':$couverture = 'Nuages épars';
		case 'Broken':$couverture = 'Nuageux';
		case 'Overcast':$couverture = 'Temps couvert';
		case 'Fog':$couverture = 'Brouillard';
		case 'Partly Cloudy':$couverture = 'Partiellement nuageux';
	}
?>
<html>
<head>
</head>

<body>
<form name="">

<input type="hidden" name="ppi_ID" value="<?php echo $ppi_ID;?>">
<input type="hidden" name="station" value="<?php echo $station;?>">

<table>
	<tr>
		<th colspan="2">Station de <?php echo $rub2['station_name'];?> le <?php echo $p->lastMesure;?></th>
		<input type="hidden" name="date" value="<?php echo $p->lastMesure;?>">
	</tr>
	<tr>
		<td>Température</td>
		<td><?php echo $p->getTemperature()." °C";?></td>
	</tr>
	<tr>
		<td>Température ressentie</td>
		<td><?php echo $p->windChill()." °C";?></td>
	</tr>
	<tr>
		<td>vitesse du vent</td>
		<td><?php echo $p->vitVentKmh." Km/h soit ".$p->vitVentMps." m/s";?></td>
	</tr>
	<tr>
		<td>direction du vent</td>
		<td><?php echo $p->dirVentDeg."° (".$p->dirVentTxt.")";?></td>
	</tr>
	<tr>
		<td>raffales</td>
		<td><?php echo $p->getRaffales();?></td>
	</tr>
	<tr>
		<td>pression athmosphérique</td>
		<td><?php echo $p->getPression()." ".$p->getUnitePression();?></td>
	</tr>
	<tr>
		<td>Evolution des pressions</td>
		<td><?php echo $p->getStabilite();?></td>
	</tr>
	<tr>
		<td>humidité relative</td>
		<td><?php echo $p->getHumidite()."%";?></td>
	</tr>
		<tr>
		<td>Point de rosée</td>
		<td><?php echo $p->getDewPoint()." °C";?></td>
	</tr>
	<tr>
		<td>visibilité</td>
		<td><?php echo $p->getVisibilite()." km";?></td>
	</tr>
	<tr>
		<td>couverture nuageuse</td>
		<td><?php echo $couverture;?></td>
	</tr>
</table>

<?php
	$dirvent = $p->dirVentDeg % 360;
	windRose($dirvent);
?>
	<div class="transp" id="rose"><img src="./rose_vent.png?<?echo time()?>"/></div>
	
	</br>
	<a href="../evenement/mto_enregistre.php?dirvent=<?php echo $dirvent;?>"> Enregistrer</a>

</form>
</body>
</html>
