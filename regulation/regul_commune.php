<?php
/**
*	regul_commune.php
*/
$backpath="../";
include($backpath."utilitairesHTML.php");
include($backpath."dbConnection.php");
include($backpath."utilitaires/google/orthodro.php");
include($backpath."utilitaires/google/adresse.php");
include($backpath."login/init_security.php");

$ville = Security::esc2Db($_REQUEST['ville_id']);
$adresse = Security::esc2Db($_REQUEST[nom]);

// caractéristiques de la ville
$requete = "SELECT ville_nom,ville_Insee,ville.secteur_Adps_ID,secteur_smur_nom,secteur_apa_nom,secteur_adps_nom,secteur_adps.secteur_adps_ID,
							 secteur_apa.secteur_apa_ID, modalite,ville_latitude,ville_longitude,pays_nom
			FROM ville, secteur_smur, secteur_adps, secteur_apa,pays
			WHERE ville_ID = '$_REQUEST[ville_id]'
			AND ville.secteur_smur_ID = secteur_smur.secteur_smur_ID
			AND ville.secteur_adps_ID = secteur_adps.secteur_adps_ID
			AND ville.secteur_apa_ID = secteur_apa.secteur_apa_ID
			AND pays.pays_ID = ville.pays_ID
			";

	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	
	$secteur_SMUR = $rep['secteur_smur_nom'];
	$secteur_APA = $rep['secteur_apa_nom'];
	$secteur_PDS = $rep['secteur_adps_nom'];
	$secteur_SMUR_no = $rep['secteur_smur_ID'];
	$secteur_APA_no = $rep['secteur_apa_ID'];
	$secteur_PDS_no = $rep['secteur_Adps_ID'];
	$INSEE = $rep['ville_Insee'];
	$secteur_regule = $rep['modalite'];
	$ville_lng = $rep['ville_longitude'];
	$ville_lat = $rep['ville_latitude'];
	$ville_pays = $rep['pays_nom'];
