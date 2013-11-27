<?php
/**
  *	peuple_db.php
  * 	remplit la table victime avec des cas fictifs
  *	générés par le programme html/populus
  *
  */
  
 	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$backPathToRoot = "../../";
	require($backPathToRoot."dbConnection.php");
	require($backPathToRoot."date.php");

  $fichier_source = 'listing1.csv';
  $separateur = ';';
  $now = time();
  
  /** hopital_ID */
  $hop = Array(1,2,6,7,8,9,11,86);
  /** type_service_ID */
  $service = Array(1,2,5,6);
  
  $fs = fopen($fichier_source, "r");
  while(!feof($fs))
  {
  		$p = fgets($fs);
  		$p = str_replace ('"', '',$p);
  		$p = trim($p);
  		$r = explode($separateur,$p);
  		$date = date("Y-m-j H:i:s",$now);
  		$now += rand(0,3)*60;
  		switch($r[7]){
  			case 'UA';$g = 1;break;
  			case 'UR';$g = 2;break;
  			case 'EC';$g = 6;break;
  			default:$g=4;
  		}
  		// sexe
  		switch($r[4]){
  			case 'h':$sexe = 1;break;
  			case 'f':$sexe = 2;break;
  		}
  		$status_ID = rand(1,11);/** localisation de la victime dans la chaine de soins */
  		$localisation_ID = '32';/** pma actif */
  		/** hopital de destination */
  		$i = rand(1,sizeof($hop)-1);
  		$hopital = $hop[$i];
  		$rep1['service_ID']='';
  		while( $rep1['service_ID']=='')
  		{
  			$j = $service[rand(1,sizeof($service))-1];echo $j;
  			$requete = "SELECT service_ID FROM service WHERE service.Hop_ID='$hopital' AND Type_ID = '$j'";
  			$resultat = ExecRequete($requete,$connexion);
  			$rep1 = mysql_fetch_array($resultat);
  			$service_ID = $rep1['service_ID'];
  		}
  		
  		$requete = "INSERT INTO victime(victime_ID,no_ordre,nom,prenom,sexe,age1,naissance,gravite,heure_creation,heure_maj,pays_ID,evenement_ID,status_ID,localisation_ID,
  						Hop_ID,service_ID) 
  						VALUES('$r[0]','$r[1]','$r[2]','$r[3]','$sexe','$r[5]','$r[6]','$g','$date','$date','1','29','$status_ID','$localisation_ID',
  						'$hopital','$service_ID')";
  		echo $requete.'<br>';
  		//$resultat = ExecRequete($requete,$connexion);
  	}
  	fclose($fs);
  
?>