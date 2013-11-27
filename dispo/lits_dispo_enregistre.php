<?php
/**
  *	lits_dispo_enregistre.php
  */
  session_start();
  error_reporting(E_ERROR | E_WARNING | E_PARSE);
  $backPathToRoot = "../";
  include_once($backPathToRoot."login/init_security.php");
  require $backPathToRoot."dbConnection.php";
  require $backPathToRoot."date.php";

  $org = $_SESSION["organisation"];
  $hop = $_SESSION["Hop_ID"];
  $date = $_SERVER['REQUEST_TIME'];
  
   $s=$_REQUEST['services'];	// tableau des identifiants des services
	$l=$_REQUEST['litsd'];		// tableau des lits disponibles
	$p=$_REQUEST['placessd'];	// tableau des places disponibles
	$max = sizeof($l);			// nb d'éléments dans les tableaux 
  /**
  $code = Security::esc2Db($_REQUEST['nom']); // code UF ou service 
  $type = Security::esc2Db($_REQUEST['type']);// type = service ou UF 
  $mat1 = Security::esc2Db($_REQUEST['mat']); // lits dispo à T0 
  $mat2 = Security::esc2Db($_REQUEST['mat2']);// lits dispo à T1 
  $mat3 = Security::esc2Db($_REQUEST['mat3']);// lits dispo à T2 
  */
  
  /** rechercher l'identifiant de l'UF ou du service 
  if($type=='uf')
  	$requete = "SELECT uf_ID as id FROM uf WHERE uf_code='$code' AND org_ID = '$org' AND Hop_ID='$hop'";
  else
   $requete = "SELECT service_ID as id FROM service WHERE service_code='$code' AND org_ID = '$org' AND Hop_ID='$hop'";
  $resultat = ExecRequete($requete,$connexion);
  $rep = mysql_fetch_array($resultat);
  $id = $rep['id'];
  */
  
  /** enregistrement de l'information */
  for($i=0;$i<$max;$i++)
	{
		if($s[$i] && is_numeric($l[$i]) || is_numeric($p[$i]))
		{
			// mise à jour du journal des lits
			$requete="INSERT INTO lits_journal VALUES('$date','$s[$i]','$l[$i]','$_SESSION[member_id]')";
			$resultat = ExecRequete($requete,$connexion);

			// mise à jour du journal des places
			if(is_numeric($p[$i]))
			{
				$requete="INSERT INTO places_journal VALUES('$date','$s[$i]','$p[$i]','$_SESSION[member_id]')";
				$resultat = ExecRequete($requete,$connexion);
			}
			
			// la mise à jour ne se fait que si la date est plus récente que la date enregistrée
			$requete = "SELECT date_maj FROM lits WHERE service_ID = '$s[$i]'";
			$resultat = ExecRequete($requete,$connexion);
			$last_maj = mysql_fetch_array($resultat);
			$date2 = $last_maj['date_maj'];
			if(intval($date2) < intval($date))
			{
				$requete = "UPDATE lits SET
										lits_dispo = '$l[$i]',
										places_dispo = '$p[$i]',
										date_maj = '$date'
										WHERE service_ID = '$s[$i]'";
				$resultat = ExecRequete($requete,$connexion);
				//print("date maj <br>");
			}
	//print($l[$i]." ".$s[$i]." ".$s[$i]." ".$p[$i]."<br>");
			$requete = "SELECT date_maj FROM lits WHERE service_ID = '$s[$i]'";
			$resultat = ExecRequete($requete,$connexion);
			$last_maj = mysql_fetch_array($resultat);
			$date3 = $last_maj['date_maj'];
			//print("last_maj = ".$date3." - date = ".$date);
		}
	}
  
	header("Location:lits_comment.php?enregistrement=ok");
?>