/**
*	Si le lieu de l'intervention correspondent à une geolocalisation utilisable
*	alors le centre de référence est le lieu de l'incident
*	sinon ce sont les coordonnées de la ville qui servent de point de référence
*/
if($adresse != ""){
	$a = $adresse.",";
	if($rep[ville_zip]) $a.= $rep[ville_zip].",";
	if($rep[ville_nom]) $a.= $rep[ville_nom].",".$rep[pays_nom];
	$r = localise($a);
	$local = explode(",",$r);
	if($local[0]==200){
		$ville_lng = $local[3];
		$ville_lat = $local[2];
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
    <title>Moyens de secours</title>
	 <link rel="stylesheet" href="div.css" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" media="screen" href="formstyle.css" />
    <link rel="stylesheet" type="text/css" media="print" href="impression.css" />
    
    <script src = "../utilitaires/google/key.js"></script>
	<script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    </script>
    <script src="carto_data.php" type="text/javascript"></script>
	<!--  <link href="regul_map.css" rel="stylesheet" type="text/css" /> -->
</head>

<body onload = "init(<?php echo $ville_lat;?>,
							<?php echo $ville_lng;?>)
							">
<?php

	
	//print($requete);
	// distances orthodromiques 
	//$D67 = orthodro($latA,$longA,$latB,$longB);
	//print("<p>Localisation: ".$rep[ville_nom]."  ".$ville_lat."  ".$ville_lng."</p><br>");
?>
<div id="sup">
	<h2>
		<? echo $rep[ville_nom];?>
		<br><br>
		<a href="../sagec67.php">Menu principal > </a><a href="index.php">Régulation > </a><a href="regul_ask.php">autre localisation</a>
	</h2>
</div>

<?php
print("<table class=\"time\" border=\"1\" cellspacing=\"0\">");
		print("<tr>");
			print("<td bgcolor=\"#FF9900\">Secteur SMUR ".$secteur_SMUR."</td>");
			print("<td bgcolor=\"#FFCC00\">Secteur APA ".$secteur_APA."</td>");
			print("<td bgcolor=\"#FFFF00\">Secteur PDS ".$secteur_PDS." - ".$secteur_PDS_no);
				if($secteur_regule==1) print(" (secteur régulé)");
				else print(" (secteur non régulé)");
				print("</td>");
			print("<b><td bgcolor=\"#FFFFCC\"> Attention distances à vol d'oiseau - Les isocercles rouges sont espacés de 5 km</td></b>");
			print("<td>".$ville_lat." | ".$ville_lng."</td>");
		print("</tr>");
	print("</table>");
?>

	<!--
			hélicoptères les plus proches 
	-->
	
	<div id="div2">
	<fieldset id="field1">
		<legend> Hélicoptères </legend>
		<table border="1" cellspacing="0">
	<?php

	$requete = "SELECT ad_longitude, ad_latitude, Vec_Nom
					FROM adresse, vecteur
					WHERE Vec_Type = 9
					AND vecteur.adresse_ID = adresse.ad_ID";
	$resultat = ExecRequete($requete,$connexion);
	$dh=array();
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep[ad_longitude] != 0){
			$dh[$rep['Vec_Nom']] = orthodro($rep[ad_latitude],$rep[ad_longitude],$ville_lat,$ville_lng);
		}
	}
	$d = asort($dh);
	foreach($dh as $key => $value)
	{
			if($value < 100){
				?><tr>
					<td><? echo $key;?></td>
					<td><? echo ceil($value)." km";?></td>
				</tr><?php
			}
	}
	?>
	</table>
	</fieldset>
	
	<fieldset id="field1">
		<legend> DSA </legend>
		<table border="1" cellspacing="0">
	<?php
	/**
	*	DSA les plus proches
	*/
	$requete = "SELECT dsa_site,dsa_lat,dsa_lng FROM dsa";
	$resultat = ExecRequete($requete,$connexion);
	$dh=array();
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep[dsa_lng] != 0){
			$dist = orthodro($rep[dsa_lat],$rep[dsa_lng],$ville_lat,$ville_lng);
			if($dist > 1) $dist= ceil($dist);
			else $dist = ceil($dist*1000)/1000;
			$dh[$rep['dsa_site']] = $dist;
		}
	}
	$d = asort($dh);
	foreach($dh as $key => $value)
	{
			if($value < 5){
				?><tr>
					<td><? echo $key;?></td>
					<td><? 
						if($value<1){
							echo $value * 1000;echo" m";}
						else 
							echo $value." km";
					?></td>
				</tr><?php
			}
	}
	?>
	</table>
	</fieldset>

	<fieldset id="field1">
		<legend> SMUR </legend>
		<table border="1" cellspacing="0">
	<?php
	/**
	*	SMUR proches
	*/
	//print("<br>=========================== SMUR ================================<br>");
	$requete = "SELECT Hop_nom, ad_longitude, ad_latitude
					FROM adresse, hopital
					WHERE Hop_Smur = 'o'
					AND hopital.adresse_ID = adresse.ad_ID";
	$resultat = ExecRequete($requete,$connexion);
	$dh=array();
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep[ad_longitude] != 0){
			$dh[$rep['Hop_nom']] = ceil(orthodro($rep[ad_latitude],$rep[ad_longitude],$ville_lat,$ville_lng));
		}
	}
	$d = asort($dh);//print_r($d);
	foreach($dh as $key => $value)
	{
		if($value < 100){
			?><tr>
				<td><? echo $key;?></td>
				<td><? echo ceil($value)." km";?></td>
			</tr><?php
		}
	}
	?>
	</table>
	</fieldset>
	<fieldset id="field1">
		<legend> APA/ASSU </legend>
		<table border="1" cellspacing="0">
	<?php
	
	/**
	*	ASSU proches
	*/
	//print("<br>=========================== ASSU ================================<br>");
	$distance = 30;//rayon de recherche en km
	$maxLignes= 10;// nombre d'entreprises à sélectionner
	// création d'une vue rassemblant le nom des entreprises et leur distance orthodromique par
	// rapport au lieu de détresse 
	$requete = "CREATE OR REPLACE VIEW assu_view
					AS SELECT org_nom, ad_longitude, ad_latitude,
					(((acos(sin(('$ville_lat'*pi()/180)) * sin((ad_latitude*pi()/180)) + cos(('$ville_lat'*pi()/180)) 
					* cos((ad_latitude*pi()/180)) * cos((('$ville_lng' - ad_longitude)*pi()/180))))*180/pi())*60*2.133) AS d
					FROM adresse, organisme
					WHERE organisme_type_ID = '4'
					AND organisme.adresse_ID = adresse.ad_ID";
	$resultat = ExecRequete($requete,$connexion);
	
	$requete = 	"SELECT org_nom,d FROM assu_view WHERE d<'$distance' ORDER BY d LIMIT ".$maxLignes;	
	$resultat = ExecRequete($requete,$connexion);

	while($rep=mysql_fetch_array($resultat))
	{
		?><tr>
				<td><? echo $rep['org_nom'];?></td>
				<td><? echo ceil($rep[d])." km";?></td>
		</tr><?php
	}
	
	
	/**
	$dh=array();
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep[ad_longitude] != 0){
			$dh[$rep['org_nom']] = ceil(orthodro($rep[ad_latitude],$rep[ad_longitude],$ville_lat,$ville_lng));
		}
	}
	$d = asort($dh);//print_r($d);
	foreach($dh as $key => $value)
	{
		if($value < 30){
			?><tr>
				<td><? echo $key;?></td>
				<td><? echo ceil($value)." km";?></td>
			</tr><?php
		}
	}
	*/
	?>
	</table>
	</fieldset>
	
	<?php
		/**
		*	VSAV proches
		*/
		//print("<br>======================= VSAV ================================<br>");
	?>
	<fieldset id="field1">
		<legend> VSAV </legend>
		<table border="1" cellspacing="0">
		<?php
		$requete = "SELECT vec_nom, ad_longitude, ad_latitude
					FROM adresse, vecteur
					WHERE Vec_Type = 3
					AND adresse_ID = adresse.ad_ID
					AND ad_longitude > 0";
		// Technique 2 
	$requete = "SELECT vec_nom, ad_longitude, ad_latitude
					FROM adresse,vecteur,centrale
					WHERE Vec_Type = 3
					AND vecteur.centrale_ID = centrale.centrale_ID
					AND centrale.centrale_adresse_ID = adresse.ad_ID
					AND ad_longitude > 0
					";
		$resultat = ExecRequete($requete,$connexion);
		$dh=array();
		while($rep=mysql_fetch_array($resultat))
		{
			$dh[$rep['vec_nom']] = ceil(orthodro($rep[ad_latitude],$rep[ad_longitude],$ville_lat,$ville_lng));
		}
		$d = asort($dh);
		foreach($dh as $key => $value)
		{
			if($value < 30){
			?><tr>
				<td><? echo $key;?></td>
				<td><? echo ceil($value)." km";?></td>
			</tr><?php
			}
		}
		?>
		</table>
	</fieldset>
	
	
	<fieldset id="field1">
		<legend> Pharmacies </legend>
		<table border="1" cellspacing="0">
	<?php
	
	/**
	*	Pharmacie proches
	*/
	//print("<br>======================= PHARMACIES ================================<br>");
	$requete = "SELECT * FROM pharmacie";
	$resultat = ExecRequete($requete,$connexion);
	$dh=array();
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep[long] != 0){
			$dh[$rep['nom']] = ceil(orthodro($rep[lat],$rep[long],$ville_lat,$ville_lng));
		}
	}
	$d = asort($dh);
	$i = 0;
	$limit = 10;
	// liste des pharmacies dans un rayon de 20 km et on se limite à $limit = 10 pharmacies
	foreach($dh as $key => $value){
		if($value <= 20){
			$i++;
			if($i > $limit)break;
			?><tr>
				<td><? echo $key;?></td>
				<td><? echo ceil($value)." km";?></td>
			</tr><?php
		}
	}
	?>
	</table>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Médecins </legend>
		<table border="1" cellspacing="0">
	<?php
	/**
	*	Médecins proches
	*/
	//print("<br>======================= MEDECINS ================================<br>");
	$requete = "SELECT * FROM mg67";
	$resultat = ExecRequete($requete,$connexion);
	$dh=array();
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep[lng] != 0){
			$dh[$rep['med_nom']] = ceil(orthodro($rep[lat],$rep[lng],$ville_lat,$ville_lng));
		}
	}
	$d = asort($dh);
	// liste des médecins dans un rayon de 20 km. On s'arrête à $limit = 10
	$i = 0;
	$limit = 10; 
	foreach($dh as $key => $value){
		if($value <= 20){
			$i++;
			?><tr>
				<td><? echo $key;?></td>
				<td><? echo ceil($value)." km";?></td>
			</tr><?php
			if($i > $limit)break;
		}
	}
	?>
	</table>
	</fieldset>
	<?php
	
	print("<table class=\"time\" border=\"1\" cellspacing=\"0\">");
		print("<tr>");
			print("<td bgcolor=\"#FF9900\">Secteur SMUR ".$secteur_SMUR."</td>");
			print("<td bgcolor=\"#FFCC00\">Secteur APA ".$secteur_APA."</td>");
			print("<td bgcolor=\"#FFFF00\">Secteur PDS ".$secteur_PDS." - ".$secteur_PDS_no);
				if($secteur_regule==1) print(" (secteur régulé)");
				else print(" (secteur non régulé)");
				print("</td>");
		print("</tr>");
	print("</table>");
?>
</div>

<div id="map">Map</div>

</body>
</html>