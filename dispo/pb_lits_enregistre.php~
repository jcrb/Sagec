<?php
/**
  *	pb_lits_enregistre.php
  */
  session_start();
  error_reporting(E_ERROR | E_WARNING | E_PARSE);
  $backPathToRoot = "../";
  include_once($backPathToRoot."login/init_security.php");
  require($backPathToRoot."dbConnection.php");
  require($backPathToRoot."date.php");

  $org = $_SESSION["organisation"];
  $hop = $_SESSION["Hop_ID"];
  $evenement = $_SESSION["evenement"];
  $user = $_SESSION["member_id"];
  $structure_ID = $_SESSION["hopID"];
  
   print('structure: '.$structure_ID);
  
  $back = $_REQUEST['back'];
  
  $code = Security::esc2Db($_REQUEST['nom']); // code UF ou service 
  $type = Security::esc2Db($_REQUEST['type']);// type = service ou UF 
  $mat1 = Security::esc2Db($_REQUEST['mat']); // lits dispo à T0 
  $mat2 = Security::esc2Db($_REQUEST['mat2']);// lits dispo à T1 
  $mat3 = Security::esc2Db($_REQUEST['mat3']);// lits dispo à T2 
  $mat4 = Security::esc2Db($_REQUEST['mat4']);// lits dispo à T3
  $mat5 = Security::esc2Db($_REQUEST['mat5']);// lits dispo à T4
  $mat6 = Security::esc2Db($_REQUEST['mat6']);// lits dispo à T5
  $cadre = Security::esc2Db($_REQUEST['cadre']);// cadre de santé et cadre sup
  $ide = Security::esc2Db($_REQUEST['ide']);// infirmières
  $as = Security::esc2Db($_REQUEST['as']);// aide-soignantes
  $med = Security::esc2Db($_REQUEST['med']);// médecins
  
  $date = uDateTime2MySql(time());
  
  /** rechercher l'identifiant de l'UF ou du service */
	if($type=='uf')
  	{
  		$requete = "SELECT uf_ID as id FROM uf WHERE uf_code='$code' AND org_ID = '$org' AND Hop_ID='$hop'";
  		$unite_type = "1";
  	}
  	else
  	{
   	$requete = "SELECT service_ID as id FROM service WHERE service_code='$code' AND org_ID = '$org' AND Hop_ID='$hop'";
   	$unite_type = "2";
   }
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	$id = $rep['id'];
	
	$structure_type = "1"; // c'est un hopital 
	$objet = "1"; // ce sont des lits
  
  /** il existe déjà un enregistrement pour ce service ? */
  $requete = "SELECT lits_pb_ID FROM lits_pb WHERE unite_ID = '$code'";
  $resultat = ExecRequete($requete,$connexion);
  $ligne = mysql_fetch_array($resultat);
  
  if($ligne[lits_pb_ID] > 0)
  {
  	/** update enregistrement */
  	$requete = "UPDATE pma.lits_pb SET 
  					date_maj = '$date',
  					t1 = '$mat1',
  					t2 = '$mat2',
  					t3 = '$mat3',
  					t4 = '$mat4',
  					t5 = '$mat5',
  					t6 = '$mat6',
  					cadre = '$cadre',
  					ide = '$ide',
  					ash = '$as',
  					med = '$med'
  					WHERE lits_pb_ID = '$ligne[lits_pb_ID]'
  					";
  }
  else
  {

  	/** enregistrement de l'information */
  	$requete = "INSERT INTO `pma`.`lits_pb` (
	`lits_pb_ID` ,
	`unite_ID` ,
	`unite_type` ,
	`structure_ID` ,
	`structure_type_ID` ,
	`objet_ID` ,
	`delai_mn` ,
	`objet_nombre` ,
	`date_maj` ,
	`delai_jour` ,
	`user_ID` ,
	`date_creation` ,
	`cata_ID`,
	t1,t2,t3,t4,t5,t6,cadre,ide,ash,med
		)
		VALUES (
			NULL , '$code', '$unite_type', '$structure_ID', '$structure_type', '$objet', '0', '$mat1', '$date', '0', '$user', '$date', '$evenement',
			'$mat1','$mat2','$mat3','$mat4','$mat5','$mat6','$cadre','$ide','$as','$med'
		)";
  }
  $resultat = ExecRequete($requete,$connexion);
  //echo $requete;
 
 // header("Location: ".$back);
?>