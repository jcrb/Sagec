<?php
/**
*	intervenants_arrive_enregistre.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");

	$code = $_REQUEST['code']; 
	//print($code."<br>");
	$idp = 0;
	$idp = $_REQUEST['id'];
	//print($idp."<br>");
	$h = uDateTime2MySql(time());
	$mouvement = $_REQUEST['mouvement'];//print($mouvement);
	
	if($idp > 0)
	{
		$id = $idp;
	}
	else if(strlen($code)==13)
	{
		$id =  substr($code,-4,3);
	}
	//print($id."<br>");
	
	/**
	  * ins�re un nouvel enregistrement avec la cl� $id et un horaire d'arriv�e
	  * si cet cl� existe d�j�, fait un update, partant du principe que s'il y a
	  * d�j� un enregistremet, la personne quitte son poste
	  */
	$requete="INSERT INTO perso_affectation VALUES('$id','','$h','','','','','','','','')
				 ON DUPLICATE KEY UPDATE heure_depart='$h'
				";
		ExecRequete($requete,$connexion);
		//print($requete."<br>");

header("Location:"."intervenants_arrive.php");
?>